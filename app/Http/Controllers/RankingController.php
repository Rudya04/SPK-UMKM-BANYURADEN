<?php

namespace App\Http\Controllers;

use App\Enum\RoleEnum;
use App\Exceptions\DataNotValidException;
use App\Exports\RankingExport;
use App\Exports\UserRankingExport;
use App\Models\Alternative;
use App\Models\AlternativeRanking;
use App\Models\Criteria;
use App\Models\CurrentAlternative;
use App\Models\CurrentUserRanking;
use App\Models\Form;
use App\Models\Ranking;
use App\Models\SubCriteria;
use App\Models\User;
use App\Models\UserRanking;
use App\Traits\CalculationTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;

class RankingController extends Controller
{
    use CalculationTrait;

    public function index()
    {
        $curentUserRanking = CurrentUserRanking::query()->where('user_id', Auth::id())
            ->orderByDesc('id')->get();

        if (Auth::user()->hasRole(RoleEnum::PENGUSAHA->value)) {
            $curentUserRanking = CurrentUserRanking::query()
                ->select('current_users_rankings.title', 'current_users_rankings.reference_code', 'current_users_rankings.created_at')
                ->join('current_alternatives', 'current_alternatives.current_user_ranking_id', '=', 'current_users_rankings.id')
                ->where('current_alternatives.pengusaha_id', Auth::id())
                ->groupBy('current_users_rankings.id',
                    'current_users_rankings.title',
                    'current_users_rankings.reference_code',
                    'current_users_rankings.created_at')
                ->orderByDesc('current_users_rankings.id')
                ->get();
        }

        return view('ranking.ranking')->with('curentUserRanking', $curentUserRanking);
    }

    public function save($reference_code)
    {
        $userId = Auth::id();
        $form = Form::with(['user_ranking'])->where('code', $reference_code)->firstOrFail();
        $alternative = Alternative::with(['pengusaha'])->where('pengusaha_id', $userId)->firstOrFail();
        $criterias = Criteria::with(['subCriterias'])->get();
        $rankings = UserRanking::query()
            ->where('form_id', $form->id)
            ->where('alternative_id', $alternative->id)
            ->get();

        return view('ranking.create-ranking')->with([
            'form' => $form,
            'alternative' => $alternative,
            'criterias' => $criterias,
            'rankings' => $rankings,
        ]);
    }

    public function showDetail($reference_code)
    {
        $form = Form::with(['user_rankings.rankings'])->where('code', $reference_code)->firstOrFail();

        return view('ranking.show-ranking')->with([
            'form' => $form,
        ]);
    }

    public function create(Request $request)
    {
        $data = $request->input('data');
        $rules = [
            'alternative_id' => [
                'required',
                'exists:alternatives,id'
            ],
            'form_id' => [
                'required',
                'exists:forms,id'
            ],
        ];
        $messages = [
            'alternative_id.required' => 'Alternative tidak boleh kosong',
            'alternative_id.exists' => 'Alternative tidak ditemukan',
            'form_id.required' => 'Form tidak boleh kosong',
            'form_id.exists' => 'Form tidak ditemukan'
        ];
        foreach ($data as $key => $value) {
            if (in_array($key, ['alternative_id', 'form_id'])) continue;
            $rules["data.$key"] = ['required', 'exists:sub_criterias,id'];
            $messages["data.$key.required"] = "Kolom $key wajib diisi.";
            $messages["data.$key.exists"] = "Data untuk $key tidak ditemukan di database.";
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();
            $dateNow = Carbon::now('Asia/Jakarta')->format('Y-m-d');
            $userId = Auth::id();
            $subCriteriaIds = [];
            foreach ($data as $key => $value) {
                $subCriteriaIds[] = $value;
            }

            $form = Form::query()->findOrFail($request->input('form_id'));

            if ($dateNow > $form->expired_date) {
                return back()->withErrors([
                    'error' => 'Tanggal melebihi batas pengisian.',
                ]);
            }

            $subCriterias = SubCriteria::query()->whereIn('id', $subCriteriaIds)->get();

            $userRanking = UserRanking::query()->create([
                'user_id' => $userId,
                'form_id' => $request->input('form_id'),
                'alternative_id' => $request->input('alternative_id')
            ]);

            $rankigs = [];
            foreach ($subCriterias as $subCriteria) {
                $rankigs[] = [
                    'criteria_id' => $subCriteria->criteria_id,
                    'sub_criteria_id' => $subCriteria->id,
                ];
            }

            $userRanking->rankings()->createMany($rankigs);
            DB::commit();
            return redirect()->route('ranking.save', ['reference_code' => $form->code])->with('success', 'Ranking berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return back()->withErrors([
                'error' => 'Gagal menambah ranking.',
            ]);
        }
    }

    public function criteria()
    {
        $userId = Auth::id();
        $ids = UserRanking::query()
            ->orderBy('id')
            ->pluck('id')->toArray();

        $rankingIds = DB::table('rankings')
            ->select('criteria_id')
            ->whereIn('user_ranking_id', $ids)
            ->groupBy('criteria_id')
            ->orderBy('criteria_id')
            ->pluck('criteria_id')->toArray();

        $criterias = Criteria::query()->whereIn('id', $rankingIds)->get()->toArray();
        $normalization = $this->normalizationBobot($criterias);

        return response()->json($normalization);
    }

    public function calculation($reference_code)
    {
        $uuid = Str::uuid();
        try {
            DB::beginTransaction();
            $userId = Auth::id();
            $form = Form::query()->where('code', $reference_code)->firstOrFail();
            $userRankings = UserRanking::with(
                [
                    'alternative',
                    'rankings.criteria',
                    'rankings.sub_criteria',
                ]
            )->where('form_id', $form->id)->orderBy('id');

            if ($userRankings->count() <= 0) {
                throw new DataNotValidException("Data tidak sesuai, silahkan sesuaikan data anda!");
            }

            $ids = $userRankings->pluck('id')->toArray();
            $rankingIds = DB::table('rankings')
                ->select('criteria_id')
                ->whereIn('user_ranking_id', $ids)
                ->groupBy('criteria_id')
                ->orderBy('criteria_id')
                ->pluck('criteria_id')->toArray();

            $criterias = Criteria::query()->whereIn('id', $rankingIds)->get()->toArray();
            $subCriteriaMax = DB::table('sub_criterias')
                ->select('criteria_id', DB::raw('MAX(value) as value_max'))
                ->whereIn('criteria_id', $rankingIds)
                ->groupBy('criteria_id')
                ->orderBy('criteria_id')->get();
            $normalization = $this->normalizationBobot($criterias);

            $userRanking = CurrentUserRanking::query()->create([
                'user_id' => $userId,
                'reference_code' => $uuid,
                'title' => $form->title
            ]);

            foreach ($userRankings->get() as $ranking) {
                $score = 0;
                $currentCriteria = $this->calculationScore($normalization, $ranking->rankings, $subCriteriaMax);
                foreach ($currentCriteria as $criteria) {
                    $score += $criteria['score'];
                }

                $currentAlternative = CurrentAlternative::query()->create([
                    'current_user_ranking_id' => $userRanking->id,
                    'alternative_id' => $ranking->alternative_id,
                    'alternative_name' => $ranking->alternative->name,
                    'pengguna_id' => $ranking->alternative->pengguna_id,
                    'score' => $score,
                    'score_akhir' => $score * 100,
                ]);

                $currentAlternative->current_criterias()->createMany($currentCriteria);
            }
            DB::commit();
            return redirect()->route('ranking.show', ['reference_code' => $uuid]);
        } catch (DataNotValidException $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return back()->withErrors([
                'error' => $e->getMessage(),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return back()->withErrors([
                'error' => 'Gagal mengjitung ranking.',
            ]);
        }
    }

    public function show($referenceCode)
    {
        $response = collect();
        $currentUserRanking = CurrentUserRanking::with(['current_alternatives.current_criterias'])->where('reference_code', $referenceCode)->firstOrFail()->toArray();
        $bobots = DB::table('current_criterias')
            ->select('current_criterias.criteria_name', DB::raw('MAX(current_criterias.criteria_value) as value'))
            ->join('current_alternatives', 'current_alternatives.id', '=', 'current_criterias.current_alternative_id')
            ->where('current_alternatives.current_user_ranking_id', $currentUserRanking['id'])
            ->groupBy('current_criterias.criteria_name', 'current_criterias.criteria_id')
            ->orderBy('current_criterias.criteria_id')
            ->get();

        $bobotArray = json_decode(json_encode($bobots), true);
        $normalization = $this->normalizationBobot($bobotArray);

        foreach ($currentUserRanking['current_alternatives'] as $userRanking) {
            $response->push([
                'alternative_name' => $userRanking['alternative_name'],
                'score' => $userRanking['score'],
                'score_akhir' => $userRanking['score_akhir'],
                'status' => $this->findStatusScore($userRanking['score_akhir']),
                'current_criterias' => $userRanking['current_criterias']
            ]);

        }

        return view('ranking.detail-ranking')->with([
            'referenceCode' => $currentUserRanking['reference_code'],
            'datas' => $response,
            'bobots' => $bobots,
            'normalizations' => $normalization,
        ]);
    }

    public function detail($id)
    {
        $ranking = UserRanking::with(['rankings'])->findOrFail($id);
        return response()->json($ranking);
    }

    public function update(Request $request, $id)
    {
        $data = $request->input('edit-data');
        $rules = [
            'alternative_id' => [
                'required',
                'exists:alternatives,id'
            ],
        ];
        $messages = [
            'alternative_id.required' => 'Alternative tidak boleh kosong',
            'alternative_id.exists' => 'Alternative tidak ditemukan'
        ];
        foreach ($data as $key => $value) {
            $rules["edit-data.$key"] = ['required', 'exists:sub_criterias,id'];
            $messages["edit-data.$key.required"] = "Kolom $key wajib diisi.";
            $messages["edit-data.$key.exists"] = "Data untuk $key tidak ditemukan di database.";
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $firstError = $validator->errors()->first();
            return response()->json(['errorFirst' => $firstError], 422);
        }

        try {
            DB::beginTransaction();
            foreach ($data as $key => $value) {
                Ranking::with(['criteria'])
                    ->where('user_ranking_id', $id)
                    ->whereHas('criteria', function ($query) use ($key) {
                        $query->where('slug', $key);
                    })->update(['sub_criteria_id' => $value]);
            }

            UserRanking::query()->findOrFail($id)->update(['alternative_id' => $request->input('alternative_id')]);

            DB::commit();
            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return response()->json(['success' => false], 422);
        }
    }

    public function delete($id)
    {
        UserRanking::query()->findOrFail($id)->delete();
        return response()->json(['success' => true], 200);
    }

    public function flow()
    {
        $response = collect();
        $bobots = [
            ['id' => 1, 'name' => 'Omset (juta)', 'value' => 5, 'slug' => 'disiplin'],
            ['id' => 2, 'name' => 'Pengalaman (tahun)', 'value' => 3, 'slug' => 'produktivitas'],
            ['id' => 3, 'name' => 'Kualitas Produk (skor)', 'value' => 2, 'slug' => 'kreativitas'],
        ];
        $datas = [
            [
                'alternative' => [
                    "name" => "A",
                ],
                'rankings' => [
                    [
                        'criteria_id' => 1,
                        'sub_criteria_id' => 1,
                        'criteria' => [
                            'name' => "Omset (juta)",
                            'value' => 5,
                        ],
                        'sub_criteria' => [
                            'name' => "Omset (juta) (50)",
                            'value' => 50,
                        ]
                    ],
                    [
                        'criteria_id' => 2,
                        'sub_criteria_id' => 1,
                        'criteria' => [
                            'name' => "Pengalaman (tahun)",
                            'value' => 3,
                        ],
                        'sub_criteria' => [
                            'name' => "Pengalaman (tahun) (4)",
                            'value' => 4,
                        ]
                    ],
                    [
                        'criteria_id' => 3,
                        'sub_criteria_id' => 1,
                        'criteria' => [
                            'name' => "Kualitas Produk (skor)",
                            'value' => 2,
                        ],
                        'sub_criteria' => [
                            'name' => "Kualitas Produk (skor) (80)",
                            'value' => 80,
                        ]
                    ]
                ]
            ],
            [
                'alternative' => [
                    "name" => "B",
                ],
                'rankings' => [
                    [
                        'criteria_id' => 1,
                        'sub_criteria_id' => 1,
                        'criteria' => [
                            'name' => "Omset (juta)",
                            'value' => 4,
                        ],
                        'sub_criteria' => [
                            'name' => "Omset (juta) (50)",
                            'value' => 60,
                        ]
                    ],
                    [
                        'criteria_id' => 2,
                        'sub_criteria_id' => 1,
                        'criteria' => [
                            'name' => "Pengalaman (tahun)",
                            'value' => 3,
                        ],
                        'sub_criteria' => [
                            'name' => "Pengalaman (tahun) (4)",
                            'value' => 3,
                        ]
                    ],
                    [
                        'criteria_id' => 3,
                        'sub_criteria_id' => 1,
                        'criteria' => [
                            'name' => "Kualitas Produk (skor)",
                            'value' => 2,
                        ],
                        'sub_criteria' => [
                            'name' => "Kualitas Produk (skor) (80)",
                            'value' => 90,
                        ]
                    ]
                ]
            ],
            [
                'alternative' => [
                    "name" => "C",
                ],
                'rankings' => [
                    [
                        'criteria_id' => 1,
                        'sub_criteria_id' => 1,
                        'criteria' => [
                            'name' => "Omset (juta)",
                            'value' => 4,
                        ],
                        'sub_criteria' => [
                            'name' => "Omset (juta) (50)",
                            'value' => 40,
                        ]
                    ],
                    [
                        'criteria_id' => 2,
                        'sub_criteria_id' => 1,
                        'criteria' => [
                            'name' => "Pengalaman (tahun)",
                            'value' => 3,
                        ],
                        'sub_criteria' => [
                            'name' => "Pengalaman (tahun) (4)",
                            'value' => 5,
                        ]
                    ],
                    [
                        'criteria_id' => 3,
                        'sub_criteria_id' => 1,
                        'criteria' => [
                            'name' => "Kualitas Produk (skor)",
                            'value' => 2,
                        ],
                        'sub_criteria' => [
                            'name' => "Kualitas Produk (skor) (80)",
                            'value' => 70,
                        ]
                    ]
                ]
            ],
        ];
        $maxValues = [
            ['criteria_id' => 1, 'value_max' => 60],
            ['criteria_id' => 2, 'value_max' => 5],
            ['criteria_id' => 3, 'value_max' => 90],
        ];
        $total = array_sum(array_column($bobots, 'value'));
        $bobotNormal = $this->normalizationBobot($bobots);

        foreach ($datas as $data) {
            $calculation = $this->calculationScore($bobotNormal, json_decode(json_encode($data['rankings'])), json_decode(json_encode($maxValues)));
            $response->push([
                'alternative' => $data['alternative']['name'],
                'results' => $calculation,
            ]);
        }


        return view('ranking.flow')->with([
            'totalBobot' => $total,
            'bobots' => $bobotNormal,
            'results' => $response,
            'maxValues' => $maxValues,
        ]);
    }

    public function export($referenceCode)
    {
        $response = collect();
        $currentUserRanking = CurrentUserRanking::with(['current_alternatives.current_criterias'])->where('reference_code', $referenceCode)->firstOrFail()->toArray();
        $bobots = DB::table('current_criterias')
            ->select('current_criterias.criteria_name', DB::raw('MAX(current_criterias.criteria_value) as value'))
            ->join('current_alternatives', 'current_alternatives.id', '=', 'current_criterias.current_alternative_id')
            ->where('current_alternatives.current_user_ranking_id', $currentUserRanking['id'])
            ->groupBy('current_criterias.criteria_name', 'current_criterias.criteria_id')
            ->orderBy('current_criterias.criteria_id')
            ->get();

        $bobotArray = json_decode(json_encode($bobots), true);
        $normalization = $this->normalizationBobot($bobotArray);

        foreach ($currentUserRanking['current_alternatives'] as $userRanking) {
            $response->push([
                'alternative_name' => $userRanking['alternative_name'],
                'score' => $userRanking['score'],
                'status' => $this->findStatusScore($userRanking['score']),
                'current_criterias' => $userRanking['current_criterias']
            ]);

        }

        return Excel::download(new RankingExport($normalization, $bobots, $response), 'ranking-' . time() . '.xlsx');
    }

    public function form()
    {
        $forms = Form::query()->orderByDesc('id')->get();
        return view('form.form')->with([
            'forms' => $forms,
        ]);
    }

    public function addForm(Request $request)
    {
        try {

            $validator = Validator::make($request->all(),
                [
                    'title' => 'required',
                    'expired_date' => 'required',
                ],
                [
                    'title.required' => 'Title wajib diisi.',
                    'expired_date.required' => 'Batas pengisian tidak boleh kosong.',
                ]
            );

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            $uuid = Str::uuid();
            $request = $request->merge(['code' => $uuid, 'user_id' => Auth::id()]);

            Form::query()->create($request->all());
            return redirect()->route('ranking')->with('success', 'Formulir berhasil ditambahkan');

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()->withErrors([
                'error' => 'Gagal menambah formulir.',
            ]);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Alternative;
use App\Models\AlternativeRanking;
use App\Models\Criteria;
use App\Models\CurrentAlternative;
use App\Models\CurrentUserRanking;
use App\Models\Ranking;
use App\Models\SubCriteria;
use App\Models\User;
use App\Models\UserRanking;
use App\Traits\CalculationTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RankingController extends Controller
{
    use CalculationTrait;

    public function index()
    {
        $curentUserRanking = CurrentUserRanking::query()->where('user_id', Auth::id())
            ->orderByDesc('id')->get();
        return view('ranking.ranking')->with('curentUserRanking', $curentUserRanking);
    }

    public function save()
    {
        $userId = Auth::id();
        $alternatives = Alternative::query()->where('user_id', $userId)->orderByDesc('id')->get();
        $criterias = Criteria::with(['subCriterias'])->where('user_id', $userId)->get();
        $rankings = UserRanking::query()->where('user_id', $userId)->get();
        return view('ranking.create-ranking')->with([
            'alternatives' => $alternatives,
            'criterias' => $criterias,
            'rankings' => $rankings,
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
        ];
        $messages = [
            'alternative_id.required' => 'Alternative tidak boleh kosong',
            'alternative_id.exists' => 'Alternative tidak ditemukan'
        ];
        foreach ($data as $key => $value) {
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
            $userId = Auth::id();
            $subCriteriaIds = [];
            foreach ($data as $key => $value) {
                $subCriteriaIds[] = $value;
            }

            $subCriterias = SubCriteria::query()->whereIn('id', $subCriteriaIds)->get();

            $userRanking = UserRanking::query()->create([
                'user_id' => $userId,
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
            return redirect()->route('ranking.save')->with('success', 'Ranking berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return back()->withErrors([
                'error' => 'Gagal menambah ranking.',
            ]);
        }
    }

    public function calculation()
    {
        $uuid = Str::uuid();
        try {
            DB::beginTransaction();
            $userId = Auth::id();
            $criterias = Criteria::query()->where('user_id', $userId)
                ->orderBy('id')->get()->toArray();
            $rankings = UserRanking::with(
                [
                    'alternative',
                    'rankings.criteria',
                    'rankings.sub_criteria',
                ]
            )->where('user_id', $userId)->orderBy('id')->get();
            $maxBobot = DB::table('rankings')
                ->select('criterias.slug as name', DB::raw('MAX(sub_criterias.value) as max_bobot'))
                ->join('criterias', 'criterias.id', '=', 'rankings.criteria_id')
                ->join('sub_criterias', 'sub_criterias.id', '=', 'rankings.sub_criteria_id')
                ->groupBy('rankings.criteria_id')
                ->get();
            $normalization = $this->normalizationBobot($criterias);

            $userRanking = CurrentUserRanking::query()->create([
                'user_id' => $userId,
                'reference_code' => $uuid
            ]);

            foreach ($rankings as $ranking) {
                $score = 0;
                $currentCriteria = $this->calculationScore($normalization, $ranking->rankings, $maxBobot);
                foreach ($currentCriteria as $criteria) {
                    $score += $criteria['score'];
                }
                $currentAlternative = CurrentAlternative::query()->create([
                    'current_user_ranking_id' => $userRanking->id,
                    'alternative_id' => $ranking->alternative_id,
                    'alternative_name' => $ranking->alternative->name,
                    'score' => $score,
                ]);

                $currentAlternative->current_criterias()->createMany($currentCriteria);

            }
            DB::commit();
            return redirect()->route('ranking.show', ['reference_code' => $uuid]);
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
            ->select('current_criterias.criteria_name', DB::raw('ANY_VALUE(current_criterias.criteria_value) as value'))
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

        return view('ranking.detail-ranking')->with([
            'datas' => $response,
            'bobots' => $bobots,
            'normalizations' => $normalization,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Alternative;
use App\Models\Criteria;
use App\Models\Ranking;
use App\Models\SubCriteria;
use App\Models\User;
use App\Models\UserRanking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RankingController extends Controller
{
    public function index()
    {
        return view('ranking.ranking');
    }

    public function save()
    {
        $userId = Auth::id();
        $alternatives = Alternative::query()->where('user_id', $userId)->orderByDesc('id')->get();
        $criterias = Criteria::with(['subCriterias'])->where('user_id', $userId)->get();
        $rankings = UserRanking::with(['alternative', 'rankings.criteria', 'rankings.sub_criteria'])->where('user_id', $userId)
            ->orderByDesc('id')->get();
        return view('ranking.create-ranking')->with([
            'alternatives' => $alternatives,
            'criterias' => $criterias,
            'rankings' => $rankings
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
            $subCriteriaIds = [];
            foreach ($data as $key => $value) {
                $subCriteriaIds[] = $value;
            }

            $subCriterias = SubCriteria::query()->whereIn('id', $subCriteriaIds)->get();
            $userRanking = UserRanking::query()->create([
                'user_id' => Auth::id(),
                'alternative_id' => $request->input('alternative_id'),
                'reference_code' => Str::uuid(),
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
}

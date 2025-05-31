<?php

namespace App\Http\Controllers;

use App\Enum\RoleEnum;
use App\Models\CurrentUserRanking;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->hasRole(RoleEnum::PENGUSAHA->value)) {
            return redirect()->route('ranking');
        }
        $now = Carbon::now()->format('Y-m-d');
        $kategoriLengkap = ['Sangat Layak', 'Layak', 'Cukup Layak', 'Tidak Layak'];

        $totalUser = User::all()->count();
        $totalUmkm = User::query()->whereHas('roles', function ($query) {
            $query->where('name', RoleEnum::PENGUSAHA->value);
        })->count();
        $totalRanking = CurrentUserRanking::all()->count();
        $totalRankingToday = CurrentUserRanking::query()
            ->whereDate('created_at', $now)->count();

        $criteriaResults = DB::table('current_alternatives')
            ->selectRaw("
        CASE
            WHEN score >= 0.8 THEN 'Sangat Layak'
            WHEN score >= 0.7 THEN 'Layak'
            WHEN score >= 0.6 THEN 'Cukup Layak'
            ELSE 'Tidak Layak'
        END as kategori,
        COUNT(*) as total
    ")
            ->groupBy('kategori')
            ->orderBy('kategori')
            ->get();

        $criteriaResultsYear = DB::table('current_alternatives')
            ->selectRaw("
        YEAR(created_at) as tahun,
        CASE
            WHEN score >= 0.8 THEN 'Sangat Layak'
            WHEN score >= 0.7 THEN 'Layak'
            WHEN score >= 0.6 THEN 'Cukup Layak'
            ELSE 'Tidak Layak'
        END as kategori,
        COUNT(*) as total
    ")
            ->groupBy('tahun', 'kategori')
            ->orderBy('tahun', 'asc')
            ->get();

        $rankingMaxs = CurrentUserRanking::query()->select('current_users_rankings.*')
            ->join('current_alternatives', 'current_alternatives.current_user_ranking_id', '=', 'current_users_rankings.id')
            ->selectRaw('MAX(current_alternatives.score) as max_rating')
            ->groupBy('current_users_rankings.id')
            ->orderByDesc('max_rating')
            ->limit(5)
            ->get();

        $responseCriteria = [
            'criteria' => $criteriaResults->pluck('kategori')->toArray(),
            'total' => $criteriaResults->pluck('total')->toArray(),
        ];

        $groupedByYear = $criteriaResultsYear->groupBy('tahun');

        $final = [];

        foreach ($groupedByYear as $tahun => $dataKategori) {
            $mapKategori = collect($kategoriLengkap)->map(function ($kategori) use ($dataKategori) {
                $item = $dataKategori->firstWhere('kategori', $kategori);
                return [
                    'kategori' => $kategori,
                    'total' => $item ? $item->total : 0
                ];
            });

            $final[] = [
                'tahun' => $tahun,
                'data' => $mapKategori
            ];
        }

        $years = [];
        $sangatLayak = [];
        $layak = [];
        $cukupLayak = [];
        $tidakLayak = [];
        foreach ($final as $fin) {
            array_push($years, $fin['tahun']);
            foreach ($fin['data'] as $data) {
                if ($data['kategori'] == 'Sangat Layak') {
                    array_push($sangatLayak, $data['total']);
                } elseif ($data['kategori'] == 'Layak') {
                    array_push($layak, $data['total']);
                } elseif ($data['kategori'] == 'Cukup Layak') {
                    array_push($cukupLayak, $data['total']);
                } else {
                    array_push($tidakLayak, $data['total']);
                }
            }
        }

        $responseYear = [
            'years' => $years,
            'sangat_layak' => $sangatLayak,
            'layak' => $layak,
            'cukup_layak' => $cukupLayak,
            'tidak_layak' => $tidakLayak
        ];


        $data = [
            'totalRanking' => $totalRanking,
            'totalRankingToday' => $totalRankingToday,
            'totalUser' => $totalUser,
            'totalUmkm' => $totalUmkm,
            'responseCriteria' => $responseCriteria,
            'responseYear' => $responseYear,
            'rankingMaxs' => $rankingMaxs,
        ];

        return view('dashboard.dashboard')->with('data', $data);
    }
}

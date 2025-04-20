<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\SubCriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SubCriteriaController extends Controller
{
    public function index()
    {
        $subCriterias = SubCriteria::with(['criteria'])->orderByDesc('id')->get();
        $criterias = Criteria::query()->where('user_id', Auth::id())->orderByDesc('id')->get();
        return view('criteria.sub-criteria')->with([
            'subCriterias' => $subCriterias,
            'criterias' => $criterias
        ]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'criteria_id' => 'required|exists:criterias,id',
                'name' => 'required',
                'value' => 'required|numeric|min:1|max:100',
            ],
            [
                'criteria_id.required' => 'Kriteria wajib diisi.',
                'criteria_id.exists' => 'Criteria yang dipilih tidak ada.',
                'name.required' => 'Nama wajib diisi.',
                'value.min' => 'Nilai minimal harus 0.',
                'value.max' => 'Nilai maximal harus 100.',
                'value.required' => 'Nilai tidak boleh kosong.',
                'value.numeric' => 'Nilai harus berupa angka.',
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            SubCriteria::query()->create($request->all());
            return redirect()->route('sub-criteria')->with('success', 'Sub kriteria berhasil ditambahkan');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()->withErrors([
                'error' => 'Gagal menambah sub kriteria.',
            ]);
        }
    }
}

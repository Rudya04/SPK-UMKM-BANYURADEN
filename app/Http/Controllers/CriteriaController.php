<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\SubCriteria;
use App\Traits\SlugFormatTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CriteriaController extends Controller
{
    use SlugFormatTrait;

    public function index()
    {
        $criterias = Criteria::query()->where('user_id', Auth::id())->orderByDesc('id')->get();
        return view('criteria.criteria')->with('criterias', $criterias);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'name' => 'required',
                'value' => 'required|numeric|min:0|max:100',
            ],
            [
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
            $request->merge([
                'user_id' => Auth::id(),
                'slug' => strtolower($this->clearString($request->input('name'))),
            ]);

            Criteria::query()->create($request->all());
            return redirect()->route('criteria')->with('success', 'Kriteria berhasil ditambahkan');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()->withErrors([
                'error' => 'Gagal menambah kriteria.',
            ]);
        }
    }

    public function show($id)
    {
        $criteria = Criteria::query()->findOrFail($id);
        return response()->json($criteria);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),
            [
                'name' => 'required',
                'value' => 'required|numeric|min:0|max:100',
            ],
            [
                'name.required' => 'Nama wajib diisi.',
                'value.min' => 'Nilai minimal harus 0.',
                'value.max' => 'Nilai maximal harus 100.',
                'value.required' => 'Nilai tidak boleh kosong.',
                'value.numeric' => 'Nilai harus berupa angka.',
            ]
        );

        if ($validator->fails()) {
            $firstError = $validator->errors()->first();
            return response()->json(['errorFirst' => $firstError], 422);
        }

        Criteria::query()->findOrFail($id)->update($request->only(['name', 'value']));

        return response()->json(['success' => true], 200);
    }

    public function delete($id)
    {
        Criteria::query()->findOrFail($id)->delete();
        return response()->json(['success' => true], 200);
    }
}

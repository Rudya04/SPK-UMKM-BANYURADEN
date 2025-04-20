<?php

namespace App\Http\Controllers;

use App\Models\Alternative;
use App\Models\Criteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AlternativeController extends Controller
{
    public function index()
    {
        $alternatives = Alternative::query()->where('user_id', Auth::id())->orderByDesc('id')->get();
        return view('criteria.alternative')->with('alternatives', $alternatives);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'name' => 'required',
            ],
            [
                'name.required' => 'Nama wajib diisi.',
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $request->merge([
                'user_id' => Auth::id()
            ]);
            Alternative::query()->create($request->all());
            return redirect()->route('alternative')->with('success', 'Alternative berhasil ditambahkan');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()->withErrors([
                'error' => 'Gagal menambah alternative.',
            ]);
        }
    }
}

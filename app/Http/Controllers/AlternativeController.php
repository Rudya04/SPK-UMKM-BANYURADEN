<?php

namespace App\Http\Controllers;

use App\Enum\RoleEnum;
use App\Models\Alternative;
use App\Models\Criteria;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AlternativeController extends Controller
{
    public function index()
    {
        $alternatives = Alternative::with(['pengusaha'])
            ->where('user_id', Auth::id())
            ->orderByDesc('id')->get();
        return view('criteria.alternative')->with('alternatives', $alternatives);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
            ],
            [
                'name.required' => 'Nama wajib diisi.',
                'email.required' => 'Email wajib diisi.',
                'email.unique' => 'Email sudah terdaftar.',
            ]
        );


        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }


        try {
            DB::beginTransaction();
            $email = $request->input('email');
            $name = $request->input('name');
            $password = Str::random(12);

            $umkm = User::query()->create([
                "name" => $name,
                "email" => $email,
                "password" => Hash::make($password),
                "is_admin" => false,
                "created_at" => now(),
                "updated_at" => now(),
                "password_text" => $password,
            ]);

            $umkm->assignRole(RoleEnum::PENGUSAHA->value);
            $request->merge([
                'user_id' => Auth::id(),
                'pengusaha_id' => $umkm->id
            ]);
            Alternative::query()->create($request->all());
            DB::commit();
            return redirect()->route('alternative')->with('success', 'Alternative berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return back()->withErrors([
                'error' => 'Gagal menambah alternative.',
            ]);
        }
    }

    public function show($id)
    {
        $alternative = Alternative::query()->findOrFail($id);
        return response()->json($alternative);
    }

    public function update(Request $request, $id)
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
            $firstError = $validator->errors()->first();
            return response()->json(['errorFirst' => $firstError], 422);
        }

        try {
            DB::beginTransaction();
            $alternatives = Alternative::query()->findOrFail($id);
            User::query()->findOrFail($alternatives->pengusaha_id)->update(['name' => $request->input('name')]);
            $alternatives->update($request->only(['name']));
            DB::commit();
            return response()->json(['success' => true], 200);
        } catch (\Exception $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return response()->json(['errorFirst' => 'Gagal memperbarui alternative.'], 422);
        }
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $alternative = Alternative::query()->findOrFail($id);
            $userId = $alternative->pengusaha_id;
            $alternative->delete();
            User::withTrashed()->findOrFail($userId)->forceDelete();
            DB::commit();
            return response()->json(['success' => true], 200);
        }catch (\Exception $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return response()->json(['errorFirst' => 'Gagal menghapus alternative.'], 422);
        }
    }
}

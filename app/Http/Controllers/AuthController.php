<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use mysql_xdevapi\Exception;

class AuthController extends Controller
{
    public function index()
    {
        return view("auth.login");
    }

    public function login(Request $request)
    {
        try {
            $credential = $request->validate([
                "email" => "required|email",
                "password" => "required"
            ]);
            if (Auth::attempt($credential)) {
                $request->session()->regenerate();
                return redirect()->intended('/');
            }
        }catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}

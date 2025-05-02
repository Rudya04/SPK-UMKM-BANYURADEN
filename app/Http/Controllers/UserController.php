<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        $users = User::with('roles')->orderBy('id')->get();
        return view('user.index')->with('users', $users);
    }
}

<?php

namespace App\Http\Controllers;

use App\Enum\RoleEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuideController extends Controller
{
    public function index() {
    if (Auth::user()->hasRole(RoleEnum::PENGUSAHA->value)) {
                return view('guide.pengusaha');
    }
        return view('guide.admin');
    }
}


<?php

use App\Http\Controllers\AlternativeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CriteriaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\SubCriteriaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'index')->name('login');
    Route::post('/login', 'login')->name('login.submit');
});

Route::middleware(['auth'])->group(function () {

    Route::controller(DashboardController::class)->group(function () {
        Route::get('/', 'index')->name('dashboard');
    });

    Route::controller(PermissionController::class)->group(function () {
        Route::get('/permission', 'index')->name('permission');
        Route::post('/permission', 'permission')->name('permission.submit');
    });

    Route::controller(CriteriaController::class)->group(function () {
        Route::get('/criteria', 'index')->name('criteria');
        Route::post('/criteria', 'create')->name('criteria.submit');
    });

    Route::controller(SubCriteriaController::class)->group(function () {
        Route::get('/sub-criteria', 'index')->name('sub-criteria');
        Route::post('/sub-criteria', 'create')->name('sub-criteria.submit');
    });

    Route::controller(AlternativeController::class)->group(function () {
        Route::get('/alternative', 'index')->name('alternative');
        Route::post('/alternative', 'create')->name('alternative.submit');
    });

    Route::controller(RankingController::class)->group(function () {
        Route::get('/ranking', 'index')->name('ranking');
        Route::get('/ranking/create', 'save')->name('ranking.save');
        Route::post('/ranking/create', 'create')->name('ranking.submit');
        Route::get('/ranking/calculation', 'calculation')->name('ranking.calculation');
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

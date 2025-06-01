<?php

use App\Http\Controllers\AlternativeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CriteriaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuideController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\SubCriteriaController;
use App\Http\Controllers\UserController;
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

    Route::controller(UserController::class)->group(function () {
        Route::get('/user', 'index')->name('user.index');
    });

    Route::controller(PermissionController::class)->group(function () {
        Route::get('/permission', 'index')->name('permission');
        Route::post('/permission', 'permission')->name('permission.submit');
    });

    Route::controller(CriteriaController::class)->group(function () {
        Route::get('/criteria', 'index')->name('criteria');
        Route::get('/criteria/{id}', 'show')->name('criteria.show');
        Route::put('/criteria/{id}', 'update')->name('criteria.update');
        Route::post('/criteria', 'create')->name('criteria.submit');
        Route::get('/criteria/{id}/delete', 'delete')->name('criteria.delete');
    });

    Route::controller(SubCriteriaController::class)->group(function () {
        Route::get('/sub-criteria', 'index')->name('sub-criteria');
        Route::get('/sub-criteria/{id}', 'show')->name('sub-criteria.show');
        Route::put('/sub-criteria/{id}', 'update')->name('sub-criteria.update');
        Route::post('/sub-criteria', 'create')->name('sub-criteria.submit');
        Route::get('/sub-criteria/{id}/delete', 'delete')->name('sub-criteria.delete');
    });

    Route::controller(AlternativeController::class)->group(function () {
        Route::get('/alternative', 'index')->name('alternative');
        Route::get('/alternative/{id}', 'show')->name('alternative.show');
        Route::post('/alternative', 'create')->name('alternative.submit');
        Route::put('/alternative/{id}', 'update')->name('alternative.update');
        Route::get('/alternative/{id}/delete', 'delete')->name('alternative.delete');
    });

    Route::controller(RankingController::class)->group(function () {
        Route::get('/ranking', 'index')->name('ranking');
        Route::get('/ranking/create', 'save')->name('ranking.save');
        Route::post('/ranking/create', 'create')->name('ranking.submit');
        Route::post('/ranking/calculation', 'calculation')->name('ranking.calculation');
        Route::get('/ranking/criteria', 'criteria')->name('ranking.criteria');
        Route::get('/flow', 'flow')->name('ranking.flow');
        Route::get('/ranking/{reference_code?}', 'show')->name('ranking.show');
        Route::get('/ranking/{reference_code?}/export', 'export')->name('ranking.export');
        Route::get('/ranking/rank/{id}', 'detail')->name('ranking.detail');
        Route::put('/ranking/rank/{id}', 'update')->name('ranking.update');
        Route::get('/ranking/rank/{id}/delete', 'delete')->name('ranking.delete');
    });

    Route::get('/guide', [GuideController::class, 'index'])->name('guide.index');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

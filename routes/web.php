<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\MyWorkApplicationController;
use App\Http\Controllers\MyWorkController;
use App\Http\Controllers\WorkApplicationController;
use App\Http\Controllers\WorkController;
use App\Http\Middleware\Employer;
use Illuminate\Support\Facades\Route;

// kalau route tak define clear cache

Route::get('', fn () => to_route('jobs.index'));

Route::resource('jobs', WorkController::class)
    ->only(['index', 'show']);

Route::get('login', fn () => to_route('auth.create'))->name('login');
Route::resource('auth', AuthController::class)
    ->only(['create', 'store']);
Route::delete('logout', fn() => to_route('auth.destroy'))->name('logout');
Route::delete('auth', [AuthController::class, 'destroy'])->name('auth.destroy');

Route::middleware('auth')->group(function () {
    Route::resource('job.application', WorkApplicationController::class)
        ->only(['create', 'store']);

    Route::resource('my-job-applications', MyWorkApplicationController::class)
        ->only(['index', 'destroy']);

    Route::resource('employer', EmployerController::class)
        ->only(['create', 'store']);

    Route::middleware('employer')
        ->resource('my-jobs', MyWorkController::class);
});
<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;


Route::get("/", [WelcomeController::class, 'index'])->name('welcome');
Route::post("/", [WelcomeController::class, 'store']);

//Route::middleware(['auth'])->group(function () {
    Route::get("dashboard", [DashboardController::class, 'index'])->name('dashboard');
    Route::post("dashboard", [DashboardController::class, 'index'])->name('dashboard');
    Route::get("timeline/{pedido_id}", [DashboardController::class, 'timeline'])->name('timeline');
//});

Route::get('/env-test', function () {
    return env('DB_DATABASE');
});


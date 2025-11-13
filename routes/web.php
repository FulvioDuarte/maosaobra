<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ConfigController;
use Illuminate\Support\Facades\Route;


Route::get("/", [WelcomeController::class, 'index'])->name('welcome');
Route::post("/", [WelcomeController::class, 'store']);

Route::get("configpainel/{desc}", [ConfigController::class, 'configpainel'])->name('configpainel');

Route::middleware(['auth'])->group(function () {
    Route::get("menuprincipal", [MenuController::class, 'menuprincipal'])->name('menuprincipal');
    
    Route::get("menu", [MenuController::class, 'index'])->name('menu.index');
    

    Route::get("dashboard", [DashboardController::class, 'index'])->name('dashboard');
    Route::post("dashboard", [DashboardController::class, 'index'])->name('dashboard');
    Route::get("timeline/{pedido_id}", [DashboardController::class, 'timeline'])->name('timeline');
    

});



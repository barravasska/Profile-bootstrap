<?php

use Illuminate\Support\Facades\Route;
// Jangan lupa import Controllernya di bagian atas
use App\Http\Controllers\PersonalDataController;
 

// 1. Route untuk Halaman Depan
Route::get('/', function () {
    return view('welcome');
});

// 2. Route untuk Personal Data (Dipisah, jangan di dalam function diatas)
Route::get('/personal-data', [PersonalDataController::class, 'index'])->name('personal-data.index');
Route::get('/personal-data/edit', [PersonalDataController::class, 'edit'])->name('personal-data.edit');
Route::post('/personal-data/update', [PersonalDataController::class, 'update'])->name('personal-data.update');
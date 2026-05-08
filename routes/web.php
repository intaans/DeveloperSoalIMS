<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KreditController;

Route::get('/', [KreditController::class, 'index']);
Route::post('/hitung', [KreditController::class, 'hitung'])->name('hitung.kredit');
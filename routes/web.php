<?php

use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FrontendController::class, 'index']);
Route::post('/', [FrontendController::class, 'search'])->name('sekolah.cari');

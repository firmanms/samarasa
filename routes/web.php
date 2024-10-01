<?php

use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

Route::get('/', [FrontendController::class, 'index']);
Route::post('/', [FrontendController::class, 'search'])->name('sekolah.cari');
// Route::match(['get', 'post'], '/samarasa', [FrontendController::class, 'search'])->name('sekolah.cari');

 Livewire::setScriptRoute(function ($handle) {
 return Route::get('/samarasa/livewire/livewire.js', $handle);
   });

   Livewire::setUpdateRoute(function ($handle) {
   return Route::post('/samarasa/livewire/update', $handle);
   });

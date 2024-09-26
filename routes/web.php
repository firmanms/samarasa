<?php

use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

//setting apabila notfound
 Livewire::setScriptRoute(function ($handle) {
 return Route::get('/kerudung/livewire/livewire.js', $handle);
   });

   Livewire::setUpdateRoute(function ($handle) {
   return Route::post('/kerudung/livewire/update', $handle);
   });

   Route::get('/', [FrontendController::class, 'index']);
   Route::post('/', [FrontendController::class, 'search'])->name('sekolah.cari');

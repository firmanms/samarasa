<?php

use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

//setting apabila notfound
 Livewire::setScriptRoute(function ($handle) {
 return Route::get('/kerudung/livewire/livewire.js', $handle);
   });

   Livewire::setUpdateRoute(function ($handle) {
   return Route::post('/kerudung/livewire/update', $handle);
   });

Route::get('/', function () {
    return view('frontend.index');
});

<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
Route::view('/', 'welcome');
Route::view('/', 'welcome')->name("home");




require __DIR__.'/auth.php';

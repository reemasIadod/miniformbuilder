<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
Route::view('/', 'welcome');

// Volt::route('/', 'pages.auth.login');
// Volt::route('/', 'pages.form-builder');

// Route::get('/forms/create', function () {
//     return view('pages.forms-create-view');
// })->name('forms.create');

// Volt::route('/create', 'pages.forms-create-view')->name('forms.create'); 
// Volt::route('/create', 'pages.forms-create-view')->name('create');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');



require __DIR__.'/auth.php';

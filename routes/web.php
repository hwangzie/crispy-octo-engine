<?php

use Illuminate\Support\Facades\Route;

Route::get('/login', App\Livewire\Login::class)->name('login');

Route::middleware('auth')->group(function () {
    Route::get('/', App\Livewire\Dashboard::class)->name('dashboard');
    Route::get('/homw', App\Livewire\Homw::class)->name('homw');
});

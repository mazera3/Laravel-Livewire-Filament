<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Tutorial\Counter;
use App\Livewire\Tutorial\Todo;

Route::get('/counter', Counter::class);
Route::get('/todo', Todo::class);


Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard\Index;


Route::view('/', 'welcome')->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', Index::class)
        ->name('dashboard');
});


Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

    



require __DIR__.'/auth.php';
require __DIR__.'/UserManagement.php';
require __DIR__.'/MasterData.php';

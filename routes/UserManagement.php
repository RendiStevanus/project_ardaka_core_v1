<?php
use App\Livewire\UserManagement\User\Index as UserIndex;
use App\Livewire\UserManagement\Role\Index as RoleIndex;
use App\Livewire\UserManagement\Permission\Index as PermissionIndex;

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/users', UserIndex::class)
        ->name('users');
    Route::get('/roles', RoleIndex::class)
        ->name('roles');
    Route::get('/permissions', PermissionIndex::class)
        ->name('permissions');
});

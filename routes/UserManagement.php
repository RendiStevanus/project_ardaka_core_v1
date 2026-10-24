<?php

use App\Livewire\UserManagement\User\Index as UserIndex;
use App\Livewire\UserManagement\Role\Index as RoleIndex;
use App\Livewire\UserManagement\Permission\Index as PermissionIndex;
use App\Livewire\ActivityLog\Index as ActivityLogIndex;
use App\Livewire\UserManagement\User\Trashed as UserTrashed;

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/users', UserIndex::class)
        ->name('users');
    Route::get('/roles', RoleIndex::class)
        ->name('roles');
    Route::get('/permissions', PermissionIndex::class)
        ->name('permissions');


    Route::get('/activity-logs', ActivityLogIndex::class)
        ->name('activity-logs')
        ->middleware('can:read_activity_log');

    Route::get('/users/trashed', UserTrashed::class)
        ->name('users.trashed')
        ->middleware('can:restore_user');
});

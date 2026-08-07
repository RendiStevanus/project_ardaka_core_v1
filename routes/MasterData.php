<?php
use App\Livewire\MasterData\ProgramStudi\Index as ProgramStudiIndex;
use Illuminate\Support\Facades\Route;
Route::middleware(['auth'])->group(function () {
    Route::get('program-studi', ProgramStudiIndex::class)
        ->name('program-studi');
});
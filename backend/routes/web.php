<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MemoryController;
use App\Http\Controllers\LoverController;

Route::post('/lover/store', [LoverController::class, 'store'])->name('lover.store');
Route::get('/lover', [LoverController::class, 'index'])->name('lover.index');
Route::get('/lover/{id}', [LoverController::class, 'show'])->name('lover.show');
Route::get('/lover/{id}/edit', [LoverController::class, 'edit'])->name('lover.edit');
Route::put('/lover/{id}', [LoverController::class, 'update'])->name('lover.update');
Route::delete('/lover/{id}', [LoverController::class, 'destroy'])->name('lover.destroy');
Route::post('/lover/{id}/add-memory', [LoverController::class, 'addMemory'])->name('lover.addMemory');
Route::get('/lover/{id}/memory', [LoverController::class, 'memory'])->name('lover.memory');
Route::post('/lover/{id}/memory/add', [LoverController::class, 'addMemoryImage'])->name('lover.memory.add');
Route::delete('/lover/{id}/memory/{imageId}', [LoverController::class, 'deleteMemoryImage'])->name('lover.memory.delete');



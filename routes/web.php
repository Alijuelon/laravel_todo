<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Auth::routes();

Route::get('/', function () {
    return view('auth/login');
});

Route::get('Todo/index', [App\Http\Controllers\TodoController::class, 'index'])->name('todo.index');
Route::get('Todo/tambah', [App\Http\Controllers\TodoController::class, 'create'])->name('todo.tambah');
Route::get('Todo/history', [App\Http\Controllers\TodoController::class, 'history'])->name('todo.history');
Route::get('Todo/pending', [App\Http\Controllers\TodoController::class, 'pending'])->name('todo.pending');
Route::post('Todo/tambah', [App\Http\Controllers\TodoController::class, 'store'])->name('todo.store');
// Rute untuk memperbarui Todo
Route::put('/todos/{todo}/update', [App\Http\Controllers\TodoController::class, 'update'])->name('todo.update');
Route::delete('/todos/{todo}/destroy', [App\Http\Controllers\TodoController::class, 'destroy'])->name('todo.destroy');

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

Route::get('/students',[StudentController::class,'index'])->name('students');
Route::get('/add', [StudentController::class,'create'])->name('add');
Route::post('store-form', [StudentController::class, 'store'])->name('store-form');
Route::get('edit-form/{id}', [StudentController::class, 'edit'])->name('edit');
Route::put('edit-form', [StudentController::class, 'update'])->name('edit-form');
Route::delete('delete/{id}', [StudentController::class, 'destroy'])->name('delete');



<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', [StudentController::class, 'index'])
    ->name('students.index');

Route::post('/students', [StudentController::class, 'store'])
    ->name('students.store');

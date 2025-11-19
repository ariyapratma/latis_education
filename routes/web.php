<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    // Route Resource untuk Student (mencakup index, create, store, show, edit, update, destroy)
    Route::resource('students', StudentController::class);

    // Route tambahan untuk DataTables AJAX
    Route::get('/students-data', [StudentController::class, 'getData'])->name('students.data');

    // Route tambahan untuk Export Excel
    Route::get('/students-export', [StudentController::class, 'export'])->name('students.export');
});

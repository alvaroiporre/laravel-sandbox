<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\studentController;

Route::get('/students', [studentController::class, 'index']);

Route::get('/students/{id}', function() {
    return 'Studens by id';
});

Route::post('/students', [studentController::class, 'store']);

Route::put('/students/{id}', function() {
    return 'Update Student';
});

Route::delete('/students/{id}', function() {
    return 'Delete student';
});


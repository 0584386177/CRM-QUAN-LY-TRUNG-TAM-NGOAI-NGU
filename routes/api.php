<?php

use App\Http\Controllers\Api\AjaxController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// AJAX API
Route::get('/search-navbar', [AjaxController::class, 'searchNavbar'])->name('search.navbar');


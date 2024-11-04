<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PropertyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/admin/dashboard', [DashboardController::class,"listRequestsInfo"]);
// ->middleware('auth:sanctum');


Route::get('/properties', function (Request $request) {
    return response()->json(["message" => "data logged"]);
});


Route::get('/properties/search', [PropertyController::class, 'search']);
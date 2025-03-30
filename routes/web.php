<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SensorController;

Route::get('/', function () {
    return view('home');
});
Route::get('/admin-dashboard', function () {
    return view('admin-dashboard');
});
Route::get('/admin-login', function () {
    return view('admin-login');
});
Route::post('/sensor-register',[SensorController::class, 'register']);

<?php

use App\Models\Admins;
use App\Models\Sensor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AQIController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminsController;
use App\Http\Controllers\SensorController;
use App\Models\AQI;
use Illuminate\Support\Facades\Log;

Route::get('/', function () {
    $sensors = Sensor::where('status', 1)->get();
    return view('home', [
        'sensors' => $sensors
    ]);
});

Route::get('/admin-login', function () {
    return view('admin-login');
});
Route::get('/admin-register', function () {
    return view('admin-register');
});


Route::post('/sensor-register', [SensorController::class, 'register']);

Route::post('/save-aqi', [AQIController::class, 'store']);

Route::post('/admin-register-process', [AdminsController::class, 'register']);
Route::post('/Adminlogin', [AdminsController::class, 'login']);
Route::post('/logout', [AdminsController::class, 'logout']);


Route::get('/admin-dashboard', function () {

    $admin = auth()->guard('admin')->user();
    $sensors = Sensor::where('admins_id', $admin->id)->get();

    $totSensors = Sensor::all()->count();

    $activeCount = Sensor::where('status', 1)
        ->Where('admins_id', $admin->id)
        ->count();

    return view('admin-dashboard', [
        'sensors' => $sensors,
        'activeCount' => $activeCount,
        'totSensors' => $totSensors
    ]);
});

Route::get('/user-management', function () {
    $Admins = Admins::all();
    return view('user-management', [
        'admins' => $Admins
    ]);
});

Route::get('/admin-logout', function () {
    session()->invalidate();
    return view('admin-login');
});

Route::post('/sensor-status', [SensorController::class, 'status']);

Route::post('/user-status', [AdminsController::class, 'status']);

Route::post('/load-chart', [SensorController::class, 'loadChart']);

Route::get('/sensor-chart', function (Request $request) {
    $sensorId = $request->query('id');

    $sensor = Sensor::find($sensorId);

    $aqiData = AQI::where('city', $sensor->location)->get();

    return view('chart', [
        'aqiData' => $aqiData,
        'location' => $sensor->location
    ]);
});

Route::get('/user-dashboard', function (Request $request) {

    $adminId = $request->query('id');
    $admin = Admins::find($adminId);
    $sensors = Sensor::where('admins_id', $admin->id)->get();

    $totSensors = Sensor::all()->count();

    $activeCount = Sensor::where('status', 1)
        ->Where('admins_id', $admin->id)
        ->count();

    return view('user-dashboard', [
        'name' => $admin->name,
        'sensors' => $sensors,
        'activeCount' => $activeCount,
        'totSensors' => $totSensors
    ]);
});

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\ClientHub\Http\Controllers\VehicleController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Direct un-prefixed vehicle route aliases for client convenience
Route::match(['get', 'post'], 'vehicle/lookup', [VehicleController::class, 'lookupVehicle']);
Route::get('vehicle/lookup/{vrm}', [VehicleController::class, 'lookupVehicle']);
Route::match(['get', 'post'], 'vehicles/lookup', [VehicleController::class, 'lookupVehicle']);
Route::get('vehicles/lookup/{vrm}', [VehicleController::class, 'lookupVehicle']);
Route::match(['get', 'post'], 'vehicle/reference-data', [VehicleController::class, 'getReferenceData']);
Route::match(['get', 'post'], 'vehicles/reference-data', [VehicleController::class, 'getReferenceData']);
Route::match(['get', 'post'], 'vehicle/models', [VehicleController::class, 'getModelsByMake']);
Route::match(['get', 'post'], 'vehicles/models', [VehicleController::class, 'getModelsByMake']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('vehicles', [VehicleController::class, 'getVehicleDetail']);
    Route::get('vehicles/{id}', [VehicleController::class, 'getSingleVehicle']);
    Route::post('vehicles', [VehicleController::class, 'saveVehicleDetail']);
    Route::post('vehicles/add', [VehicleController::class, 'saveVehicleDetail']);
    Route::match(['put', 'post'], 'vehicles/{id}', [VehicleController::class, 'updateVehicleDetail']);
    Route::post('vehicles/update', [VehicleController::class, 'updateVehicleDetail']);
    Route::match(['delete', 'post'], 'vehicles/{id}/delete', [VehicleController::class, 'vehicleDelete']);
    Route::delete('vehicles/{id}', [VehicleController::class, 'vehicleDelete']);
    Route::post('vehicles/delete', [VehicleController::class, 'vehicleDelete']);
    Route::post('vehicles/{id}/set-default', [VehicleController::class, 'setDefaultVehicle']);
    Route::post('vehicles/{id}/refresh-checks', [VehicleController::class, 'refreshVehicleChecks']);
});

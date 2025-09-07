<?php

use App\Enums\MapEnums;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\Portal\PortalController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/**
 * General Routes
 */
Route::get('/allEnums', function () {
    return apiResponse(
        true,
        '',
        Response::HTTP_OK,
        MapEnums::EnumsMap
    );
});

Route::get('/allModels', function () {
    return apiResponse(
        true,
        '',
        Response::HTTP_OK,
        ModelsMap(true)
    );
});

Route::get("/modelDDLList", [GeneralController::class, 'modelDDLList'])->name('modelDDLList');
Route::get("/enumDDLList", [GeneralController::class, 'enumDDLList'])->name('enumDDLList');


<?php

use App\Http\Controllers\API\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\SikepSyncController;

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
})->withoutMiddleware('throttle:api');

Route::post('masuk', [AuthController::class, 'login'])->withoutMiddleware('throttle:api');

Route::get('/sync-pegawai', [SikepSyncController::class, 'syncPegawaiApi']);
Route::get('/sync-jabatan', [SikepSyncController::class, 'syncJabatanApi']);

// Route::resource('faridl', AuthController::class);

<?php

use App\Exports\RegistrationsExport;
use App\Http\Controllers\Api\Admin\CheckinController;
use App\Http\Controllers\Api\Admin\StatisticsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
require __DIR__.'/auth.php';

//admin route
Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
    Route::apiResource('events', \App\Http\Controllers\Api\Admin\EventController::class);
    Route::get('events/{event}/registrations', [\App\Http\Controllers\Api\Admin\RegistrationController::class, 'index']);

    //route check in
    Route::post('/checkin/{id}', [CheckinController::class, 'checkin'])->name('checkin.qr');

    //dowload file excel danh sách user tham gia 1 event
    Route::get('/events/{event}/export', function ($eventId) {
    return Excel::download(new RegistrationsExport($eventId), 'registrations.xlsx');});

    //route thống kê
    Route::get('/statistics', [StatisticsController::class, 'index']);
});

//user route
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/events', [\App\Http\Controllers\Api\User\EventController::class, 'index']);
    Route::get('/events/{id}', [\App\Http\Controllers\Api\User\EventController::class, 'show']);

    //đăng ký sự kiện
    Route::post('/events/{id}/register', [\App\Http\Controllers\Api\User\RegistrationController::class, 'store']);

    //hủy đăng ký sự kiện
    Route::delete('/events/{event}/cancel', [\App\Http\Controllers\Api\User\RegistrationController::class, 'destroy']);


});

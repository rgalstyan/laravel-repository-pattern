<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthUserController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::controller(AuthUserController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
});
Route::group(['middleware' => 'auth:api'], function () {
    Route::post(
        'logout',
        [AuthUserController::class, 'logout']
    );
});
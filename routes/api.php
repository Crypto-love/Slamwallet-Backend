<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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
// header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
// header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization, Accept,charset,boundary,Content-Length');
// header('Access-Control-Allow-Origin: *');

Route::post('/signup', [App\Http\Controllers\RegisterController::class, 'signup'])->middleware('log.route');
Route::post('/signin', [App\Http\Controllers\RegisterController::class, 'signin'])->middleware('log.route');
Route::post('/forget', [App\Http\Controllers\RegisterController::class, 'forget'])->middleware('log.route');
Route::post('/token', [App\Http\Controllers\RegisterController::class, 'token']);
Route::post('/transaction', [App\Http\Controllers\RegisterController::class, 'transaction'])->middleware('log.route');

Route::post('/eth_slam', [App\Http\Controllers\RegisterController::class, 'eth_slam'])->middleware('log.route');
Route::post('/bnb_slam', [App\Http\Controllers\RegisterController::class, 'bnb_slam'])->middleware('log.route');

Route::post('{user_id}/reset', [App\Http\Controllers\RegisterController::class, 'reset'])->middleware('log.route');
Route::post('verify', [App\Http\Controllers\RegisterController::class, 'verify'])->middleware('log.route');

Route::get('manages', [App\Http\Controllers\RegisterController::class, 'manages']);
Route::post('getAffiliations', [App\Http\Controllers\RegisterController::class, 'getAffiliations'])->middleware('log.route');
Route::post('email-verify', [App\Http\Controllers\RegisterController::class, 'emailVerify'])->middleware('log.route');
Route::post('toggle/{status}/email-verify', [App\Http\Controllers\RegisterController::class, 'emailVerifyToggle'])->middleware('log.route');

Route::post('{user_id}/resetPasswd', [App\Http\Controllers\RegisterController::class, 'resetPasswd'])->middleware('log.route');
Route::post('verificationEmail', [App\Http\Controllers\RegisterController::class, 'verificationEmail'])->middleware('log.route');

Route::post('currentSoldTokenAmount', [App\Http\Controllers\RegisterController::class, 'currentSoldTokenAmount']);

Route::post('getBnbBalance/{wallet_address}', [App\Http\Controllers\RegisterController::class, 'getBnbBalance'])->middleware('log.route');
Route::post('getEthBalance/{wallet_address}', [App\Http\Controllers\RegisterController::class, 'getEthBalance'])->middleware('log.route');

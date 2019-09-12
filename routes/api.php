<?php
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

use Illuminate\Support\Facades\Route;

Route::get('/encrypt', 'Web\EncryptionController@encrypt');
Route::get('/guan_zhu/{unique_id}', 'Web\IndexController@guanZhuList');
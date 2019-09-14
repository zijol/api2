<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;

/**
 * 内部使用，获取签名值
 */
Route::get('/signature', 'Web\SignatureController@index');

/**
 * 内部使用，加密、解密
 */
Route::get('/encrypt', 'Web\EncryptionController@encrypt');
Route::get('/decrypt', 'Web\EncryptionController@decrypt');


Route::get('/dy/index', 'Web\DyController@index');
Route::get('/dy/{user_id}/detail', 'Web\DyController@detail');

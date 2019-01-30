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

require_once "web/api_doc.php";

Route::get('/', function () {
    return view('welcome');
});

/**
 * 内部使用，获取签名值
 */
Route::get('/signature', 'Web\SignatureController@index');

/**
 * 内部使用，加密、解密
 */
Route::get('/encrypt', 'Web\EncryptionController@encrypt');
Route::get('/decrypt', 'Web\EncryptionController@decrypt');

/**
 * change log view
 */
Route::get('/changelog', function () {
    return view('changelog');
});

Route::get('/document', 'Web\DocController@index');
Route::get('/document/{type}/{tag}', 'Web\DocController@get');

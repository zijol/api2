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

Route::get('/', 'Web\CouponTemplateController@list');
Route::post('/', 'Web\CouponTemplateController@post');

Route::get('/ar', 'Web\ArController@list');
Route::post('/ar', 'Web\ArController@post');

Route::get('/user/{user}', 'Web\MemberUserController@get');
Route::delete('/user/{user}', 'Web\MemberUserController@delete');
Route::put('/user/{user}', 'Web\MemberUserController@put');
Route::get('/user_list', 'Web\MemberUserController@list');

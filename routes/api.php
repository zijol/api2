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

use App\Services\Helper\Make;
use App\Services\Helper\ErrorCode\ErrorCode;
/**
 * 未匹配到的路由，统一返回
 */
Route::fallback(function () {
    return Make::ApiFail(ErrorCode::ROUTE_NOT_FOUND);
});

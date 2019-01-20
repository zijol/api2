<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 19/1/20
 * Time: 14:39
 */

Route::get('/doc/project/detail', 'Web\DocProjectController@detail');
Route::get('/doc/project/list', 'Web\DocProjectController@list');
Route::post('/doc/project', 'Web\DocProjectController@post');

<?php

use Illuminate\Support\Facades\Route;

//登入
Route::post('login', 'admin@login');

//檔案管理
Route::group(['prefix' => 'storage'], function () {
    Route::post('image', 'storage@uploadImage');
});

//新聞管理
Route::group(['prefix' => 'news'], function () {
    Route::get('', 'News@getList');
    Route::get('{newsId}', 'News@get');
    Route::post('', 'News@create');
    Route::put('{newsId}', 'News@update');
    Route::delete('{newsId}', 'News@delete');
});

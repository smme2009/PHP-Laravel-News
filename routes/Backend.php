<?php

use Illuminate\Support\Facades\Route;

//登入
Route::post('login', 'admin@login');

//檔案管理
Route::group(['prefix' => 'storage'], function () {
    Route::post('image', 'storage@uploadImage');
});

//商品管理
Route::group(['prefix' => 'product'], function () {
    Route::get('', 'product@getList');
    Route::get('{productId}', 'product@get');
    Route::post('', 'product@create');
    Route::put('{productId}', 'product@update');
    Route::delete('{productId}', 'product@delete');
});

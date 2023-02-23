<?php

use Illuminate\Support\Facades\Route;

//新聞
Route::group(['prefix' => 'news'], function () {
    Route::get('', 'News@getList');
    Route::get('{newsId}', 'News@get');
});

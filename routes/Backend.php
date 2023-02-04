<?php

use Illuminate\Support\Facades\Route;

Route::post('login', 'admin@login');

Route::group(['prefix' => 'storage'], function () {
    Route::post('image', 'storage@uploadImage');
});

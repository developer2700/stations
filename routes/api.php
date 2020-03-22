<?php

use Illuminate\Http\Request;

Route::group(['namespace' => 'Api'], function () {

    Route::apiResource('companies', 'CompanyController');

    // we won't use these in this project
    Route::post('users/login', 'AuthController@login');
    Route::post('users', 'AuthController@register');
    Route::get('user', 'UserController@index');
    Route::match(['put', 'patch'], 'user', 'UserController@update');

});

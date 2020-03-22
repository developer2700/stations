<?php

use Illuminate\Http\Request;

Route::group(['namespace' => 'Api'], function () {

    Route::apiResource('companies', 'CompanyController');

});

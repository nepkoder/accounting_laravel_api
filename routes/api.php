<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'v1'], function () {
    Route::post('/login', 'AuthController@login');
    Route::post('/logout', 'AuthController@logout');
});

Route::group(['prefix' => 'v1'], function () {

    Route::post('/requestDemo','AuthController@demoRequest');
    Route::post('/loginDemo','AuthController@demoLogin');
    Route::post('/companyDemo','AuthController@demoCompany');
    Route::get('/AllParty', 'CustomerController@index');

});

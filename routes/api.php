<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1'], function () {
    Route::get('/', ['uses' => 'HomeController@index', 'as' => 'home']);

    Route::group(['middleware' => ['guest']], function () {
        Route::post('/register', ['uses' => 'Auth\RegisterController@register', 'as' => 'register']);
        Route::post('/login', ['uses' => 'Auth\LoginController@login', 'as' => 'login']);
    });

    Route::group(['middleware' => ['auth:api']], function () {
        Route::get('/account', ['uses' => 'UsersController@account', 'as' =>'account']);
        Route::post('/profile', ['uses' => 'UsersController@setProfile', 'as' => 'storeProfile']);
    });

    /** Common data */
    Route::get('/activityfields', ['uses' => 'ActivityFieldsController@index', 'as' => 'activityFields']);
    Route::get('/countries', ['uses' => 'PlacesController@countries', 'as' => 'countries']);
    Route::get('/cities', ['uses' => 'PlacesController@cities', 'as' => 'cities']);
    Route::get('/city/{city}', ['uses' => 'PlacesController@city', 'as' => 'city']);
    Route::get('/languages', ['uses' => 'LanguagesController@index', 'as' => 'languages']);
    Route::get('/goals', ['uses' => 'GoalsController@index', 'as' => 'goals']);
});

<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1'], function () {
    Route::get('/', ['uses' => 'HomeController@index', 'as' => 'home']);

    Route::group(['middleware' => ['guest']], function () {
        Route::post('/auth/register', ['uses' => 'Auth\RegisterController@register', 'as' => 'register']);
        Route::post('/auth/login', ['uses' => 'Auth\LoginController@login', 'as' => 'login']);
    });

    Route::group(['middleware' => ['auth:api']], function () {
        Route::post('/auth/logout', ['uses' => 'Auth\LoginController@logout', 'as' => 'logout']);
        Route::get('/user/account', ['uses' => 'User\UsersController@account', 'as' =>'account']);
        Route::post('/user/profile', [
                'uses' => 'User\UsersController@setProfile',
                'as' => 'storeProfile',
                'middleware' => ['can:setUserProfile,App\Entities\User'],
            ]);
        Route::post('/user/companyprofile', [
                'uses' => 'User\UsersController@setCompanyProfile',
                'as' => 'storeCompanyProfile',
                'middleware' => ['can:setCompanyProfile,App\Entities\User'],
            ]);
    });

    Route::get('/user/companies/search', ['uses' => 'User\UsersController@findCompanies', 'companiesSearch']);

    /** Common data */
    Route::group(['prefix' => 'common', 'namespace' => 'Common'], function () {
        Route::get('/activityfields', ['uses' => 'ActivityFieldsController@index', 'as' => 'activityFields']);
        Route::get('/countries', ['uses' => 'PlacesController@countries', 'as' => 'countries']);
        Route::get('/cities', ['uses' => 'PlacesController@cities', 'as' => 'cities']);
        Route::get('/city/{city}', ['uses' => 'PlacesController@city', 'as' => 'city']);
        Route::get('/languages', ['uses' => 'LanguagesController@index', 'as' => 'languages']);
        Route::get('/goals', ['uses' => 'GoalsController@index', 'as' => 'goals']);
        Route::get('/organizationtypes', ['uses' => 'OrganizationTypesController@index', 'as' => 'organizationTypes']);
    });
});

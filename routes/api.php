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

        Route::group(['middleware' => ['hasProfile']], function () {
            Route::post('/main/event', ['uses' => 'Main\EventsController@create', 'as' => 'eventCreate']);
            Route::post('/main/action', ['uses' => 'Main\ActionsController@create', 'as' => 'actionCreate']);
            Route::post('/main/action/join/{action}', ['uses' => 'Main\ActionsController@joinToAction', 'as' => 'joinToAction']);
            Route::post('/user/message/send', ['uses' => 'User\UsersController@sendMessage', 'as' => 'sendMessage']);
        });
    });

    /** Profiles */
    Route::get('/user/{user}', ['uses' => 'User\UsersController@view', 'as' => 'viewUser']);
    Route::get('/user/activities/all', ['uses' => 'User\UsersController@getUsersActionsAndEvents']);
    Route::get('/user/companies/search', ['uses' => 'User\UsersController@findCompanies', 'as' => 'companiesSearch']);
    Route::get('/users/companies', ['uses' => 'User\UsersController@getCompanies', 'as' => 'companies']);
    Route::get('/users/company/members', ['uses' => 'User\UsersController@companyMembers']);
    /** Events */
    Route::get('/main/events', ['uses' => 'Main\EventsController@index', 'eventsList']);
    Route::get('/main/events/{event}', ['uses' => 'Main\EventsController@view', 'as' => 'eventView']);
    /** Actions */
    Route::get('/main/actions', ['uses' => 'Main\ActionsController@index', 'actionsList']);
    Route::get('/main/actions/{action}', ['uses' => 'Main\ActionsController@view', 'as' => 'actionView']);
    Route::get('/main/actions/{action}/members', ['uses' => 'Main\ActionsController@getMembers', 'as' => 'actionMembers']);

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

    Route::get('/summary/countries', ['uses' => 'Main\IndexController@getWorldInfo']);
    Route::get('/summary/country', ['uses' => 'Main\IndexController@getCountryInfo']);
    Route::post('/user/subscribe', ['uses' => 'User\MailSubscribesController@subscribe']);
});

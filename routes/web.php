<?php

//Route::get('/', function () {
//    return view('welcome', ['url' => 'dasdas', 'text' => 'vasya', 'mailFrom' => 'kek', 'mailFromName' => 'kek']);
//});

Route::group(['prefix' => '/admin', '', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => [
    'auth', 'can:viewAdmin,App\RBAC\Permission',
]], function () {
    Route::get('/', ['uses' => 'HomeController@index', 'as' => 'home']);
    /** Permissions */
    Route::get('/permissions', ['uses' => 'PermissionsController@index', 'as' => 'permissions.index', 'middleware' => ['can:view,App\RBAC\Permission']]);
    Route::put('/permissions', ['uses' => 'PermissionsController@update', 'as' => 'permissions.update', 'middleware' => ['can:update,App\RBAC\Permission']]);
    /** Users */
    Route::get('/users', ['uses' => 'UsersController@index', 'as' => 'users.index', 'middleware' => ['can:manageUsers,App\Entities\User']]);
    Route::get('/users/{user}', ['uses' => 'UsersController@view', 'as' => 'users.view', 'middleware' => ['can:manageUsers,App\Entities\User']]);
    Route::put('/user/{user}', ['uses' => 'UsersController@update', 'as' => 'users.update', 'middleware' => ['can:manageUsers,App\Entities\User']]);
    Route::post('/user/{user}/status', ['uses' => 'UsersController@changeStatus', 'as' => 'users.changeStatus', 'middleware' => ['can:manageUsers,App\Entities\User']]);
    /** Actions */
    Route::get('/actions', ['uses' => 'ActionsController@index', 'as' => 'actions.index']);
    Route::get('/actions/{id}', ['uses' => 'ActionsController@view', 'as' => 'actions.view']);
    Route::post('/actions/{id}/status', ['uses' => 'ActionsController@status', 'as' => 'actions.setStatus']);
    /** Events */
    Route::get('/events', ['uses' => 'EventsController@index', 'as' => 'events.index']);
    Route::get('/events/{id}', ['uses' => 'EventsController@view', 'as' => 'events.view']);
    Route::post('/events/{id}/status', ['uses' => 'EventsController@status', 'as' => 'events.setStatus']);
    /** Subscribers */
    Route::get('/subscribers', ['uses' => 'SubscribersController@index', 'as' => 'subscribers.index']);
    Route::get('/subscribers/export', ['uses' => 'SubscribersController@export', 'as' => 'subscribers.export']);
    /** Reviews */
    Route::resource('reviews', 'ReviewsController');
});

Route::group(['middleware' => ['guest']], function () {
    /** Auth */
    Route::get('/login', ['uses' => 'Auth\LoginController@showLoginForm', 'as' => 'login']);
    Route::post('/login', ['uses' => 'Auth\LoginController@login', 'as' => 'loginUser']);
    Route::post('/logout', ['uses' => 'Auth\LoginController@logout', 'as' => 'logout']);
});

/** Auth via services */
Route::get('/login/{serviceName}', [
    'uses' => 'Auth\SocialServicesController@providerRedirect',
    'as' => 'login.service',
])->where(['serviceName' => '(vkontakte|facebook)']);
Route::get('/login/{serviceName}/callback', [
    'uses' => 'Auth\SocialServicesController@providerCallback',
    'as' => 'login.callback'
])->where(['serviceName' => '(vkontakte|facebook)']);

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
    Route::get('/user/export/members', ['uses' => 'UsersController@exportMembers', 'as' => 'users.exportMembers', 'middleware' => ['can:manageUsers,App\Entities\User']]);
    Route::get('/user/export/companies', ['uses' => 'UsersController@exportCompanies', 'as' => 'users.exportCompanies', 'middleware' => ['can:manageUsers,App\Entities\User']]);
    Route::delete('/user/company-member', ['uses' => 'UsersController@removeCompanyMember', 'as' => 'users.removeCompanyMember', 'middleware' => ['can:manageUsers,App\Entities\User']]);
    /** Actions */
    Route::get('/actions', ['uses' => 'ActionsController@index', 'as' => 'actions.index']);
    Route::get('/actions/{id}', ['uses' => 'ActionsController@view', 'as' => 'actions.view']);
    Route::post('/actions/{id}/status', ['uses' => 'ActionsController@status', 'as' => 'actions.setStatus']);
    Route::post('/actions/{id}/favorite', ['uses' => 'ActionsController@toggleFavoriteStatus', 'as' => 'actions.toggleFavoriteStatus']);
    /** Events */
    Route::get('/events', ['uses' => 'EventsController@index', 'as' => 'events.index']);
    Route::get('/events/{id}', ['uses' => 'EventsController@view', 'as' => 'events.view']);
    Route::post('/events/{id}/status', ['uses' => 'EventsController@status', 'as' => 'events.setStatus']);
    Route::post('/events/{id}/favorite', ['uses' => 'EventsController@toggleFavoriteStatus', 'as' => 'events.toggleFavoriteStatus']);
    Route::get('/events/{id}/update', ['uses' => 'EventsController@update', 'as' => 'events.update']);
    Route::put('/events/{id}/update', ['uses' => 'EventsController@change', 'as' => 'events.change']);
    Route::post('/events/new-photo', ['uses' => 'EventsController@uploadNewPhoto', 'as' => 'events.newPhoto']);
    /** Subscribers */
    Route::get('/subscribers', ['uses' => 'SubscribersController@index', 'as' => 'subscribers.index']);
    Route::get('/subscribers/export', ['uses' => 'SubscribersController@export', 'as' => 'subscribers.export']);
    /** Reviews */
    Route::resource('reviews', 'ReviewsController');
    /** Slider Photos */
    Route::resource('sliderPhotos', 'SliderPhotosController');
    /** Main news */
    Route::get('/main-news', ['uses' => 'HomeController@mainNews', 'as' => 'mainNews']);
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

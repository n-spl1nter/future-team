<?php

//Route::get('/', function () {
//    return view('mail.password', ['email' => 'dasdas', 'mailFrom' => 'vasya', 'mailFromName' => 'kek']);
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
    /** Actions */
    Route::get('/actions', ['uses' => 'ActionsController@index', 'as' => 'actions.index']);
    Route::get('/actions/{id}', ['uses' => 'ActionsController@view', 'as' => 'actions.view']);
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
]);

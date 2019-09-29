<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => '/admin', '', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => [
    'auth', 'can:viewAdmin,App\Models\Permission',
]], function () {
    Route::get('/', ['uses' => 'HomeController@index', 'as' => 'home']);
});

Route::group(['middleware' => ['guest']], function () {
    /** Auth */
    Route::get('/login', ['uses' => 'Auth\LoginController@showLoginForm', 'as' => 'login']);
    Route::post('/login', ['uses' => 'Auth\LoginController@login', 'as' => 'loginUser']);
    Route::post('/logout', ['uses' => 'Auth\LoginController@logout', 'as' => 'logout']);
});

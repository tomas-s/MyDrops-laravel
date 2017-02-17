<?php

/*
  |--------------------------------------------------------------------------
  | Routes File
  |--------------------------------------------------------------------------
  |
  | Here is where you will register all of the routes in an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */

Route::get('/', function () {
    return view('welcome');
});

Route::post('newdata','DataController@postData');
Route::get('test',  'NotificationController@test');

Route::group(array('prefix' => 'api'), function()
    {
        Route::resource('sensors', 'SensorController',['only' => ['index', 'show']]);
        Route::resource('users.sensors', 'UserSensorController',['only' => ['index', 'show']]);
    });
/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | This route group applies the "web" middleware group to every route
  | it contains. The "web" middleware group is defined in your HTTP
  | kernel and includes session state, CSRF protection, and more.
  |
 */

Route::group(['middleware' => ['web']], function () {
    Route::get('auth/login', 'Auth\AuthController@getLogin');
    Route::post('auth/login', 'Auth\AuthController@postLogin');
    Route::get('auth/logout', 'Auth\AuthController@getLogout');

    // Registration routes...
    Route::get('auth/register', 'Auth\AuthController@getRegister');
    Route::post('auth/register', 'Auth\AuthController@postRegister');
    
    Route::get('social/login/redirect/{provider}', ['uses' => 'Auth\AuthController@redirectToProvider', 'as' => 'social.login']);
    Route::get('social/login/{provider}', 'Auth\AuthController@handleProviderCallback');
    
    Route::get('register/verify/{confirmationCode}', [
    'as' => 'confirmation_path',
    'uses' => 'MyDropsController@confirm'
    ]);
    
    Route::get('sendConfirmationEmail', 'MyDropsController@sendConfirmationEmail');
});

Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::get('/mydrops', 'MyDropsController@index');
    Route::post('changeSensorData','SensorController@formUpdateSensor');

    Route::get('/', function () {
        echo"Ahoj svet";
        //return view('welcome');
    });
});

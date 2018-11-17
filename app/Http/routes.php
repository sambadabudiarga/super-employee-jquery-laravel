<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return redirect('/home');
});

// Route::auth();

// Route::group(['middleware' => ['web', 'auth']], function() {
    Route::get('/home', 'HomeController@index');
    Route::get('/statistic', 'HomeController@statistic');

    Route::get('/employees/datatable', 'EmployeeController@datatable');
    Route::get('/employees/chart', 'EmployeeController@chart');
    Route::get('/employees/{employee}', 'EmployeeController@show');
    Route::post('/employees', 'EmployeeController@store');
// });

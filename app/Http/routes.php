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

# Guest Routes for Get operations


	Route::get('/', function () {
	    return 'Hello World';
	});

	Route::get('/Home', 'SenateDashboardController@getHome');
	Route::get('/About', 'SenateDashboardController@getAbout');
	Route::get('/FAQ', 'SenateDashboardController@getFAQ');
	Route::get('/Donate', 'SenateDashboardController@getDonate');


	Route::get('/MostPopular', 'SenateDashboardController@getMostPopular');
	Route::get('/SenateDashboard', 'SenateDashboardController@getSenateDashboard');
	Route::get('/SenatorDashboard/{senator_id}', 'SenateDashboardController@getSenatorDashboard');
	

# Guest Routes for Post operations
	Route::post('/Search', 'SenateDashboardController@postSearch');
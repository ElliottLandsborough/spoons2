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

// load angular
Route::get('/', 'SpoonsController@home');

Route::group(array('prefix' => 'api'), function() {

	// get array of pubs
	Route::post('latlon', 'SpoonsController@pubsByLatLon');
	Route::post('string', 'SpoonsController@pubsByString');

	Route::group(array('prefix' => 'admin'), function() {

		// todo: block anyone but admin from going here
		Route::post('diff', 'SpoonsController@pubsByString');
		Route::post('delete', 'SpoonsController@deletePubById');
		Route::post('add', 'SpoonsController@addPubById');
		Route::post('update', 'SpoonsController@updatePubById');
		Route::post('updateGeo', 'SpoonsController@updateGeoById');
		Route::post('updatePlace', 'SpoonsController@updateGeoById');

	});

});
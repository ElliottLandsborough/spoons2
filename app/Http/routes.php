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
	Route::any('latlon', 'SpoonsController@pubsByLatLon');
	Route::any('string', 'SpoonsController@pubsByString');

	Route::group(array('prefix' => 'admin'), function() {

		// todo: block anyone but admin from going here
		Route::any('download', 'SpoonsController@downloadNewJson');
		Route::any('diff', 'SpoonsController@pubsByString');
		Route::any('delete', 'SpoonsController@deletePubById');
		Route::any('add', 'SpoonsController@addPubById');
		Route::any('update', 'SpoonsController@updatePubById');
		Route::any('updateGeo', 'SpoonsController@updateGeoById');
		Route::any('updatePlace', 'SpoonsController@updateGeoById');

	});

});
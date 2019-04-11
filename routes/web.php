<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->group(['prefix' => 'api'], function () use ($router) {
	$router->post('users', 'UsersController@store');
    $router->group(['prefix' => 'v1', 'middleware' => 'auth'], function() use ($router) {
		$router->put('/users', 'UsersController@update');
	    $router->delete('/users', 'UsersController@destroy');
	    $router->post('/teams', 'TeamsController@store');
	    $router->put('/teams/{teamId}', 'TeamsController@update');
	    $router->post('/teams/{teamId}/assign/{userId}', 'TeamsController@assignUser');
	    $router->post('/teams/{teamId}/assign/{userId}/owner', 'TeamsController@assignUserAsOwner');
	    $router->delete('/teams/{teamId}', 'TeamsController@destroy');
    });
});
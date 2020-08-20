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

$router->get('/clients', 'ClientsController@index');
$router->post('/clients', 'ClientsController@store');
$router->get('/clients/{client}', 'ClientsController@show');
$router->put('/clients/{client}', 'ClientsController@update');
$router->patch('/clients/{client}', 'ClientsController@update');
$router->delete('/clients/{client}', 'ClientsController@destroy');

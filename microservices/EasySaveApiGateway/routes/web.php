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


/**
 * Route for USSD Application
 **/
$router->get('/ussd/v1/easy-save-ussd', 'USSDController@index');


/**
 * Routes for clients
 **/
$router->get('/clients', 'ClientsController@index');
$router->post('/clients', 'ClientsController@store');
$router->get('/clients/{client}', 'ClientsController@show');
$router->put('/clients/{client}', 'ClientsController@update');
$router->patch('/clients/{client}', 'ClientsController@update');
$router->delete('/clients/{client}', 'ClientsController@destroy');


/**
 * Routes for sms
 **/
$router->get('/sms-messages', 'SMSController@index');
$router->post('/sms-messages/send-sms', 'SMSController@sendSMSMessage');
$router->get('/sms-messages/{sms}', 'SMSController@show');
$router->delete('/sms-messages/{sms}', 'SMSController@destroy');


$router->group(['middleware' => 'client.credentials'], function() use($router) {

});


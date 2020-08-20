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
 * Routes for USSD
 **/
$router->get('/ussd/v1/easy-save-ussd', 'USSDController@index');


/**
 * Routes for Linked List Test
 **/
$router->get('/linked-list-test', 'LinkedListTestController@testLinkedList');


$router->group(['middleware' => 'client.credentials'], function() use($router) {

});


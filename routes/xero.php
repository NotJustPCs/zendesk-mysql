<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->get('api/xero', [
    'as' => 'xero.index', 'uses' => 'XeroController@index'
]);

$router->get('api/xero/authorization', [
    'as' => 'xero.authorization', 'uses' => 'XeroController@authorization'
]);

$router->get('/api/xero/callback', [
    'as' => 'xero.callback', 'uses' => 'XeroController@callback'
]);

$router->group(['middleware' => 'xeroTokenExpired'], function () use ($router) {

    $router->get('/api/xero/load-data', [
        'as' => 'xero.load.data', 'uses' => 'XeroController@loadData'
    ]);
    $router->get('/api/xero/invoice/{id}', [
        'as' => 'xero.load.invoice', 'uses' => 'XeroController@loadInvoice'
    ]);
});

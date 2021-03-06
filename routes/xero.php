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
        'as' => 'xero.store.data', 'uses' => 'XeroController@storeData'
    ]);
    $router->get('/api/xero/invoice/{id}', [
        'as' => 'xero.store.invoice', 'uses' => 'XeroController@storeInvoice'
    ]);
    $router->get('/api/xero/invoice/{id}/OnlineInvoice', [
        'as' => 'xero.store.online.invoice', 'uses' => 'XeroController@storeOnlineInvoice'
    ]);
    $router->get('/api/xero/repeating-invoice/{id}/history', [
        'as' => 'xero.repeating.invoice.history', 'uses' => 'XeroController@storeRepeatingInvoiceHistory'
    ]);
    $router->get('/api/xero/item/{id}/history', [
        'as' => 'xero.item.history', 'uses' => 'XeroController@storeItemHistory'
    ]);
    $router->get('/api/xero/contact/{id}/history', [
        'as' => 'xero.contact.history', 'uses' => 'XeroController@storeContactHistory'
    ]);
    $router->get('/api/xero/invoice/{id}/history', [
        'as' => 'xero.invoice.history', 'uses' => 'XeroController@storeInvoiceHistory'
    ]);
    $router->get('/api/xero/quote/{id}/history', [
        'as' => 'xero.quote.history', 'uses' => 'XeroController@storeQuoteHistory'
    ]);
});

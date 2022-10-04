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

//Auth Controller
$router->post('/api/login',['uses' => 'AuthController@login']);
$router->post('/api/register',['uses' => 'AuthController@register']);

$router->get('/', ['middleware' => 'auth',function () use ($router) {
    return $router->app->version();
}]);

$router->group(['middleware' => 'auth','prefix' => 'api'],function() use ($router)
{

    //Customers
    $router->post('/customer',['uses' => 'CustomerController@create']);
    $router->get('/customer',['uses' => 'CustomerController@read']);
    $router->get('/customer/{id}',['uses' => 'CustomerController@read']);
    $router->patch('/customer/{id}',['uses' => 'CustomerController@update']);
    $router->delete('/customer/{id}',['uses' => 'CustomerController@delete']);

    //English test
    $router->post('/english',['uses' => 'EnglishTestController@create']);
    $router->get('/english',['uses' => 'EnglishTestController@read']);
    $router->get('/english/{id}',['uses' => 'EnglishTestController@read']);
    $router->patch('/english/{id}',['uses' => 'EnglishTestController@update']);
    $router->delete('/english/{id}',['uses' => 'EnglishTestController@delete']);

});

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
$router->get('/api/confirm/{token}',['uses' => 'AuthController@confirm']);

$router->get('/', ['middleware' => 'auth',function () use ($router) {
    return $router->app->version();
}]);

$router->group(['middleware' => 'auth','prefix' => 'api'],function() use ($router)
{

    //Customers
    $router->post('/customer',['uses' => 'CustomerController@create']);
    $router->get('/customer[/{id}]',['uses' => 'CustomerController@read']);
    $router->patch('/customer/{id}',['uses' => 'CustomerController@update']);
    $router->delete('/customer/{id}',['uses' => 'CustomerController@delete']);

    //Links
    $router->post('/link',['uses'=>'LinkController@create']);
    $router->get('/link/{id}',['uses'=>'LinkController@read']);
    $router->delete('/link/{id}',['uses'=>'LinkController@delete']);


    //English tests
    $router->post('/english_test',['uses' => 'EnglishTestController@create']);
    $router->get('/english_test[/{id}]',['uses' => 'EnglishTestController@read']);
    $router->patch('/english_test/{id}',['uses' => 'EnglishTestController@update']);
    $router->delete('/english_test/{id}',['uses' => 'EnglishTestController@delete']);

    //English answers
    $router->post('/english_answer',['uses' => 'EnglishAnswerController@create']);
    $router->get('/english_answer/{id}', ['uses' => 'EnglishAnswerController@read']);

});

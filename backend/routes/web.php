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
$router->post('/login',['uses' => 'AuthController@login']);
$router->post('/register',['uses' => 'AuthController@register']);

$router->get('/', ['middleware' => 'auth',function () use ($router) {
    return $router->app->version();
}]);

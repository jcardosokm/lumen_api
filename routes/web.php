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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function () use ($router) {

    //add task
    $router->post('tasks/add', ['uses' => 'TaskController@create']);

    //edit task by uuid
    $router->put('tasks/edit/{uuid}', ['uses' => 'TaskController@update']);
    
    //remove job
    $router->delete('tasks/{uuid}', ['uses' => 'TaskController@delete']);

    //retrieve job
    $router->get('tasks/{uuid}', ['uses' => 'TaskController@showTask']);
});

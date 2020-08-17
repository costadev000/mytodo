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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api', 'middleware' => 'autenticador'], function() use ($router){
    $router->group(['prefix' => 'user'], function() use ($router){
        $router->get('{id}', 'UserController@show');
        $router->get('{id}/todos', 'UserController@todos');
        $router->put('{id}', 'UserController@update');
    });
    $router->group(['prefix' => 'todo'], function () use ($router){
        $router->post('', 'TodoController@store');
        $router->put('{id}', 'TodoController@update');
        $router->delete('{id}', 'TodoController@destroy');
        $router->get('{id}/checklists', 'TodoController@checklists');
        $router->get('lastTodos', 'TodoController@lastTodos');
    });
    $router->group(['prefix' => 'checklist'], function() use ($router){
        $router->post('', 'ChecklistController@store');
        $router->put('{id}', 'ChecklistController@update');
        $router->delete('{id}', 'ChecklistController@destroy');
    });
});

$router->post('/api/user', 'UserController@newUser');
$router->post('/api/login', 'TokenController@gerarToken');
$router->post('/api/checkToken', 'TokenController@refreshToken');

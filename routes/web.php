<?php
        use Illuminate\Support\Str;

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

$router->group(['middleware' => ['auth']], function () use($router){
    $router->get('/user', ['uses' => 'UserController@index']);
    $router->get('/user', ['uses' => 'UserController@index']);
    $router->post('/user', ['uses' => 'UserController@create']);
    $router->get('/user/{id}', ['uses' => 'UserController@getUserById']);
    $router->put('/user/{id}', ['uses' => 'UserController@updateUserById']);
    $router->delete('/user/{id}', ['uses' => 'UserController@deleteUserById']);
});


$router->post('/login', ['uses' => 'UserController@getToken']);

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/key', function(){
    return Str::random(30);
    // return 'hOLA MUD';
});



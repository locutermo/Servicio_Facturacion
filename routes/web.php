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
/*
| $router->get('/', function () use ($router) {
|     return $router->app->version();
| });
*/
$router->get('/editorials','EditorialController@getListarEditorial' );
$router->post('/editorials','EditorialController@addEditorial' );
$router->get('/editorials/{editorial}','EditorialController@showEditorial' );
$router->put('/editorials/{editorial}','EditorialController@editorialUpdate' );
$router->patch('/editorials/{editorial}','EditorialController@editorialUpdate' );
$router->delete('/editorials/{editorial}','EditorialController@editorialDelete');

$router->get('/authors','AuthorController@getListarAuthor' );
$router->post('/authors','AuthorController@addAuthor' );
$router->post('/authors/import','AuthorController@importData' );
$router->get('/authors/{author}','AuthorController@showAuthor' );
$router->put('/authors/{author}','AuthorController@authorUpdate' );
$router->patch('/authors/{author}','AuthorController@authorUpdate' );
$router->delete('/authors/{author}','AuthorController@authorDelete');

$router->get('/stands','StandController@getListarStand' );
$router->post('/stands','StandController@addStand' );
$router->get('/stands/{stand}','StandController@showStand' );
$router->put('/stands/{stand}','StandController@standUpdate' );
$router->patch('/stands/{stand}','StandController@standUpdate' );
$router->delete('/stands/{stand}','StandController@standDelete');
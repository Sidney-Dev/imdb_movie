<?php

use Core\Router;

$router = new Router();

$router->get('/', 'MovieController@index');
$router->post('/movie/search', 'MovieController@search');
$router->post('/movie/save', 'MovieController@save');

return $router;

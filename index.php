<?php
require_once 'config.php';
require_once 'core/Router.php';
$USERS_BASE_URL = API_BASE_URL . 'users';
$NEWS_BASE_URL = API_BASE_URL . 'news';
$AUTH_BASE_URL = API_BASE_URL . 'auth';
$router = new Router();

// User routes
$router->add('GET', $USERS_BASE_URL, '/UserController@getUsers');
$router->add('POST', $USERS_BASE_URL, '/UserController@createUser');
$router->add('PUT', $USERS_BASE_URL, '/UserController@updateUser');
$router->add('DELETE', $USERS_BASE_URL, '/UserController@deleteUser');

// News routes
$router->add('GET', $NEWS_BASE_URL, 'NewsController@getNews');
$router->add('GET', $NEWS_BASE_URL . '/{id}', 'NewsController@getNews');
$router->add('GET', $NEWS_BASE_URL . '/{id}/{member}', 'NewsController@getNews');
$router->add('POST', $NEWS_BASE_URL, 'NewsController@createNews');
$router->add('PUT', $NEWS_BASE_URL . '/{id}', 'NewsController@uploadNews');
$router->add('DELETE', $NEWS_BASE_URL . '/{id}', 'NewsController@deleteNews');
$router->add('POST', $NEWS_BASE_URL . '/upload', 'NewsController@uploadFile');
$router->add('POST', $NEWS_BASE_URL . '/uploadTest', 'NewsController@uploadTest');

// Authentication routes
// $router->add('POST', $AUTH_BASE_URL . '/login', 'AuthController@login');
$router->add('POST', $AUTH_BASE_URL . '/googleLogin', 'AuthController@googleLogin');
$router->add('GET', $AUTH_BASE_URL . '/me', 'AuthController@me');

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];
$router->dispatch($path, $method); 

//
//http://localhost/php/api/users
/** "/php/api/users" */

<?php
require_once 'config.php';
require_once 'core/Router.php';
$router = new Router();
$router->add('GET', API_BASE_URL . 'users', 'UserController@getUsers');
$router->add('POST', API_BASE_URL . 'users', 'UserController@createUser');
$router->add('PUT', API_BASE_URL . 'users', 'UserController@updateUser');
$router->add('DELETE', API_BASE_URL . 'users', 'UserController@deleteUser');
//todo 字串看能不能改成"{參數}"模式
$router->add('GET', NEWS_BASE_URL, 'NewsController@getNews');
$router->add('GET', NEWS_BASE_URL . '{id}', 'NewsController@getNews');
$router->add('GET', NEWS_BASE_URL . '{id}/{member}', 'NewsController@getNews');
$router->add('POST', NEWS_BASE_URL, 'NewsController@createNews');
$router->add('PUT', NEWS_BASE_URL . '{id}', 'NewsController@uploadNews');
$router->add('DELETE', NEWS_BASE_URL . '{id}', 'NewsController@deleteNews');


$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
var_dump($path);
$method = $_SERVER['REQUEST_METHOD'];
$router->dispatch($path, $method); 

//http://localhost/php/api/users
/** "/php/api/users" */

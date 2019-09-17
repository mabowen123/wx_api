<?php


$router->get('/', function () {
    return 'hello api';
});

//登陆
$router->post('/login', 'LoginController@login');

$router->group(['middleware' => ['auth']], function ($router) {
    $router->get('article', 'ArticleController@list');
});

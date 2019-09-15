<?php



//登陆
$router->post('/login', 'LoginController@login');

$router->group(['middleware' => ['auth']], function ($router) {
    $router->get('/', function () {
        return 'hello api';
    });
});

<?php

require __DIR__ . '/../vendor/autoload.php';
$router = new \Bramus\Router\Router();

// Logic
$router->setNamespace('\http');

$router->before('GET|POST', '/.*', function () {
    session_start();
});
$router->set404(function() {
    header('Location: /page-not-found');
    exit();
});

$router->get('/', function() {
    header('Location: /home');
    exit();
});

$router->get('/home', 'MainController@HomeOverview');
$router->get('/about', 'MainController@AboutOverview');

$router->run();
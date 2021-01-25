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
    if (isset($_SERVER['HTTP_CLIENT_IP'])) $ip = $_SERVER['HTTP_CLIENT_IP'];
    elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    elseif (isset($_SERVER['REMOTE_ADDR'])) $ip = $_SERVER['REMOTE_ADDR'];
    else $ip = '';
    setcookie('user-ip', $ip, time() + 60 * 60 * 24 * 7);
    $date = new DateTime('now', new DateTimeZone('Europe/Brussels'));
    setcookie('entery-time', 'Entered-website-on-' . $date->format('d-m-y\-\a\t\-H-i'), time() + 60 * 60 * 24 * 7);
    header('Location: /home');
    exit();
});

$router->get('/home', 'MainController@HomeOverview');
$router->get('/about', 'MainController@AboutOverview');
$router->get('/shop', 'MainController@ShopOverview');
$router->get('/jeans', 'MainController@JeansOverview');
$router->get('/shoes', 'MainController@ShoesOverview');
$router->get('/contact', 'MainController@ContactOverview');
$router->get('/login', 'MainController@LoginOverview');
$router->get('/page-not-found', 'MainController@PageNotFoundOverview');
$router->get('/admin', 'AdminController@AdminLoginOverview');

$router->post('/login/register', 'AuthController@RegisterNewPerson');
$router->post('/login', 'AuthController@LoginPerson');
$router->get('/logout', 'AuthController@LogoutPerson');

$router->run();
<?php
require_once realpath(dirname(__FILE__) . '/application/Core/Router.php');
require_once realpath(dirname(__FILE__) . '/application/Core/Dispatcher.php');
require_once realpath(dirname(__FILE__) . '/application/Core/Controller.php');

require_once realpath(dirname(__FILE__) . '/application/Models/HelloModel.php');

require_once realpath(dirname(__FILE__) . '/application/Views/HelloView.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

// массив роутеров
$routes = require $_SERVER['DOCUMENT_ROOT'] . '/application/config/routes.php';
$uri = $_SERVER['REQUEST_URI'];

$router = new Router($routes, $uri);
$router->controller();
?>
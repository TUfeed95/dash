<?php
require_once realpath(dirname(__FILE__) . '/application/Core/Router.php');
require_once realpath(dirname(__FILE__) . '/application/Core/Dispatcher.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

// массив роутеров
$routes = require $_SERVER['DOCUMENT_ROOT'] . '/application/config/routes.php';
$uri = $_SERVER['REQUEST_URI'];

$router = new Router($routes, $uri);

$router->controller();
// (\/hello\/text)\?(\w+=\w+)$

?>

<p><?
$param = parse_url('/hello/text?var=int&var=str');
print_r($param['query']);
$array = explode('&', $param['query']);
echo '<br>';
print_r($array);

?></p>
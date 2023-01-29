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


?>

<p><?
$rout = '/hello/text?id=9';

$test = explode('/', trim($rout, '/'));
print_r($test);
echo '<br>';
$exp = parse_url($rout);
print_r($exp);
echo '<br>';
print_r(explode('/', trim($exp['path'], '/')));

if (key_exists('query', $exp)) {
  print_r($exp['query']);
} else {
  print_r('Error');
}



?></p>
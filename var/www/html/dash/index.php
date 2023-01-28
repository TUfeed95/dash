<?php
namespace Core;

error_reporting(E_ALL);
ini_set('display_errors', 1);

// автозагрузка классов
spl_autoload_register(function($class){
  // Директория корня документов, в которой выполняется текущий скрипт, в точности та, 
  // которая указана в конфигурационном файле сервера: config/nginx/default.conf
  $root = $_SERVER['DOCUMENT_ROOT'];
  // разделитель
  $ds = DIRECTORY_SEPARATOR;
  // получаем путь до класса
  $fileName = $root . $ds . 'application' . $ds . str_replace('\\', $ds, $class) . '.php';
  require ($fileName);
});

// массив роутеров
$routes = require $_SERVER['DOCUMENT_ROOT'] . '/application/config/routes.php';


$rout = '/test/add/';

foreach ($routes as $route) {
  $rout = $route->path;
}
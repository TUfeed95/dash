<?php
session_start();


require_once realpath(dirname(__FILE__) . '/application/Database/Database.php');
require_once realpath(dirname(__FILE__) . '/application/Database/ConnectionDB.php');
require_once realpath(dirname(__FILE__) . '/application/Database/Builder.php');

require_once realpath(dirname(__FILE__) . '/application/Auth/UserAuthentication.php');

require_once realpath(dirname(__FILE__) . '/application/Core/Router.php');
require_once realpath(dirname(__FILE__) . '/application/Core/Dispatcher.php');
require_once realpath(dirname(__FILE__) . '/application/Core/Controller.php');
require_once realpath(dirname(__FILE__) . '/application/Core/Model.php');
require_once realpath(dirname(__FILE__) . '/application/Core/View.php');

require_once realpath(dirname(__FILE__) . '/application/Models/UserModel.php');

require_once realpath(dirname(__FILE__) . '/application/Views/UserView.php');

require_once realpath(dirname(__FILE__) . '/application/Modules/user/User.php');



error_reporting(E_ALL);
ini_set('display_errors', 1);

// массив роутеров
$routes = require $_SERVER['DOCUMENT_ROOT'] . '/application/config/routes.php';
$uri = $_SERVER['REQUEST_URI'];

$router = new Router($routes, $uri);
$router->controller();

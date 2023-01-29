<?php

class Dispatcher
{
  private $controller;

  public function __construct($controller)
  {
    $this->controller = $controller;
  }

  public function getController()
  {
    $basePath = $_SERVER['DOCUMENT_ROOT'];
    $controllerName = ucfirst($this->controller->name) . 'Controller';

    require $basePath . '/application/Controllers/' . $controllerName . '.php';
    call_user_func(array(new $controllerName, $this->controller->action), $this->controller->param);
  }
}
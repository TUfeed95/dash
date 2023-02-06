<?php

class Dispatcher
{
  private $controller;

  public function __construct($controller)
  {
    $this->controller = $controller;
  }

  /**
   * Определение контроллера
   * @return void
   */
  public function getController()
  {
    $controllerName = ucfirst($this->controller->name) . 'Controller';

    require $_SERVER['DOCUMENT_ROOT'] . '/application/Controllers/' . $controllerName . '.php';
    
    if ($this->controller->params) {
      call_user_func(array(new $controllerName, $this->controller->action), $this->controller->params);
    } else {
      call_user_func(array(new $controllerName, $this->controller->action));
    }
    
  }
}
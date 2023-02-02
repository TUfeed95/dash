<?php

class HelloView
{
  public function render($params)
  {
    if ((int)$params['var']){
      require_once $_SERVER['DOCUMENT_ROOT'] . '/application/templates/404.php';
    } else {
      require_once $_SERVER['DOCUMENT_ROOT'] . '/application/templates/hello.php';
    }
  }
}
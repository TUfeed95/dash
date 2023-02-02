<?php

//require_once $_SERVER['DOCUMENT_ROOT'] . '/application/Views/HelloView.php';

class HelloModel
{
  public function message($params)
  {
    $view = new HelloView();
    $view->render($params);
  }
}
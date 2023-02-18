<?php

class UserView
{
  public function loginTemplate()
  {
    require $_SERVER['DOCUMENT_ROOT'] . '/application/templates/admin/login.php';
  }

  public function registerTemplate()
  {
    require $_SERVER['DOCUMENT_ROOT'] . '/application/templates/admin/register.php';
  }

  public function render($model)
  {
    header('Content-Type: application/json');
    
    echo json_encode($model);
  }
}
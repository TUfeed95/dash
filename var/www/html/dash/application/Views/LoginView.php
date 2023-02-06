<?php

class LoginView
{
  public function loginTemplate()
  {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/application/templates/admin/login.php';
  }

  public function render($model)
  {
    if ($model) {
      header('Location: /');
    } else {
      header('Location: /admin/login/');
    }
  }
}
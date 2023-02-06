<?php

class AdminController
{
  public function login()
  {
    (new LoginView())->loginTemplate();
  }

  public function loginForm()
  {
    $login = htmlspecialchars($_POST['login']);
    $password = htmlspecialchars($_POST['password']);
    $model = new UserModel();
    
    $view = new LoginView();
    $view->render($model->getUser($login, $password));
    
  }
}
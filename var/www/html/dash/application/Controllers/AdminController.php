<?php

class AdminController
{
  public function login()
  {
    (new UserView())->loginTemplate();
  }

  public function register()
  {
    (new UserView())->registerTemplate();
  }

  public function loginForm()
  {
    $login = $_POST['login'];
    $password = $_POST['password'];

    $model = new UserModel();

    $view = new UserView();
    $authResponse = $model->authUser($login, $password);
    $view->render($authResponse);
  }

  public function registerForm()
  {
    $email = htmlspecialchars($_POST['email']);
    $login = htmlspecialchars($_POST['login']);
    $password = htmlspecialchars($_POST['password']);

    $model = new UserModel();
    $view = new UserView();
  }
}

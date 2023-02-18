<?php

class AdminController
{
  /**
   * Страница авторизации пользователя
   */
  public function login()
  {
    (new UserView())->loginTemplate();
  }

  /**
   * Страница регистрации пользователя
   */
  public function register()
  {
    (new UserView())->registerTemplate();
  }

  /**
   * Получаем данные авторизации с фронта, 
   * далее передаем их в модель, из модели получаем ответ о правильности данных и передаем его в представление.
   * 
   */
  public function authorizationData()
  {
    // получаем данные из фронта, через fetch  запрос
    $login = htmlspecialchars($_POST['login']);
    $password = htmlspecialchars($_POST['password']);

    $model = new UserModel();
    $view = new UserView();

    $isAuthorization = $model->authorizationUser($login, $password); // проверка правильности данных авторизации
    $view->render($isAuthorization); // передаем ответ в представление
  }

  /**
   * Получаем данные регистрации с фронта, 
   * далее передаем их в модель, из модели получаем ответ о статусе регистрации (успех/не успех) данных и передаем его в представление.
   * 
   */
  public function registrationData()
  {
    $email = htmlspecialchars($_POST['email']);
    $login = htmlspecialchars($_POST['login']);
    $password = htmlspecialchars($_POST['password']);

    $model = new UserModel();
    $view = new UserView();

    $isRegistration = $model->registrationUser($email, $login, $password);
    $view->render($isRegistration);
  }
}

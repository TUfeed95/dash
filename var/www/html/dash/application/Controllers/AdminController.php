<?php

require_once 'Tool/Tool.php';

class AdminController
{
  /**
   * Страница авторизации пользователя
   */
  public function login(): void
  {
    (new UserView(template: 'admin/login.php'))->render();
  }

  /**
   * Страница регистрации пользователя
   */
  public function register(): void
  {
    (new UserView(template: 'admin/register.php'))->render();
  }

	/**
	 * Выход
	 * @return void
	 */
	public function logout(): void
	{
		$_SESSION['auth'] = false;
		header('Location: /admin/login/');
	}

  /**
   * Страница админпанели
   */
  public function index(): void
  {
		if ($_SESSION['auth']) {
			(new UserView(template: 'admin/index.php'))->render();
		} else {
			header('Location: /admin/login/');
		}
  }

  /**
   * Получаем данные авторизации с фронта, 
   * далее передаем их в модель, из модели получаем ответ о правильности данных и передаем его в представление.
   * 
   */
  public function authorizationData(): void
  {
    Tool::checkCsrfToken(htmlspecialchars($_POST['token']));

    $login = htmlspecialchars($_POST['login']);
    $password = htmlspecialchars($_POST['password']);

    $model = new UserModel('users');
    $view = new UserView(model: $model->authorizationUser($login, $password));

    $view->response(); // передаем ответ
  }

  /**
   * Получаем данные регистрации с фронта, далее передаем их в модель,
   * из модели получаем ответ о статусе регистрации (успех/неудача) данных и передаем его в представление.
   *
   * @throws Exception
   */
  public function registrationData(): void
  {
    Tool::checkCsrfToken(htmlspecialchars($_POST['token']));

    $email = htmlspecialchars($_POST['email']);
    $login = htmlspecialchars($_POST['login']);
    $password = htmlspecialchars($_POST['password']);

    $model = new UserModel('users');
    $view = new UserView(model: $model->registrationUser($email, $login, $password));

    $view->response();
  }
}

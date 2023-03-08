<?php

require_once 'Tool/Tool.php';

class AdminController
{
  /**
   * Страница авторизации пользователя
   */
  public function login(): void
  {
    (new UserView())->render('admin/auth/login.php');
  }

  /**
   * Страница регистрации пользователя
   */
  public function register(): void
  {
    (new UserView())->render('admin/auth/register.php');
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
			(new UserView())->render('admin/index.php');
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
		// проверка токена
    if (!Tool::checkCsrfToken(htmlspecialchars($_POST['token']))) {
	    header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
	    exit;
    }

    $login = htmlspecialchars($_POST['login']);
    $password = htmlspecialchars($_POST['password']);

    $userAuthentication = new UserAuthentication();
    $view = new UserView($userAuthentication->authorization($login, $password));

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
	  // проверка токена
	  if (!Tool::checkCsrfToken(htmlspecialchars($_POST['token']))) {
		  header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
		  exit;
	  }

    $email = htmlspecialchars($_POST['email']);
    $login = htmlspecialchars($_POST['login']);
    $password = htmlspecialchars($_POST['password']);

	  $userAuthentication = new UserAuthentication();
    $view = new UserView($userAuthentication->registration($email, $login, $password));

    $view->response();
  }
}
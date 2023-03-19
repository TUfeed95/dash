<?php
namespace Controllers;
use Controllers\Tool\Tool;
use Core\View;
use Exception;
use Auth\UserAuthentication;


class AdminController
{
	/**
	 * Страница авторизации пользователя
	 * @throws Exception
	 */
  public function login(): void
  {
    (new View())->render('admin/auth/login.php');
  }

	/**
	 * Страница регистрации пользователя
	 * @throws Exception
	 */
  public function register(): void
  {
    (new View())->render('admin/auth/register.php');
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
	 * @throws Exception
	 */
  public function index(): void
  {
		if ($_SESSION['auth']) {
			(new View())->render('admin/index.php');
		} else {
			header('Location: /admin/login/');
		}
  }

	/**
	 * Получаем данные авторизации с фронта,
	 * далее передаем их в модель, из модели получаем ответ о правильности данных и передаем его в представление.
	 *
	 * @throws Exception
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
    $view = new View();

    $view->response($userAuthentication->authorization($login, $password)); // передаем ответ
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
    $view = new View();

    $view->response($userAuthentication->registration($email, $login, $password));
  }
}
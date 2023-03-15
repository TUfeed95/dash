<?php
require_once 'Tool/Tool.php';

class UserController
{

	/**
	 * Страница мой профиль
	 * @throws Exception
	 */
	public function index(): void
	{
		if ($_SESSION['auth']) {
			$user = new User();
			$user->currentUser();
			(new View())->render('admin/user/profile.php', $user);
		} else {
			header('Location: /admin/login/');
		}
	}

	/**
	 * @return void
	 * @throws Exception
	 */
	public function basicInformation(): void
	{
		if ($_SESSION['auth']) {
			$user = new User();
			$view = new View();
			$user->currentUser();
			$token = array_shift($_POST);

			// проверка токена
			if (!Tool::checkCsrfToken(htmlspecialchars($token))) {
				header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
				exit;
			}

			$fromData = [];
			foreach ($_POST as $key => $value) {
				$fromData[$key] = htmlspecialchars($value);
			}

			$checkEmail = $user->checkModelAttribute(['email' => $fromData['email']]);
			$checkLogin = $user->checkModelAttribute(['login' => $fromData['login']]);

			if ($checkEmail && $user->email !== $fromData['email']) {
				$view->response(['status' => false, 'message' => 'E-mail занят. Укажите другой.']);
				return;
			} else {
				$user->email = $fromData['email'];
			}

			if ($checkLogin && $user->login !== $fromData['login']) {
				$view->response(['status' => false, 'message' => 'Логин занят. Придумайте другой.']);
				return;
			} else {
				$user->login = $fromData['login'];
			}

			$user->firstname = $fromData['firstname'];
			$user->lastname = $fromData['lastname'];
			$user->city = $fromData['city'];

			$view = new View();
			$view->response($user->save());

		} else {
			header('Location: /admin/login/');
		}
	}

}
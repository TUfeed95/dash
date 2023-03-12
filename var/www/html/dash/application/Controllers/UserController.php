<?php
require_once 'Tool/Tool.php';
class UserController
{

	/**
	 * Страница мой профиль
	 */
	public function index(): void
	{
		if ($_SESSION['auth']) {
			(new UserView())->render('admin/user/profile.php');
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
			$model = new UserModel('users');
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

			$view = new UserView($model->updateUserBasicInformation($fromData));
			$view->response();
		} else {
			header('Location: /admin/login/');
		}

	}

}
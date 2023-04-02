<?php
namespace Controllers;

use Exception;
use Models\User\DataMapperUser;
use Models\User\User;
use Core\View;
use Controllers\Tool\Tool;


class UserController
{

	/**
	 * Страница мой профиль
	 * @throws Exception
	 */
	public function index(): void
	{
		if ($_SESSION['auth']) {
			$currentUser = (new User())->currentUser();
			(new View())->render('admin/user/profile.php', $currentUser);
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
			$user = (new User())->currentUser();
			$mapperUser = new DataMapperUser();
			$view = new View();
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

			if ($mapperUser->getEmail($fromData['email']) && $user->email !== $fromData['email']) {
				$view->response(['status' => false, 'message' => 'E-mail занят. Укажите другой.']);
				return;
			} else {
				$user->email = $fromData['email'];
			}

			if ($mapperUser->getlogin($fromData['login']) && $user->login !== $fromData['login']) {
				$view->response(['status' => false, 'message' => 'Логин занят. Придумайте другой.']);
				return;
			} else {
				$user->login = $fromData['login'];
			}

			$user->firstname = $fromData['firstname'];
			$user->lastname = $fromData['lastname'];
			$user->city = $fromData['city'];

			if ($mapperUser->update($user)) {
				$view->response(['status' => true, 'message' => 'Изменения сохранены.']);
			} else {
				$view->response(['status' => false, 'message' => 'Ошибка сохранения.']);
			}

		} else {
			header('Location: /admin/login/');
		}
	}

}
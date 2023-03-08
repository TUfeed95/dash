<?php

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


	public function basicInformation()
	{
		$model = new UserModel('users');
		$view = new UserView($model);
	}

}
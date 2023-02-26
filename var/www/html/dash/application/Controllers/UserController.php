<?php

class UserController
{

	/**
	 * Страница админпанели
	 */
	public function index(): void
	{
		if ($_SESSION['auth']) {
			(new UserView())->render('admin/user/profile.php');
		} else {
			header('Location: /admin/login/');
		}
	}

}
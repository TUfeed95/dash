<?php

namespace Controllers;

class BaseController
{
	/**
	 * Вошел ли текущий пользователь в систему
	 * @return void
	 */
	protected function isCurrentUserLoggedIn(): void
	{
		if (!$_SESSION['auth']) {
			header('Location: /admin/login/');
		}
	}
}
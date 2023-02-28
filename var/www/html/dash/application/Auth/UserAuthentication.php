<?php

class UserAuthentication
{

	/**
	 * Регистрация пользователя
	 *
	 * @param string $email
	 * @param string $login
	 * @param string $password
	 * @return array
	 * @throws Exception
	 */
	public function registration(string $email, string $login, string $password): array
	{
		$model = new Model('users');
		// результат и ответ для запроса с фронта
		$result = [];

		// что бы понять свободен ли e-mail, ищем пользователей у кого есть такой адрес
		// если пользователь не найден то и e-mail свободен
		$checkEmail = $model->getOneRecord('email', $email);

		if ($checkEmail) {
			return ['email' => true];
		}
		$result['email'] = false;

		$checkLogin = $model->getOneRecord('login', $login);

		if ($checkLogin) {
			return ['login' => true];
		}
		$result['login'] = false;

		// ключи должны соответствовать именам колонок в таблице
		$result['status'] = $model->addRecord([
			'login' => $login,
			'password' => $password,
			'email' => $email,
		]);

		return $result;
	}

	/**
	 * Авторизация пользователя
	 *
	 * @param string $login
	 * @param string $password
	 * @return array
	 */
	public function authorization(string $login, string $password): array
	{
		$user = (new Model('users'))->getOneRecord('login', $login);

		// если пользователь найден по логину, проверяем пароль
		if ($user && $user['password'] == $password) {
			// сохраняем данные в сессию
			$_SESSION['user_id'] = $user['id'];
			$_SESSION['auth'] = true; // пользователь авторизован
			return ['status' => true];
		} else {
			return ['status' => false];
		}
	}
}
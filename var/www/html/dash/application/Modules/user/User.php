<?php

/**
 * Класс пользователя
 */
class User
{
	private $id;
	private $login = '';
	private $email = '';

	public function __construct(int $id)
	{
		$this->id = $id;
	}

	public function setLogin()
	{
		$model = new UserModel('users');
		$user = $model->getUserLogin('id', $this->id);
		$this->login = $user['login'];
	}

	public function getLogin()
	{
		$this->setLogin();
		return $this->login;
	}

  /**
   * Текущий пользователь
   *
   */
  public function currentUser()
  {
		if ($this->id === $_SESSION['user_id']) {
			$model = new UserModel('users');
			$user = $model->getOneRecord('id', $this->id);
			return $user ?: false;
		}
		throw new Exception('Пользователь не является текущим!!');
  }
}
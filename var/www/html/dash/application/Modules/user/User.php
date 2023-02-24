<?php

/**
 * Класс пользователя
 */
class User
{

  public function __construct(public $id)
  {
  }

  /**
   * Текущий пользователь
   *
   */
  public function currentUser()
  {
    $model = new UserModel('users');
		$user = $model->getOneRecord('id', $this->id);
		if ($user) {
			return $user;
		}
  }
}
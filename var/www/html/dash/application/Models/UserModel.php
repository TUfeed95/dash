<?php

class UserModel extends Model
{

  private function tableName(): string
  {
    $this->tableName = 'users';
    return $this->tableName;
  }

  /**
   * Авторизация пользователя
   * 
   * @param string $login
   * @param string $password
   * @return bool
   */
  public function authorizationUser(string $login, string $password): bool
  {
    $user = self::getOneRecord(self::tableName(), 'login', $login);

    // если пользователь найден по логину, проверяем пароль
    if ($user && $user['password'] == $password) {
      // сохраняем данные в сессию
      $_SESSION['user_id'] = $user['id']; // id пользователя, потом понядобиться для организации метода currentUser
      $_SESSION['auth'] = true; // пользователь авторизован
      return true;

    } else {
      return false;
    }

  }

    /**
     * Регистрация пользователя
     *
     * @param string $email
     * @param string $login
     * @param string $password
     * @return array
     * @throws Exception
     */
  public function registrationUser(string $email, string $login, string $password): array
  {
    // что бы понять свободен ли e-mail, ищем пользователей у кого есть такой адрес
    // если пользователь не найден то и e-mail свободен
    $checkEmail = self::getOneRecord(self::tableName(), 'email', $email);

    $result = [];

    if ($checkEmail) {
      return ['email' => true];
    }

    $result['email'] = false;

    $checkLogin = self::getOneRecord(self::tableName(), 'login', $login);

    if ($checkLogin) {
      return ['login' => true];
    }

    $result['login'] = false;

    // ключи должны соотвествовать именам колонок  в таблице
    $params = [
      'login' => $login,
      'password' => $password,
      'email' => $email,
    ];

    if (self::addRecord($this->tableName(), $params))
    {
      $result['status'] = true;
    } else {
      $result['status'] = false;
    }

    return $result;

  }
}

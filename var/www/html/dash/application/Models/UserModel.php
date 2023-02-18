<?php

class UserModel extends Model
{

  private function tableName()
  {
    $this->tableName = 'users';
    return $this->tableName;
  }

  /**
   * Авторизация пользователя
   * 
   * @param mixed $login
   * @param mixed $password
   * @return bool
   */
  public function authorizationUser($login, $password)
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
   */
  public function registrationUser($email, $login, $password)
  {
    $user = self::getOneRecord(self::tableName(), 'email', $email);
    
    $result = [];

    if ($user) {
      $result['email'] = true;
      $result['login'] = $user['login'] == $login ? true : false;
      $result['status'] = false;
      return $result;
    }
    
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

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
     * @throws Exception
     */
  public function registrationUser(string $email, string $login, string $password): array
  {
    $user = self::getOneRecord(self::tableName(), 'email', $email);
    
    $result = [];

    if ($user) {
      $result['email'] = true;
      $result['login'] = $user['login'] == $login;
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

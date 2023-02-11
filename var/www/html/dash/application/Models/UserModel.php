<?php



class UserModel
{

  /**
   * Авторизация пользователя
   * 
   * @param mixed $login
   * @param mixed $password
   * @return bool
   */
  public function authUser($login, $password)
  {
    $connection = Database::connection();

    $query = 'SELECT * FROM users WHERE login = :login';
    $stmt = $connection->prepare($query);
    $stmt->execute(['login' => $login]);

    // если пользователь найден по логину, проверяем пароль
    if ($stmt->rowCount()) {
      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($user['password'] == $password) {
        // сохраняем данные в сессию
        $_SESSION['user_id'] = $user['id']; // id пользователя, потом понядобиться для организации метода currentUser
        $_SESSION['auth'] = true; // пользователь авторизован
        return true;
      } else {
        return false;
      }
    } else {
      return false;
    }
  }

  /**
   * Регистрация пользователя
   * 
   * @param mixed $login
   * @param mixed $password
   */
  public function registerUser($login, $password)
  {
    
  }
}
<?php

class UserModel
{
  public function getUser($login, $password)
  {
    $connection = Database::connection();

    $query = 'SELECT * FROM users WHERE login = :login';
    $stmt = $connection->prepare($query);
    $stmt->execute(['login' => $login]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stmt->rowCount()) {
      if ($user['password'] == $password) {
        return $user;
      }
    } else {
      return false;
    }
  }
}
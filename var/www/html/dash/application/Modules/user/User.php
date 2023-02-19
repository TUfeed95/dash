<?php

/**
 * Класс пользователя
 */
class User
{
  /**
   * Логин пользователя
   * @var string
   */
  public string $login;
  /**
   * E-mail пользователя
   * @var string
   */
  public string $email;

  public function __construct($login, $email)
  {
    $this->login = $login;
    $this->email = $email;
  }

  /**
   * Получаем e-mail пользователя
   *
   * @return string
   */
  public function getEmail(): string
  {
    return $this->email;
  }

  /**
   * Получаем логин пользователя
   *
   * @return string
   */
  public function getLogin(): string
  {
    return $this->login;
  }

  /**
   * Текущий пользователь
   *
   */
  public function currentUser($id)
  {
    return $id;
  }
}
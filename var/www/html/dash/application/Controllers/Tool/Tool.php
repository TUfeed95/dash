<?php

class Tool
{
  /**
   * Проверка csrf-токена
   *
   * @param $token
   * @return void
   */
  public static function checkCsrfToken($token): void
  {
    if (!$token || $token !== $_SESSION['csrf_token']) {
      header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
      exit;
    }
  }
}
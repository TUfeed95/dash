<?php

class View
{
  protected function generateCSRFToken(): void
  {
    try {
      $_SESSION['csrf_token'] = bin2hex(random_bytes(35));
    } catch (Exception $e) {
      echo "Произошла ошибка при генерации csrf-токена.";
    }
  }
}
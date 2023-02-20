<?php

class UserView extends View
{
  public function loginTemplate(): void
  {
    $this->generateCSRFToken();
    require $_SERVER['DOCUMENT_ROOT'] . '/application/templates/admin/login.php';
  }

  public function registerTemplate(): void
  {
    $this->generateCSRFToken();
    require $_SERVER['DOCUMENT_ROOT'] . '/application/templates/admin/register.php';
  }

  public function render($model): void
  {
    header('Content-Type: application/json');
    
    echo json_encode($model);
  }
}
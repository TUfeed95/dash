<?php

class View
{

  protected $model;

  public function __construct($model = null)
  {
    $this->model = $model;
  }

  protected function generateCSRFToken(): void
  {
    try {
      $_SESSION['csrf_token'] = bin2hex(random_bytes(35));
    } catch (Exception $e) {
      echo "Произошла ошибка при генерации csrf-токена: " . $e->getMessage();
    }
  }

  public function render($template, $data = null): void
  {
    $this->generateCSRFToken();
    include $_SERVER['DOCUMENT_ROOT'] . '/application/templates/' . $template;
  }
}
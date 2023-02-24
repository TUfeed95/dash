<?php

class View
{

  protected $model;
  protected $template;

  public function __construct($model = null, $template = null)
  {
    $this->model = $model;
    $this->template = $template;
  }

  protected function generateCSRFToken(): void
  {
    try {
      $_SESSION['csrf_token'] = bin2hex(random_bytes(35));
    } catch (Exception $e) {
      echo "Произошла ошибка при генерации csrf-токена: " . $e->getMessage();
    }
  }

  public function render($params = null): void
  {
		$data = '';
		if ($params != null) {
			$data = $params;
    }
    $this->generateCSRFToken();
    require $_SERVER['DOCUMENT_ROOT'] . '/application/templates/' . $this->template;
  }
}
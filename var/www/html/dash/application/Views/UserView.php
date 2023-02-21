<?php

class UserView extends View
{

  public function render($template)
  {
    $this->generateCSRFToken();
    require $_SERVER['DOCUMENT_ROOT'] . '/application/templates/' . $template;
  }

  public function response($model): void
  {
    header('Content-Type: application/json');
    
    echo json_encode($model);
  }
}
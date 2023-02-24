<?php

class UserView extends View
{

  /**
   * Ответ на запрос с js
   * @return void
   */
  public function response(): void
  {
    header('Content-Type: application/json');
    echo json_encode($this->model);
  }
}
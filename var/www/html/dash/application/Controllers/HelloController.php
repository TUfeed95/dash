<?php

class HelloController
{
  public function text($data)
  {
    $params = $data;
    require_once $_SERVER['DOCUMENT_ROOT'] . '/application/templates/test.php';
  }
}
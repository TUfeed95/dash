<?php

class TestController
{
  public function hello($data)
  {
    $param = $data;
    require_once $_SERVER['DOCUMENT_ROOT'] . '/application/templates/hello.php';
  }
}
<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/application/Models/HelloModel.php';

class HelloController
{
  public function text($data)
  {

    $helloModel = new HelloModel();
    $helloModel->message($data);    
  }
}
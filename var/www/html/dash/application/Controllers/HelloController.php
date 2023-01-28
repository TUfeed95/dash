<?php
use Core\Controller;
use Core\Views;

class HelloController
{
  private $view;

  public function __construct($view)
  {
    // путь до шаблонов
    $this->view = new Views('../Views');
  }
  public function hello($text)
  {
    // формируем параметры
    $params = [
      ['title' => 'Hello', 'text' => 'Text'],
      ['title' => 'Hello 1', 'text' => 'Text 1']
    ];
    // передаем парметры в шаблон
    $this->view->render('hello.php', ['params' => $params]);
  }
}
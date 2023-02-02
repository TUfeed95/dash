<?php

class View
{
  private $template;
  private $model;
  private $controller;

  public function __construct($template, $model, $controller)
  {
    $this->template = $template;
    $this->model = $model;
  }

  public function render($template, $model)
  {
    $data = $this->model->param;
    require_once $this->template;
  }
}
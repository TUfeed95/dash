<?php

class View
{
  private $template;
  private $model;

  public function __construct($template, $model)
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
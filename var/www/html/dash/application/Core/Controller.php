<?php



class Controller
{
  private $name;
  private $action;
  private $params;

  public function __construct($name, $action, array $params)
  {
    $this->name = $name;
    $this->action = $action;
    $this->params = $params;
  }

  public function __get($property)
  {
    return $this->$property;
  }
}
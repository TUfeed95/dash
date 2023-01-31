<?php



class Controller
{
  private $name;
  private $action;
  private $param;

  public function __construct($name, $action, array $param)
  {
    $this->name = $name;
    $this->action = $action;
    $this->param = $param;
  }

  public function __get($property)
  {
    return $this->$property;
  }
}
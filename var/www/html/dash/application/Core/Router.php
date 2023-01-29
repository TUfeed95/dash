<?php

require_once 'Controller.php';

class Router
{
  private $routes;
  private $uri;

  public function __construct($routes, $uri)
  {
    $this->routes = $routes;
    $this->uri = $uri;
  }

  public function controller()
  { 
    foreach ($this->routes as $route) {
      $pattern = self::generatePatternRouter($route);
      if (preg_match($pattern, $this->uri, $matches)) {
        $controller = new Controller($route->controller, $route->action, $matches[3]);
        $dispatcher = new Dispatcher($controller);
        $dispatcher->getController();
        return;
      }
    }
    require $_SERVER['DOCUMENT_ROOT'] . '/application/templates/404.php';
  }

  /**
   * Генерирует регулярное выражение на основе предопределенного роутера.
   * 
   * @param Route $route роутер
   * @return string
   */
  private function generatePatternRouter($route) 
  {
    // TODO: Метод требует доработки для генерации более сложных выражений

    $pattern = '/';
    $seporator = '\/';
    // разбиваем роутер на фрагменты
    $fragments = explode('/', trim($route->path, '/'));
    foreach ($fragments as $fragment) {
      // если фрагмент не состоит только из цифр то записываем как есть, 
      // иначе записываем диапазон цифр
      if (!ctype_digit($fragment)) {
        $pattern .= $seporator . '(' . $fragment . ')';
      } else {
        $pattern .= $seporator . '([0-9]+)';
      }
    }
    // конец выражения
    $pattern .= '$/';
    return $pattern;
  }
}
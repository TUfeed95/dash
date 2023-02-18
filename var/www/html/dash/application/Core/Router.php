<?php

//require_once 'Controller.php';

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
    if ($this->uri == '/') {
      require $_SERVER['DOCUMENT_ROOT'] . '/application/templates/index.php';
      return;
    }
    // парсим url, получаем из него парматры и передаем в класс контроллера
    $query = parse_url($this->uri);
    foreach ($this->routes as $route) {
      $pattern = self::generatePatternRouter($route);
      if (preg_match($pattern, $query['path'], $matches)) {
        // получаем парметры из url
        // если есть параметры то передаем, иначе null
        if (array_key_exists('query', $query)) {
          parse_str($query['query'], $params);
          // создаем объект контроллера
          $controller = new Controller($route->controller, $route->action, $params);
        } else {
          $controller = new Controller($route->controller, $route->action);
        }
        // передаем объект контроллера и создаем объект диспетчера в котором определяем класс контроллера
        $dispatcher = new Dispatcher($controller);
        // определяем класс контроллера
        $dispatcher->getController();
        return;
      }
    }
    require $_SERVER['DOCUMENT_ROOT'] . '/application/templates/404.php';
  }

  /**
   * Генерирует регулярное выражение на основе переданного роутера.
   * 
   * @param $route роутер
   * @return string
   */
  private function generatePatternRouter($route)
  {
    $seporator = '\/';
    // разбиваем роутер на фрагменты
    $fragments = parse_url($route->path);
    $path = $fragments['path'];
    $pattern = '/(' . str_replace('/', $seporator, $path) . ')$/';
    return $pattern;
  }
}

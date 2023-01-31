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
    $params = [];
    foreach ($this->routes as $route) {
      $pattern = self::generatePatternRouter($route);
      if (preg_match($pattern, $this->uri, $matches)) {
        // парсим url, получаем из него парматры и передаем в класс контроллера
        $params = self::arrayParams($this->uri);
        // создаем объект контроллера
        $controller = new Controller($route->controller, $route->action, $params);
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
    // TODO: Метод требует доработки для генерации более сложных выражений

    $pattern = '/';
    $seporator = '\/';
    // разбиваем роутер на фрагменты
    $fragments = parse_url($route->path);
    $path = $fragments['path'];
    $query = $fragments['query'];
    $params = explode('&', $query);
    $pattern .= '(' . str_replace('/', $seporator, $path) . ')' . '\?';
    foreach ($params as $param) {
      if (preg_match('/(\w+)=(\w+)/', $param, $matches)) {
        switch ($matches[2]) {
          case 'int':
            $pattern .= '(\w+=[0-9]+)&';
            break;
          case 'str':
            $pattern .= '(\w+=\w+)&';
            break;
        }
      }
    }
    // конец выражения
    $pattern = substr($pattern, 0, -1) .  '$/'; // substr($pattern, 0, -1) - удаляем последний символ "&" в строке
    return $pattern;
  }

  /**
   * Массив с параметрами из url
   * @param string $uri url переданный в адресную строку браузера
   */
  public function arrayParams($uri) 
  {
    $uriFragment = parse_url($uri); // парсим url
    $params = explode('&', $uriFragment['query']); // разбиваем на пары
    $arrayParams = [];
    foreach ($params as $param) {
      $itemParams = explode('=', $param);
      $arrayParams[$itemParams[0]] = $itemParams[1]; // формируем массив: ключ => значение
    }
    return $arrayParams;
  }
}
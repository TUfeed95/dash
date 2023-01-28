<?php
namespace Core;

class Router
{
  public function getRoute($routes, $uri)
  { 
    foreach ($routes as $route) {
      $pattern = self::generatePatternRouter($route);
      if (preg_match($pattern, $uri, $matches)) {
        
      }
    }
    return '';
  }

  /**
   * Генератор регулярного выражения из роутера
   */
  public function generatePatternRouter($route) 
  {
    // TODO: Метод требует доработки для генерации более сложных выражений

    // начало выражения
    $pattern = '/';
    // слэш
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
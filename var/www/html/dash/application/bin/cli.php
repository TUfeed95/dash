<?php
require_once '../Exceptions/CliExeption.php';

try {
  // удаляем первый аргумент командной строки
  unset($argv[0]);

  // автоматически загружаем классы из директории Commands
  spl_autoload_register(function ($className) {
    require_once '../Commands/' . $className . '.php';
  });

  // получаем наименование класса и метода
  $className = 'Command' . array_shift($argv);
  $funcName = array_shift($argv);

  // получаем аргументы по шаблону: -d=2
  foreach ($argv as $arguments) {
    preg_match('/^--(.+)=(.+)$/', $arguments, $matches);
    if (!empty($matches)) {
      $paramName = $matches[1];
      $paramValue = $matches[2];

      $params[$paramName] = $paramValue;
    }
  }

  // выполняем переданую функцию
  // если нет аргументов
  if (empty($params)) {
    $class = new $className();
    $class->$funcName();
  } else {
    // если есть аргументы
    call_user_func_array(array($className, $funcName), $params);
  }
} catch (CliExeption $e) {
  echo "Ошибка: " . $e->getMessage();
}

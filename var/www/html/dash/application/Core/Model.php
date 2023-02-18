<?php

class Model
{
  /**
   * Имя таблицы
   */
  protected $tableName;

  /**
   * Возвращает одну запись из таблицы
   * 
   * @param string $table  имя таблицы
   * @param string $column  имя поля по которому отбирать запись
   * @param string $param  значение по которому отбирать запись
   */
  protected function getOneRecord(string $table, string $column, string $param)
  {
    $connection = Database::connection();

    $query = 'SELECT * FROM ' . $table .  ' WHERE ' . $column . ' = :param';
    
    try {
      $stmt = $connection->prepare($query);
      $stmt->execute(['param' => $param]);
    } catch (PDOException $exeption) {
      echo "Произошла ошибка при выполнении запроса: " . $exeption->getMessage();
    }
    
    // если кол-во строк более 0 то возвращем в виде массива
    // по идее строк не может быть больше одной
    if ($stmt->rowCount()) {
      $response = $stmt->fetch(PDO::FETCH_ASSOC);

      // закрываем подключение
      $connection = null;
      $stmt = null;

      return $response;
    } else {
      return false;
    }
  }

  /**
   * Добавление записи в таблицу
   * 
   * @param string $tableName имя таблицы
   * @param array $params ассоциативный массив где: key = имя колонки, а value = содержимое колонки
   */
  protected function addRecord($tableName, $params = [])
  {
    $connrection = Database::connection();

    $colums = [];
    $prepareColums = [];

    // выбрасываем исключение, если массив не ассоциативный
    if (array_is_list($params)){
      throw new Exception('Массив должен иметь формат: key => value');
    }

    // перебираем ключи массива, это нужно для того, что бы при построении запроса использовать их как
    // наименования колонок и псевдопеременные
    foreach ($params as $key => $value) {
      $colums[] = $key;
      $prepareColums[] = ':' . $key;
    }

    // преобразуем массивы ключей и псевдопеременных в строки
    $columnNames = implode(',', $colums); // наименования колонок
    $pseudoVariables = implode(',', $prepareColums); // псевдопеременные

    $query = "INSERT INTO " . $tableName . " (" . $columnNames . ") VALUES (" . $pseudoVariables . ")";

    try {
      $stmt = $connrection->prepare($query);
      $stmt->execute($params);

      $connrection = null;
      $stmt = null;

      return true;
    } catch (PDOException $exeption) {
      echo "Произошла ошибка при выполнении запроса: " . $exeption->getMessage();
      return false;
    }

  }
}
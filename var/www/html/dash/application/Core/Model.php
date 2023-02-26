<?php

class Model
{

  public function __construct(private $tableName)
  {
  }

	public function getTableName()
	{
		return $this->tableName;
	}

  /**
   * Возвращает одну запись из таблицы
   *
   * @param string $column  имя поля по которому отбирать запись
   * @param string $param  значение по которому отбирать запись
   */
  public function getOneRecord(string $column, string $param)
  {
    $connection = Database::connection();

    $query = 'SELECT * FROM ' . $this->tableName .  ' WHERE ' . $column . ' = :param';
    
    try {
      $stmt = $connection->prepare($query);
      $stmt->execute(['param' => $param]);
    } catch (PDOException $exception) {
      throw new PDOException('Привыполнении запроса возникла ошибка: ' . $exception->getMessage());
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
     * @param array $params ассоциативный массив где: key = имя колонки, а value = содержимое колонки
     * @throws Exception
     */
  protected function addRecord(array $params): bool
  {
    $connection = Database::connection();

    $columns = [];
    $prepareColumns = [];

    // выбрасываем исключение, если массив не ассоциативный
    if (array_is_list($params)){
      throw new Exception('Массив должен иметь формат: key => value');
    }

    // перебираем ключи массива, это нужно для того, что бы при построении запроса использовать их как
    // наименования колонок и псевдопеременные
    foreach ($params as $key => $value) {
      $columns[] = $key;
      $prepareColumns[] = ':' . $key;
    }

    // преобразуем массивы ключей и псевдопеременных в строки
    $columnNames = implode(',', $columns); // наименования колонок
    $pseudoVariables = implode(',', $prepareColumns); // псевдопеременные

    $query = "INSERT INTO " . $this->tableName . " (" . $columnNames . ") VALUES (" . $pseudoVariables . ")";

    try {
      $stmt = $connection->prepare($query);
      $stmt->execute($params);

      $connection = null;
      $stmt = null;

      return true;
    } catch (PDOException $exception) {
      echo "Произошла ошибка при выполнении запроса: " . $exception->getMessage();
      return false;
    }

  }
}
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
	 * @param string $column Имя поля по которому отбирать запись
	 * @param string $value Значение по которому отбирать запись
	 * @throws Exception
	 */
  public function getOneRecord(string $column, string $value)
  {
		$db = new Database();
	  $params = [$column => $value];
    
    try {
	    $stmt = $db->createRequest()
		    ->select()
		    ->from($this->tableName)
		    ->where($params)
		    ->query();
    } catch (PDOException $exception) {
      throw new PDOException('При выполнении запроса возникла ошибка: ' . $exception->getMessage());
    }
    // если кол-во строк более 0, то возвращаем в виде массива
    // по идее строк не может быть больше одной
    if ($stmt->rowCount()) {
	    return $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
      return false;
    }
  }

  /**
   * Добавление записи в таблицу
   *
   * @param array $params Ассоциативный массив где: key = имя колонки, а value = содержимое колонки
   * @throws Exception
   */
  public function addRecord(array $params): bool
  {
	  $connection = (ConnectionDB::getInstance())->connection();

    $columns = [];
    $prepareColumns = [];
	  $query = '';

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
      return true;
    } catch (PDOException $exception) {
      echo "Произошла ошибка при выполнении запроса: " . $exception->getMessage();
      return false;
    }
  }

	/**
	 * @throws Exception
	 */
	public function updateRecord($where, $values): bool
	{
		$connection = (ConnectionDB::getInstance())->connection();

		$setParams = $this->substringPseudoVariables($values, ',');
		$whereParams = $this->substringPseudoVariables($where, 'AND');

		$query = 'UPDATE ' . $this->tableName . ' SET ' . $setParams . ' WHERE ' . $whereParams;
		$executeParams = array_merge($where, $values);

		try {
			$stmt = $connection->prepare($query);
			$stmt->execute($executeParams);
			return true;
		} catch (PDOException $exception) {
			echo "Произошла ошибка при выполнении запроса: " . $exception->getMessage();
			return false;
		}
	}

	private function substringPseudoVariables($params, $separator): string
	{
		$paramsToString = [];
		$result = '';
		foreach ($params as $key => $value) {
			$paramsToString[] .= $key . ' = :' . $key;
			$result = implode($separator, $paramsToString);
		}
		return $result;
	}
}
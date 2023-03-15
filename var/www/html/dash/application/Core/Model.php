<?php

class Model
{

	/**
	 * Имя таблицы
	 * @var string
	 */
	protected string $table;

	/**
	 * Результат сохранения данных
	 * @var array
	 */
	protected array $result;

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
		    ->from($this->table)
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
   * @return array Возврат массива со статусом ['status' => true/false]
   * @param array $params Ассоциативный массив где: key = имя колонки, а value = содержимое колонки
   * @throws Exception
   */
  public function addRecord(array $params): array
  {
	  $connection = (ConnectionDB::getInstance())->connection();

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

	  $query = "INSERT INTO " . $this->table . " (" . $columnNames . ") VALUES (" . $pseudoVariables . ")";

    try {
      $stmt = $connection->prepare($query);
      $stmt->execute($params);
			$this->result['status'] = true;
    } catch (PDOException $exception) {
      throw new PDOException("Произошла ошибка при выполнении запроса: " . $exception->getMessage());
    }
		return $this->result;
  }

	/**
	 * Обновление записи в БД по заданным параметрам
	 * @return array Возврат массива со статусом ['status' => true/false]
	 * @throws Exception
	 */
	public function updateRecord($where, $values): array
	{
		$connection = (ConnectionDB::getInstance())->connection();

		$setParams = $this->substringPseudoVariables($values, ',');
		$whereParams = $this->substringPseudoVariables($where, 'AND');

		$query = 'UPDATE ' . $this->table . ' SET ' . $setParams . ' WHERE ' . $whereParams;
		$executeParams = array_merge($where, $values);

		try {
			$stmt = $connection->prepare($query);
			$stmt->execute($executeParams);
			$this->result['status'] = 'true';
			$this->result['message'] = 'Данные успешно сохранены.';
		} catch (PDOException $exception) {
			throw new PDOException("Произошла ошибка при выполнении запроса: " . $exception->getMessage());
		}
		return $this->result;
	}


	function checkModelAttribute($params): bool
	{
		$db = new Database();

		try {
			$stmt = $db->createRequest()
				->select()
				->from($this->table)
				->where($params)
				->query();
		} catch (PDOException $exception) {
			throw new PDOException('При выполнении запроса возникла ошибка: ' . $exception->getMessage());
		}
		if ($stmt->rowCount()) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Строка из параметров для sql запроса:
	 *
	 * Пример:
	 * 1. Разделитель - 'AND': key = :key AND key1 = :key1 AND key2 = :key2
	 * 2. Разделитель - запятая: key = :key, key1 = :key1, key2 = :key2
	 *
	 * @param array $params Ассоциативный массив с параметрами
	 * @param string $separator Разделитель
	 * @return string
	 */
	private function substringPseudoVariables(array $params, string $separator): string
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
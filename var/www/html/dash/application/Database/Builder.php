<?php

// TODO позже разработать нормальный билдер
class Builder
{
	private string $select = '';
	private string $from = '';
	private array $where = [];

	/**
	 *
	 * @return void
	 */
	public function clearFeatures(): void
	{
		$this->where = [];
		$this->select = '';
		$this->from = '';
	}

	/**
	 * Оператор выборки данных
	 * @param $columns
	 * @return $this
	 */
	public function select($columns = null)
	{
		if (!$columns) {
			$columns = '*';
		}

		$this->select = 'SELECT ' . $columns;
		return $this;
	}

	/**
	 * Таблица
	 * @param $table
	 * @return $this
	 */
	public function from($table)
	{
		$this->from = ' FROM ' . $table;
		return $this;
	}

	/**
	 * Параметры получения выборки
	 * @throws Exception
	 */
	public function where($params = [])
	{
		// выбрасываем исключение, если массив не ассоциативный
		if (array_is_list($params)){
			throw new Exception('Массив должен иметь формат: key => value');
		}

		$this->where = $params;
		return $this;
	}

	/**
	 * Выполнение запроса
	 * @throws Exception
	 */
	public function query(): bool|PDOStatement
	{
		$db = ConnectionDB::getInstance();
		$connection = $db->connection();
		$params = '';

		foreach ($this->where as $key => $value) {
			$params .= $key . ' = :' . $key;
			if (!array_key_last($this->where) && !array_key_first($this->where)) {
				$params .= ' AND ';
			}
		}

		$query = $this->select . $this->from . ' WHERE ' . $params;
		$stmt = $connection->prepare($query);
		$stmt->execute($this->where);

		$this->clearFeatures();
		return $stmt;
	}

}
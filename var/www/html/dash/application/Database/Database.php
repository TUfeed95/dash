<?php

class Database
{
  const DB_USER = 'root';
  const DB_USER_PASSWORD = 'root';
  const DB_NAME = 'dashboard_db';
  const DB_HOST = 'dash_db';

	private $select = '';
	private $from = '';
	private $where = '';

  /**
   * Подключение к базе данных
   * @return PDO|void
   */
  public function connection()
  {
    try {
      $dsn = sprintf("pgsql:host='%s';port=5432;dbname='%s';user='%s';password='%s'", self::DB_HOST, self::DB_NAME, self::DB_USER, self::DB_USER_PASSWORD);
      return new PDO($dsn);
    } catch (PDOException $e) {
      echo "Ошибка подключения к базе данных: " . $e->getMessage() . PHP_EOL;
      die();
    }
  }


  /**
   * Существует ли таблица.
   * Если таблица не существует то, возвращает пустое значение (в прямом смысле этого слова).
   * Иначе возвращает 1.
   * @param string $tableName Имя таблицы
   */
  public static function checkTable(string $tableName): bool|PDOStatement
  {
    $conn = (new Database)->connection();
    $query = "SELECT EXISTS (SELECT FROM information_schema.tables WHERE TABLE_NAME = '" . $tableName . "')";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    return $stmt;
  }

	public function select($columns)
	{
		$this->select = "SELECT " . $columns;
		return $this;
	}

	public function from($table)
	{
		$this->from = " FROM " . $table;
		return $this;
	}

	public function where($params)
	{
		$this->where = " WHERE " . $params;
		return $this;
	}

	public function query()
	{
		$connection = (new Database())->connection();
		$query = $this->select . $this->from . $this->where;
		$stmt = $connection->prepare($query);

	}

}
<?php
namespace Database;

use PDOStatement;
use Exception;

class Database
{
	public function __construct()
	{

	}
	/**
	 * Существует ли таблица.
	 * Если таблица не существует то, возвращает пустое значение (в прямом смысле этого слова).
	 * Иначе возвращает 1.
	 * @param string $tableName Имя таблицы
	 * @throws Exception
	 */
  public static function checkTable(string $tableName): bool|PDOStatement
  {
	  $connection = ConnectionDB::getInstance()->connection();
    $query = "SELECT EXISTS (SELECT FROM information_schema.tables WHERE TABLE_NAME = '" . $tableName . "')";
    $stmt = $connection->prepare($query);
    $stmt->execute();
    return $stmt;
  }

	/**
	 * @return Builder
	 */
	public function createRequest(): Builder
	{
		return new Builder();
	}
}
<?php

class Database
{
	/**
	 * Существует ли таблица.
	 * Если таблица не существует то, возвращает пустое значение (в прямом смысле этого слова).
	 * Иначе возвращает 1.
	 * @param string $tableName Имя таблицы
	 * @throws Exception
	 */
  public static function checkTable(string $tableName): bool|PDOStatement
  {
	  $connection = (ConnectionDB::getInstance())->connection();
    $query = "SELECT EXISTS (SELECT FROM information_schema.tables WHERE TABLE_NAME = '" . $tableName . "')";
    $stmt = $connection->prepare($query);
    $stmt->execute();
    return $stmt;
  }

	/**
	 * Для того, что бы организовать простую ОРМ и в цепочке вызова методов не было лишних функций,
	 * возвращаем объект класса ORM
	 * @return ORM
	 */
	public function createRequest(): ORM
	{
		return new ORM();
	}
}
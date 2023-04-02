<?php

namespace Models;

use Database\ConnectionDB;
use PDO;
use PDOException;
use Exception;

class DataMapper
{
	/**
	 * @param string $query SQL запрос
	 * @param array $params Массив с данными для запроса
	 * @throws Exception
	 */
	protected function requestExecute(string $query, array $params): void
	{
		$connection = ConnectionDB::getInstance()->connection();
		try {
			$stmt = $connection->prepare($query);
			$stmt->execute($params);
			$stmt->closeCursor();
		} catch (PDOException $exception) {
			throw new PDOException("Произошла ошибка при выполнении запроса: " . $exception->getMessage());
		}
	}

	/**
	 * Выполняем запрос и возвращаем объект
	 *
	 * @param string $stdClass Имя класса создаваемого объекта
	 * @param string $query SQL запрос
	 * @param array $params Массив с данными для запроса
	 * @throws Exception
	 */
	protected function requestExecuteAndReturnFetchObject(string $stdClass, string $query, array $params)
	{
		$connection = ConnectionDB::getInstance()->connection();
		$stmt = $connection->prepare($query);
		$stmt->execute($params);
		$stmt->closeCursor();
		if (!empty($stmt)) {
			return $stmt->fetchObject($stdClass);
		}
		return $stmt;
	}

	/**
	 * Выполняем запрос и возвращаем строку с данными
	 *
	 * @param string $query SQL запрос
	 * @param array $params Массив с данными для запроса
	 * @throws Exception
	 */
	protected function requestExecuteAndReturnRecord(string $query, array $params)
	{
		$connection = ConnectionDB::getInstance()->connection();

		$stmt = $connection->prepare($query);
		$stmt->execute($params);
		$stmt->closeCursor();
		if (!empty($stmt)) {
			return $stmt->fetch(PDO::FETCH_ASSOC);
		}
		return $stmt;
	}
}
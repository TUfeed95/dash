<?php

namespace Models\User;

use Models\MapperInterface;
use Database\ConnectionDB;

use PDO;
use Exception;
use PDOException;

class MapperUser implements MapperInterface
{
	/**
	 * @throws Exception
	 */
	public function create($model): bool
	{
		$connection = ConnectionDB::getInstance()->connection();

		// удаление пустых элементов
		$params = array_diff((array) $model, array(null, 'id'));

		$paramsConverting = self::convertingArrayToColumnNamesAndPseudoVariables($params);

		$query = "INSERT INTO users (" . $paramsConverting->columnNames . ") VALUES (" . $paramsConverting->pseudoVariables . ")";

		try {
			$stmt = $connection->prepare($query);
			$stmt->execute($params);
		} catch (PDOException $exception) {
			throw new PDOException("Произошла ошибка при выполнении запроса: " . $exception->getMessage());
		}
		return true;
	}

	/**
	 * @throws Exception
	 */
	public function update($model): bool
	{
		$connection = ConnectionDB::getInstance()->connection();

		$params = (array) $model;
		$paramsConverting = self::substringPseudoVariables($params, ',');

		$query = 'UPDATE users SET ' . $paramsConverting . ' WHERE id = ' . $model->id;

		try {
			$stmt = $connection->prepare($query);
			$stmt->execute($params);
		} catch (PDOException $exception) {
			throw new PDOException("Произошла ошибка при выполнении запроса: " . $exception->getMessage());
		}
		return true;
	}

	public function remove()
	{
		// TODO: Implement remove() method.
	}

	/**
	 * Возвращаем пользователя по его id
	 * @throws Exception
	 */
	public function getById($id)
	{
		if (!empty($id)) {
			$connection = ConnectionDB::getInstance()->connection();

			$query = "SELECT * FROM users WHERE id = '" . $id . "'";
			$stmt = $connection->prepare($query);
			$stmt->execute();

			if (!empty($stmt)) {
				return $stmt->fetchObject('Models\User\User');
			}
			return $stmt;
		} else {
			throw new Exception("Переменная id пустая.");
		}
	}

	/**
	 * Возвращаем пользователя по его логину
	 *
	 * @param string $login Логин пользователя
	 * @return bool|User Объект пользователя или false
	 * @throws Exception
	 */
	public function getByLogin(string $login): bool|User
	{
		if (!empty($login)) {
			$connection = ConnectionDB::getInstance()->connection();

			$query = "SELECT * FROM users WHERE login = '" . $login . "'";
			$stmt = $connection->prepare($query);
			$stmt->execute();

			if (!empty($stmt)) {
				return $stmt->fetchObject('Models\User\User');
			}
			return $stmt;
		} else {
			throw new Exception("Переменная email пустая.");
		}
	}

	/**
	 * @throws Exception
	 */
	public function getEmail($email)
	{
		if (!empty($email)) {
			$connection = ConnectionDB::getInstance()->connection();

			$query = "SELECT email FROM users WHERE email = '$email'";
			$stmt = $connection->prepare($query);
			$stmt->execute();

			if (!empty($stmt)) {
				return $stmt->fetch(PDO::FETCH_ASSOC);
			}
			return $stmt;
		} else {
			throw new Exception("Переменная email пустая.");
		}
	}

	/**
	 * @throws Exception
	 */
	public function getLogin($login)
	{
		if (!empty($login)) {
			$connection = ConnectionDB::getInstance()->connection();

			$query = "SELECT login FROM users WHERE login = '$login'";
			$stmt = $connection->prepare($query);
			$stmt->execute();

			if (!empty($stmt)) {
				return $stmt->fetch(PDO::FETCH_ASSOC);
			}
			return $stmt;
		} else {
			throw new Exception("Переменная login пустая.");
		}
	}

	/**
	 * Перебираем ключи массива, это нужно для того, что бы при построении запроса использовать их как
	 * наименования колонок и псевдопеременные
	 * @param array $params
	 * @return object
	 * @throws Exception
	 */
	private function convertingArrayToColumnNamesAndPseudoVariables(array $params): object
	{
		// выбрасываем исключение, если массив не ассоциативный
		if (array_is_list($params)){
			throw new Exception('Массив должен иметь формат: key => value');
		}

		$columns = [];
		$prepareColumns = [];

    foreach ($params as $key => $value) {
	    $columns[] = $key;
	    $prepareColumns[] = ':' . $key;
    }

		// преобразуем массивы ключей и псевдопеременных в строки
		$columnNames = implode(',', $columns); // наименования колонок
		$pseudoVariables = implode(',', $prepareColumns); // псевдопеременные

		return (object) ['columnsNames' => $columnNames, 'pseudoVariables' => $pseudoVariables];
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
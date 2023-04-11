<?php

namespace Models\User;

use Models\DataMapper;
use Models\DataMapperInterface;
use Exception;

class DataMapperUser extends DataMapper implements DataMapperInterface
{
	/**
	 * Создание пользователя
	 * @throws Exception
	 */
	public function create($model): bool
	{
		// удаление пустых элементов
		$params = array_diff((array) $model, array(null, 'id'));

		$paramsConverting = self::convertingArrayToColumnNamesAndPseudoVariables($params);

		$query = "INSERT INTO users (" . $paramsConverting->columnNames . ") VALUES (" . $paramsConverting->pseudoVariables . ")";
		$this->requestExecute($query, $params);

		return true;
	}

	/**
	 * Обновление пользователя
	 * @throws Exception
	 */
	public function update($model): bool
	{
		$params = (array) $model;
		$paramsConverting = self::substringPseudoVariables($params, ',');

		$query = 'UPDATE users SET ' . $paramsConverting . ' WHERE id = ' . $model->id;
		$this->requestExecute($query, $params);

		return true;
	}

	public function remove()
	{
		// TODO: Implement remove() method.
	}

	/**
	 * Возвращаем пользователя по его id
	 * @return bool|User Объект пользователя
	 * @throws Exception
	 */
	public function getById($id): bool|User
	{
		if (!empty($id)) {
			$query = "SELECT * FROM users WHERE id = :id";
			return $this->requestExecuteAndReturnFetchObject('Models\User\User', $query, ['id' => $id]);
		} else {
			throw new Exception("Переменная id пустая.");
		}
	}

	/**
	 * Возвращаем пользователя по его логину
	 *
	 * @param string $login Логин пользователя
	 * @return bool|User Объект пользователя
	 * @throws Exception
	 */
	public function getByLogin(string $login): bool|User
	{
		if (!empty($login)) {
			$query = "SELECT * FROM users WHERE login = :login";
			return $this->requestExecuteAndReturnFetchObject('Models\User\User', $query, ['login' => $login]);
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
			$query = "SELECT email FROM users WHERE email = :email";
			return $this->requestExecuteAndReturnRecord($query, ['email' => $email]);
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
			$query = "SELECT login FROM users WHERE login = :login";
			return $this->requestExecuteAndReturnRecord($query, ['login' => $login]);
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

		return (object) ['columnNames' => $columnNames, 'pseudoVariables' => $pseudoVariables];
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
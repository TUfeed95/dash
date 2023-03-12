<?php

/**
 * Класс модели пользователя.
 */
class UserModel extends Model
{

  public function __construct($tableName)
  {
    parent::__construct($tableName);
  }

	/**
	 * Возвращает логин пользователя
	 * @param $column
	 * @param $param
	 * @return false|mixed
	 * @throws Exception
	 */
	public function getUserLogin($column, $param): mixed
	{

		$connection = (ConnectionDB::getInstance())->connection();

		$query = 'SELECT login FROM ' . $this->getTableName() .  ' WHERE ' . $column . ' = :param';
		try {
			$stmt = $connection->prepare($query);
			$stmt->execute(['param' => $param]);
		} catch (PDOException $exception) {
			throw new PDOException('При выполнении запроса возникла ошибка: ' . $exception->getMessage());
		}
		if ($stmt->rowCount()) {
			return $stmt->fetch(PDO::FETCH_ASSOC);
		}
		return false;
	}

	/**
	 * @throws Exception
	 */
	public function updateUserBasicInformation($fromData): array
	{
		$result = [];
		$user = new User();

		if (self::getOneRecord('login', $fromData['login']) && $user->login != $fromData['login']) {
			$result['login'] = 'false';
		}

		if (self::getOneRecord('email', $fromData['email']) && $user->email != $fromData['email']) {
			$result['email'] = 'false';
		}

		if (!empty($result)) {
			return $result;
		}

		$result['status'] = self::updateRecord(['id' => $user->id], $fromData);
		return $result;
	}
}

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

	public function getUserLogin($column, $param)
	{
		$db = new Database();
		$connection = $db->connection();

		$query = 'SELECT login FROM ' . $this->getTableName() .  ' WHERE ' . $column . ' = :param';
		try {
			$stmt = $connection->prepare($query);
			$stmt->execute(['param' => $param]);
		} catch (PDOException $exception) {
			throw new PDOException('При выполнении запроса возникла ошибка: ' . $exception->getMessage());
		}
		if ($stmt->rowCount()) {
			$login = $stmt->fetch(PDO::FETCH_ASSOC);

			// закрываем подключение
			$connection = null;
			$stmt = null;

			return $login;
		}
	}
}

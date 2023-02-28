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
   * Авторизация пользователя
   * 
   * @param string $login
   * @param string $password
   * @return array
   */
  public function authorizationUser(string $login, string $password): array
  {

    $user = parent::getOneRecord('login', $login);

    // если пользователь найден по логину, проверяем пароль
    if ($user && $user['password'] == $password) {
      // сохраняем данные в сессию
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['auth'] = true; // пользователь авторизован
      return ['status' => true];
    } else {
      return ['status' => false];
    }

  }

    /**
     * Регистрация пользователя
     *
     * @param string $email
     * @param string $login
     * @param string $password
     * @return array
     * @throws Exception
     */
  public function registrationUser(string $email, string $login, string $password): array
  {
    // результат и ответ для запроса с фронта
    $result = [];

    // что бы понять свободен ли e-mail, ищем пользователей у кого есть такой адрес
    // если пользователь не найден то и e-mail свободен
    $checkEmail = parent::getOneRecord('email', $email);

    if ($checkEmail) {
      return ['email' => true];
    }
    $result['email'] = false;

    $checkLogin = parent::getOneRecord('login', $login);

    if ($checkLogin) {
      return ['login' => true];
    }
    $result['login'] = false;

    // ключи должны соотвествовать именам колонок в таблице
    $result['status'] = parent::addRecord([
      'login' => $login,
      'password' => $password,
      'email' => $email,
      ]);

    return $result;
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
			throw new PDOException('Привыполнении запроса возникла ошибка: ' . $exception->getMessage());
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

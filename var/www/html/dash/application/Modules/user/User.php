<?php

/**
 * Класс пользователя
 *
 * @property $id Id пользователя
 * @property $email Адрес электронной почты пользователя
 * @property $login Логин пользователя
 * @property $lastname Фамилия пользователя
 * @property $firstname Имя пользователя
 * @property $city Город пользователя
 */
class User
{
	/**
	 * Получаем текущего пользователя в конструкторе
	 * @throws Exception
	 */
	public function __construct()
	{
		$this->currentUser();
	}

	/**
	 * Магическим образом получаем имя свойства, возвращаем соответствующий ему метод get
	 * @param string $property
	 * @return void
	 */
	public function __get(string $property)
	{
		$method = "get{$property}";

		if (method_exists($this, $method)) {
			return $this->$method();
		}
	}

	/**
	 * Магическим образом получаем имя свойства, передаем значение $value и возвращаем соответствующий ему метод set
	 * @param string $property
	 * @param mixed $value
	 * @return void
	 */
	public function __set(string $property, mixed $value)
	{
		$method = "set{$property}";

		if (method_exists($this, $method)) {
			$this->$method($value);
		}
	}

	/**
	 * Возвращает id пользователя
	 * @return int
	 */
	private function getId(): int
	{
		return $this->id;
	}

	/**
	 * Возвращает email пользователя
	 * @return string
	 */
	private function getEmail(): string
	{
		return $this->email;
	}

	/**
	 * Возвращает login пользователя
	 * @return string
	 */
	private function getLogin(): string
	{
		return $this->login;
	}

	/**
	 *
	 * @param string $email
	 */
	private function setEmail(string $email): void
	{
		$this->email = $email;
	}

	/**
	 * @param string $login
	 */
	private function setLogin(string $login): void
	{
		$this->login = $login;
	}

	/**
	 * @param int $id
	 */
	private function setId(int $id): void
	{
		$this->id = $id;
	}

	/**
	 * @return string
	 */
	private function getCity(): string
	{
		return $this->city;
	}

	/**
	 * @return string
	 */
	private function getFirstname(): string
	{
		return $this->firstname;
	}

	/**
	 * @return string
	 */
	private function getLastname(): string
	{
		return $this->lastname;
	}

	/**
	 * @param mixed $city
	 */
	private function setCity(?string $city): void
	{
		$this->city = $city;
	}

	/**
	 *
	 * @param mixed $firstname
	 */
	private function setFirstname(?string $firstname): void
	{
		$this->firstname = $firstname;
	}

	/**
	 *
	 * @param mixed $lastname
	 */
	private function setLastname(?string $lastname): void
	{
		$this->lastname = $lastname;
	}

	/**
	 * Текущий пользователь
	 *
	 * @throws Exception
	 */
  private function currentUser(): void
  {
		$this->id = $_SESSION['user_id'];

		$model = new UserModel('users');
		$user = $model->getOneRecord('id', $this->id);

		$this->email = $user['email'];
		$this->login = $user['login'];
		$this->lastname = $user['lastname'];
		$this->firstname = $user['firstname'];
		$this->city = $user['city'];
  }

	/**
	 * @throws Exception
	 */
	public function save(): void
	{
		$model = new UserModel('users');
		$model->updateRecord(['id' => $this->id], [
			'login' => $this->login,
			'email' => $this->email,
			'lastname' => $this->lastname,
			'firstname' => $this->firstname,
			'city' => $this->city,
		]);
	}
}
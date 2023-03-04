<?php

/**
 * Класс подключения к базе данных. Реализовано через паттерн singleton
 */
class ConnectionDB
{

	const DB_USER = 'root';
	const DB_USER_PASSWORD = 'root';
	const DB_NAME = 'dashboard_db';
	const DB_HOST = 'dash_db';

	/**
	 * @var ConnectionDB|null
	 */
	private static ?ConnectionDB $instance = null;

	/**
	 * Подключение к БД
	 * @var
	 */
	public $connection;

	private function __construct()
	{
	}

	/**
	 * Реализация паттерна singleton
	 * @return static
	 */
	public static function getInstance(): self
	{
		if (self::$instance === null) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Подключение к базе данных
	 * @return PDO|void
	 */
	public function connection()
	{
		try {
			$dsn = sprintf("pgsql:host='%s';port=5432;dbname='%s';user='%s';password='%s'",
				self::DB_HOST, self::DB_NAME, self::DB_USER, self::DB_USER_PASSWORD);

			$this->connection = new PDO($dsn, options:[PDO::ATTR_PERSISTENT=>true]);
			return $this->connection;
		} catch (PDOException $e) {
			echo "Ошибка подключения к базе данных: " . $e->getMessage() . PHP_EOL;
			die();
		}
	}
}
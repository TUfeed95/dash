<?php

require_once 'Database.php';

class Migrations
{
  const TABLE_MIGRATION_VERSIONS = 'migration_versions';

  public function createTableMigrationVersions(): \PDOStatement|false
  {
    $connection = Database::connection();
    // проверям существование таблицы
    $checkTableMigrationVersions = Database::checkTable(self::TABLE_MIGRATION_VERSIONS);
    $tableMigrationVersionsExists = $checkTableMigrationVersions->fetch(PDO::FETCH_ASSOC);
    // создаем таблицу, если ее не существует
    if (!$tableMigrationVersionsExists['exists']) {
      echo 'Создаем таблицу "' . self::TABLE_MIGRATION_VERSIONS .'"' . PHP_EOL;
      $query = "CREATE TABLE " . self::TABLE_MIGRATION_VERSIONS . " (version varchar(255) NOT NULL)";

      try{
        $stmt = $connection->prepare($query);
        $stmt->execute();
        return $stmt;
      } catch (PDOException $e) {
        echo 'Ошибка при создании таблицы "' . self::TABLE_MIGRATION_VERSIONS .'": ' . $e->getMessage() . PHP_EOL;
      }

    }
    return $checkTableMigrationVersions;
  }

  /**
   * Получаем миграции
   */
  public function getMigrationFiles($tableMigrationVersions, $migrationFiles): array
  {
    $connection = Database::connection();
    // формируем массив из имен файлов
    $nameMigrationFiles = [];
    foreach ($migrationFiles as $migrationFile) {
      $nameMigrationFiles[] = basename($migrationFile);
    }

    // если таблица пустая, возращаем весе файлы
    if (!$tableMigrationVersions) {
      return $nameMigrationFiles;
    }

    // запрашиваем примененые миграции
    $query = "SELECT version FROM " . self::TABLE_MIGRATION_VERSIONS;
    $stmt = $connection->prepare($query);
    $stmt->execute();
    $tableMigrationVersionsRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // формируем массив из имен
    $migrationVersions = [];
    foreach ($tableMigrationVersionsRows as $row) {
      $migrationVersions[] = $row['version'];
    }

    // возвращаем разницу
    return array_diff($nameMigrationFiles, $migrationVersions);
  }

  /**
   * Выполнение запроса
   */
  public function executeQuery($query): bool
  {
    $connection = Database::connection();
    try{
      $stmt = $connection->prepare($query);
      $stmt->execute();
      //echo "  => Запрос успешно выполнен." . PHP_EOL;
      return true;
    } catch (PDOException $e) {
      echo "  => Во время выполнения запроса произошла ошибка: " . $e->getMessage() . PHP_EOL;
      return false;
    }
  }
}
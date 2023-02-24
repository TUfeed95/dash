# Dash - приложение для отслеживания задач.
## Миграции
### 1. Миграция после разворачивания docker
  В консоли перейти в директорию ``` var/www/html/dash/application/bin ``` и выполнить команду: ``` php migration migrate ```
  В этом случае выполнятся все файлы миграций, которые находятся в директории ``` var/www/html/dash/application/Database/migrations ```

## Экспорт заведений

Приложение, которое выбирает все заведения и экспортирует их в XML, CSV, HTML.

### Установка и настройка

Для локальной настройки (например, БД) можно скопировать файл `.env` в `.env.local` и изменить переменные.

Запуск dev-среды:
```shell script
$ docker-compose up -d
``` 

Установка зависимостей:
```shell script
$ docker-compose exec php bash
root@docker-php:/var/www/html# cd /app
root@docker-php:/app# composer install
```

Все команды, начинающиеся с `root@docker-php`, выполняются в докер-контейнере php. При запуске на машине разработчика на этом месте будет приветствие вида `root@070b69e285a3` с ID контейнера.

Миграция БД:
```shell script
root@docker-php:/app# bin/console doctrine:migrations:migrate
```

### Запуск

Перед первоначальным запуском можно сгенерировать и загрузить фикстуры:
```shell script
root@docker-php:/app# bin/console doctrine:fixtures:load
```

Запуск импорта (например, в xml):
```shell script
root@docker-php:/app# bin/console app:export-places xml var/places.xml
```

### Добавление нового типа экспорта

Основные интерфейсы живут в `\App\Exporter\Places\`, далле все референсы относительно этого неймспейса.

Для добавления нового типа экспорта достаточно создать реализацию `ConcretePlacesExporterInterface`.

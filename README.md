# Документация по развертыванию проекта

## Требования
Перед началом убедитесь, что у вас установлены:
- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)

## Установка и запуск

1. Клонируйте репозиторий проекта:
   ```sh
   git clone https://github.com/dri2015/chat-test-work.git
   cd chat-test-work
   ```

2. Соберите контейнеры:
   ```sh
   docker-compose build
   ```

3. Запустите контейнеры в фоновом режиме:
   ```sh
   docker-compose up -d
   ```

## Остановка и удаление контейнеров

Чтобы остановить запущенные контейнеры, выполните:
```sh
docker-compose down
```

Для полного удаления контейнеров, сетей и томов:
```sh
docker-compose down -v
```

## Дополнительные команды

Проверка запущенных контейнеров:
```sh
docker ps
```

Просмотр логов:
```sh
docker-compose logs -f
```

Перезапуск контейнеров:
```sh
docker-compose restart
```

## Заключение
После успешного запуска, приложение будет доступно по адресу [http://localhost:8080](http://localhost:8080).


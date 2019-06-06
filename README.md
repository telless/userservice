# Small user service

# TODO
* Привести в порядок докер (сделать Dockerfile вокруг php-fpm стандартного, а не тянуть этого монстра)
* Тесты домена
* Больше DTO, меньше массивов
* Psalm
* Консьюмеры иногда падают на старте, т.к. запускаются раньше rmq, разобраться.


Запуск проекта - `make start`
Перезапуск консьюмеров - `make restart-workers`
Логи контейнера - `make s=%cont_name% logs`
Логи приложения (dev.log стандартный) - `make project-logs`
Пересоздание базы - `make db`
Остальные команды - `make help`

# API
Создание пользователя - `/user/register/ - POST (application/x-www-form-urlencoded), login + password`
Список пользователей - `/user/ - GET`
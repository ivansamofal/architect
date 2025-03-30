QUIET := @
ARGS=$(filter-out $@, $(MAKECMDGOALS))

.DEFAULT_GOAL=help
.PHONY=help
app_container=php

init-db: ## Проинициализировать БД
	$(QUIET) chmod 774 ./config/postgrespro/bin/initdb.sh
	$(QUIET) ./config/postgrespro/bin/initdb.sh

cmp-install: ## Установить пакеты
	$(QUIET) docker-compose run --rm --no-deps webapp composer install

cmp-update: ## Обновить пакеты
	$(QUIET) docker-compose run --rm --no-deps webapp composer update ${ARGS}

shell-php: ## Войти в php-контейнер
	docker-compose run --rm --no-deps webapp bash

entity:
	php bin/console make:entity

mi-generate:
	php bin/console doctrine:migrations:generate

migrate:
	php bin/console --no-interaction doctrine:migrations:migrate

diff:
	php bin/console --no-interaction doctrine:migrations:diff

books:
	php bin/console load:books

queue:
	php bin/console messenger:consume async --verbose

mongo:
	docker exec -it mongodb mongosh -u root -p rootpassword --authenticationDatabase admin

node:
	docker exec -it node_container bash
DOCKER_COMPOSE?=docker-compose --file deploy/docker/dev/docker-compose.yml
EXEC_PHP?=$(DOCKER_COMPOSE) exec php-fpm
CONSOLE?=bin/console
DIR=$(shell pwd)

install:
	make build start composer-install db quality

composer-install:
	${EXEC_PHP} composer install

quality:
	make cs-fix-dryrun phpstan

cs-fix:
	${EXEC_PHP} vendor/bin/php-cs-fixer fix --config .php-cs.dist --allow-risky=yes

cs-fix-dryrun:
	${EXEC_PHP} vendor/bin/php-cs-fixer fix --dry-run --config .php-cs.dist --allow-risky=yes

phpstan:
	${EXEC_PHP} vendor/bin/phpstan analyse -c phpstan.neon

cc:
	${EXEC_PHP} ${CONSOLE} c:c -e dev

db:
	${EXEC_PHP} ${CONSOLE} doctrine:database:drop --force --if-exists -e dev
	${EXEC_PHP} ${CONSOLE} doctrine:database:drop --force --if-exists -e test --no-debug
	${EXEC_PHP} ${CONSOLE} doctrine:database:create -e dev
	${EXEC_PHP} ${CONSOLE} doctrine:database:create -e test --no-debug
	${EXEC_PHP} ${CONSOLE} doctrine:migration:migrate --no-interaction -e dev
	${EXEC_PHP} ${CONSOLE} doctrine:migration:migrate --no-interaction -e test --no-debug
	${EXEC_PHP} ${CONSOLE} doctrine:fixtures:load --no-interaction -e dev
	${EXEC_PHP} ${CONSOLE} doctrine:fixtures:load --no-interaction -e test --no-debug

db-diff:
	${EXEC_PHP} ${CONSOLE} doctrine:migration:diff

test:
	rm -rf ./var/cache/test/*
	${EXEC_PHP} vendor/bin/phpunit --testsuite="students-grades-api" --stop-on-failure

test-class:
	rm -rf ./var/cache/test/*
	${EXEC_PHP} vendor/bin/phpunit --testsuite="students-grades-api" --filter=$(class)

test-coverage:
	rm -rf ./var/cache/test/*
	${EXEC_PHP} vendor/bin/phpunit --testsuite="students-grades-api" --stop-on-failure --coverage-text

build:
	${DOCKER_COMPOSE} build --force-rm

start:
	${DOCKER_COMPOSE} up -d --remove-orphan

start-doc:
	docker run --rm -d -p 8081:8080 --name api-doc -e SWAGGER_JSON=/api/statics/openapi_specifications.yaml -v ${DIR}/config/statics:/api/statics swaggerapi/swagger-ui

stop-doc:
	docker stop api-doc

stop:
	${DOCKER_COMPOSE} down

exec:
	docker exec -it php-fpm /bin/sh

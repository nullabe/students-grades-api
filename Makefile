DOCKER_COMPOSE?=docker-compose --file deploy/docker/dev/docker-compose.yml
EXEC_PHP?=$(DOCKER_COMPOSE) exec php-fpm
CONSOLE?=bin/console

quality:
	make cs-fix-dryrun phpstan

cs-fix:
	vendor/bin/php-cs-fixer fix --config .php-cs.dist --allow-risky=yes

cs-fix-dryrun:
	vendor/bin/php-cs-fixer fix --dry-run --config .php-cs.dist --allow-risky=yes

phpstan:
	vendor/bin/phpstan analyse -c phpstan.neon

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

stop:
	${DOCKER_COMPOSE} down

exec:
	docker exec -it php-fpm /bin/sh

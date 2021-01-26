DOCKER_COMPOSE?=docker-compose --file deploy/docker/dev/docker-compose.yml
EXEC_PHP?=$(DOCKER_COMPOSE) exec php-fpm

quality:
	make cs-fix-dryrun phpstan

cs-fix:
	vendor/bin/php-cs-fixer fix --config .php-cs.dist --allow-risky=yes

cs-fix-dryrun:
	vendor/bin/php-cs-fixer fix --dry-run --config .php-cs.dist --allow-risky=yes

phpstan:
	vendor/bin/phpstan analyse -c phpstan.neon

test:
	${EXEC_PHP} vendor/bin/phpunit --testsuite="students-grades-api"

test-coverage:
	${EXEC_PHP} vendor/bin/phpunit --testsuite="students-grades-api" --coverage-text

build:
	${DOCKER_COMPOSE} build --force-rm

start:
	${DOCKER_COMPOSE} up -d --remove-orphan

stop:
	${DOCKER_COMPOSE} down

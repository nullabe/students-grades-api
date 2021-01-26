quality:
	make cs-fix-dryrun phpstan

cs-fix:
	vendor/bin/php-cs-fixer fix --config .php-cs.dist --allow-risky=yes

cs-fix-dryrun:
	vendor/bin/php-cs-fixer fix --dry-run --config .php-cs.dist --allow-risky=yes

phpstan:
	vendor/bin/phpstan analyse -c phpstan.neon

test:
	vendor/bin/phpunit --testsuite="students-grades-api"

test-coverage:
	vendor/bin/phpunit --testsuite="students-grades-api" --coverage-text

build:
	docker-compose --file deploy/docker/dev/docker-compose.yml build --force-rm

start:
	docker-compose --file deploy/docker/dev/docker-compose.yml up -d --remove-orphan

stop:
	docker-compose --file deploy/docker/dev/docker-compose.yml down

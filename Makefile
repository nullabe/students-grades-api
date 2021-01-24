quality:
	make cs-fix-dryrun phpstan

cs-fix:
	vendor/bin/php-cs-fixer fix --config .php-cs.dist --allow-risky=yes

cs-fix-dryrun:
	vendor/bin/php-cs-fixer fix --dry-run --config .php-cs.dist --allow-risky=yes

phpstan:
	vendor/bin/phpstan analyse -c phpstan.neon

test:
	vendor/bin/phpunit .

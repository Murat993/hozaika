build:
	docker-compose -p hoz-project build
up:
	docker-compose -p hoz-project up -d
stop:
	docker-compose -p hoz-project stop
fpm:
	docker-compose -p hoz-project exec fpm bash
logs:
	docker-compose -p hoz-project logs -f --tail=20
ps:
	docker-compose -p hoz-project ps
rector:
	docker-compose -p hoz-project run --rm fpm vendor/bin/rector process app --dry-run
phpstan:
	docker-compose -p hoz-project run --rm fpm vendor/bin/phpstan analyze --memory-limit=2048M --configuration=phpstan.neon
devup:
	docker-compose -f docker-compose-dev.yml -p hoz-project up -d


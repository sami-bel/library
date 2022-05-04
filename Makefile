init:
	cd docker && docker build -t local_php8_apache2:latest .
	docker-compose up -d
	docker exec -it php8_local bash -c 'cd library && composer install && exit'

up:
	docker-compose up -d

stop:
	docker-compose stop

ssh:
	docker exec -it php8_local bash -c 'cd library; bash'


install:
	docker exec -it php8_local bash -c 'cd library && composer install && exit'

test:
	docker exec -it php8_local bash -c 'cd library && vendor/bin/phpunit && exit'

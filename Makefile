init-docker:
	cd docker && docker build -t local_php8_apache2:latest .

up:
	docker-compose up -d

stop:
	docker-compose stop

ssh:
	docker exec -it php8_local bash -c 'cd library; bash'


install:
	docker exec -it php8_local bash -c 'cd library && composer install && exit'

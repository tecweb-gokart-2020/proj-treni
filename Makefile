install:
	@mkdir -p ./db
	@mkdir -p ./logs/db
	@mkdir -p ./logs/php
	@mkdir -p ./logs/web
	@mkdir -p ./cimgs/web
	@mkdir -p ./cimgs/php
	@docker-compose up -d --build

start:
	@docker-compose start

stop:
	@docker-compose stop

remove:
	@docker-compose down

restart: stop start

rebuild: stop purge install

purge: remove
	@rm -rf ./db/*
	@rm -rf ./logs/db/*
	@rm -rf ./logs/php/*
	@rm -rf ./logs/web/*
	@rm -rf ./cimgs/web/*
	@rm -rf ./cimgs/php/*

validate:
	@docker-compose config

bash-db:
	@docker-compose exec db bash

bash-php:
	@docker-compose exec php bash

bash-web:
	@docker-compose exec web bash

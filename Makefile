-include .env

DOCKER_COMPOSE ?= docker-compose
DOCKER_SYNC ?= docker-sync
EXECUTE_APP ?= $(DOCKER_COMPOSE) exec app
EXECUTE_POSTGRES ?= $(DOCKER_COMPOSE) exec postgres
RUN_PHP ?= $(DOCKER_COMPOSE) run --rm --no-deps app

ssh:
		@$(EXECUTE_APP) sh
.PHONY: ssh

up:
	$(DOCKER_COMPOSE) up --remove-orphans -d
.PHONY: up

test-unit:
	$(RUN_PHP) bin/phpunit
.PHONY: test-unit

db-migrate:
	$(RUN_PHP) bin/console doctrine:migration:migrate -n
.PHONY: db-migrate

composer-install:
	$(RUN_PHP) composer install
.PHONY: composer-install

sync-restart: sync-stop sync-start
.PHONY: sync-restart

sync-stop:
	$(DOCKER_SYNC) stop
.PHONY: sync-stop

sync-clean:
	$(DOCKER_SYNC) clean
.PHONY: sync-clean

sync-start:
	$(DOCKER_SYNC) start
.PHONY: sync-start

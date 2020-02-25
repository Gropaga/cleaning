-include .env

DOCKER_COMPOSE ?= docker-compose
DOCKER_SYNC ?= docker-sync
EXECUTE_APP ?= $(DOCKER_COMPOSE) exec app
EXECUTE_POSTGRES ?= $(DOCKER_COMPOSE) exec postgres
RUN_PHP ?= $(DOCKER_COMPOSE) run --rm --no-deps app
RUN_COMPOSER = $(RUN_PHP) composer

ssh:
		@$(EXECUTE_APP) sh
.PHONY: ssh

up:
	$(DOCKER_COMPOSE) up --remove-orphans -d
.PHONY: up

up-rebuild:
	$(DOCKER_COMPOSE) up -d --no-deps --build
.PHONY: up-rebuild

down:
	$(DOCKER_COMPOSE) down --remove-orphans
.PHONY: down

test-unit:
	$(RUN_PHP) bin/phpunit
.PHONY: test-unit

clear-cache:
	$(RUN_PHP) bin/console cache:clear
.PHONY: cache-clear

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

cs-fixer:
	$(RUN_COMPOSER) run-script cs-fixer
.PHONY: cs-fixer

db-migrate:
	$(RUN_PHP) bin/console doctrine:migration:migrate -n
.PHONY: db-migrate

db-prev:
	$(RUN_PHP) bin/console doctrine:migration:migrate prev -n
.PHONY: db-prev

db-next:
	$(RUN_PHP) bin/console doctrine:migration:migrate next -n
.PHONY: db-next

db-diff:
	$(RUN_PHP) bin/console doctrine:migration:diff -n
.PHONY: db-diff

db-gen:
	$(RUN_PHP) bin/console doctrine:migration:generate -n
.PHONY: db-gen

debug-autowiring:
	$(RUN_PHP) bin/console debug:autowiring
.PHONY: debug-autowiring

debug-messenger:
	$(RUN_PHP) bin/console debug:messenger
.PHONY: debug-messenger

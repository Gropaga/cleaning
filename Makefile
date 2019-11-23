-include .env

DOCKER_COMPOSE ?= docker-compose

EXECUTE_APP ?= $(DOCKER_COMPOSE) exec app
EXECUTE_POSTGRES ?= $(DOCKER_COMPOSE) exec postgres
RUN_PHP ?= $(DOCKER_COMPOSE) run --rm --no-deps app

ssh:
		@$(EXECUTE_APP) sh
.PHONY: ssh

up:
	$(DOCKER_COMPOSE) up --remove-orphans -d
.PHONY: up

db-migrate:
	$(RUN_PHP) bin/console doctrine:migration:migrate -n
.PHONY: db-migrate

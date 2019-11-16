-include .env

DOCKER_COMPOSE ?= docker-compose

EXECUTE_APP ?= $(DOCKER_COMPOSE) exec app
EXECUTE_POSTGRES ?= $(DOCKER_COMPOSE) exec postgres

ssh:
		@$(EXECUTE_APP) bash
.PHONY: ssh

up:
	$(DOCKER_COMPOSE) up --remove-orphans -d
.PHONY: up

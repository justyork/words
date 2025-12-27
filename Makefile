.PHONY: help up down restart build logs shell composer install update migrate migrate-create assets clean ps

# Default target
.DEFAULT_GOAL := help

# Colors for output
GREEN  := $(shell tput -Txterm setaf 2)
YELLOW := $(shell tput -Txterm setaf 3)
RESET  := $(shell tput -Txterm sgr0)

help: ## Show this help message
	@echo '${GREEN}Usage:${RESET}'
	@echo '  make ${YELLOW}<target>${RESET}'
	@echo ''
	@echo '${GREEN}Available targets:${RESET}'
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "  ${YELLOW}%-20s${RESET} %s\n", $$1, $$2}' $(MAKEFILE_LIST)

up: ## Start all containers
	docker-compose up -d
	@echo "${GREEN}Containers started!${RESET}"
	@echo "Application: http://127.0.0.1:8000"
	@echo "phpMyAdmin: http://127.0.0.1:8080"

down: ## Stop all containers
	docker-compose down
	@echo "${GREEN}Containers stopped!${RESET}"

restart: ## Restart all containers
	docker-compose restart
	@echo "${GREEN}Containers restarted!${RESET}"

build: ## Build containers
	docker-compose build
	@echo "${GREEN}Containers built!${RESET}"

rebuild: ## Rebuild containers from scratch
	docker-compose down
	docker-compose build --no-cache
	docker-compose up -d
	@echo "${GREEN}Containers rebuilt!${RESET}"

logs: ## Show logs from all containers
	docker-compose logs -f

logs-php: ## Show PHP container logs
	docker-compose logs -f php

logs-mysql: ## Show MySQL container logs
	docker-compose logs -f mysql

ps: ## Show running containers
	docker-compose ps

shell: ## Open shell in PHP container
	docker-compose exec php bash

shell-root: ## Open shell as root in PHP container
	docker-compose exec -u root php bash

mysql: ## Open MySQL CLI
	docker-compose exec mysql mysql -u words_user -p words_db

mysql-root: ## Open MySQL CLI as root
	docker-compose exec mysql mysql -u root -p

composer: ## Run composer command (usage: make composer CMD="install")
	docker-compose exec php composer $(CMD)

install: ## Install composer dependencies
	docker-compose exec -u root php git config --global --add safe.directory /app || true
	docker-compose exec php composer install --ignore-platform-reqs
	@echo "${GREEN}Dependencies installed!${RESET}"

update: ## Update composer dependencies
	docker-compose exec -u root php git config --global --add safe.directory /app || true
	docker-compose exec php composer update --with-all-dependencies --ignore-platform-reqs
	@echo "${GREEN}Dependencies updated!${RESET}"

update-lock: ## Update composer.lock file
	docker-compose exec -u root php git config --global --add safe.directory /app || true
	docker-compose exec php composer update --lock --with-all-dependencies --ignore-platform-reqs
	@echo "${GREEN}Composer lock file updated!${RESET}"

fresh-install: ## Remove vendor and composer.lock, then reinstall
	docker-compose exec -u root php git config --global --add safe.directory /app || true
	docker-compose exec php rm -rf vendor composer.lock
	docker-compose exec php composer install --ignore-platform-reqs
	@echo "${GREEN}Fresh installation complete!${RESET}"

migrate: ## Run database migrations
	docker-compose exec php php yii migrate
	@echo "${GREEN}Migrations applied!${RESET}"

migrate-create: ## Create new migration (usage: make migrate-create NAME="migration_name")
	docker-compose exec php php yii migrate/create $(NAME)

migrate-down: ## Rollback last migration
	docker-compose exec php php yii migrate/down

migrate-history: ## Show migration history
	docker-compose exec php php yii migrate/history

migrate-new: ## Show new migrations
	docker-compose exec php php yii migrate/new

assets: ## Set proper permissions for runtime and assets
	docker-compose exec php chmod -R 777 runtime web/assets
	@echo "${GREEN}Permissions set!${RESET}"

clean: ## Clean runtime and assets directories
	docker-compose exec php rm -rf runtime/cache/* runtime/logs/* web/assets/*
	@echo "${GREEN}Cache and logs cleaned!${RESET}"

yii: ## Run Yii console command (usage: make yii CMD="cache/flush")
	docker-compose exec php php yii $(CMD)

test: ## Run tests
	docker-compose exec php vendor/bin/codecept run

test-unit: ## Run unit tests
	docker-compose exec php vendor/bin/codecept run unit

test-functional: ## Run functional tests
	docker-compose exec php vendor/bin/codecept run functional

init: install assets migrate ## Initialize project (install deps, set permissions, run migrations)
	@echo "${GREEN}Project initialized!${RESET}"

setup: rebuild install assets migrate ## Full setup (rebuild, install, setup)
	@echo "${GREEN}Project setup complete!${RESET}"
	@echo "Application: http://127.0.0.1:8000"
	@echo "phpMyAdmin: http://127.0.0.1:8080"

stop: down ## Alias for down

start: up ## Alias for up


.PHONY: help hello install start stop php mysql node test serve infection

.DEFAULT_GOAL = help

build: ## Build docker image
	docker-compose build
	make up

up: stop ## Run containers
	@printf "\n\n"
			@printf "================\n"
			@printf "  Le site est disponible ici : https://vip-impro.valeur-et-capital.localhost  \n"
			@printf "================\n"
	docker-compose up -d

down: ## Stop all containers
	docker-compose down

php: ## Connect to the PHP container
	docker-compose exec --user www-data php bash

node: ## Connect to the Node container
	docker-compose exec node /bin/bash

serve: ## Launch Hot-reload from yarn
	docker-compose exec node bash -c 'yarn run dev-server'

install: build up installer

init: build up installer-init

installer-init:
	@printf "\n\n"
		@printf "================\n"
		@printf "  INSTALLATION DU PROJET ET INIT DE LA BASE \n"
		@printf "================\n"
	docker-compose exec --user www-data php bash -c 'php installer/install.php init dev https://vip-impro.valeur-et-capital.localhost vip-impro'

installer:
	@printf "\n\n"
		@printf "================\n"
		@printf "  INSTALLATION DU PROJET  \n"
		@printf "================\n"
	docker-compose exec --user www-data php bash -c 'php installer/install.php install dev https://vip-impro.valeur-et-capital.localhost vip-impro'


hello: ## Print the welcome message
	@printf "\n\n"
	@printf "================\n"
	@printf "  APP IS READY  \n"
	@printf "================\n"
	@printf "\n"
	@printf "1. Start hot reload using 'make serve'"
	@printf "\n"
	@printf "2. Go to : https://vip-impro.valeur-et-capital.localhost"
	@printf "\n\n"
	@echo "Enjoy!"
	@printf "\n\n"

help:
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-20s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

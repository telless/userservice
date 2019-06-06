.PHONY: start
start: install erase up db ## clean current environment, recreate dependencies and spin up again

.PHONY: install
install: ## composer install
		composer install

.PHONY: restart-workers
restart-workers: ## restart rabbitmq consumers
		docker-compose restart register_worker successful_register_worker failed_register_worker

.PHONY: stop
stop: ## stop environment
		docker-compose stop

.PHONY: rebuild
rebuild: ## start with --build
		docker-compose up --build -d

.PHONY: erase
erase: ## stop and delete containers, clean volumes.
		docker-compose stop
		docker-compose rm -v -f

.PHONY: up
up: ## spin up environment
		docker-compose up -d

.PHONY: db
db: ## recreate database
		docker-compose exec php sh -lc './bin/console d:d:d --force'
		docker-compose exec php sh -lc './bin/console d:d:c'
		docker-compose exec php sh -lc './bin/console d:m:m -n'

.PHONY: schema-validate
schema-validate: ## validate database schema
		docker-compose exec php sh -lc './bin/console d:s:v'

.PHONY: sh
sh: ## gets inside a container, use 's' variable to select a service. make s=php sh
		docker-compose exec $(s) /bin/bash -it

.PHONY: logs
logs: ## look for 's' service logs, make s=php logs
		docker-compose logs -f $(s)

.PHONY: project-logs
project-logs: ## look for 's' service logs, make s=php logs
		docker-compose exec php tail /app/var/log/dev.log

.PHONY: help
help: ## Display this help message
	@cat $(MAKEFILE_LIST) | grep -e "^[a-zA-Z_\-]*: *.*## *" | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

PWD := $(shell pwd)
UNAME := $(shell uname)
PROJECT_NAME := symfony-template
BACKEND_CONTAINER := backend
DOCKER_COMPOSE=docker-compose -p ${PROJECT_NAME} -f ${PWD}/ops/docker/docker-compose.yml -f ${PWD}/ops/docker/docker-compose.dev.yml
GREEN=\033[0;32m
RESET=\033[0m

.EXPORT_ALL_VARIABLES:

.PHONY: debug
debug:
	@echo "UNAME: $(UNAME)"
	@echo "PWD: $(PWD)"

.PHONY: help
help:
ifeq ($(UNAME), Linux)
	@grep -P '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | \
		awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-20s\033[0m %s\n", $$1, $$2}'
else
	@# this is not tested, but prepared in advance for you, Mac drivers
	@awk -F ':.*###' '$$0 ~ FS {printf "%15s%s\n", $$1 ":", $$2}' \
		$(MAKEFILE_LIST) | grep -v '@awk' | sort
endif


restart: stop start

start: docker-build docker-up logs

stop:
	@${DOCKER_COMPOSE} down --remove-orphans

docker-build:
	@${DOCKER_COMPOSE} build #--no-cache

docker-up:
	@${DOCKER_COMPOSE} up -d

logs:
	@${DOCKER_COMPOSE} logs -f

#COMPOSER

composer-require:
	@${DOCKER_COMPOSE} exec ${BACKEND_CONTAINER} composer require ${PACKAGE}

composer-remove:
	@${DOCKER_COMPOSE} exec ${BACKEND_CONTAINER} composer remove ${PACKAGE}

#MIGRATION

create-migrations:
	@${DOCKER_COMPOSE} exec ${BACKEND_CONTAINER} php bin/console doctrine:migrations:diff

execute-migrations:
	@${DOCKER_COMPOSE} exec ${BACKEND_CONTAINER} php bin/console doctrine:migrations:migrate

#TEST

tests-unit:
	@${DOCKER_COMPOSE} exec ${BACKEND_CONTAINER} php vendor/bin/phpunit --testsuite=unit

tests-functional:
	@${DOCKER_COMPOSE} exec ${BACKEND_CONTAINER} php vendor/bin/phpunit --testsuite=functional

#CODESTYLE

fix-codestyle-dry:
	@${DOCKER_COMPOSE} exec ${BACKEND_CONTAINER} php vendor/bin/php-cs-fixer fix --dry-run --diff

fix-codestyle:
	@${DOCKER_COMPOSE} exec ${BACKEND_CONTAINER} php vendor/bin/php-cs-fixer fix
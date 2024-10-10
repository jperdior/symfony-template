export PROJECT_NAME := symfony-template
export CURRENT_PATH := $(shell pwd)
export BACKEND_CONTAINER := backend

DOCKER_COMPOSE=docker-compose -p ${PROJECT_NAME} -f ${CURRENT_PATH}/ops/docker/docker-compose.yml -f ${CURRENT_PATH}/ops/docker/docker-compose.dev.yml

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

composer-require-backend:
	@${DOCKER_COMPOSE} exec ${BACKEND_CONTAINER} composer require ${PACKAGE}

composer-remove-backend:
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
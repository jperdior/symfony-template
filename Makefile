export PROJECT_NAME := sequra
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

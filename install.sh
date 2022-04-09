#!/bin/bash

docker run -it --rm --name composer -w "/app" -v "$PWD:/app" composer install --no-interaction --ignore-platform-reqs

cp .env.example .env
docker-compose build

docker-compose up -d

docker-compose run --rm --name phppost \
  web ./yii migrate --interactive=0
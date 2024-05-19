#!/bin/bash

echo "Launching containers..."
docker-compose up -d
docker-compose logs -f &


echo "Installing Composer Dependencies..."
docker exec -it $(docker ps -qf "name=app") sh -c "composer install"
echo "Performing DB Migrations..."
docker exec -it $(docker ps -qf "name=app") sh -c "php bin/console doctrine:migrations:migrate --no-interaction"
echo "Loading Data Fixtures..."
docker exec -it $(docker ps -qf "name=app") sh -c "php bin/console app:fill-product-data --no-interaction"

echo -e "\033[0;32mThe project went up successfully!\033[0m"
# BailFacile
Here is my participation to the technical test

## Getting Started

### Installation local


1. Clone the repository
   ```sh
   git clone git@github.com:Tlecomte13/bailfacile.git
   ```
2. Go to project bailfacile
   ```sh
   cd bailfacile
   ```
3. Installation with docker-compose
   ```sh
   docker-compose up -d
   ```
4. Create file .env.local in folder app
   ```sh
   cd app
   touch .env.local
   ```
5. copy this line
   ```mysql
   DATABASE_URL="mysql://root:root@mysql:3306/bailfacile?serverVersion=8&charset=utf8mb4"
   ```

6. go in container php
   ```sh
   docker-compose exec php /bin/bash
   ```

7. install dependencies
   ```sh
   composer i
   ```

8. install migration
   ```sh
   php bin/console doctrine:migration:migrate
   ```

9. install fixtures
   ```sh
   php bin/console doctrine:fixtures:load
   ```


## URL

1. Swagger
   ```sh
   http://localhost:8080/api
   ```
   
## TEST

1. setup
   ```sh
    php bin/console doctrine:database:create --env=test
    php bin/console doctrine:migration:migrate --env=test
    php bin/console doctrine:fixtures:load --env=test
   ```

2. launch
   ```sh
   php bin/phpunit
   ```

## PACKAGE

   ```sh
    Api platform
    php unit
   ```

<p align="right"><a href="#top">Back to top</a></p>
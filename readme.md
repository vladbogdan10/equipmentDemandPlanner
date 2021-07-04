# How to run

Requirements:
* Docker

Run `docker-compose up -d` to start docker containers.

Run `docker exec equipmentDemandPlanner_fpm composer install` to install dependencies.

Run `docker exec -it equipmentDemandPlanner_fpm bin/console doctrine:database:create` to created the DB (by default should already be created, otherwise just run this command).

Run `docker exec -it equipmentDemandPlanner_fpm bin/console doctrine:migrations:migrate` to create the DB schema (when prompt input "yes").

Run `docker exec -it equipmentDemandPlanner_fpm bin/console doctrine:fixtures:load` to seed the DB with data (when prompt input "yes").

The app should be up and running at this point. Check the following routes.

Routes:
* dashboard view: http://localost:8000/dashboard/{station}  
e.g.  http://localost:8000/dashboard/munich
* api: http://localost:8000/api/{station}  
e.g. http://localost:8000/api/munich

The routes also take an optional query parameter `month` e.g.
* dashboard view: http://localost:8000/dashboard/{station}?month=july
* api: http://localost:8000/api/{station}?month=july

If no month is provided the current calendar month will apply.

Assumption: each month starts with a default stock of 10 equipment pieces per station.


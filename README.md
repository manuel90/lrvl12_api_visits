API Story Visits - Backend Laravel 12 with MySQL 5.7
====================


# User Story

The topic is about visits specically schedule visits. An example is a group of people who visits a museum. 
In order to keep a record of the visitors the museum would use this API to create a system of its visits.
For this API example the visits will have these attributes:
- start date
- end date
- description
- status

Each visit can have a list of visitors. Each visitor will have these attributes:
- name
- email
- phone

This API was designed to support a visitor can belong to many visits.

Considerations:
 - A visitor can belong a many visits including if the visits are at the same time.


# Installation using Docker
It's required: 

* [Docker +20](https://www.docker.com/)
* [Docker compose +2.5.1](https://docs.docker.com/compose/install/other/)
* PHP 8.2


Steps:

1. Ensure ports 8002, 8003 and 3030 are not running other services.
1. `cd {your project folder}`
1. `sudo docker-compose build --no-cache`
1. `sudo docker-compose up`

1. Finally, go to [localhost:8002](http://localhost:8002)
1. Open adminer: [localhost:8003](http://localhost:8003/?server=story_visits_dbmysql) (Credentials: User: <b>dev</b> Password: <b>dev</b> Database: <b>story_visits_laravel</b> Server: <b>story_visits_dbmysql</b>)

### DB Migrations
Use this command to run the migrations:

`php artisan migrate`


### Running Tests
Use this command to run the tests:

`php artisan test`
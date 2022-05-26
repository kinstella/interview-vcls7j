# Reporting system exercise

## System design

This is a small PHP application running on a very simple microframework and connected to MariaDB/MySQL. We chose to
create this microframework, rather than use one from the community, for these related reasons:

* There are no unnecessary features or layers of abstraction (although if you want to debate this in the next phase, you
  are welcome to!)
* The framework code is concise and in front of the reader; it should be easy for you to discover and debug the
  framework code
* No one will be at an advantage or disadvantage based on the libraries they know or don't know already

The controllers render [Twig](https://twig.symfony.com/) templates found in the `templates/` directory.

There is a "utility" class: `NullableMemberLookup`, and its interface `Gettable`, wrap an array and provide
key-exists verification, so we don't have to worry about checking every time we access an array.

## How to run

You are welcome to run the application on whatever platform you prefer. We have included a Docker-based setup for your
convenience.

### Docker setup

The database image comes with the structure and seed data preloaded.

> :warning: **WARNING:** If you remove the database container, any changes you've made to the database will be lost.

1. Use Composer to install dependencies, e.g.:

    ```shell
    docker run --rm -v $PWD:/app -v $HOME/.composer:/tmp composer:latest composer install --no-interaction --prefer-dist
    ```

2. Run the command `docker compose up` to launch the two containers that serve the application - one for the PHP web
   server, and one for the database server. By default, the web server port will be published to your host OS on port `8080`

#### Using a MySQL client

The database is accessible on port `13306`: you can do `mysql -h 127.0.0.1 -P 13306 -u root` or `docker compose exec
mysql mysql -u root` to connect to the database running in the container.

### Custom setup

1. Use [Composer](https://getcomposer.org/) to load the project's dependencies
2. Point your web server running PHP 8 at the `public/` directory. (e.g. `php -S 0.0.0.0:8080 -t public/`)
   All requests for web pages (e.g. `http://localhost:8080/reports/payments`) should be handled by `public/index.php`
3. Update the MySQL configuration in `dbConnection.php` as appropriate for your setup
4. Load the database structure from `cpp_interview.schema.sql`
5. Load the seed data by running `scripts/seed.php`

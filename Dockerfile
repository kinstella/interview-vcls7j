FROM php:8.1-cli-bullseye

RUN apt-get update && apt-get upgrade -y && apt-get install -y libicu-dev libonig-dev
RUN docker-php-ext-install mbstring intl mysqli pdo_mysql

WORKDIR /app
STOPSIGNAL SIGINT
CMD ["php", "-S", "0.0.0.0:80", "-t", "/app/public"]

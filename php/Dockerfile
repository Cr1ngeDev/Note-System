FROM php:8.1-fpm

RUN apt-get update && apt-get install -y git \
    && docker-php-ext-install pdo pdo_mysql

WORKDIR /var/www/project

COPY ././ /var/www/project

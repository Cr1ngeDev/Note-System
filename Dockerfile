FROM php:8.1-fpm as php_stage

RUN apt-get update
RUN docker-php-ext-install pdo pdo_mysql

WORKDIR /var/www/nginx/notes
COPY ./docker/conf.d/default.conf /etc/nginx/conf.d/default.conf
COPY . /var/www/nginx/notes

RUN chmod -R 755 /var/www/nginx/notes

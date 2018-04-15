FROM php:7.2-fpm

RUN apt-get update && apt-get install -y libmcrypt-dev mysql-client && docker-php-ext-install pdo_mysql

WORKDIR /var/www/sleepcoffe

RUN curl -sS https://getcomposer.org/installer | \
    php -- --install-dir=/usr/bin/ --filename=composer

COPY ./01-http-server.conf /etc/supervisor/conf.d/

FROM php:latest

WORKDIR /var/www/sleepcoffe

RUN apt-get update && apt-get install -y libmcrypt-dev mysql-client && docker-php-ext-install pdo_mysql

RUN chown -R www-data:www-data /var/www/sleepcoffe

RUN curl -sS https://getcomposer.org/installer | \
    php -- --install-dir=/usr/bin/ --filename=composer

CMD ["php", "-S", "0.0.0.0:8000", "-t", "public/"]

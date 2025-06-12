FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    sqlite3 libsqlite3-dev \
    zip unzip git curl

RUN docker-php-ext-install pdo pdo_sqlite

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

EXPOSE 80
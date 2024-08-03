FROM php:8.2-fpm

RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN docker-php-ext-install opcache

RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libzip-dev

RUN docker-php-ext-install zip

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini;

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

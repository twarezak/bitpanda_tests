FROM php:7.4-fpm

RUN apt-get update

RUN apt-get install -y zlib1g-dev libpq-dev git libicu-dev libxml2-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl

RUN docker-php-ext-install pdo pdo_mysql

COPY development.ini /usr/local/etc/php/conf.d/zz-php.ini

RUN curl --insecure https://getcomposer.org/composer.phar -o /usr/bin/composer && chmod +x /usr/bin/composer

RUN pecl install xdebug && docker-php-ext-enable xdebug

# Set timezone
RUN rm /etc/localtime
RUN ln -s /usr/share/zoneinfo/Europe/Warsaw /etc/localtime
RUN "date"

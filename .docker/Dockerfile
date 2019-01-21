FROM php:7.1-apache

LABEL MAINTAINER 'Marcel Oliveira / @mrabello23'

RUN mkdir /app && mkdir /app/log && chown -R www-data:www-data /app && a2enmod rewrite
RUN pecl install xdebug-2.6.0 \ && docker-php-ext-enable xdebug
RUN docker-php-ext-install pdo
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install mysqli
RUN docker-php-ext-install bcmath

COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf
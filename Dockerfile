FROM php:8.0-apache

RUN apt-get update && apt-get upgrade -y
RUN apt-get install -y git unzip

RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

RUN a2enmod rewrite
#ADD . /var/www/html

RUN curl -sS https://getcomposer.org/installer -o composer-setup.php
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer

VOLUME /var/www/html
EXPOSE 80

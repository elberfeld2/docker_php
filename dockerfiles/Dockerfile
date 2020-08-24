FROM php:7.0-apache

RUN a2enmod rewrite

RUN apt-get update \
    && docker-php-ext-install mysqli \
    && docker-php-ext-configure mysqli
    

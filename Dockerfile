FROM php:7.4-apache

WORKDIR /var/www/html

RUN apt-get clean && rm -rf /var/lib/apt/lists/* 
RUN apt-get update
RUN apt-get install -y \
    git \
    curl \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

RUN docker-php-ext-install mysqli pdo pdo_mysql mbstring exif pcntl bcmath gd zip
RUN docker-php-ext-enable sodium
RUN a2enmod rewrite
RUN rm /etc/apt/preferences.d/no-debian-php

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
COPY ./app /var/www/html/

WORKDIR /var/www/html/admin/server
RUN composer install

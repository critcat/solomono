FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
    libpq-dev \
    zlib1g-dev \
    libmcrypt-dev \
    libzip-dev \
    git

RUN docker-php-ext-install pdo pdo_mysql zip

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --filename=composer
RUN php -r "unlink('composer-setup.php');"
RUN mv composer /usr/local/bin/composer

WORKDIR /symfony

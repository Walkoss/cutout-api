FROM php:7-fpm

ENV TERM="xterm"                        \
    DEBIAN_FRONTEND="noninteractive"    \
    COMPOSER_ALLOW_SUPERUSER=1          \
    SYMFONY_ALLOW_APPDEV=1

RUN apt-get update && apt-get install -y \
    git \
    nano    \
    zip

## https://github.com/maxpou/docker-symfony/blob/master/php7-fpm/Dockerfile
# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

# Set timezone
RUN rm /etc/localtime
RUN ln -s /usr/share/zoneinfo/Europe/Paris /etc/localtime
RUN "date"

# PHP Extensions
RUN docker-php-ext-install  \
    pdo \
    pdo_mysql

WORKDIR /app
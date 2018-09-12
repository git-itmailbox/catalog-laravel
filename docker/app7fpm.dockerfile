FROM php:7-fpm

RUN apt-get update && apt-get install -y libmcrypt-dev \
    mysql-client libmagickwand-dev --no-install-recommends \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && docker-php-ext-install zip \
    && docker-php-ext-install pdo_mysql

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# COPY xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini


RUN groupadd -g 1000 app \
 && useradd -g 1000 -u 1000 -d /var/www -s /bin/bash app


#RUN apt-get install -y git cron

# Add crontab file in the cron directory
# ADD crontab /etc/cron.d/hello-cron


# Give execution rights on the cron job
# RUN chmod 0644 /etc/cron.d/hello-cron

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer global require "laravel/installer"

USER app:app


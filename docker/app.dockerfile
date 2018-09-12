FROM php:7.0.8-fpm

RUN apt-get update && apt-get install -y libmcrypt-dev \
    mysql-client libmagickwand-dev --no-install-recommends \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && docker-php-ext-install mcrypt pdo_mysql

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

#COPY xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

#RUN apt-get install -y git cron

# Add crontab file in the cron directory
#ADD crontab /etc/cron.d/hello-cron


# Give execution rights on the cron job
#RUN chmod 0644 /etc/cron.d/hello-cron

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer global require "laravel/installer"

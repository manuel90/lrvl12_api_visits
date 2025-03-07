ARG PHP_VERSION
FROM php:${PHP_VERSION}-apache

# GD extension
RUN apt-get update
RUN apt-get install -y libpng-dev libjpeg-dev apt-utils libfreetype6-dev libmcrypt-dev libjpeg-dev apt-utils
	
RUN rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure gd
RUN docker-php-ext-install gd


RUN apt-get update && apt-get install -y \
    libmagickwand-dev --no-install-recommends \
    && pecl install imagick \
	&& docker-php-ext-enable imagick


RUN apt-get update -y 

COPY 000-default.conf /etc/apache2/sites-available/
RUN sed -ri -e 's!AllowOverride None!AllowOverride All!g' /etc/apache2/apache2.conf

RUN docker-php-ext-install opcache
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN apt-get install -y libzip-dev zip
RUN docker-php-ext-install zip
	
# SOAP extension	
RUN apt-get update -y 
RUN apt-get install -y libxml2-dev
RUN apt-get clean -y
	
RUN docker-php-ext-install soap
 
# MCRYPT extension
RUN pecl install mcrypt
RUN docker-php-ext-enable mcrypt

	
# Enable Apache re-write mode
RUN cp /etc/apache2/mods-available/rewrite.load /etc/apache2/mods-enabled/
RUN cp /etc/apache2/mods-available/headers.load /etc/apache2/mods-enabled/

COPY custom.ini /etc/php/${PHP_VERSION}/apache2/
RUN mv /etc/php/${PHP_VERSION}/apache2/custom.ini /etc/php/${PHP_VERSION}/apache2/php.ini
RUN cp /etc/php/${PHP_VERSION}/apache2/php.ini /usr/local/etc/php/php.ini


ENV APACHE_RUN_USER  www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_LOG_DIR   /var/log/apache2
ENV APACHE_PID_FILE  /var/run/apache2/apache2.pid
ENV APACHE_RUN_DIR   /var/run/apache2
ENV APACHE_LOCK_DIR  /var/lock/apache2
ENV APACHE_LOG_DIR   /var/log/apache2

RUN mkdir -p $APACHE_RUN_DIR
RUN mkdir -p $APACHE_LOCK_DIR
RUN mkdir -p $APACHE_LOG_DIR

# # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# Composer Installation
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# Laravel Installer
RUN composer global require laravel/installer

ENV PATH="${PATH}:/root/.composer/vendor/bin"

# Set default work directory  
WORKDIR /var/www/html
#COPY --chown=www-data:www-data . .


EXPOSE 80

# # # # # # # # # # # # # # # # # # # # # # #


CMD /bin/bash -i /var/www/html/entrypoint.sh

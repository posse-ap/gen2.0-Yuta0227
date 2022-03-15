# FROM php:7.2-apache
FROM php:7.4.0-fpm

RUN apt-get update
RUN apt-get install -y vim
RUN docker-php-ext-install pdo_mysql
# RUN apt-get install --enablerepo=remi php-mysqlnd
ADD ./php.ini /usr/local/etc/php/php.ini
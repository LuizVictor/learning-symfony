FROM php:8.2-apache

# Update system
RUN apt-get update && apt-get install unzip

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

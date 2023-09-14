FROM php:7.4-fpm

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Update packages and install dependencies
RUN apt-get update \
    && apt-get install -y git zip zlib1g-dev libzip-dev zip \
    && docker-php-ext-install zip pdo pdo_mysql

# Install Xdebug
RUN pecl install xdebug-2.9.8 \
    && docker-php-ext-enable xdebug

# Add Xdebug config (you can modify this part according to your needs)
RUN echo "xdebug.mode=develop,coverage" >> /usr/local/etc/php/php.ini
RUN echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/php.ini
RUN echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/php.ini
RUN echo "xdebug.client_port=9003" >> /usr/local/etc/php/php.ini

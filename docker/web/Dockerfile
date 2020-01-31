FROM php:7.4.2-fpm

RUN apt-get update && \
            apt-get install -y libmcrypt-dev zlib1g-dev libzip-dev && \
            apt-get -y autoremove && \
            apt-get clean && \
            rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* \
    && docker-php-ext-install zip pdo_mysql pcntl \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \

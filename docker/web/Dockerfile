FROM php:7.3.14-apache

RUN docker-php-ext-configure pdo_mysql \
    && apt-get update && \
            apt-get install -y zlib1g-dev libzip-dev && \
            apt-get -y autoremove && \
            apt-get clean && \
            rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* \
    && docker-php-ext-install zip \
    && a2enmod rewrite \
    && a2enmod headers \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \

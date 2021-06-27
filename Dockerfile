FROM php:7.4-fpm-alpine

RUN apk update && apk add --no-cache \
    bash \
    icu-dev \
    libzip-dev \
    shadow \
    nano \
    zlib-dev \
    npm

RUN docker-php-ext-install \
    bcmath \
    gd \
    intl \
    zip

RUN curl -sS https://getcomposer.org/installer | \
    php -- --install-dir=/usr/bin --filename=composer

RUN usermod -u 1000 www-data && \
    groupmod -g 1000 www-data

RUN chown -R www-data:www-data /var/www
USER www-data

WORKDIR /var/www
COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN composer install

RUN npm install && \
    npm run-script build

EXPOSE 9000
CMD ["php-fpm"]

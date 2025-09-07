FROM php:8.3-fpm-alpine

RUN set -eux; \
    apk add --no-cache icu-dev git unzip; \
    docker-php-ext-install intl pdo pdo_mysql;

COPY docker/app/secure.ini /usr/local/etc/php/conf.d/secure.ini
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY docker/app/wait_for_it.sh /usr/local/bin/wait_for_it.sh
RUN chmod +x /usr/local/bin/wait_for_it.sh
COPY docker/app/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["entrypoint.sh"]
CMD ["php-fpm"]

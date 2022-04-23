FROM php:8-fpm-alpine

ARG UID
ARG GID

ENV UID=${UID}
ENV GID=${GID}

RUN mkdir -p /var/www/html

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

RUN delgroup dialout

RUN addgroup -g ${GID} --system laravel
RUN adduser -G laravel --system -D -s /bin/sh -u ${UID} laravel

RUN sed -i "s/user = www-data/user = laravel/g" /usr/local/etc/php-fpm.d/www.conf
RUN sed -i "s/group = www-data/group = laravel/g" /usr/local/etc/php-fpm.d/www.conf
RUN echo "php_admin_flag[log_errors] = on" >> /usr/local/etc/php-fpm.d/www.conf

RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

COPY ./entrypoint.sh /entrypoint.sh

RUN chown -R www-data:www-data /var/www/html
RUN chmod 777 /var/www/html/storage
RUN chmod +x /entrypoint.sh

CMD ["php-fpm", "-y", "/usr/local/etc/php-fpm.conf", "-R"]

ENTRYPOINT ["/entrypoint.sh"]
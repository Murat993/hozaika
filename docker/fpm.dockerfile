FROM php:8.2-fpm as base
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/install-php-extensions
RUN install-php-extensions pdo_mysql && docker-php-ext-enable pdo_mysql
RUN install-php-extensions sockets && docker-php-ext-enable sockets
RUN install-php-extensions gd && docker-php-ext-enable gd
RUN install-php-extensions timezonedb && docker-php-ext-enable timezonedb
RUN install-php-extensions redis && docker-php-ext-enable redis
RUN apt-get update && apt-get install -y git unzip && \
    php -r "copy('https://getcomposer.org/installer', '/tmp/composer-setup.php');" && \
    php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer && \
    apt-get clean
COPY ./docker/php.ini.append /usr/local/etc/php/php.ini

FROM base as vendors
WORKDIR /app
COPY /composer.json /composer.lock ./
COPY /database ./database
COPY /tests ./tests
RUN composer install --optimize-autoloader --no-scripts --no-dev

FROM base as prod
WORKDIR /var/www/html
COPY --from=vendors /app/vendor vendor
COPY / .
RUN chmod -R 777 storage/
RUN chmod -R 777 public/files
RUN pecl upgrade timezonedb

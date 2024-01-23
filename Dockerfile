#getting base image php
FROM php:8.0

RUN apt-get update -y
RUN apt-get install -y unzip libzip-dev
RUN apt-get install -y default-mysql-client
RUN docker-php-ext-install pdo_mysql zip

COPY . ./app/

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR ./app/

RUN composer install
RUN php artisan key:generate
RUN php artisan storage:link
RUN composer dump-autoload
CMD php artisan migrate:refresh --seed

CMD php artisan serve --host=0.0.0.0 --port=8000

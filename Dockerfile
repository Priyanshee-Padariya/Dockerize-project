#getting base image php
FROM php:8.0

RUN apt-get update -y
RUN apt-get install -y unzip

COPY . ./app/

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR ./app/

RUN composer install

CMD php artisan serve --host=0.0.0.0 --port=8000

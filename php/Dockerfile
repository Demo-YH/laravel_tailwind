ARG SPRYKER_PHP_VERSION=8.4

FROM php:${SPRYKER_PHP_VERSION}-fpm-bullseye

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN apt-get update && apt-get install -y vim
RUN apt update && apt install -y zip
RUN apt update && apt install -y unzip
RUN apt update && apt install -y libicu-dev git


RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl
RUN docker-php-ext-install pdo_mysql

RUN curl -fsSL https://bun.sh/install | bash

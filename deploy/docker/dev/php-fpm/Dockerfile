FROM php:8-fpm

RUN apt-get update && apt-get install -y libzip-dev

RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install zip && docker-php-ext-enable zip
RUN pecl install pcov && docker-php-ext-enable pcov

RUN curl -sS https://getcomposer.org/installer | tee composer-setup.php \
    && php composer-setup.php && rm composer-setup.php* \
    && chmod +x composer.phar && mv composer.phar /usr/bin/composer

WORKDIR /var/www/app

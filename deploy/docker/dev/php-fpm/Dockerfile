FROM php:8-fpm

RUN pecl install pcov

RUN curl -sS https://getcomposer.org/installer | tee composer-setup.php \
    && php composer-setup.php && rm composer-setup.php* \
    && chmod +x composer.phar && mv composer.phar /usr/bin/composer

COPY pcov.ini  /etc/php/conf.d/

WORKDIR /var/www/app


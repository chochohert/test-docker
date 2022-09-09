FROM php:8-fpm

RUN apt update \
 && apt install -y  mariadb-client openssl zip unzip iputils-ping \
 && docker-php-ext-install mysqli  pdo_mysql

WORKDIR /code

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \

COPY composer.json composer.lock ./
CMD bash -c "composer install && composer dump-autoload"

RUN   pecl install xdebug  \
  &&   docker-php-ext-enable xdebug \
  &&   echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
  &&   echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
  &&   echo "display_startup_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
  &&   echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
  &&  echo "xdebug.mode=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \


COPY . .

COPY ./docker/run.sh /tmp
RUN  chmod -R 777 /tmp/run.sh

EXPOSE 9000




FROM php:7-apache-buster

RUN adduser --uid 1337 --disabled-password --gecos HD hd

ENV APACHE_RUN_USER=hd \
    DB_HOST=hd-db DB_PORT=5432 DB_DATABASE=hd DB_USERNAME=hd DB_PASSWORD=hd DB_CONNECTIOn=pgsql \
    DOOR_DB_HOST=hd-db DOOR_DB_PORT=5432 DOOR_DB_DATABASE=hd DOOR_DB_USERNAME=hd DOOR_DB_PASSWORD=hd \
	  MAIL_HOST=mail MAIL_PORT=1025 MAIL_FROM=hd@localhost MAIL_DRIVER=smtp \
	  CACHE_DRIVER=memcached SESSION_DRIVER=memcached MEMCACHED_HOST=hd-memcached REDIS_HOST=hd-redis \
    BROADCAST_DRIVER=redis QUEUE_DRIVER=database ENVIRONMENT=production \
    DOCKERIZE_VERSION=v0.6.1

# upgrade system and install essential tools
RUN apt-get update && apt-get upgrade -y && apt-get install -y --no-install-recommends \
    vim less netcat dnsutils postgresql-client wget git msmtp iec16022 libxml2-dev libcurl3-dev libpng-dev libc-client-dev libkrb5-dev libicu-dev \
    libmagickwand-dev libmemcached-dev supervisor openssl libonig-dev

# dockerize help utility
RUN wget https://github.com/jwilder/dockerize/releases/download/$DOCKERIZE_VERSION/dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz \
    && tar -C /usr/local/bin -xzvf dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz \
    && rm dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz

# msmtp mail delivery
RUN echo "sendmail_path = $(which msmtp) -ti" > /usr/local/etc/php/conf.d/mail.ini

# php extensions
RUN apt-get install -y --no-install-recommends libonig-dev iec16022 libxml2-dev libcurl3-dev libpng-dev libc-client-dev libkrb5-dev libicu-dev libpq-dev && \
    PHP_OPENSSL=yes docker-php-ext-configure imap --with-kerberos --with-imap-ssl && \
    docker-php-ext-install gd xml mbstring intl pgsql pdo pdo_pgsql soap curl opcache && docker-php-ext-enable pdo_pgsql

# update PECL
RUN pecl channel-update pecl.php.net

# install xdebug from PECL
RUN pecl install xdebug && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini # LOCAL

# install imagick extension from PECL and enable in docker-php
RUN pecl install imagick && docker-php-ext-enable imagick

# APCu
RUN pecl install apcu && echo extension=apcu.so > /usr/local/etc/php/conf.d/apcu.ini

# clean up apt-get
RUN rm -rf /var/lib/apt/lists/*

# enable apache rewrite module
RUN a2enmod rewrite

# configure default port to 8080
RUN sed -i -e 's/<VirtualHost \*:80>/<VirtualHost \*:8080>/' /etc/apache2/sites-available/000-default.conf
RUN sed -i -e 's/Listen 80/Listen 8080/' /etc/apache2/ports.conf

# logging
RUN mkdir -p /var/log/php

WORKDIR /var/www/html/

RUN a2enmod expires headers
RUN apachectl configtest

RUN pecl install memcached \
    && docker-php-ext-enable memcached

COPY docker-entrypoint /usr/local/bin/
RUN sed -i -e 's/\r$//' /usr/local/bin/docker-entrypoint && chmod +x /usr/local/bin/docker-entrypoint
ENTRYPOINT [ "docker-entrypoint" ]
RUN service supervisor start
CMD [ "apache2-foreground" ]

COPY php.ini /usr/local/etc/php/
COPY laravel-worker.conf /etc/supervisor/conf.d/laravel-worker.conf

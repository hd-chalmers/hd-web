FROM registry.pentacore.se/hd/images/web:latest

ENV APACHE_RUN_USER=hd \
    DB_HOST=hd-db DB_PORT=5432 DB_DATABASE=hd DB_USERNAME=hd DB_PASSWORD=hd DB_CONNECTIOn=pgsql \
    DOOR_DB_HOST=hd-door-db DOOR_DB_PORT=5432 DOOR_DB_DATABASE=hd DOOR_DB_USERNAME=hd DOOR_DB_PASSWORD=hd \
    PRICE_DB_HOST=hd-price-db PRICE_DB_PORT=5432 PRICE_DB_DATABASE=hd PRICE_DB_USERNAME=hd PRICE_DB_PASSWORD=hd \
	  MAIL_HOST=mail MAIL_PORT=1025 MAIL_FROM=hd@localhost MAIL_DRIVER=smtp \
	  CACHE_DRIVER=memcached SESSION_DRIVER=memcached MEMCACHED_HOST=hd-memcached REDIS_HOST=hd-redis \
    BROADCAST_DRIVER=redis QUEUE_DRIVER=database ENVIRONMENT=production

RUN apt-get update && apt-get upgrade -y

RUN apt-get install jpegoptim optipng pngquant gifsicle webp npm -y
RUN npm install -g svgo

COPY docker-entrypoint /usr/local/bin/
RUN sed -i -e 's/\r$//' /usr/local/bin/docker-entrypoint && chmod +x /usr/local/bin/docker-entrypoint
ENTRYPOINT [ "docker-entrypoint" ]
RUN service supervisor start
CMD [ "apache2-foreground" ]

WORKDIR /var/www/html

COPY php.ini /usr/local/etc/php/
COPY laravel-worker.conf /etc/supervisor/conf.d/laravel-worker.conf

# DEPLOY COPY --chown=hd:hd /web/ /var/www/html/
# DEPLOY COPY --chown=hd:hd /web/.* /var/www/html/
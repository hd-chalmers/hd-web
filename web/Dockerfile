# FROM git.hd.chalmers.se:5050/hd/images/web:latest
FROM nginx:1.20.1

ENV DB_HOST=hd-db DB_PORT=5432 DB_DATABASE=hd DB_USERNAME=hd DB_PASSWORD=hd DB_CONNECTIOn=pgsql \
    DOOR_DB_HOST=hd-door-db DOOR_DB_PORT=5432 DOOR_DB_DATABASE=hd DOOR_DB_USERNAME=hd DOOR_DB_PASSWORD=hd \
    PRICE_DB_HOST=hd-price-db PRICE_DB_PORT=5432 PRICE_DB_DATABASE=hd PRICE_DB_USERNAME=hd PRICE_DB_PASSWORD=hd \
	MAIL_HOST=mail MAIL_PORT=1025 MAIL_FROM=hd@localhost MAIL_DRIVER=smtp \
	CACHE_DRIVER=redis SESSION_DRIVER=redis MEMCACHED_HOST=hd-memcached REDIS_HOST=hd-redis \
    BROADCAST_DRIVER=redis QUEUE_DRIVER=database ENVIRONMENT=production


#COPY docker-entrypoint /usr/local/bin/
#RUN sed -i -e 's/\r$//' /usr/local/bin/docker-entrypoint && chmod +x /usr/local/bin/docker-entrypoint
#ENTRYPOINT [ "docker-entrypoint" ]
#RUN service supervisor start
#COPY apache2.conf /etc/apache2/
#COPY .htaccess /var/www/
#CMD [ "apache2-foreground" ]
COPY nginx-config/ /etc/nginx/

WORKDIR /usr/share/nginx/html
#COPY php.ini /usr/local/etc/php/
#COPY laravel-worker.conf /etc/supervisor/conf.d/laravel-worker.conf

COPY --chown=www-data:www-data dist/ /usr/share/nginx/html
#COPY --chown=www-data:www-data dist/.* /usr/share/nginx/html

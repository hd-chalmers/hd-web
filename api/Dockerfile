FROM node:14


#ENV DB_HOST=hd-db DB_PORT=5432 DB_DATABASE=hd DB_USERNAME=hd DB_PASSWORD=hd DB_CONNECTIOn=pgsql \
#    DOOR_DB_HOST=hd-door-db DOOR_DB_PORT=5432 DOOR_DB_DATABASE=hd DOOR_DB_USERNAME=hd DOOR_DB_PASSWORD=hd \
#    PRICE_DB_HOST=hd-price-db PRICE_DB_PORT=5432 PRICE_DB_DATABASE=hd PRICE_DB_USERNAME=hd PRICE_DB_PASSWORD=hd \
#	MAIL_HOST=mail MAIL_PORT=1025 MAIL_FROM=hd@localhost MAIL_DRIVER=smtp \
#	CACHE_DRIVER=redis SESSION_DRIVER=redis MEMCACHED_HOST=hd-memcached REDIS_HOST=hd-redis \
#    BROADCAST_DRIVER=redis QUEUE_DRIVER=database ENVIRONMENT=production


WORKDIR /home/node
COPY package*.json ./
USER node
RUN npm i
#RUN chmod 777 -R ./node_modules/webp-converter/bin
COPY ./build .
CMD [ "node", "app.js" ]
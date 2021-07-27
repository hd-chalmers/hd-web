FROM postgres:12

# set timezone
ENV TZ='Europe/Stockholm'

# upgrade system and install essential tools
RUN apt-get update && apt-get upgrade -y

COPY initdb.d /docker-entrypoint-initdb.d/

CMD ["postgres"]
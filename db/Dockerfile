FROM postgres:12

# set timezone
ENV TZ='Europe/Stockholm'

# upgrade system and install essential tools
RUN apt-get update && apt-get upgrade -y

# default environment variables for dev environment
ENV POSTGRES_ROOT_PASSWORD=root POSTGRES_DB=hd POSTGRES_USER=hd POSTGRES_PASSWORD=hd

COPY initdb.d /docker-entrypoint-initdb.d/

CMD ["postgres"]
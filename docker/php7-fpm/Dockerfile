# See https://github.com/docker-library/php/blob/master/7.1/fpm/Dockerfile
FROM ddall/docker-php-ms

#RUN apt-get update && apt-get install -y \
#    && rm -rf /var/lib/apt/lists/*

RUN pecl install trader && docker-php-ext-enable trader
ADD 99-extra-config.ini /usr/local/etc/php/conf.d/

RUN apt-get update && apt-get install -y libpq-dev npm node \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql \
    && rm -rf /var/lib/apt/lists/*

RUN npm install -g bower

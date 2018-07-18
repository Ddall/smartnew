# See https://github.com/docker-library/php/blob/master/7.1/fpm/Dockerfile
FROM ddall/docker-php-trader

ADD 99-extra-config.ini /usr/local/etc/php/conf.d/

WORKDIR /var/www/symfony
RUN ssh -oStrictHostKeyChecking=no github.com; exit 0
RUN ssh -oStrictHostKeyChecking=no gitlab.com; exit 0

COPY symfony /var/www/symfony
RUN mkdir -p /var/www/symfony/var && chown www-data:www-data -R /var/www/symfony/var


ENTRYPOINT entrypoint.sh

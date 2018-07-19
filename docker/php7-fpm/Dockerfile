# See https://github.com/docker-library/php/blob/master/7.1/fpm/Dockerfile
FROM ddall/docker-php-trader

ADD docker/php7-fpm/99-extra-config.ini /usr/local/etc/php/conf.d/

WORKDIR /var/www/symfony
RUN ssh -oStrictHostKeyChecking=no github.com; exit 0
RUN ssh -oStrictHostKeyChecking=no gitlab.com; exit 0

COPY symfony /var/www/symfony
RUN mkdir -p /var/www/symfony/var && chown www-data:www-data -R /var/www/symfony/var

COPY docker/php7-fpm/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Install deps
RUN /entrypoint.sh install && \
    rm /var/www/symfony/web/app_dev.php && \
    chown www-data:www-data -R /var/www/symfony && \

ENTRYPOINT ["/entrypoint.sh"]
CMD ["run"]

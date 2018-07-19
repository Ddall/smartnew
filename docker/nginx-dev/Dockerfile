FROM nginx:latest

RUN rm /etc/nginx/nginx.conf && rm /etc/nginx/conf.d/default.conf
ADD docker/nginx/nginx.conf /etc/nginx/
ADD docker/nginx/symfony.conf /etc/nginx/conf.d/symfony.conf

RUN echo "upstream php-upstream { server php:9000; }" > /etc/nginx/conf.d/upstream.conf

FROM nginx:alpine

COPY nginx.conf /etc/nginx/
COPY default.conf /etc/nginx/conf.d/

RUN echo "upstream php-upstream { server php-fpm:9000; }" > /etc/nginx/conf.d/upstream.conf

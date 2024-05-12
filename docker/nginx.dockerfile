FROM nginx:1.14

COPY ./docker/nginx.conf /etc/nginx/nginx.conf
COPY ./docker/site.conf /etc/nginx/conf.d/default.conf

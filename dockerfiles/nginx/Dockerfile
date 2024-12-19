FROM nginx:stable-alpine

# Arguments defined
ARG PHP_PROXY
ARG PORT
ARG UID
ARG GID

RUN apk add --no-cache shadow && \
    groupmod  -g $GID nginx && \
    usermod -u $UID -g nginx nginx && \
    apk del shadow

RUN rm -rf /etc/nginx/conf.d/default.conf
COPY ./dockerfiles/nginx/ecd.conf /etc/nginx/conf.d/
COPY --chown=nginx:nginx ./public  /var/www/html/public
RUN sed -i "s/fastcgi_pass php:9000/fastcgi_pass 172.19.0.1:9000/g" /etc/nginx/conf.d/ecd.conf


# Expose port by env and start nginx server
EXPOSE $PORT



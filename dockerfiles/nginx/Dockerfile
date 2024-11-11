FROM nginx:stable-alpine

# Arguments defined
ARG PHP_PROXY
ARG PORT

RUN rm -rf /etc/nginx/conf.d/default.conf
COPY ./dockerfile/nginx/evm_admin.conf /etc/nginx/conf.d/
COPY --chown=nginx:nginx ./public  /var/www/html/public
RUN sed -i "s/fastcgi_pass php:9000/fastcgi_pass $PHP_PROXY/g" /etc/nginx/conf.d/evm_admin.conf

# Expose port by env and start nginx server
EXPOSE $PORT



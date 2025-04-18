FROM php:8.1-fpm-alpine AS base

## Install dependencies only when needed
FROM base AS deps

# Arguments defined
ARG PHP_PORT
ARG UID
ARG GID

# Install PHP extensions
RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    pcntl \
    && docker-php-ext-enable pcntl 

## Installing PHP and additional dependencies
FROM deps AS composer

# Set working directory
WORKDIR /var/www/html

COPY . .

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install composer
RUN composer update
RUN composer install --ignore-platform-reqs
RUN composer clear-cache
RUN composer dump-autoload
# RUN php artisan migrate

## 3. Running application
FROM deps AS runner

RUN echo "php_admin_flag[log_errors] = on" >> /usr/local/etc/php-fpm.d/www.conf
RUN echo 'memory_limit = 1024M' >> /usr/local/etc/php/conf.d/docker-php-memlimit.ini;
RUN echo 'max_execution_time=60' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini;

# Install tools and create group/user
RUN apk add --no-cache shadow && \
    groupmod -g $GID www-data && \
    usermod -u $UID -g www-data www-data && \
    apk del shadow

# Copy existing application directory permissions
COPY --chown=www-data:www-data ./ /var/www/html/

# Set working directory
WORKDIR /var/www/html

COPY --from=composer --chown=www-data:www-data /var/www/html/vendor ./vendor

# Change current user
USER www-data

# Expose port 9000 and start php-fpm server
EXPOSE $PHP_PORT

CMD ["php-fpm", "-y", "/usr/local/etc/php-fpm.conf", "-R"]


# Run image by enviroment
FROM runner AS localhost
FROM runner AS develop
FROM runner AS staging
FROM runner AS production

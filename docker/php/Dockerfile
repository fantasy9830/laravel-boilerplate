FROM php:fpm

ENV DEBIAN_FRONTEND noninteractive

ARG TZ=UTC
ENV TZ ${TZ}

RUN set -x \
  && apt-get update \
  && pecl channel-update pecl.php.net \
  && apt-get upgrade -y \
  && apt-get install -y --no-install-recommends \
    curl \
    zip \
    unzip \
    libzip-dev \
    libmemcached-dev \
    libz-dev \
    libpq-dev \
    libjpeg-dev \
    libpng-dev \
    libfreetype6-dev \
    libssl-dev \
    libmcrypt-dev \
    apt-utils

# Install pdo_mysql pdo_pgsql exif pcntl opcache zip gd
RUN docker-php-ext-install -j$(nproc) pdo_mysql pdo_pgsql exif pcntl opcache zip \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install -j$(nproc) gd

# Install redis
RUN pecl install -o -f redis && docker-php-ext-enable redis

# Use the default production configuration
# RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Override with custom settings
COPY ./laravel.ini $PHP_INI_DIR/conf.d/
COPY ./xlaravel.pool.conf /usr/local/etc/php-fpm.d/
COPY ./opcache.ini /usr/local/etc/php/conf.d/opcache.ini

# Clean up
RUN apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* \
    && rm /var/log/lastlog /var/log/faillog

WORKDIR /var/www

CMD ["php-fpm"]

EXPOSE 9000

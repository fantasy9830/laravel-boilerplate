FROM phusion/baseimage:latest

LABEL maintainer="Ricky Lu <fantasy9830@gmail.com>"

RUN DEBIAN_FRONTEND=noninteractive
RUN locale-gen en_US.UTF-8

ENV LANGUAGE=en_US.UTF-8
ENV LC_ALL=en_US.UTF-8
ENV LC_CTYPE=en_US.UTF-8
ENV LANG=en_US.UTF-8
ENV TERM xterm

# Add the "PHP 7" ppa
RUN apt-get install -y software-properties-common \
    && add-apt-repository -y ppa:ondrej/php

#
#--------------------------------------------------------------------------
# Software's Installation
#--------------------------------------------------------------------------
#

RUN echo 'DPkg::options { "--force-confdef"; };' >> /etc/apt/apt.conf

# Install
RUN apt-get update -yqq \
    && apt-get install -y --allow-downgrades --allow-remove-essential --allow-change-held-packages \
      php7.4-cli \
      php7.4-common \
      php7.4-curl \
      php7.4-intl \
      php7.4-json \
      php7.4-xml \
      php7.4-mbstring \
      php7.4-mysql \
      php7.4-pgsql \
      php7.4-sqlite \
      php7.4-sqlite3 \
      php7.4-zip \
      php7.4-bcmath \
      php7.4-memcached \
      php7.4-gd \
      php7.4-dev \
      php-redis \
      pkg-config \
      libcurl4-openssl-dev \
      libedit-dev \
      libssl-dev \
      libxml2-dev \
      xz-utils \
      libsqlite3-dev \
      sqlite3 \
      git \
      curl \
      vim \
      nano \
      inetutils-ping \
      postgresql-client \
      apt-utils \
      libzip-dev zip unzip \
    && apt-get clean

#####################################
# Composer:
#####################################

# Install composer and add its bin to the PATH.
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

RUN set -xe; \
    apt-get update -yqq \
    && pecl channel-update pecl.php.net

RUN groupadd ricky && useradd -g ricky -m ricky && usermod -p "*" ricky -s /bin/bash

# Set Timezone
ARG TZ=UTC
ENV TZ ${TZ}
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# User Aliases
USER root

COPY ./aliases.sh /root/aliases.sh
COPY ./aliases.sh /home/ricky/aliases.sh

RUN sed -i 's/\r//' /root/aliases.sh && \
    sed -i 's/\r//' /home/ricky/aliases.sh && \
    chown ricky:ricky /home/ricky/aliases.sh && \
    echo "" >> ~/.bashrc && \
    echo "# Load Custom Aliases" >> ~/.bashrc && \
    echo "source ~/aliases.sh" >> ~/.bashrc && \
	  echo "" >> ~/.bashrc

USER ricky

RUN echo "" >> ~/.bashrc && \
    echo "# Load Custom Aliases" >> ~/.bashrc && \
    echo "source ~/aliases.sh" >> ~/.bashrc && \
	  echo "" >> ~/.bashrc

# Crontab
USER root

COPY ./crontab /etc/cron.d
RUN chmod -R 644 /etc/cron.d

# Clean up
RUN apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* && \
    rm /var/log/lastlog /var/log/faillog

USER root

# Set default work directory
WORKDIR /var/www

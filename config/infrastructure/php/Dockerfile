FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    gnupg \
    apt-transport-https \
    lsb-release \
    libssl-dev \
    pkg-config \
    unzip \
    curl \
    git \
    libpq-dev \
    libgrpc-dev \
    libprotobuf-dev \
    protobuf-compiler

RUN docker-php-ext-install pdo_pgsql

RUN pecl install mongodb && docker-php-ext-enable mongodb

RUN apt-get update && apt-get install -y librabbitmq-dev && \
    pecl install amqp && \
    docker-php-ext-enable amqp

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#RUN curl -sS https://packages.blackfire.io/gpg.key | apt-key add - && \
 #   echo "deb http://packages.blackfire.io/debian any main" > /etc/apt/sources.list.d/blackfire.list
#
## Устанавливаем agent и PHP-расширение
#RUN apt-get update && apt-get install -y \
#    blackfire-agent \
#    blackfire-php
#

#RUN curl -L \
#    -H "Accept: application/octet-stream" \
#    -H "User-Agent: Blackfire Docker Installer" \
#    "https://blackfire.io/api/v1/releases/cli/linux/amd64/blackfire_2.15.0" \
#    -o /usr/local/bin/blackfire && \
#    chmod +x /usr/local/bin/blackfire

#RUN apt install -y wget
#RUN wget -q -O - https://packages.blackfire.io/gpg.key | dd of=/usr/share/keyrings/blackfire-archive-keyring.asc
#RUN echo "deb [arch=$(dpkg --print-architecture) signed-by=/usr/share/keyrings/blackfire-archive-keyring.asc] http://packages.blackfire.io/debian any main" | tee /etc/apt/sources.list.d/blackfire.list
#RUN apt update
#RUN apt install -y blackfire

RUN curl -sS https://packages.blackfire.io/gpg.key | apt-key add - && \
    echo "deb http://packages.blackfire.io/debian any main" > /etc/apt/sources.list.d/blackfire.list && \
    apt-get update && \
    apt-get install -y blackfire-agent blackfire-php


#RUN curl -sS https://packages.blackfire.io/gpg.key | apt-key add - && \
 #   echo "deb http://packages.blackfire.io/debian any main" > /etc/apt/sources.list.d/blackfire.list

#RUN apt-get update && apt-get install -y \
#    blackfire-agent \
#    blackfire-php

#RUN curl -s https://packages.blackfire.io/gpg.key | apt-key add - && \
#    echo "deb http://packages.blackfire.io/debian any main" > /etc/apt/sources.list.d/blackfire.list && \
#    apt-get update && \
#    apt-get install -y blackfire-agent

RUN pecl install xdebug && docker-php-ext-enable xdebug

RUN apt update && apt install -y procps
RUN apt install net-tools
RUN apt update && apt install -y iputils-ping
RUN apt update && apt install -y telnet

RUN apt-get update && apt-get install -y supervisor
COPY config/infrastructure/php/supervisord.conf /etc/supervisord.conf

RUN rm -f /usr/local/etc/php/conf.d/zz-blackfire.ini

# Очистка после установки
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]

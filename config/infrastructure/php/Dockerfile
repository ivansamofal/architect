# Используем базовый образ PHP 8.4 с FPM
FROM php:8.4-fpm

# Обновляем apt и устанавливаем зависимости, необходимые для сборки расширения pdo_pgsql и других пакетов
RUN apt-get update && apt-get install -y \
    libssl-dev \
    pkg-config \
    unzip \
    curl \
    git \
    libpq-dev \
 && docker-php-ext-install pdo_pgsql

# Устанавливаем MongoDB расширение через PECL и включаем его
RUN pecl install mongodb && docker-php-ext-enable mongodb

# Устанавливаем Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

# Очистка кэша apt для уменьшения размера образа
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

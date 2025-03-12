# Используем базовый образ PHP (например, официальный)
#FROM taygeta/php:8.4
FROM php:8.4-fpm

#RUN #apk update
# Устанавливаем необходимые зависимости
RUN apt-get update && apt-get install -y \
    libssl-dev pkg-config && \
    pecl install mongodb && \
    docker-php-ext-enable mongodb
#
## Очистка ненужных файлов (уменьшает размер образа)
#RUN apt-get clean && rm -rf /var/lib/apt/lists/*

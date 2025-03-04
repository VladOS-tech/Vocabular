# Используем официальный образ PHP 8.3
FROM php:8.3-fpm

# Устанавливаем зависимости и расширения
RUN apt-get update && apt-get install -y --no-install-recommends \
    libpq-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo pdo_pgsql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Устанавливаем рабочий каталог
WORKDIR /var/www/html

# Копируем содержимое проекта в контейнер
COPY ./public /var/www/html

# Настраиваем права доступа
RUN chown -R www-data:www-data /var/www/html

# Запускаем сервер
CMD ["php-fpm"]


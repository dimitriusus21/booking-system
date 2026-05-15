FROM php:8.4-cli

# Системные зависимости
RUN apt-get update && apt-get install -y \
    libpq-dev \
    unzip \
    git \
    curl \
    zip \
    && docker-php-ext-install pdo pdo_pgsql pgsql

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Кэшируем зависимости
COPY composer.json composer.lock ./

RUN composer install \
    --no-interaction \
    --no-dev \
    --optimize-autoloader \
    --ignore-platform-req=ext-pdo_mysql \
    --no-scripts

# Копируем проект
COPY . .

# Laravel optimize
RUN php artisan package:discover --ansi || true

# Права
RUN mkdir -p storage/framework/{sessions,views,cache} storage/logs bootstrap/cache \
    && chmod -R 777 storage bootstrap/cache

ENV APP_ENV=production
ENV PORT=8080

EXPOSE 8080

CMD sh -c "php artisan migrate --force && php -S 0.0.0.0:${PORT} -t public"

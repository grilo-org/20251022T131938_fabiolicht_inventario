# Dockerfile (PHP 7.4 + FPM + Composer)
FROM php:7.4-fpm

# Dependências do sistema
RUN apt-get update && apt-get install -y \
    git unzip zip \
    libzip-dev \
    libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
    libonig-dev libicu-dev libxml2-dev \
    libpq-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) intl mbstring zip gd pdo_mysql pdo_pgsql \
    && rm -rf /var/lib/apt/lists/*

# Composer 2
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# PHP.ini mínimos
RUN echo "memory_limit=512M" > /usr/local/etc/php/conf.d/memory-limit.ini \
 && echo "date.timezone=America/Sao_Paulo" > /usr/local/etc/php/conf.d/timezone.ini

WORKDIR /var/www/html

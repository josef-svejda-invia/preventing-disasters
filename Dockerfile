# Runtime is PHP 8.5, but the code deliberately sticks to syntax that is
# readable on 8.2+ (see the platform pin in composer.json).
FROM php:8.5-cli

RUN apt-get update \
    && apt-get install -y --no-install-recommends git unzip libzip-dev \
    && docker-php-ext-install zip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

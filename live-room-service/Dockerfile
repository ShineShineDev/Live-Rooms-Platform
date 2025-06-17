FROM php:8.3-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    unzip \
    zip \
    curl \
    git \
    && docker-php-ext-install pdo pdo_pgsql zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy app code
COPY . .

# Install dependencies
RUN composer install --no-interaction --prefer-dist --ignore-platform-req=ext-gd --ignore-platform-req=ext-sockets

# Expose Laravel's default port (if using php -S, otherwise ignore this)
EXPOSE 8001

# Copy and set permission for entrypoint script
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Start container using entrypoint
CMD ["/entrypoint.sh"]

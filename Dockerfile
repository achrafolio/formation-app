FROM php:8.2-cli

# Install dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    git \
    libonig-dev \
    libxml2-dev \
    libssl-dev \
    && docker-php-ext-install pdo_mysql zip mbstring xml pcntl

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy existing application directory contents
COPY . /app

# Install Laravel dependencies
# Allow composer to run as root just for the build process
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer update --no-interaction --optimize-autoloader

# Set correct permissions
RUN chmod -R 777 /app/storage /app/bootstrap/cache

# Expose port 3000
EXPOSE 3000

# Start Laravel development server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=3000"]

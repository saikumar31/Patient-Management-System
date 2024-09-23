FROM php:8.2-fpm

# Install required PHP extensions
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    git \
    && docker-php-ext-install zip \
    && docker-php-ext-install pdo pdo_mysql

# Set working directory
WORKDIR /var/www/html/patient-management-app

# Copy the application files (including composer.json) into the container
COPY ./patient-management-app /var/www/html/patient-management-app

# Copy the composer.phar to the container
COPY composer.phar /usr/local/bin/composer

# Make sure composer is executable
RUN chmod +x /usr/local/bin/composer

# Install Composer dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Expose port for PHP-FPM
EXPOSE 9000


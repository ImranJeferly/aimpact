FROM php:8.1-apache

# Install system dependencies
RUN apt-get update \
    && docker-php-ext-install pdo pdo_mysql \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . .

# Install Composer and dependencies (skip if fails)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader --no-scripts || true

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && mkdir -p cache \
    && chown -R www-data:www-data cache

# Expose port
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
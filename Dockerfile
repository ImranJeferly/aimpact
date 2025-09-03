FROM php:8.2-apache

# Install system dependencies and curl for health checks
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    curl \
    && docker-php-ext-install pdo pdo_mysql zip \
    && rm -rf /var/lib/apt/lists/*

# Enable Apache modules for better performance
RUN a2enmod rewrite deflate expires headers ssl

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy composer files first for better Docker layer caching
COPY composer.json composer.lock* ./

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copy application files
COPY . .

# Run composer scripts after copying all files
RUN composer run-script post-install-cmd || true

# Create necessary directories
RUN mkdir -p cache uploads/blogs uploads/testimonials submissions \
    && chown -R www-data:www-data cache uploads submissions \
    && chmod -R 755 cache uploads submissions

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html \
    && find /var/www/html -type f -exec chmod 644 {} \; \
    && find /var/www/html -type d -exec chmod 755 {} \;

# Copy Apache configuration
COPY apache.conf /etc/apache2/sites-available/000-default.conf

# Configure PHP for production
COPY .user.ini /var/www/html/.user.ini

# Health check
HEALTHCHECK --interval=30s --timeout=10s --start-period=5s --retries=3 \
    CMD curl -f http://localhost/health.php || exit 1

# Expose port
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
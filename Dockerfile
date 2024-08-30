# Use the PHP-Apache base image
FROM php:8.2-apache

# Set working directory
WORKDIR /var/www/html

# Install dependencies
RUN apt-get update \
  && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libmariadb-dev-compat \
    libmariadb-dev \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install gd \
  && docker-php-ext-install pdo_mysql \
  && rm -rf /var/lib/apt/lists/*

# Enable mod_rewrite for Laravel
RUN a2enmod rewrite

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

# Copy application source code
COPY . .

# Install Laravel dependencies
RUN composer install

# Expose port 80 for Apache
EXPOSE 80

# Start Apache
CMD ["sh", "-c", "php artisan migrate --force && apache2-foreground"]
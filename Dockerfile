FROM php:8.1-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    sqlite3 \
    libsqlite3-dev \
    zip \
    unzip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd
RUN docker-php-ext-install pdo_sqlite

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy the entire application
COPY . /app

# Set file permissions
RUN chmod -R 775 /app/storage /app/bootstrap/cache

# Install dependencies
RUN composer install --no-interaction --no-dev --optimize-autoloader

# Create SQLite database
RUN touch /tmp/database.sqlite
RUN chmod 777 /tmp/database.sqlite

# Set up environment
COPY .env.example .env
RUN php artisan key:generate
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache
RUN php artisan migrate --force
RUN php artisan db:seed --force

# Expose port 10000
EXPOSE 10000

# Start PHP server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"] 
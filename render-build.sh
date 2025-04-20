#!/usr/bin/env bash

# Install PHP & dependencies
apt-get update && apt-get install -y \
    php8.1-cli \
    php8.1-common \
    php8.1-mbstring \
    php8.1-xml \
    php8.1-zip \
    php8.1-sqlite3 \
    php8.1-curl \
    php8.1-gd \
    unzip \
    curl \
    git

# Install Composer
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer

# Install dependencies
composer install --no-dev

# Laravel setup
cp .env.example .env
php artisan key:generate
mkdir -p database
touch database/database.sqlite
chmod -R 777 storage bootstrap/cache database
php artisan migrate --force
php artisan db:seed --force
npm install
npm run build
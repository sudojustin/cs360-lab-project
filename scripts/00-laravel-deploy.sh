#!/usr/bin/env bash
echo "Running composer"
composer install --no-dev --working-dir=/var/www/html

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Creating sqlite database..."
touch /var/www/html/database/database.sqlite

echo "Running migrations..."
php artisan migrate --force

echo "Running seeders..."
php artisan db:seed --force 
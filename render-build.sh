#!/usr/bin/env bash

# Install PHP & dependencies
apt-get update
apt-get install -y php php-mbstring php-xml php-bcmath php-curl php-sqlite3 unzip curl git

# Install Composer
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer

# Laravel setup
composer install --no-dev
cp .env.example .env
php artisan key:generate
touch /tmp/database.sqlite
php artisan migrate --force
php artisan db:seed --force
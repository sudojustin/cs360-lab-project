#!/bin/bash
# Fix permissions
chmod -R 777 /var/www/html/storage
chmod -R 777 /var/www/html/database
chmod -R 777 /var/www/html/bootstrap/cache

# Create necessary directories for cache/storage if they don't exist
mkdir -p /var/www/html/storage/framework/sessions
mkdir -p /var/www/html/storage/framework/views
mkdir -p /var/www/html/storage/framework/cache
mkdir -p /var/www/html/storage/framework/cache/data
mkdir -p /var/www/html/bootstrap/cache

# Ensure SQLite database exists
touch /var/www/html/database/database.sqlite || true
chmod 777 /var/www/html/database/database.sqlite || true

# Check if there's an index.php in the root that's not our redirect
if [ -f /var/www/html/index.php ]; then
  grep -q "header('Location: /public/');" /var/www/html/index.php || rm /var/www/html/index.php
fi

# Make sure the webroot is correctly set
export WEBROOT=/var/www/html/public

# Create a symbolic link for the public directory if needed
if [ ! -d "/var/www/public" ]; then
  ln -sf /var/www/html/public /var/www/public
fi

# Configure environment for database and cache
cd /var/www/html
# Create/update .env.production file
cat > /var/www/html/.env.production << EOF
APP_NAME=Laravel
APP_ENV=production
APP_KEY=base64:UzXBgdd33QALrq7h98RrSwv6TPURtkHqp0RVGPdsZUA=
APP_DEBUG=false
APP_URL=https://cs360-lab-project.onrender.com

LOG_CHANNEL=stderr
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

DB_CONNECTION=sqlite
DB_DATABASE=/var/www/html/database/database.sqlite

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=cookie
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

MAIL_MAILER=log
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="\${APP_NAME}"

ASSET_URL=https://cs360-lab-project.onrender.com/
EOF

# Replace .env with .env.production
cp /var/www/html/.env.production /var/www/html/.env

# Run Laravel migrations and setup cache
php artisan migrate --force
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize

# Set proper permissions again after all operations
chmod -R 777 /var/www/html/storage
chmod -R 777 /var/www/html/database
chmod -R 777 /var/www/html/bootstrap/cache

# Execute the base image's startup script
exec /usr/bin/supervisord -n -c /etc/supervisord.conf 
#!/bin/bash
# Fix permissions
chmod -R 777 /var/www/html/storage
chmod -R 777 /var/www/html/database
chmod -R 777 /var/www/html/bootstrap/cache
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

# Execute the base image's startup script
exec /usr/bin/supervisord -n -c /etc/supervisord.conf 
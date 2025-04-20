#!/bin/bash
# Fix permissions
chmod -R 777 /var/www/html/storage
chmod -R 777 /var/www/html/database
chmod -R 777 /var/www/html/bootstrap/cache
touch /var/www/html/database/database.sqlite || true
chmod 777 /var/www/html/database/database.sqlite || true

# Execute the base image's startup script
exec /usr/bin/supervisord -n -c /etc/supervisord.conf 
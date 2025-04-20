FROM richarvey/nginx-php-fpm:3.1.4
 
COPY . .
 
# Image config
ENV SKIP_COMPOSER 0
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1
ENV NGINX_PORT 80

# Laravel config
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr
ENV SESSION_DRIVER cookie
ENV CACHE_DRIVER file
 
# Allow composer to run as root
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_PROCESS_TIMEOUT 2000
ENV COMPOSER_MEMORY_LIMIT -1
 
# Fix permissions
RUN mkdir -p /var/www/html/database
RUN mkdir -p /var/www/html/storage/framework/sessions
RUN mkdir -p /var/www/html/storage/framework/views
RUN mkdir -p /var/www/html/storage/framework/cache
RUN chmod -R 777 /var/www/html/storage
RUN chmod -R 777 /var/www/html/database
RUN chmod -R 777 /var/www/html/bootstrap/cache

# Install Node.js and build assets
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash -
RUN apt-get install -y nodejs
RUN npm ci
RUN npm run build
 
CMD ["/start.sh"]
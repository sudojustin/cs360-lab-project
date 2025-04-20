@echo off
REM Windows startup script for Laravel application

REM Create storage directories if they don't exist
IF NOT EXIST storage\framework\cache mkdir storage\framework\cache
IF NOT EXIST storage\framework\sessions mkdir storage\framework\sessions 
IF NOT EXIST storage\framework\views mkdir storage\framework\views
IF NOT EXIST storage\logs mkdir storage\logs

REM Create database directory and file if they don't exist
IF NOT EXIST database mkdir database
IF NOT EXIST database\database.sqlite type NUL > database\database.sqlite

REM Configure environment
copy .env.example .env
php artisan key:generate --force

REM Set up cache configuration
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear

REM Ensure cache table migration exists
php artisan cache:table

REM Run database migrations and seeders
php artisan migrate --force
php artisan db:seed --force

REM Optimize the application
php artisan optimize
php artisan config:cache

REM Start the development server
php artisan serve 
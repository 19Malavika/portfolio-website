#!/bin/sh
set -e

# Run production optimizations and database setup
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Run database migrations and seeders on first boot
php artisan migrate --force
php artisan db:seed --force

# Start Apache in foreground
exec apache2-foreground

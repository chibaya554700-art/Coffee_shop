#!/bin/bash
set -e

# Run migrations
php artisan migrate --force

# Run seeders
php artisan db:seed --force

# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start Apache
exec apache2-foreground
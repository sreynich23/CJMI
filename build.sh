#!/bin/bash

# Install dependencies
composer install --no-dev --optimize-autoloader

# Clear and cache config
php artisan config:clear
php artisan config:cache

# Clear and cache routes
php artisan route:clear
php artisan route:cache

# Clear and cache views
php artisan view:clear
php artisan view:cache

# Create public directory
mkdir -p public

# Copy necessary files to public
cp -r resources/css public/
cp -r resources/js public/
cp -r resources/images public/ 2>/dev/null || :
cp -r public/* dist/ 2>/dev/null || :

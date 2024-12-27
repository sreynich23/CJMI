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

# Install npm dependencies and build assets
npm install
npm run build

# Ensure the public directory exists
mkdir -p public

# Copy all necessary files to public directory
cp -r resources/css public/ 2>/dev/null || :
cp -r resources/js public/ 2>/dev/null || :
cp -r resources/images public/ 2>/dev/null || :

# Create symbolic link for storage
php artisan storage:link

# Ensure proper permissions
chmod -R 755 public
chmod -R 755 storage

# Create output directory structure
mkdir -p .vercel/output/static
mkdir -p .vercel/output/functions

# Copy public files to output
cp -r public/* .vercel/output/static/ 2>/dev/null || :

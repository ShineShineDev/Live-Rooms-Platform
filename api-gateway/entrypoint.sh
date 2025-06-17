#!/bin/sh

# Exit on error
set -e

# Wait for PostgreSQL (or any other services) to be ready (optional but useful)
# You can use tools like wait-for-it or add a sleep
# sleep 5

# Run Laravel migrations
php artisan migrate --force

# Optionally install Passport (if you're using Laravel Passport)
php artisan passport:install --force

# Start the Laravel built-in server (for dev only)
php -S 0.0.0.0:8000 -t public

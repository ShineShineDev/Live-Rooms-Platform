#!/bin/sh

set -e

# Run migrations
php artisan migrate --force

# Run the RoomSeeder
php artisan db:seed --class=RoomSeeder --force

# Start Laravel development server (for local development)
php -S 0.0.0.0:8001 -t public

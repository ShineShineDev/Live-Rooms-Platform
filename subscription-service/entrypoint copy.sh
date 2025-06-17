#!/bin/sh

# Run Laravel migrations
php artisan migrate --force

# Start the Laravel server
php -S 0.0.0.0:8002 -t public

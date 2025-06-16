#!/bin/bash
set -e

# Run Laravel package discovery now that the app is fully set up
php artisan package:discover

# Run the default apache foreground command
exec apache2-foreground

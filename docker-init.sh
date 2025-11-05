#!/usr/bin/env bash

# Docker initialization script for YourLab multi-tenant application

echo "🚀 Initializing YourLab application..."

# Wait for MySQL to be ready
echo "⏳ Waiting for MySQL to be ready..."
until php artisan db:show 2>/dev/null; do
    sleep 2
done

echo "✅ MySQL is ready!"

# Run database migrations (includes both central and tenant tables in single database)
echo "📦 Running database migrations..."
php artisan migrate --force

# Seed database on first run (creates test data)
if [ ! -f /var/www/html/storage/.initialized ]; then
    echo "🌱 Seeding database (first run)..."
    php artisan db:seed --force
    touch /var/www/html/storage/.initialized
fi

echo "✨ YourLab is ready!"

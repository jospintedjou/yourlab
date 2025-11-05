#!/usr/bin/env bash

# Docker initialization script for YourLab multi-tenant application

echo "🚀 Initializing YourLab application..."

# Wait for MySQL to be ready
echo "⏳ Waiting for MySQL to be ready..."
until php artisan db:show 2>/dev/null; do
    sleep 2
done

echo "✅ MySQL is ready!"

# Run central database migrations
echo "📦 Running central database migrations..."
php artisan migrate --force

# Run tenant migrations
echo "🏢 Running tenant migrations..."
php artisan tenants:migrate --force

# Check if we need to seed data
if [ "$APP_ENV" = "local" ] && [ ! -f /var/www/html/storage/.initialized ]; then
    echo "🌱 Seeding database (first run)..."
    php artisan db:seed --force
    touch /var/www/html/storage/.initialized
fi

echo "✨ YourLab is ready!"

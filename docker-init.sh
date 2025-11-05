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

# Seed database if no tenants exist (intelligent check)
echo "🔍 Checking if database needs seeding..."
php artisan db:seed --force

echo "✨ YourLab is ready!"

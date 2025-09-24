#!/bin/bash

# Script de despliegue para Railway
echo " Iniciando despliegue..."

# Generar clave de aplicación si no existe
if [ -z "$APP_KEY" ]; then
    echo " Generando APP_KEY..."
    php artisan key:generate --force
fi

# Ejecutar migraciones
echo "Ejecutando migraciones..."
php artisan migrate --force

# Ejecutar seeders
echo "Ejecutando seeders..."
php artisan db:seed --force

# Limpiar cache
echo "Limpiando cache..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Generar JWT secret si no existe
if [ -z "$JWT_SECRET" ]; then
    echo "Generando JWT_SECRET..."
    php artisan jwt:secret --force
fi

echo "✅ Despliegue completado!"

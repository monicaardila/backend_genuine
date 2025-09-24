#!/bin/bash

# Script de inicio para Railway
echo "Iniciando aplicación Laravel..."

# Configurar base de datos para Railway
echo "Configurando base de datos..."
if [ ! -z "$DATABASE_URL" ]; then
    echo "Usando DATABASE_URL de Railway"
    # Railway proporciona DATABASE_URL, extraer componentes
    export DB_CONNECTION=pgsql
    export DB_HOST=$(echo $DATABASE_URL | sed -n 's/.*@\([^:]*\):.*/\1/p')
    export DB_PORT=$(echo $DATABASE_URL | sed -n 's/.*:\([0-9]*\)\/.*/\1/p')
    export DB_DATABASE=$(echo $DATABASE_URL | sed -n 's/.*\/\([^?]*\).*/\1/p')
    export DB_USERNAME=$(echo $DATABASE_URL | sed -n 's/.*:\/\/\([^:]*\):.*/\1/p')
    export DB_PASSWORD=$(echo $DATABASE_URL | sed -n 's/.*:\([^@]*\)@.*/\1/p')
fi

# Generar clave de aplicación si no existe
if [ -z "$APP_KEY" ]; then
    echo " Generando APP_KEY..."
    php artisan key:generate --force
fi

# Ejecutar migraciones
echo "Ejecutando migraciones..."
php artisan migrate --force

# Verificar que el usuario de prueba existe
echo "Verificando usuario de prueba..."
php artisan tinker --execute="
if (App\Models\User::count() === 0) {
    echo 'Creando usuario de prueba...';
    App\Models\User::create([
        'name' => 'Usuario Prueba',
        'email' => 'prueba@example.com',
        'password' => bcrypt('12345678')
    ]);
    echo 'Usuario de prueba creado exitosamente';
} else {
    echo 'Usuario de prueba ya existe';
}
"

# Limpiar cache
echo "Limpiando cache..."
php artisan config:cache
php artisan route:cache

# Generar JWT secret si no existe
if [ -z "$JWT_SECRET" ]; then
    echo " Generando JWT_SECRET..."
    php artisan jwt:secret --force
fi

# Iniciar servidor
echo "Iniciando servidor en puerto $PORT..."
php artisan serve --host=0.0.0.0 --port=$PORT

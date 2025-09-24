# 🏫 Genuine School API

API REST para gestión de estudiantes implementada con **Laravel** y **Arquitectura Limpia (Clean Architecture)**.

## Arquitectura

Este proyecto implementa los principios de **Clean Architecture** para mantener un código limpio, mantenible y testeable.

### Estructura del Proyecto

```
app/
├── Domain/                    # Capa de Dominio (más interna)
│   ├── Entities/             # Entidades de negocio puras
│   │   └── Student.php       # Entidad Student
│   └── Repositories/         # Interfaces de repositorios
│       └── StudentRepositoryInterface.php
├── Application/              # Capa de Aplicación
│   ├── Services/             # Casos de uso y lógica de aplicación
│   │   └── StudentService.php
│   └── DTOs/                 # Data Transfer Objects
│       └── StudentDTO.php
├── Infrastructure/           # Capa de Infraestructura
│   └── Repositories/         # Implementaciones concretas
│       └── EloquentStudentRepository.php
├── Presentation/             # Capa de Presentación
│   ├── Http/Controllers/     # Controladores REST
│   │   └── StudentController.php
│   ├── Requests/             # Form Requests para validación
│   │   ├── CreateStudentRequest.php
│   │   └── UpdateStudentRequest.php
│   └── Resources/            # API Resources
│       └── StudentResource.php
└── Shared/                   # Utilidades compartidas
    └── Exceptions/           # Excepciones personalizadas
        ├── StudentNotFoundException.php
        └── StudentEmailAlreadyExistsException.php
```

### Principios de Clean Architecture

1. **Independencia de frameworks** - No depende de Laravel en las capas internas
2. **Testabilidad** - Lógica de negocio aislada y fácil de testear
3. **Independencia de la UI** - La UI puede cambiar sin afectar el negocio
4. **Independencia de la base de datos** - Fácil cambiar de MySQL a PostgreSQL
5. **Independencia de agentes externos** - La lógica de negocio no sabe nada del mundo exterior

## 🚀 Características

- **Autenticación JWT** completa
- **CRUD de estudiantes** con validación
- **Arquitectura limpia** y escalable
- **Manejo de errores** robusto
- **Logs detallados** para debugging
- **Validación de datos** con Form Requests
- **API Resources** para respuestas consistentes
- **Inyección de dependencias** con Service Providers

## Requisitos

- PHP >= 8.1
- Composer
- PostgreSQL (o MySQL)
- Laravel 11.x

## Instalación

### 1. Clonar el repositorio
```bash
git clone https://github.com/monicaardila/backend_genuine.git
cd backend_genuine
```

### 2. Instalar dependencias
```bash
composer install
```

### 3. Configurar variables de entorno
```bash
cp .env.example .env
```

Editar `.env` con tu configuración:
```env
APP_NAME="Genuine School API"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=genuine_school
DB_USERNAME=postgres
DB_PASSWORD=tu_password

JWT_SECRET=tu_jwt_secret_aqui
```

### 4. Generar claves
```bash
php artisan key:generate
php artisan jwt:secret
```

### 5. Ejecutar migraciones y seeders
```bash
php artisan migrate
php artisan db:seed
```

### 6. Iniciar servidor
```bash
php artisan serve
```

## API Endpoints

### Autenticación

#### Login
```http
POST /api/login
Content-Type: application/json

{
  "email": "prueba@example.com",
  "password": "12345678"
}
```

**Respuesta:**
```json
{
  "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
  "token_type": "bearer",
  "expires_in": 3600
}
```

### Estudiantes

Todos los endpoints de estudiantes requieren autenticación JWT.

#### Listar estudiantes
```http
GET /api/students
Authorization: Bearer {token}
```

#### Crear estudiante
```http
POST /api/students
Authorization: Bearer {token}
Content-Type: application/json

{
  "name": "Juan Pérez",
  "email": "juan@example.com",
  "grade": "10°"
}
```

#### Ver estudiante específico
```http
GET /api/students/{id}
Authorization: Bearer {token}
```

#### Actualizar estudiante
```http
PUT /api/students/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
  "name": "Juan Carlos Pérez",
  "email": "juan.carlos@example.com",
  "grade": "11°"
}
```

#### Eliminar estudiante
```http
DELETE /api/students/{id}
Authorization: Bearer {token}
```

## Desarrollo

### Estructura de respuestas

Todas las respuestas siguen un formato consistente:

**Éxito:**
```json
{
  "data": { ... },
  "message": "Operación exitosa"
}
```

**Error:**
```json
{
  "message": "Descripción del error"
}
```

### Agregar nueva funcionalidad

1. **Crear entidad** en `app/Domain/Entities/`
2. **Definir interfaz** en `app/Domain/Repositories/`
3. **Crear DTO** en `app/Application/DTOs/`
4. **Implementar servicio** en `app/Application/Services/`
5. **Crear repositorio** en `app/Infrastructure/Repositories/`
6. **Crear controlador** en `app/Presentation/Http/Controllers/`
7. **Registrar dependencias** en `app/Providers/`

### Testing

```bash
# Ejecutar tests
php artisan test

# Ejecutar tests con coverage
php artisan test --coverage
```

## Despliegue

### Railway

El proyecto está configurado para desplegarse en Railway:

1. Conecta tu repositorio de GitHub
2. Railway detectará automáticamente la configuración
3. Agrega las variables de entorno necesarias
4. El despliegue se realizará automáticamente

### Variables de entorno para producción

```env
APP_ENV=production
APP_DEBUG=false
JWT_SECRET=tu_jwt_secret_muy_seguro
LOG_LEVEL=error
```

## Base de datos

### Migraciones

```bash
# Crear migración
php artisan make:migration create_students_table

# Ejecutar migraciones
php artisan migrate

# Revertir migración
php artisan migrate:rollback
```

### Seeders

```bash
# Ejecutar seeders
php artisan db:seed

# Ejecutar seeder específico
php artisan db:seed --class=UserSeeder
```

## Logs

Los logs se almacenan en `storage/logs/laravel.log` y incluyen:

- Intentos de login
- Operaciones CRUD de estudiantes
- Errores de validación
- Errores de aplicación

## Contribución

1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

## Licencia

Este proyecto está bajo la Licencia MIT. Ver el archivo `LICENSE` para más detalles.

##  Autores

- **Monica Ardila** - *Desarrollo inicial* - [monicaardila](https://github.com/monicaardila)

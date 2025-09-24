# Backend Genuine - API Laravel con Arquitectura Limpia

## 📋 Descripción del Proyecto

API REST desarrollada en Laravel 12 con arquitectura limpia para gestión de estudiantes, incluyendo autenticación JWT, validación de datos y despliegue en múltiples plataformas.

## 🛠️ Herramientas y Tecnologías Utilizadas

### Backend
- **Laravel 12.30.1** - Framework PHP moderno y robusto
- **PHP 8.2.12** - Versión estable con mejoras de rendimiento
- **PostgreSQL** - Base de datos relacional para persistencia de datos
- **JWT (tymon/jwt-auth)** - Autenticación stateless para APIs
- **Laravel Sanctum** - Autenticación adicional y manejo de CORS

### Arquitectura
- **Clean Architecture** - Separación clara de responsabilidades
- **DTOs (Data Transfer Objects)** - Transferencia de datos tipada
- **Form Requests** - Validación centralizada
- **Resources** - Transformación de datos para APIs
- **Services** - Lógica de negocio encapsulada

### Herramientas de Desarrollo
- **Composer** - Gestión de dependencias PHP
- **Git** - Control de versiones
- **PowerShell** - Terminal para desarrollo en Windows

### Plataformas de Despliegue (Intentadas)
- **Railway** - Plataforma cloud moderna
- **Heroku** - Plataforma tradicional para PHP
- **Render** - Alternativa moderna (evaluada)

## 🚧 Principales Desafíos y Soluciones

### 1. **Problemas de Despliegue en Railway**

**Desafío:** Railway no lograba ejecutar correctamente el servidor PHP Laravel, resultando en errores 404 persistentes en healthchecks.

**Intentos de Solución:**
- Configuración de `railway.json` con diferentes builders (NIXPACKS, DOCKERFILE)
- Creación de archivos de healthcheck personalizados (`health.php`, `simple.php`, `test.txt`)
- Modificación de `public/index.php` para manejar healthchecks directamente
- Configuración de CORS personalizada con middleware
- Uso de servidor PHP integrado vs Apache

**Resultado:** Railway demostró incompatibilidad con Laravel, requiriendo migración a otra plataforma.

### 2. **Configuración de CORS**

**Desafío:** Errores de CORS al conectar frontend con backend.

**Solución:**
- Creación de middleware personalizado `CorsMiddleware`
- Configuración en `bootstrap/app.php`
- Headers CORS apropiados para desarrollo y producción

### 3. **Validación de Datos JSON**

**Desafío:** `CreateStudentRequest` no procesaba correctamente datos JSON del frontend.

**Solución:**
- Implementación de validación manual en el controlador
- Manejo de encoding UTF-8
- Parsing directo de contenido JSON

### 4. **Arquitectura Limpia**

**Desafío:** Estructurar el proyecto siguiendo principios de Clean Architecture.

**Solución:**
- Separación en capas: Presentation, Application, Domain, Infrastructure
- Uso de DTOs para transferencia de datos
- Services para lógica de negocio
- Resources para transformación de respuestas

## 🔄 Si Pudiera Empezar de Nuevo

### 1. **Elección de Plataforma de Despliegue**
- **Empezaría con Heroku** desde el inicio por su compatibilidad probada con Laravel
- **Evitaría Railway** para proyectos PHP/Laravel
- **Consideraría Vercel** solo para APIs de Node.js

## 📚 Lo Que Aprendí del Proceso

### 1. **Despliegue en la Nube**
- **Railway** es excelente para Node.js pero problemático para PHP
- **Heroku** sigue siendo la opción más confiable para Laravel
- La configuración de healthchecks es crítica para el éxito del despliegue

### 2. **Arquitectura de Software**
- Clean Architecture mejora significativamente la mantenibilidad
- Los DTOs proporcionan type safety y claridad
- La separación de responsabilidades facilita el testing

### 3. **Desarrollo con Laravel**
- Laravel 12 introduce cambios significativos en la estructura
- El manejo de CORS requiere configuración cuidadosa
- La validación de datos JSON puede ser compleja



## 🎯 Habilidades Adicionales Relevantes

### 1. **DevOps y Despliegue**
- Experiencia con Docker y contenedores
- Configuración de CI/CD con GitHub Actions

### 2. **Arquitectura de Software**
- Patrones de diseño (Repository, Factory, Observer)
- Principios SOLID y Clean Code
- Microservicios y arquitectura distribuida


### 4. **Otras Tecnologías**
- **Node.js/Express** - Para APIs rápidas y ligeras
- **React/Vue.js** - Para frontends modernos
- **MongoDB** - Para bases de datos NoSQL
- **Redis** - Para caching y sesiones

##  Instrucciones de Instalación

### Requisitos
- PHP 8.2+
- Composer
- PostgreSQL
- Git

### Pasos
1. Clonar el repositorio
2. Instalar dependencias: `composer install`
3. Configurar `.env` con credenciales de base de datos
4. Ejecutar migraciones: `php artisan migrate`
5. Generar claves: `php artisan key:generate` y `php artisan jwt:secret`
6. Iniciar servidor: `php artisan serve`

##  Endpoints de la API

- `POST /api/register` - Registro de usuarios
- `POST /api/login` - Autenticación
- `GET /api/me` - Información del usuario autenticado
- `POST /api/logout` - Cerrar sesión
- `GET /api/students` - Listar estudiantes
- `POST /api/students` - Crear estudiante
- `GET /api/students/{id}` - Obtener estudiante
- `PUT /api/students/{id}` - Actualizar estudiante
- `DELETE /api/students/{id}` - Eliminar estudiante

##  Configuración para Despliegue

### Heroku
```bash
# Crear app en Heroku
heroku create tu-app-name

# Configurar variables de entorno
heroku config:set APP_KEY=tu-app-key
heroku config:set JWT_SECRET=tu-jwt-secret
heroku config:set DB_CONNECTION=pgsql
heroku config:set DB_URL=tu-database-url

# Desplegar
git push heroku main
```

### Railway (No Recomendado)
A pesar de múltiples intentos, Railway no logró ejecutar correctamente la aplicación Laravel.

##  Estado del Proyecto

- ✅ **Backend Local**: Funcionando correctamente
- ✅ **API Endpoints**: Implementados y probados
- ✅ **Autenticación JWT**: Configurada
- ✅ **Validación de Datos**: Implementada
- ✅ **CORS**: Configurado
- ❌ **Despliegue en Railway**: Falló después de múltiples intentos
- 🔄 **Despliegue en Heroku**: Pendiente de implementación


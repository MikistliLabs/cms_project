# CMS - Documentación e Instalación

## Descripción

Este proyecto es un CMS desarrollado en PHP con Laravel, diseñado para la gestión eficiente de contenido. Permite la administración de usuarios, roles, permisos y contenido dinámico. Además, incluye integración con  subida de archivos.


## Requisitos Previos

Antes de instalar el proyecto, asegúrate de contar con los siguientes requisitos:

- PHP >= 8.0
- Composer
- MySQL o PostgreSQL
- Laravel 10+
- Extensiones PHP necesarias: OpenSSL, pgsql, PDO, Mbstring, Tokenizer, XML, GD
- Servidor Apache o Nginx con soporte para mod\_rewrite

## Instalación

### 1. Clonar el repositorio

```bash
git clone https://github.com/usuario/repo-cms.git
cd repo-cms
```

### 2. Instalar dependencias

```bash
composer install
```

### 3. Configuración del entorno

```bash
cp .env.example .env
php artisan key:generate
```
# Base de datos
Creación del esquema y usuarios requeridos

create databaste cms;
CREATE USER reader WITH ENCRYPTED PASSWORD 'reader_pass';
CREATE USER writer WITH ENCRYPTED PASSWORD 'writer_pass';
GRANT CONNECT ON DATABASE cms TO reader,writer;
Una ves conectados al esquema cms asignaremos los respectivos permisos a los usuarios
-- asignación de permisos de lectura
GRANT USAGE ON SCHEMA public TO reader;
GRANT SELECT ON ALL TABLES IN SCHEMA public TO reader;
ALTER DEFAULT PRIVILEGES IN SCHEMA public GRANT SELECT ON TABLES TO reader;

-- asignación de permisos de escritura
GRANT USAGE, CREATE ON SCHEMA public TO writer;
GRANT SELECT, INSERT, UPDATE, DELETE ON ALL TABLES IN SCHEMA public TO writer;
ALTER DEFAULT PRIVILEGES IN SCHEMA public 
GRANT SELECT, INSERT, UPDATE, DELETE ON TABLES TO writer;

Configura las credenciales de la base de datos en el archivo `.env`. Se ocuparon 3 usuarios 1 superadministrador para realizar las migraciones correspondientes y los usuarios soplicitad en la prueba para las distintas operaciones.

DB_USERNAME_ADMIN=postgres
DB_PASSWORD_ADMIN=AdminR00t

DB_USERNAME_WRITE=writer
DB_PASSWORD_WRITE=writer_pass

DB_USERNAME_READ=reader
DB_PASSWORD_READ=reader_pass

### 4. Migraciones y Seeders

```bash
php artisan migrate --database=pgsql_admin
```
-- Despues de ejecutar las migraciones se deberan asignar los permisos a las secuencias 
--al usuario de escritura
GRANT USAGE, SELECT, UPDATE ON SEQUENCE users_id_seq TO writer;
GRANT USAGE, SELECT, UPDATE ON SEQUENCE roles_id_seq TO writer;
GRANT USAGE, SELECT, UPDATE ON SEQUENCE categories_id_seq TO writer;
GRANT USAGE, SELECT, UPDATE ON SEQUENCE articles_id_seq TO writer;
Despues se podran ejecutar los seeders con el usuario de escritura
php artisan db:seed --database=pgsql_write


### 5. Configuración de almacenamiento y enlaces simbólicos

```bash
php artisan storage:link
```
php artisan ui bootstrap --auth

### 6. Servidor de desarrollo

```bash
php artisan serve
```

Accede a `http://127.0.0.1:8000` en tu navegador.


## Configuración Adicional

### Configuración de Sesión y Cache

```ini
SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
```

### Integración de reCAPTCHA

```ini
RECAPTCHA_SITE_KEY=your_site_key
RECAPTCHA_SECRET_KEY=your_secret_key
```

### Integración de Bootstrap

```html
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
```

### Paginación

Para asegurarte de que los botones de paginación respeten los estilos de Bootstrap, agrega lo siguiente en `AppServiceProvider.php`:

```php
use Illuminate\Pagination\Paginator;

public function boot()
{
    Paginator::useBootstrap();
}
```

Esto permite que las vistas utilicen las clases de Bootstrap automáticamente.


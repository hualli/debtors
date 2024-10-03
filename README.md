# Importación de Deudores

## Descripción

Este repositorio contiene una solución diseñada para importar un archivo TXT con el listado de deudores del Banco Central de la República Argentina (BCRA). La información de deudores y entidaes se almacenará en una base de datos no relacional (MongoDB), respetando la estructura y formato requeridos.

El proyecto cuenta con un endpoint para la carga del archivo a procesar y ejecuta el procesamiento del mismo en una cola de laravel.

### **Login (Administradores y Usuarios)**
- **POST /import**: Carga el archivo a procesar:
   ```bash 
  array('file'=> new CURLFILE('url/file.txt'))
  
## Requisitos Técnicos
- **docker-compose v3**

## Cómo Ejecutar el Proyecto

- **Clonar repositorio**:
   ```bash
   git clone url_repositorio

- **En el directorio raiz ejecutar**:
   ```bash
   docker-compose up -d

- **Dentro del contenedor de PHP, instalar dependencias con composer**:
   ```bash
   composer install

- **Copiar y configurar el archivo de variables de entorno según su configuración local**:
   ```bash
   cp .env.example .env

- **Generar key en caso de ser necesario**:
   ```bash
   php artisan key:generate

- **Dentro del contenedor de PHP, ejecutar las migraciones**:
   ```bash
   php artisan migrate

- **Dentro del contenedor de PHP, ejecutar el worker**:
   ```bash
   php artisan queue:work
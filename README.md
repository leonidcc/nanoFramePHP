```markdown
# Documentación

## Introducción
Lore o um dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

## Requerimientos
- PHP 7.4.11 (puedes probar con otra versión)
- MySQL
- PHPMyAdmin recomendado

## Instalación
1. Abrir phpMyAdmin y crear una nueva base de datos importando el archivo `Template.sql` o crear la base de datos "Template" y modificar el archivo `config.php`.
2. Ir a la carpeta del proyecto y abrir una terminal de Linux o Windows.
   ```bash
   User@pc: ~/nanoFrameworkPhp$
   ```

3. Para instalar los valores por defecto de la base de datos, ejecutar:
   ```bash
   User@pc: ~/nanoFrameworkPhp$ php gen/installdb.php
   ```

4. Ejecutar para iniciar un servidor con el proyecto:
   ```bash
   User@pc: ~/nanoFrameworkPhp$ php -S localhost:3000
   ```

5. Ir al navegador a la URL [http://localhost:3000/](http://localhost:3000/).

Puedes [iniciar sesión](/ingresar) con:
- admin@gmail.com
- vendedor@gmail.com
- user@gmail.com
Contraseña: "123123"

## Estructura del proyecto MVC
- **@recursos:** Imágenes, iconos generales para el entorno.
- **assets:** Archivos estáticos para su aplicación.
- **core:** Núcleo del nanoframework, no suele modificarse.
  - **lib:** Librerías por defecto del nanoframework.
- **gen:** Script que permite generar código CRUD rápidamente. Intentar:
   ```bash
   User@pc: ~/nanoFrameworkPhp$ php core/crud.php tablatest name:string edad:int
   ```
   Levantar el servidor e ir a [tablatest](/panel/tablatest) para ver el resultado.
- **modelos:** Clases sobre las entidades que permiten interactuar con la base de datos.
- **vistas:** HTML de los componentes y páginas.
  - Basado en Archivos
  - Basado en un solo archivo .kaiwik

## Rutas
- **paginas:** Sistema de rutas basado en directorios.
  - **General:** [Home](/)
  - **Api:** [Api](/api)

## Helpers
Puedes codificar funcionalidades generales sobre todo el sistema en `/helper.class.php`.

## Avanzado
Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
```
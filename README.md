# Proyecto de Gestión de Productos

Este proyecto es una aplicación simple para gestionar productos utilizando Laravel con modelo vista y controlador, el repositorio de datos es un archivo JSON para almacenar los productos y otro archivo usuario para almacenar los usuarios pero sin modelo. Permite a los usuarios agregar, editar, eliminar y obtener información sobre productos.

## Funcionalidades

- **Agregar productos**: Permite crear nuevos productos.
- **Editar productos**: Permite modificar productos existentes.
- **Eliminar productos**: Permite eliminar productos.
- **Obtener productos**: Permite ver la lista de todos los productos o un producto específico.
- **Middleware de seguridad**: Controla el acceso a los endpoints según roles.
- **Pruebas unitarias**: Sobre el controlador y modelo de productos.

## Tecnologías Utilizadas

- Laravel version 10
- PHP version 8.1
- JSON
- Composer
- Jquery
- Bootstrap

## Estructura de archivos codificados

- app/Http/Controllers/ProductoController.php: Controlador que maneja las operaciones CRUD para productos.

- app/Http/Controllers/UserController.php: Controlador que maneja la logica de autenticacion

- app/Http/Middleware/VerifyUser.php: Middleware que verifica si el usuario esta autenticado antes de permitir el acceso a ciertas rutas

- app/Http/Middleware/VerifyRole.php: Middleware que verifica el rol del usuario admin o user antes de permitir el acceso a ciertas funciones

- app/Models/Producto.php: Modelo que representa la tabla de productos en el archivo JSON.

- resources/views/productos/index.blade.php: Vista que muestra la lista de productos.

- resources/views/login.blade.php: Vista del login

- routes/web.php: Define las rutas para login y para las operaciones CRUD de productos.

- public/js/productos.js: Script JavaScript que maneja la interacción del frontend con el CRUD de productos.

- public/js/spanish.json: Json con la traduccion para datatable.

- public/css/style.css: Estilos CSS utilizados en las vistas del CRUD de productos.

- storage/app/public/productos.json: Lista de productos en formato JSON para el modelo de entidad.

- storage/app/public/clientes.json:  Lista de clientes en formato JSON.

- tests/Unit/ProductoTest.php Prueba unitaria para el modelo de productos

- tests/Feature/ProductoControllerTest.php Prueba unitaria para el controlador de productos


## Usuarios

1. **Usuario Administrador**
   - **Nombre de usuario**: `admin`
   - **Contraseña**: `admin123`
   - **Rol**: `admin`

2. **Usuario Normal**
   - **Nombre de usuario**: `user1`
   - **Contraseña**: `user123`
   - **Rol**: `user`

## Instalación

1. cd crud-productos

2. Clona el repositorio:
   git clone https://github.com/dariocasx/crud-productos.git

3. composer install

4. reemplazar: .env.example .env

5. php artisan key:generate

6. php artisan serve

## Pruebas unitarias:
- php artisan test




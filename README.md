# Proyecto de Gestión de Productos

Este proyecto es una aplicación simple para gestionar productos utilizando Laravel con modelo vista y controlador, el repositorio de datos es un archivo JSON para almacenar los productos y otro archivo usuario para almacenar los usuarios pero sin modelo. Permite a los usuarios agregar, editar, eliminar y obtener información sobre productos.

## Funcionalidades

- **Agregar productos**: Permite crear nuevos productos.
- **Editar productos**: Permite modificar productos existentes.
- **Eliminar productos**: Permite eliminar productos.
- **Obtener productos**: Permite ver la lista de todos los productos o un producto específico.
- **Middleware de seguridad**: Controla el acceso a los endpoints según roles (solo administradores).
- **Pruebas unitarias**: Sobre el controlador y modelo de productos.

## Tecnologías Utilizadas

- Laravel version 10
- PHP version 8.1
- JSON
- Composer
- Jquery
- Bootstrap

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

1. Clona el repositorio:
   ```bash
   git clone https://github.com/dariocasx/crud-productos.git
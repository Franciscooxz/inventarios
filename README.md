# Sistema de Inventario y Mantenimiento de Productos

Este es un sistema web desarrollado en PHP y MySQL que permite gestionar el inventario y mantenimiento de productos en una empresa u organización. El sistema ofrece diversas funcionalidades para facilitar el control y seguimiento de los productos, categorías, proveedores y mantenimientos realizados.

## Características principales

- **Gestión de productos**: Permite registrar, actualizar, eliminar y buscar productos. Cada producto tiene información como código, nombre, precio, stock, categoría, imagen y última fecha de mantenimiento.
- **Categorías de productos**: Organiza los productos en diferentes categorías para una mejor clasificación y búsqueda.
- **Historial de mantenimiento**: Registra un historial detallado de los mantenimientos realizados a cada producto, incluyendo la fecha anterior, la nueva fecha, el usuario que realizó el mantenimiento y observaciones adicionales.
- **Reportes de mantenimiento**: Genera reportes de los mantenimientos realizados en un rango de fechas específico, filtrados opcionalmente por categoría de producto.
- **Búsqueda y filtrado**: Permite buscar productos por nombre o código, y filtrar la lista de productos por categoría.
- **Paginación**: La lista de productos se muestra de forma paginada para mejorar el rendimiento y la usabilidad.
- **Autenticación de usuarios**: Cuenta con un sistema de autenticación de usuarios para restringir el acceso a ciertas funcionalidades según los permisos asignados.

## Requisitos

- PHP 7.4 o superior
- MySQL 5.7 o superior
- Servidor web (Apache, Nginx, etc.)

## Instalación

1. Clona este repositorio en tu servidor web: `git clone https://github.com/tu-usuario/inventario-productos.git`
2. Importa el archivo `basededatos.sql` en tu servidor MySQL para crear la estructura de la base de datos y los datos iniciales.
3. Configura los parámetros de conexión a la base de datos en el archivo `php/main.php`.
4. Accede a la aplicación desde tu navegador web utilizando la URL correspondiente.

## Estructura de directorios

- `php/`: Contiene los archivos PHP que manejan la lógica del sistema.
- `vistas/`: Contiene los archivos HTML que conforman la interfaz de usuario.
- `css/`: Archivos CSS para estilos de la aplicación.
- `js/`: Archivos JavaScript para funcionalidades del lado del cliente.
- `img/`: Directorio para almacenar las imágenes de los productos.



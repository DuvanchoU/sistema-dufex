# Sistema de gestión **ORDER RAE** desarrollado con **Laravel** y **MySQL**.

## Descripción
Este proyecto fue construido a partir de una **base de datos real**, migrada a Laravel,
con el objetivo de implementar buenas prácticas de backend, modelado relacional
y análisis de información.

Incluye migraciones, modelos Eloquent con relaciones y vistas SQL para análisis de ventas y 
módulos CRUD completos con interfaz web, validaciones y eliminación lógica.

## Tecnologías utilizadas
- Laravel - PHP - MySQL - Eloquent ORM - Git & GitHub - Tailwind CSS 

## Base de datos
- Migraciones generadas desde una base de datos existente.
- Relaciones entre productos, ventas, compras, clientes, inventario y producción.
- Uso de llaves foráneas y tablas intermedias.
- Soporte de eliminación lógica (SoftDeletes) en entidades clave.
- Timestamps gestionados automáticamente para auditoría.

## Módulos implementados
Gestión de Productos:
- Creación, lectura, actualización y eliminación lógica.
- Relación con categorías.
- Validación de campos (código único, precio, etc.).
- Interfaz con Tailwind CSS y mensajes de usuario.

Gestión de Categorías
- CRUD completo con estado (activo/inactivo).
- Prevención de eliminación si tiene productos asociados.
- Integración con el módulo de productos.
- 
## Vistas SQL incluidas
- Ventas diarias
- Ventas semanales
- Ventas mensuales
- Ventas anuales
- Productos más vendidos
- Compras por cliente

## Autor
**Duvan Felipe Uribe**  
Estudiante de Análisis y Desarrollo de Software (SENA)  
Enfocado en desarrollo backend con Laravel y bases de datos relacionales.

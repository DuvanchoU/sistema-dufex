# 🛒 DUFEX — Sistema de Gestión Comercial ERP
> *Orden que vende — Desarrollado por Duvan Felipe Uribe Tejada*

---

## 📋 Descripción General

DUFEX es un sistema de gestión comercial integral (ERP) desarrollado desde cero para pequeñas y medianas empresas del sector muebles y hogar. Es una solución completa que automatiza y optimiza todos los procesos comerciales de una empresa, desde el control de inventario hasta la gestión de ventas, compras, producción y usuarios.

El sistema cuenta con una interfaz moderna, responsive y profesional, basada en filtros multicriterio horizontales, dashboard visual con métricas clave, modo oscuro, y control de acceso granular por roles y permisos.

---

## 📦 Módulos Implementados

| Módulo | Funcionalidad Principal |
|--------|------------------------|
| **Dashboard** | Panel de control con métricas y gráficos |
| **Productos** | Gestión de catálogo, categorías y stock |
| **Inventario** | Control de bodegas y movimientos |
| **Compras** | Proveedores y órdenes de compra |
| **Ventas** | Pedidos, facturación y reportes |
| **Producción** | Planificación y seguimiento |
| **Clientes** | CRM con historial de compras |
| **Usuarios & Roles** | Control de acceso granular |

---

## 🏗️ Arquitectura y Tecnologías

### 🔙 Backend
- **Laravel 12** — Framework PHP moderno y escalable
- **Eloquent ORM** — Relaciones complejas (belongsTo, hasMany, belongsToMany)
- **Spatie Permission** — Control de acceso por roles y permisos
- **Soft Deletes** — Eliminación lógica en entidades críticas
- **Form Requests** — Validaciones centralizadas
- **Middleware** — Protección de rutas
- **Migraciones y Seeders** — Base de datos versionada
- **Vistas SQL** — Consultas optimizadas para reportes

### 🎨 Frontend
- **Tailwind CSS** — Diseño moderno y responsive
- **Blade Templates** — Vistas modulares y reutilizables
- **Chart.js** — Gráficos dinámicos en dashboard
- **Feather Icons** — Iconografía profesional
- **Modo Oscuro/Claro** — Toggle con persistencia

### 🗄️ Base de Datos
- **MySQL** — Base de datos relacional
- **MySQL Workbench** — Diseño y gestión
- **Relaciones complejas** — Integridad referencial

---

## 🌟 Características Principales

### 🔍 Filtros Multicriterio Avanzados

Cada módulo incluye un panel de filtros horizontal para búsqueda avanzada:

**Productos:** categoría, precio, stock, estado  
**Compras:** proveedor, usuario, método de pago, estado, fecha, total  
**Ventas:** cliente, usuario, método de pago, estado, fecha, total  
**Pedidos:** cliente, estado, fecha, total  

**Tipos de filtros:**
- ✅ Búsqueda por texto parcial
- ✅ Rangos de fechas
- ✅ Estados (activo, pendiente, completado, etc.)
- ✅ Relaciones entre entidades
- ✅ Rangos numéricos (precios, cantidades, totales)

### 🌓 Modo Oscuro / Claro

DUFEX incluye un sistema completo de temas con:

- **Toggle de modo** en el sidebar para cambiar entre Light/Dark Mode
- **Logo dinámico** que se adapta automáticamente al tema seleccionado
- **Colores optimizados** para mejor legibilidad en ambos modos
- **Persistencia del tema** en localStorage para mantener la preferencia del usuario

**Mejoras de UI/UX:**
- ✅ Tablas minimalistas y estrechas para mejor legibilidad
- ✅ Botón "VER" con color distintivo `#B3B792`
- ✅ Header de BODEGAS con tono blanco-gris
- ✅ Mensajes de éxito/error centrados y visibles
- ✅ Elementos de interfaz con tonos grises y neutros

### 🔐 Control de Acceso por Roles y Permisos

Sistema de autorización avanzado basado en Spatie Permissions:

- **Roles configurables** (Gerente, Asesor, Jefe Logístico, etc.)
- **Permisos por acción** (ver, crear, editar, eliminar)
- **Permisos específicos:** `ver_compras`, `eliminar_compras`, `ver_productos`, `ver_roles`, `ver_ventas`, `ver_todos_pedidos`, `editar_roles`
- **Sidebar dinámico** que muestra solo los módulos permitidos
- **Nombre y rol del usuario** visibles en la interfaz

### ♻️ Eliminación Lógica y Auditoría

Todos los módulos principales soportan `SoftDeletes`, manteniendo integridad referencial y permitiendo recuperación de registros:

- `Categoria`, `Producto`, `Bodega`, `Cliente`
- `Venta`, `Compra`, `Inventario`, `Pedido`, `Producción`

### 🔗 Relaciones Complejas entre Modelos

Ejemplos:
- **Producto** → Categoría, Inventario, DetalleVenta, DetalleCompra
- **Pedido** → Cliente, Usuario, Venta
- **Compra** → Proveedor, Usuario, DetalleCompra
- **Inventario** → Producto, Bodega, Proveedor

---

## 👨‍💻 Autor

**Duvan Felipe Uribe Tejada**  
🎓 Estudiante de Tecnólogo en Análisis y Desarrollo de Software — SENA  
📍 Colombia | Bogotá  
📧 duvanfuribe@gmail.com  
🔗 [LinkedIn](https://www.linkedin.com/in/duvan-felipe-uribe-758303359/)  
💼 [Computrabajo](https://candidato.co.computrabajo.com/candidate/cv/edit/?idapp=3&f=FEE939887FF3D46C)

---

## 🎯 Buscando Oportunidades

Estoy activamente buscando oportunidades como:
- 🎓 **Practicante** en desarrollo de software
- 🎓 **Pasante** en proyectos tecnológicos  
- 👨‍💻 **Desarrollador Junior** Full Stack

**¿Qué ofrezco?**
- ✨ Actitud proactiva y hambre de aprender
- 🤝 Facilidad para trabajo en equipo
- 🐛 Resolución efectiva de problemas
- 💡 Comprensión de procesos de negocio reales (muebles, textiles, construcción)
- 🚀 Capacidad para aportar desde el primer día con Laravel y arquitectura MVC

---

> 🚀 **DUFEX** es el núcleo de un sistema comercial en evolución, que seguiré desarrollando hasta convertirlo en un software listo para el mercado. Cada línea de código refleja mi compromiso con la calidad, la escalabilidad y la solución de problemas reales para diferentes sectores.

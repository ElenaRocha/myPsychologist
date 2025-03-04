# MyPsychologist

Este es un proyecto basado en **Laravel 10** y **Vue 3**, diseñado para facilitar el desarrollo de aplicaciones web modernas enfocadas en la gestión de servicios profesionales por horas, como pueden ser sesines de psicología. 

## 🚀 Tecnologías utilizadas
- **Laravel 10** → Framework de PHP para el backend.
- **Vue 3** → Framework de JavaScript para el frontend.
- **Sanctum** → Autenticación API en Laravel.
- **MySQL** → Base de datos.
- **Vite** → Servidor de desarrollo para el frontend.
- **TailwindCSS** → Estilos CSS.

## 📌 Funcionalidades principales
- **Usuarios Clientes**:
  - Registro e inicio de sesión.
  - Reserva de bonos de sesiones (5 o 10 sesiones).
  - Reserva de sesiones individuales o usando bonos.
  - Consulta de sesiones anteriores y futuras.

- **Usuarios Administradores**:
  - Gestión de clientes (crear, modificar, eliminar).
  - Gestión de bonos y sesiones de clientes.
  - Acceso a información de contacto de los clientes.

## 📋 Requisitos previos
Antes de clonar y ejecutar este proyecto, asegúrate de tener instalado en tu sistema:

- **PHP 8.2 o superior** → Puedes instalarlo con [XAMPP](https://www.apachefriends.org/index.html) o de manera independiente.
- **Composer** → [Descargar Composer](https://getcomposer.org/)
- **Node.js 18 o superior** → [Descargar Node.js](https://nodejs.org/)
- **Git** → [Descargar Git](https://git-scm.com/)
- **MySQL** → Incluido en XAMPP o instalarlo por separado.

## 📦 Instalación
Sigue estos pasos para clonar y configurar el proyecto:

1. **Clonar el repositorio**
```sh
git clone https://github.com/TU-USUARIO/myPsychologist.git
cd myPsychologist
```

2. **Instalar dependencias de PHP**
```sh
composer install
```

3. **Instalar dependencias de JavaScript**
```sh
npm install
```

4. **Configurar variables de entorno**
```sh
cp .env.example .env
```
Después, abre el archivo `.env` y configura la conexión a tu base de datos:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nombre_de_tu_base_de_datos
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

5. **Generar la clave de la aplicación**
```sh
php artisan key:generate
```

6. **Ejecutar migraciones y seeders (opcional)**
```sh
php artisan migrate --seed
```

## 🎮 Cómo ejecutar el proyecto
### 🚀 Ejecutar el backend (Laravel)
```sh
php artisan serve
```
Esto iniciará el servidor de Laravel en `http://127.0.0.1:8000`

### 🎨 Ejecutar el frontend (Vue + Vite)
```sh
npm run dev
```
Esto iniciará Vite y el frontend estará disponible en `http://127.0.0.1:5173`

## ⚡ Opcional: Usar XAMPP
Si prefieres usar **XAMPP**, simplemente:
- Inicia Apache y MySQL desde el panel de control de XAMPP.
- Configura la base de datos en `phpMyAdmin` (`http://localhost/phpmyadmin`).
- Asegúrate de que el puerto de MySQL en el archivo `.env` coincida con el de XAMPP (`3306` por defecto).

## 🤝 Contribuciones
Si deseas contribuir a este proyecto:
1. Haz un **fork** del repositorio.
2. Crea una nueva **rama** con tu funcionalidad (`git checkout -b nueva-funcionalidad`).
3. **Confirma** tus cambios (`git commit -m "Descripción de cambios"`).
4. **Haz push** a la rama (`git push origin nueva-funcionalidad`).
5. Abre un **pull request** en GitHub.

## 📜 Licencia
Este proyecto está bajo la licencia [MIT](https://opensource.org/licenses/MIT).

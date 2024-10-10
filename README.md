# Task Manager

Este es un proyecto de administración de tareas, donde los usuarios pueden agregar, ver, completar y eliminar tareas. Utiliza PHP y MySQL para la gestión de datos.

## Requisitos

- PHP >= 7.0
- MySQL
- Apache (o cualquier otro servidor web que soporte PHP)
- Bootstrap (se incluye mediante CDN)

## Instalación

Sigue estos pasos para clonar e instalar el proyecto en tu computadora local:

1. **Clona el repositorio:**

   ```bash
   git clone <URL_DEL_REPOSITORIO>


2. **Copia el proyecto a tu servidor web:**

   ```bash
   Coloca la carpeta del proyecto en el directorio de tu servidor web. Por ejemplo, si usas XAMPP, colócala en C:\xampp\htdocs\task_manager.


3.Crea la base de datos:
    ```bash
    Accede a tu cliente de MySQL (como phpMyAdmin) y ejecuta el siguiente comando para crear la base de datos:
    CREATE DATABASE task_manager;

4. Importa el esquema de la base de datos:
 ```bash
-- Crear la tabla de usuarios (users)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL
);

CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    priority ENUM('low', 'medium', 'high') NOT NULL,
    status ENUM('pending', 'completed') DEFAULT 'pending',
    user_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
//crea un usuario
INSERT INTO users (name, email, password) VALUES ('Usuario de Prueba', 'test@test.com', '12345');

5. Configura la conexión a la base de datos:

Abre el archivo db.php y ajusta las siguientes variables si es necesario:
$host = 'localhost'; // Cambia si usas otro host
$port = '3306'; // Cambia si usas otro puerto
$dbname = 'task_manager'; // Nombre de la base de datos
$user = 'root'; // Usuario de la base de datos
$pass = ''; // Contraseña de la base de datos

6.Accede a la aplicación:
Abre tu navegador web y visita http://localhost/task_manager para acceder a la aplicación.

USO
1.Inicia sesión con tus credenciales o regístrate si es la primera vez que accedes.
2.Agrega nuevas tareas, visualiza tareas existentes, marca tareas como completadas o elimínalas según sea necesario.
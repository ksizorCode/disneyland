-- Crear la base de datos (si no existe)
CREATE DATABASE IF NOT EXISTS todo_app;

-- Usar la base de datos
USE todo_app;

-- Crear la tabla para la lista de tareas
CREATE TABLE IF NOT EXISTS miTODOlist (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descripcion TEXT,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    fecha_vencimiento DATE,
    prioridad ENUM('baja', 'media', 'alta') DEFAULT 'media',
    estado ENUM('pendiente', 'en_progreso', 'completada') DEFAULT 'pendiente'
);

-- Añadir algunos datos de ejemplo (opcional)
INSERT INTO miTODOlist (titulo, descripcion, fecha_vencimiento, prioridad) VALUES
('Completar proyecto PHP', 'Finalizar la aplicación de lista de tareas y enviarla', DATE_ADD(CURRENT_DATE, INTERVAL 7 DAY), 'alta'),
('Comprar comestibles', 'Leche, huevos, pan y verduras', DATE_ADD(CURRENT_DATE, INTERVAL 1 DAY), 'media'),
('Llamar al dentista', 'Programar revisión anual', DATE_ADD(CURRENT_DATE, INTERVAL 3 DAY), 'baja');
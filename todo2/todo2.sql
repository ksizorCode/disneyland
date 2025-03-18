-- Crear la base de datos (si no existe)
CREATE DATABASE IF NOT EXISTS todo_app;

-- Usar la base de datos
USE todo_app;

-- Crear la tabla para la lista de tareas con las mejoras solicitadas
CREATE TABLE IF NOT EXISTS miTODOlist (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descripcion TEXT,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    fecha_vencimiento DATE,
    hora_vencimiento TIME DEFAULT NULL,
    prioridad ENUM('baja', 'media', 'alta') DEFAULT 'media',
    estado ENUM('pendiente', 'en_progreso', 'completada') DEFAULT 'pendiente',
    asignado_a VARCHAR(100) DEFAULT NULL
);

-- Añadir algunos datos de ejemplo (opcional)
INSERT INTO miTODOlist (titulo, descripcion, fecha_vencimiento, hora_vencimiento, prioridad, asignado_a) VALUES
('Completar proyecto PHP', 'Finalizar la aplicación de lista de tareas y enviarla', DATE_ADD(CURRENT_DATE, INTERVAL 7 DAY), '18:00:00', 'alta', 'María González'),
('Comprar comestibles', 'Leche, huevos, pan y verduras', DATE_ADD(CURRENT_DATE, INTERVAL 1 DAY), '13:30:00', 'media', 'Juan Pérez'),
('Llamar al dentista', 'Programar revisión anual', DATE_ADD(CURRENT_DATE, INTERVAL 3 DAY), '10:00:00', 'baja', 'Ana Rodríguez'),
('Reunión de equipo', 'Discutir avances del proyecto y asignar nuevas tareas', DATE_ADD(CURRENT_DATE, INTERVAL 2 DAY), '09:00:00', 'alta', 'Carlos López'),
('Actualizar documentación', 'Revisar y actualizar la documentación del proyecto según las últimas modificaciones', DATE_ADD(CURRENT_DATE, INTERVAL 5 DAY), '17:00:00', 'media', 'Laura Martínez');
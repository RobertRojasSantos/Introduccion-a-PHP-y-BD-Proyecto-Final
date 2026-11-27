
CREATE DATABASE IF NOT EXISTS prueba_web CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE prueba_web;


CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL
);


INSERT INTO usuarios (nombre, email) VALUES 
('Carlos Mendoza', 'carlos@gmail.com'),
('Diego Torres', 'diego@gmail.com'),
('Jimena Vargas', 'jimena@gmail.com'),
('Robert Rojas', 'robert@gmail.com'),
('Lucia Fernandez', 'lucia@gmail.com'),
('Mateo Silva', 'mateo@gmail.com');

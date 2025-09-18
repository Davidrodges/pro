
CREATE DATABASE IF NOT EXISTS pro;


USE pro;


CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


INSERT INTO users (name, email) VALUES
('David Rodgers', 'david.rodgy@gmail.com'),
('Davina Rihannah', 'davina.rihannah@gmail.com'),
('Maria Sasha', 'maria.sasha@gmail.com');

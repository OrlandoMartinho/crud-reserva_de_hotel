CREATE DATABASE `reservas_de_hoteis`;

USE `reservas_de_hoteis`;

CREATE TABLE `usuarios` (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  senha VARCHAR(255) NOT NULL,
  tipo VARCHAR(20)  DEFAULT NULL
);

CREATE TABLE `reservas` (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  checkin DATE NOT NULL,
  checkout DATE NOT NULL,
  quarto VARCHAR(20) NOT NULL
);

INSERT INTO usuarios (nome, email, senha)
VALUES
    ('Admin', 'admin@example.com', '12345678');



-- Script de Criação do Banco de Dados e Tabela para a Fase 2
CREATE DATABASE IF NOT EXISTS todo_db CHARACTER SET utf8 COLLATE utf8_general_ci;
USE todo_db;

CREATE TABLE IF NOT EXISTS tarefas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    status VARCHAR(50) DEFAULT 'Pendente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

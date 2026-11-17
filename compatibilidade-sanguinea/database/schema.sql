CREATE DATABASE IF NOT EXISTS administrador_compatibilidade_sanguinea
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE administrador_compatibilidade_sanguinea;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    tipo_sanguineo ENUM('A+','A-','B+','B-','AB+','AB-','O+','O-') NOT NULL,
    criado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB;


CREATE TABLE IF NOT EXISTS consultas (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    usuario_id INT UNSIGNED NOT NULL,
    tipo1 ENUM('A+','A-','B+','B-','AB+','AB-','O+','O-') NOT NULL,
    tipo2 ENUM('A+','A-','B+','B-','AB+','AB-','O+','O-') NOT NULL,
    gestante ENUM('tipo1','tipo2','usuario','outra') NOT NULL,
    origem ENUM('consulta','explorar') NOT NULL,
    criado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY idx_consultas_usuario (usuario_id),
    CONSTRAINT fk_consultas_usuario
        FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS tentativas_login (
    chave CHAR(64) NOT NULL,
    tentativas INT UNSIGNED NOT NULL DEFAULT 0,
    primeira_tentativa DATETIME NOT NULL,
    atualizado_em DATETIME NOT NULL,
    PRIMARY KEY (chave),
    KEY idx_tentativas_atualizado (atualizado_em)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

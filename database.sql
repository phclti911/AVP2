CREATE DATABASE IF NOT EXISTS recrutamento;
USE recrutamento;

CREATE TABLE vagas (
    id CHAR(36) PRIMARY KEY,
    empresa VARCHAR(255) NOT NULL,
    titulo VARCHAR(255) NOT NULL,
    descricao TEXT,
    localizacao CHAR(1) NOT NULL,
    nivel INT NOT NULL
);

CREATE TABLE pessoas (
    id CHAR(36) PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    profissao VARCHAR(255) NOT NULL,
    localizacao CHAR(1) NOT NULL,
    nivel INT NOT NULL
);

CREATE TABLE candidaturas (
    id CHAR(36) PRIMARY KEY,
    id_vaga CHAR(36) NOT NULL,
    id_pessoa CHAR(36) NOT NULL,
    UNIQUE (id_vaga, id_pessoa),
    FOREIGN KEY (id_vaga) REFERENCES vagas(id),
    FOREIGN KEY (id_pessoa) REFERENCES pessoas(id)
);
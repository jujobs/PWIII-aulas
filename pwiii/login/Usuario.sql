CREATE DATABASE Usuarioetimpwiii;
USE Usuarioetimpwiii;
CREATE TABLE Usuarios (
    id    INT AUTO_INCREMENT PRIMARY KEY,
    nome  VARCHAR(50)  NOT NULL,
    email VARCHAR(100) NOT NULL,
    senha VARCHAR(32)  NOT NULL
)
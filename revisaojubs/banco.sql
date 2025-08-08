CREATE DATABASE etimrevisao;
USE etimrevisao;
CREATE TABLE revisao(
    id int primary key auto_increment,
    nome varchar(30),
    senha varchar(32)
);

INSERT INTO revisao SET nome = "Admin", senha = "123";
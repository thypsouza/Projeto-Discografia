CREATE DATABASE testesupliu;


CREATE TABLE album(
	id INT PRIMARY KEY AUTO_INCREMENT,
        nome VARCHAR(60),
        ano SMALLINT
);

CREATE TABLE faixa(
    id INT PRIMARY KEY AUTO_INCREMENT,
    numero INT,
    nome VARCHAR(60),
    duracao VARCHAR(25),
    album_id INT,
    CONSTRAINT fk_album FOREIGN KEY (album_id) REFERENCES album(id)
);
CREATE DATABASE IF NOT EXISTS livreor;
USE livreor;

CREATE TABLE utilisateurs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    login VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE commentaires (
    id INT PRIMARY KEY AUTO_INCREMENT,
    commentaire TEXT NOT NULL,
    id_utilisateur INT NOT NULL,
    date DATETIME NOT NULL
);

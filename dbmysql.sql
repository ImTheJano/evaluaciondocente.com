DROP DATABASE IF EXISTS evaluaciondocente;
CREATE DATABASE evaluaciondocente;
USE evaluaciondocente;
DROP TABLE IF EXISTS usuario;
CREATE TABLE usuario(
	id INT AUTO_INCREMENT,
	nombre VARCHAR(50),
	apPaterno VARCHAR(50),
	apMaterno VARCHAR(50),
	sexo VARCHAR(1),
	fechaNac DATE,
	usuario VARCHAR(15),
	pswd VARCHAR(100),
	PRIMARY KEY (id),
	UNIQUE KEY (usuario)
);
INSERT INTO usuario VALUES
(1,'Alejandro','Garcia','Montiel','m','1992/19/02','imthejano','123'),
(2,'Israel','Fidel','Antonio','m','1992/19/02','fidel','123');
DROP TABLE IF EXISTS infoAlumno;
CREATE TABLE infoAlumno(
	id INT,
	matricula VARCHAR(10),
	turno VARCHAR(1),
	carrera VARCHAR(30),
	grupo VARCHAR(5),
	PRIMARY KEY (id),
	UNIQUE KEY (matricula),
	FOREIGN KEY (id) REFERENCES usuario (id)
);
INSERT INTO infoAlumno VALUES
(1,'20141878','v','isc','8s21'),
(2,'20141879','v','isc','8s21');

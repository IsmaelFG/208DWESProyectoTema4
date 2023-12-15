-- Crea la base de datos DB208DWESProyectoTema4
CREATE DATABASE IF NOT EXISTS DB208DWESProyectoTema4;

-- Selecciona la base de datos recién creada
USE DB208DWESProyectoTema4;

-- Crea la tabla Departamento
CREATE TABLE IF NOT EXISTS T02_Departamento (
    T02_CodDepartamento CHAR(3) NOT NULL,
    T02_DescDepartamento VARCHAR(255),
    T02_FechaCreacionDepartamento DATETIME,
    T02_VolumenDeNegocio FLOAT,
    T02_FechaBajaDepartamento DATETIME,
    PRIMARY KEY (T02_CodDepartamento)
);

-- Crear usuario y dar privilegios
CREATE USER 'user208DWESProyectoTema4'@'%' IDENTIFIED BY 'paso';
GRANT ALL PRIVILEGES ON DB208DWESProyectoTema4.* TO 'user208DWESProyectoTema4';

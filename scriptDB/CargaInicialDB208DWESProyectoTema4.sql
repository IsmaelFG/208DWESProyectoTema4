-- Selecciona la base de datos DB208DWESProyectoTema4
USE DB208DWESProyectoTema4;

-- Inserta algunos datos de ejemplo en la tabla Departamento
INSERT INTO T02_Departamento (T02_CodDepartamento, T02_DescDepartamento, T02_FechaCreacionDepartamento, T02_VolumenNegocio, T02_FechaBaja) VALUES
('DVT', 'Departamento de Ventas', '2022-05-10 08:30:00', 100000.50, NULL),
('DMT', 'Departamento de Marketing', '2021-11-23 14:45:00', 75000.25, NULL),
('DRH', 'Departamento de Recursos Humanos', '2023-02-15 10:00:00', 60000.75, NULL),
('DFN', 'Departamento de Finanzas', '2022-08-03 12:15:00', 90000.90, NULL);
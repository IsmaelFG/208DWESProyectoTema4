<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>codigo05</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="/208DWESProyectoTema3/webroot/css/style.css">
        <style>
            body {
                margin-top: 70px;
                margin-bottom: 100px;
                font-family: Arial, sans-serif;
            }

            .navbar {
                background-color: #007BFF;
            }

            .navbar-brand {
                color: #fff;
            }

            h1 {
                text-align: center;
            }

            form {
                max-width: 500px;
                margin: 0 auto;
                padding: 20px;
                border: 1px solid #ccc;
                border-radius: 5px;
                background-color: #f9f9f9;
            }

            label {
                display: block;
                margin-bottom: 10px;
            }
            #f_actual{
                background-color: #bbb;
                color: black;
            }
            input[type="text"],
            select {
                width: 200px;
                padding: 10px;
                margin-bottom: 15px;
                border: 1px solid #ccc;
                border-radius: 5px;
            }
            input[type="text"],
            .radioq
            select {
                width: 200px;
                padding: 10px;
                margin-bottom: 15px;
                border: 1px solid #ccc;
                border-radius: 5px;
            }

            .obligatorio{
                background-color: #f5ec78;
            }

            input[type="radio"] {
                margin: 10px;
            }
            .radio {
                display: flex; /* Hace que los elementos radio se muestren en línea */
                align-items: center; /* Centra verticalmente los elementos radio */
            }

            .radio input[type="radio"] {
                margin-right: 10px; /* Agrega un margen derecho entre los elementos radio */
                width: auto; /* Ancho automático para evitar que los elementos se expandan */
            }
            input{
                min-width: 20px;
            }

            input[type="reset"],
            input[type="submit"] {
                background-color: #007BFF;
                color: #fff;
                padding: 10px 20px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                margin-top: 20px;
                margin-right: 20px;

            }
            .error{
                color: red;
            }
            input[type="reset"]:hover,
            input[type="submit"]:hover {
                background-color: #0056b3;
            }
        </style>
    </head>
    <body style="margin-top:70px; margin-bottom: 100px">
        <nav class="navbar navbar-expand-lg bg-primary fixed-top">
            <div class="container">
                <a class="navbar-brand text-white" href="/index.html">Ejercicio05</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>
        <?php
        $dsn = 'mysql:host=192.168.20.19;dbname=DB208DWESProyectoTema4';
        $username = 'user208DWESProyectoTema4';
        $password = 'paso';
        include_once('../core/231018libreriaValidacion.php');
        define('FECHA_ACTUAL', date('Y-m-d H:i:s'));
        $entradaOK = true;
        try {
            // Conexion con la Base de datos
            $miDB = new PDO($dsn, $username, $password);
            // Configuramos las excepciones
            $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // Deshabilitamos el modo autocommit
            $miDB->beginTransaction();
            // Consultas SQL de inserción 
            $consultaInsercion = "INSERT T02_Departamento(T02_CodDepartamento, T02_DescDepartamento, T02_FechaCreacionDepartamento, T02_VolumenNegocio, T02_FechaBaja) "
                    . "VALUES (:CodDepartamento, :DescDepartamento, :FechaCreacionDepartamento, :VolumenNegocio, :FechaBaja)";

            // Preparamos las consultas
            $resultadoconsultaInsercion = $miDB->prepare($consultaInsercion);

            // array con los registros a añadir
            $aDepartamentosNuevos = [
                ['CodDepartamento' => 'STM', 'DescDepartamento' => 'Departamento de Sistemas', 'FechaCreacionDepartamento' => FECHA_ACTUAL, 'VolumenNegocio' => 550, 'FechaBaja' => null],
                ['CodDepartamento' => 'FNT', 'DescDepartamento' => 'Departamento de Fuentes', 'FechaCreacionDepartamento' => FECHA_ACTUAL, 'VolumenNegocio' => 100, 'FechaBaja' => null]
            ];
            //Recorremos los registros que vamos a insertar en la tabla
            foreach ($aDepartamentosNuevos as $departamento) {
                $aResgistros = [':CodDepartamento' => $departamento['CodDepartamento'],
                    ':DescDepartamento' => $departamento['DescDepartamento'],
                    ':FechaCreacionDepartamento' => $departamento['FechaCreacionDepartamento'],
                    ':VolumenNegocio' => $departamento['VolumenNegocio'],
                    ':FechaBaja' => $departamento['FechaBaja']];
                if (!$resultadoconsultaInsercion->execute($aResgistros)) {
                    $entradaOK = false;
                    break;
                }
            }
            if ($entradaOK) {
                // Confirma los cambios
                $miDB->commit();
                echo ("<div class='respuestaCorrecta'>Los datos se han insertado correctamente en la tabla Departamento.</div>");

                // Preparamos y ejecutamos la consulta SQL
                $consulta = "SELECT * FROM T02_Departamento";
                $resultadoConsultaPreparada = $miDB->prepare($consulta);
                $resultadoConsultaPreparada->execute();

                // Tabla para mostrar los resultados
                echo ("<div class='list-group text-center'>");
                echo ("<table>
                                    <thead>
                                    <tr>
                                        <th>Codigo de Departamento</th>
                                        <th>Descripcion de Departamento</th>
                                        <th>Fecha de Creacion</th>
                                        <th>Volumen de Negocio</th>
                                        <th>Fecha de Baja</th>
                                    </tr>
                                    </thead>");

                //Recorremos todos los valores de la tabla, columna por columna, usando fetchObject() , 
                echo ("<tbody>");
                while ($oDepartamento = $resultadoConsultaPreparada->fetchObject()) {
                    echo ("<tr>");
                    echo ("<td>" . $oDepartamento->T02_CodDepartamento . "</td>");
                    echo ("<td>" . $oDepartamento->T02_DescDepartamento . "</td>");
                    echo ("<td>" . $oDepartamento->T02_FechaCreacionDepartamento . "</td>");
                    echo ("<td>" . $oDepartamento->T02_VolumenNegocio . "</td>");
                    echo ("<td>" . $oDepartamento->T02_FechaBaja . "</td>");
                    echo ("</tr>");
                }

                echo ("</tbody>");
            }
        } catch (PDOException $miExcepcionPDO) {
            //Revierte los cambios si algo sale mal
            // Almacenamos el código del error de la excepción en la variable '$errorExcepcion'
            // Almacenamos el mensaje de la excepción en la variable '$mensajeExcepcion'
            $miDB->rollback();
            $errorExcepcion = $miExcepcionPDO->getCode();
            $mensajeExcepcion = $miExcepcionPDO->getMessage();

            echo ("<div class='errorException'>Hubo un error al insertar los datos en la tabla Departamento.<br></div>");
            echo "<span class='errorException'>Error: </span>" . $mensajeExcepcion . "<br>";
            echo "<span class='errorException'>Código del error: </span>" . $errorExcepcion;
        } finally {
            //Cerramos la conexion
            unset($miDB);
        }
        ?>
        <footer class="bg-primary text-light py-4 fixed-bottom">
            <div class="container">
                <div class="row">
                    <div class="col text-center text-white">
                        <a href="/index.html">
                            <p class="text-white">&copy; 2023/24 Ismael Ferreras
                                García. Todos los derechos
                                reservados.</p>
                        </a>
                    </div>
                    <div class="col text-end">
                        <a href="../indexProyectoTema4.html">
                            <img src="/webroot/imagenes/casa-removebg-preview.png" alt="Home" width="35" height="35">
                        </a>
                        <a href="https://github.com/IsmaelFG" target="_blank">
                            <img src="/webroot/imagenes/github-removebg-preview.png" alt="GitHub" width="35" height="35">
                        </a>
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>

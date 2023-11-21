<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>codigo04</title>
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
                <a class="navbar-brand text-white" href="/index.html">Ejercicio04</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>

        <?php
        try {
            $dsn = 'mysql:host=192.168.20.19;dbname=DB208DWESProyectoTema4';
            $username = 'user208DWESProyectoTema4';
            $password = 'paso';
            include_once('../core/231018libreriaValidacion.php');
            $miDB = new PDO($dsn, $username, $password);
            $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Configuramos las excepciones
            //TRANSACCION
            // Deshabilitamos el modo autocommit
            $miDB->beginTransaction();

            // Consultas SQL de inserción 
            $consultaInsercion1 = "INSERT INTO T02_Departamento(T02_CodDepartamento,T02_DescDepartamento,T02_VolumenNegocio) VALUES ('DOF', 'Departamento de Ofimatica', 500)";
            $consultaInsercion2 = "INSERT INTO T02_Departamento(T02_CodDepartamento,T02_DescDepartamento,T02_VolumenNegocio) VALUES ('DID', 'Departamento de I+D', 200)";
            $consultaInsercion3 = "INSERT INTO T02_Departamento(T02_CodDepartamento,T02_DescDepartamento,T02_VolumenNegocio) VALUES ('DGT', 'Departamento de Gestion', 1000)";

            // Preparamos las consultas
            $resultadoconsultaInsercion1 = $miDB->prepare($consultaInsercion1);
            $resultadoconsultaInsercion2 = $miDB->prepare($consultaInsercion2);
            $resultadoconsultaInsercion3 = $miDB->prepare($consultaInsercion3);

            // Ejecuto las consultas preparadas y mostramos la tabla en caso 'true' o un mensaje de error en caso de 'false'.
            // (La función 'execute()' devuelve un valor booleano que indica si la consulta se ejecutó correctamente o no.)
            if ($resultadoconsultaInsercion1->execute() && $resultadoconsultaInsercion2->execute() && $resultadoconsultaInsercion3->execute()) {
                $miDB->commit(); // Confirma los cambios y los consolida
                echo ("<div class='respuestaCorrecta'>Los datos se han insertado correctamente en la tabla Departamento.</div>");

                // Preparamos y ejecutamos la consulta SQL
                $consulta = "SELECT * FROM T02_Departamento";
                $resultadoConsultaPreparada = $miDB->prepare($consulta);
                $resultadoConsultaPreparada->execute();

                // Creamos una tabla en la que mostraremos la tabla de la BD
                echo ("<div class='list-group text-center'>");
                echo ("<table>
                                        <thead>
                                        <tr>
                                            <th>CodDepartamento</th>
                                            <th>DescDepartamento</th>
                                            <th>FechaBaja</th>
                                            <th>VolumenNegocio</th>
                                        </tr>
                                        </thead>");

                // Aqui recorremos todos los valores de la tabla, columna por columna, usando fetchObject()
                echo ("<tbody>");
                while ($oDepartamento = $resultadoConsultaPreparada->fetchObject()) {
                    echo ("<tr>");
                    echo "<td>$oDepartamento->T02_CodDepartamento</td>"; //Obtener los códigos.
                    echo "<td>$oDepartamento->T02_DescDepartamento</td>"; //Obtener las descripciones.
                    echo "<td>$oDepartamento->T02_FechaCreacionDepartamento</td>"; //Obtener la fecha de creacion
                    echo "<td>$oDepartamento->T02_VolumenNegocio</td>"; //Obtener el volumen de negocio.
                    echo "<td>$oDepartamento->T02_FechaBaja</td>"; //Obtener la fecha de baja.
                    echo ("</tr>");
                }

                echo ("</tbody>");
            }
        } catch (PDOException $miExcepcionPDO) {
            $miDB->rollback(); //  Revierte o deshace los cambios
            $errorExcepcion = $miExcepcionPDO->getCode(); // Almacenamos el código del error de la excepción en la variable '$errorExcepcion'
            $mensajeExcepcion = $miExcepcionPDO->getMessage(); // Almacenamos el mensaje de la excepción en la variable '$mensajeExcepcion'

            echo ("<div class='errorException'>Hubo un error al insertar los datos en la tabla Departamento campo duplicado.<br></div>");
            echo "<span class='errorException'>Error: </span>" . $mensajeExcepcion . "<br>"; // Mostramos el mensaje de la excepción
            echo "<span class='errorException'>Código del error: </span>" . $errorExcepcion; // Mostramos el código de la excepción
        } finally {
            unset($miDB); // Para cerrar la conexión
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

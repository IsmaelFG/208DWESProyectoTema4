<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>codigo01</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="/208DWESProyectoTema3/webroot/css/style.css">
    </head>
    <body style="margin-top:70px">
        <nav class="navbar navbar-expand-lg bg-primary fixed-top">
            <div class="container">
                <a class="navbar-brand text-white" href="/index.html">Ejercicio01</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>

        <?php
        /**
         * @author Ismael Ferreras García
         * @version 1.0
         * @since 6/11/2023
         */
        require_once '../config/confDB.php';
        try {
            // Establecemos la conexión por medio de PDO
            $miDB = new PDO(DSN, USERNAME, PASSWORD);
            //Ejecutamos una query en la tabla Departamento.
            $resultadoDepartamentos = $miDB->query("select * from T02_Departamento;");
            //Mostrar el numerode registros mediante rowCount()
            printf("<p>Número de registros: %s</p><br>", $resultadoDepartamentos->rowCount());
            //Cargamos los resultados mediante fetch(PDO::FETCH_OBJ).
            $oDepartamento = $resultadoDepartamentos->fetchObject();
            //Creamos una tabla para mostrar los resultados
            echo "<table border=1><tr><th>CodigoDepartamento</th><th>DescripcionDepartamento</th><th>FechaCreacionDepartamento</th><th>VolumenDeNegocio</th><th>FechaBajaDepartamento</th></tr><tbody>";
            while ($oDepartamento != null) {
                echo "<tr>";
                //Recorrido de la fila cargada
                echo "<td>$oDepartamento->T02_CodDepartamento</td>"; //Obtener los códigos.
                echo "<td>$oDepartamento->T02_DescDepartamento</td>"; //Obtener las descripciones.
                echo "<td>$oDepartamento->T02_FechaCreacionDepartamento</td>"; //Obtener la fecha de creacion
                echo "<td>$oDepartamento->T02_VolumenDeNegocio</td>"; //Obtener el volumen de negocio.
                echo "<td>$oDepartamento->T02_FechaBajaDepartamento</td>"; //Obtener la fecha de baja.
                echo "</tr>";
                $oDepartamento = $resultadoDepartamentos->fetchObject();
            }
            echo "</tbody></table>";
            //Mediante PDOException mostramos un mensaje de error cuando salte la exception
        } catch (PDOException $excepcion) {
            echo 'Error: ' . $excepcion->getMessage() . "<br>";
            echo 'Código de error: ' . $excepcion->getCode() . "<br>";
        }
        //Mediante unset cerramos la sesion de la base de datos
        unset($miDB);
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



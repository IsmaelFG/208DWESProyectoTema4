<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>codigo02</title>
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
                max-width: 800px;
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
        <script>
            window.addEventListener('load', function () {
                // Obtén el campo de entrada por su ID
                const codDepartamentoInput = document.getElementById("CodDepartamento");
                // Agrega un detector de eventos para el evento "input"
                codDepartamentoInput.addEventListener("input", function () {
                    // Convierte el valor del campo a mayúsculas
                    this.value = this.value.toUpperCase();
                });
            });
        </script>
    </head>
    <body style="margin-top:70px; margin-bottom: 100px">
        <nav class="navbar navbar-expand-lg bg-primary fixed-top">
            <div class="container">
                <a class="navbar-brand text-white" href="/index.html">Ejercicio02</a>
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
         * @since 7/11/2023
         */
        $dsn = 'mysql:host=192.168.20.19;dbname=DB208DWESProyectoTema4';
        $username = 'user208DWESProyectoTema4';
        $password = 'paso';
        include_once('../core/231018libreriaValidacion.php'); //Importar la libreria de validacion
        $entradaOK = true; //Indica si todas las respuestas son correctas
        // Obtener la fecha y hora actual en Datetime
        $FechaCreacion = date('Y-m-d H:i:s');
        $oFechaCreacionDateTime = new DateTime($FechaCreacion);
        //Almacena las respuestas
        $aRespuestas = [
            'CodDepartamento' => '',
            'DescDepartamento' => '',
            'FechaCreacionDepartamento' => '',
            'VolumenNegocio' => '',
            'FechaBaja' => null
        ];
        //Almacena los errores
        $aErrores = [
            'CodDepartamento' => '',
            'DescDepartamento' => '',
            'VolumenNegocio' => ''
        ];
        //Validar los campos
        if (isset($_REQUEST['enviar'])) {

            $aErrores = [
                'CodDepartamento' => validacionFormularios::comprobarAlfabetico($_REQUEST['CodDepartamento'], 3, 3, 1),
                'DescDepartamento' => validacionFormularios::comprobarAlfaNumerico($_REQUEST['DescDepartamento'], 255, 1, 1),
                'VolumenNegocio' => validacionFormularios::comprobarFloat($_REQUEST['VolumenNegocio'])
            ];
            // Comprobar si el CodDepartamento introducido ya existe
            if ($aErrores['CodDepartamento'] == null) {
                $miDB = new PDO($dsn, $username, $password);
                $consulta = $miDB->prepare('SELECT T02_CodDepartamento FROM T02_Departamento WHERE T02_CodDepartamento ="' . $_REQUEST['CodDepartamento'] . '";');
                $consulta->execute();
                if ($consulta->rowCount() > 0) {
                    $aErrores['CodDepartamento'] = 'El CodDepartamento ya existe.';
                }
                unset($miDB);
            }
            //Recorre aErrores para ver si hay alguno
            foreach ($aErrores as $campo => $valor) {
                if ($valor == !null) {
                    $entradaOK = false;
                    //Limpiamos el campo
                    $_REQUEST[$campo] = '';
                }
            }
        } else {
            $entradaOK = false;
        }
        //En caso de que '$entradaOK' sea true, cargamos las respuestas en el array '$aRespuestas' 
        if ($entradaOK) {
            $aRespuestas = [
                'CodDepartamento' => $_REQUEST['CodDepartamento'],
                'DescDepartamento' => $_REQUEST['DescDepartamento'],
                'FechaCreacionDepartamento' => $oFechaCreacionDateTime->format('Y-m-d H:i:s'),
                'VolumenNegocio' => $_REQUEST['VolumenNegocio'],
                'FechaBaja' => null
            ];

            try {
                $miDB = new PDO($dsn, $username, $password);

                $consulta = "INSERT INTO T02_Departamento (T02_CodDepartamento, T02_DescDepartamento, T02_FechaCreacionDepartamento, T02_VolumenNegocio) 
                 VALUES (:CodDepartamento, :DescDepartamento,:FechaCreacionDepartamento, :VolumenNegocio)";

                // Consulta preparada
                $resultadoConsulta = $miDB->prepare($consulta);

                // Asignar valores a los parámetros de la consulta preparada en el método execute
                if ($resultadoConsulta->execute([
                            ':CodDepartamento' => $aRespuestas['CodDepartamento'],
                            ':DescDepartamento' => $aRespuestas['DescDepartamento'],
                            ':FechaCreacionDepartamento' => $aRespuestas['FechaCreacionDepartamento'],
                            ':VolumenNegocio' => $aRespuestas['VolumenNegocio'],
                        ])) {
                    echo "Los datos se han insertado correctamente en la tabla Departamento.</br>";
                    //Ejecutamos una query en la tabla Departamento.
                    $resultadoDepartamentos = $miDB->query("select * from T02_Departamento;");
                    //Mostrar el numerode registros mediante rowCount()
                    printf("<p>Número de registros: %s</p><br>", $resultadoDepartamentos->rowCount());
                    //Cargamos los resultados mediante fetchObject().
                    $oDepartamento = $resultadoDepartamentos->fetchObject();
                    //Creamos una tabla para mostrar los resultados
                    echo "<table border=1><tr><th>CodigoDepartamento</th><th>DescripcionDepartamento</th><th>FechaCreacionDepartamento</th><th>VolumenDeNegocio</th><th>FechaBajaDepartamento</th></tr><tbody>";
                    while ($oDepartamento != null) {
                        echo "<tr>";
                        //Recorrido de la fila cargada
                        echo "<td>$oDepartamento->T02_CodDepartamento</td>"; //Obtener los códigos.
                        echo "<td>$oDepartamento->T02_DescDepartamento</td>"; //Obtener las descripciones.
                        echo "<td>$oDepartamento->T02_FechaCreacionDepartamento</td>"; //Obtener la fecha de creacion
                        echo "<td>$oDepartamento->T02_VolumenNegocio</td>"; //Obtener el volumen de negocio.
                        echo "<td>$oDepartamento->T02_FechaBaja</td>"; //Obtener la fecha de baja.
                        echo "</tr>";
                        $oDepartamento = $resultadoDepartamentos->fetchObject();
                    }
                    echo "</tbody></table>";
                } else {
                    echo "Hubo un error al insertar los datos en la tabla Departamento.";
                }
            } catch (PDOException $pdoEx) {
                echo ("<div class='fs-4 text'>ERROR AL INSERTAR LOS VALORES</div> " . $pdoEx->getMessage());
            }
            unset($miDB);
        } else {
            ?>
            <h1>Cuestionario</h1>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <table>
                    <tr>
                        <td><label for="CodDepartamento">Codigo Departamento:</label></td>
                        <td><input class="obligatorio" type="text" id="CodDepartamento" name="CodDepartamento" value="<?php echo (isset($_REQUEST['CodDepartamento']) ? $_REQUEST['CodDepartamento'] : ''); ?>"></td>
                        <td class="error"><?php echo (!empty($aErrores["CodDepartamento"]) ? $aErrores["CodDepartamento"] : ''); ?></td>
                    </tr>
                    <tr>
                        <td><label for="DescDepartamento">Descripcion Departamento:</label></td>
                        <td><input class="obligatorio" type="text" id="DescDepartamento" name="DescDepartamento" value="<?php echo (isset($_REQUEST['DescDepartamento']) ? $_REQUEST['DescDepartamento'] : ''); ?>"></td>
                        <td class="error"><?php echo (!empty($aErrores["DescDepartamento"]) ? $aErrores["DescDepartamento"] : ''); ?></td>
                    </tr>
                    <tr>
                        <td><label for="FechaCreacionDepartamento">Fecha Creacion:</label></td>
                        <td>
                            <input  type="text" 
                                    id="FechaCreacionDepartamento" 
                                    name="FechaCreacionDepartamento" 
                                    value="<?php echo ($oFechaCreacionDateTime->format('Y-m-d H:i:s')); ?>" 
                                    disabled>
                            </td>
                        <td class="error"><?php echo (!empty($aErrores["FechaCreacionDepartamento"]) ? $aErrores["FechaCreacionDepartamento"] : ''); ?></td>
                    </tr>
                    <tr>
                        <td><label for="VolumenNegocio">Volumen Negocio:</label></td>
                        <td><input class="obligatorio" type="text" id="VolumenNegocio" name="VolumenNegocio" value="<?php echo (isset($_REQUEST['VolumenNegocio']) ? $_REQUEST['VolumenNegocio'] : ''); ?>"></td>
                        <td class="error"><?php echo (!empty($aErrores["VolumenNegocio"]) ? $aErrores["VolumenNegocio"] : ''); ?></td>
                    </tr>
                    <tr>
                        <td><label for="FechaBaja">Fecha Baja:</label></td>
                        <td><input  type="text" id="FechaBaja" name="FechaBaja" value="" disabled></td>
                        <td class="error"><?php echo (!empty($aErrores["FechaBaja"]) ? $aErrores["FechaBaja"] : ''); ?></td>
                    </tr>
                </table>
                <input type="reset" value="Borrar">
                <input name="enviar" type="submit" value="Añadir">
            </form>
            <?php
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

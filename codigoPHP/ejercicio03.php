<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>codigo03</title>
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
    </head>
    <body style="margin-top:70px; margin-bottom: 100px">
        <nav class="navbar navbar-expand-lg bg-primary fixed-top">
            <div class="container">
                <a class="navbar-brand text-white" href="/index.html">Ejercicio03</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>
        <h1>Cuestionario</h1>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <table>
                <tr>
                    <td><label for="DescDepartamento">Descripcion Departamento:</label></td>
                    <td><input type="text" id="DescDepartamento" name="DescDepartamento" value="<?php echo (isset($_REQUEST['DescDepartamento']) ? $_REQUEST['DescDepartamento'] : ''); ?>"></td>
                </tr>
            </table>
            <input name="enviar" type="submit" value="Buscar">
        </form>

        <?php
        $dsn = 'mysql:host=192.168.20.19;dbname=DB208DWESProyectoTema4';
        $username = 'user208DWESProyectoTema4';
        $password = 'paso';
        include_once('../core/231018libreriaValidacion.php');

        // Verificar si se envió el formulario
        if (isset($_REQUEST['enviar'])) {
            // Almacena las respuestas y los errores
            $aRespuestas = [
                'DescDepartamento' => ''
            ];
            $aErrores = [
                'DescDepartamento' => ''
            ];

            // Validar los campos
            $aErrores = [
                'DescDepartamento' => validacionFormularios::comprobarAlfaNumerico($_REQUEST['DescDepartamento'], 255, 1)
            ];

            // Recorre aErrores para ver si hay alguno
            foreach ($aErrores as $campo => $valor) {
                if ($valor != null) {
                    // Limpiamos el campo
                    $_REQUEST[$campo] = '';
                }
            }

            // En caso de que no haya errores, realizamos la búsqueda y mostramos la tabla actualizada
            try {
                $miDB = new PDO($dsn, $username, $password);

                // Valor de búsqueda proporcionado por el usuario (o vacío si no se proporciona)
                $valor_busqueda = isset($_REQUEST['DescDepartamento']) ? '%' . $_REQUEST['DescDepartamento'] . '%' : '';

                // Consulta SQL preparada
                if ($valor_busqueda) {
                    $consulta = $miDB->prepare("SELECT * FROM Departamento WHERE DescDepartamento LIKE :valor_busqueda");
                    $consulta->bindParam(':valor_busqueda', $valor_busqueda, PDO::PARAM_STR);
                    $consulta->execute();
                } else {
                    $consulta = $miDB->prepare("SELECT * FROM Departamento");
                    $consulta->execute();
                }

                // Obtener resultados como objetos
                echo "<h1>Resultados de la búsqueda</h1>";
                echo "<table border='1'>";
                while ($fila = $consulta->fetchObject()) {
                    echo "<tr><td>CodDepartamento: " . $fila->CodDepartamento . "</td><td>Descripción: " . $fila->DescDepartamento . "</td><td>FechaBaja: " . $fila->FechaBaja . "</td><td>VolumenNegocio: " . $fila->VolumenNegocio . "</td></tr>";
                }
                echo "</table>";
            } catch (PDOException $pdoEx) {
                echo ("<div class='fs-4 text'>ERROR AL MOSTRAR LOS VALORES</div> " . $pdoEx->getMessage());
            }
            unset($miDB);
        } else {
            try {
                $miDB = new PDO($dsn, $username, $password);
                $consulta = $miDB->prepare("SELECT * FROM Departamento");
                $consulta->execute();

                echo "<h1>Resultados de la búsqueda</h1>";
                echo "<table border='1'>";
                while ($fila = $consulta->fetchObject()) {
                    echo "<tr><td>CodDepartamento: " . $fila->CodDepartamento . "</td><td>Descripción: " . $fila->DescDepartamento . "</td><td>FechaBaja: " . $fila->FechaBaja . "</td><td>VolumenNegocio: " . $fila->VolumenNegocio . "</td></tr>";
                }
                echo "</table>";
            } catch (PDOException $pdoEx) {
                echo ("<div class='fs-4 text'>ERROR AL MOSTRAR LOS VALORES</div> " . $pdoEx->getMessage());
            }
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

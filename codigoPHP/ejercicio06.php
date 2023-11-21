<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>codigo06</title>
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
                <a class="navbar-brand text-white" href="/index.html">Ejercicio06</a>
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
// Especifica la ruta al archivo JSON
        $jsonFilePath = "/var/www/DAW208/public_html/208DWESProyectoTema4/tmp/departamentos.json";

// Verifica si el archivo existe
        if (file_exists($jsonFilePath)) {
            // Lee el contenido del archivo JSON
            $jsonContents = file_get_contents($jsonFilePath);

            // Decodifica los datos JSON
            $departamentos = json_decode($jsonContents, true);

            // Verifica si la decodificación fue exitosa
            if ($departamentos !== null) {
                
                try {
                    // Conexión a la base de datos
                    $conexion = new PDO($dsn, $username, $password);

                    // Prepara la consulta para la inserción
                    $sql = "INSERT INTO T02_Departamento (T02_CodDepartamento, T02_FechaCreacionDepartamento, T02_DescDepartamento, T02_VolumenNegocio, T02_FechaBaja) 
                    VALUES (:codDepartamento, :fechaCreacionDepartamento, :descDepartamento, :volumenNegocio, :FechaBaja)";

                    $consulta = $conexion->prepare($sql);

                    //Insertar los departamentos en la ase de datos
                    foreach ($departamentos as $departamento) {
                        // Ejecuta la consulta para insertar el departamento
                        $consulta->execute($departamento);
                    }

                    echo "<p>Importación a la base de datos exitosa.</p>";
                } catch (PDOException $ex) {
                    echo "<p>Error al conectar a la base de datos: " . $ex->getMessage() . "</p>";
                } finally {
                    // Cierra la conexión
                    unset($conexion);
                }
            } else {
                echo "<p>Error al decodificar los datos JSON.</p>";
            }
        } else {
            echo "<p>El archivo JSON no existe.</p>";
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

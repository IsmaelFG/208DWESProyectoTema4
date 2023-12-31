<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>codigo00</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="/208DWESProyectoTema3/webroot/css/style.css">
    </head>
    <body style="margin-top:70px">
        <nav class="navbar navbar-expand-lg bg-primary fixed-top">
            <div class="container">
                <a class="navbar-brand text-white" href="/index.html">Ejercicio00</a>
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
         * @since 21/11/2023
         */
        require_once '../config/confDB.php';
        try {
            // Establecemos la conexión por medio de PDO
            $miDB = new PDO(DSN, USERNAME, PASSWORD);
            echo ("CONEXIÓN EXITOSA") . "<br>";
            // Mostrar atributos de la conexión PDO
            echo "ERRMODE: " . $miDB->getAttribute(PDO::ATTR_ERRMODE) . "<br>";
            echo "EMULATE_PREPARES: " . $miDB->getAttribute(PDO::ATTR_EMULATE_PREPARES) . "<br>";
            echo "DEFAULT_FETCH_MODE: " . $miDB->getAttribute(PDO::ATTR_DEFAULT_FETCH_MODE) . "<br>";
            echo "DRIVER_NAME: " . $miDB->getAttribute(PDO::ATTR_DRIVER_NAME) . "<br>";
            echo "SERVER_INFO: " . $miDB->getAttribute(PDO::ATTR_SERVER_INFO) . "<br>";
            echo "SERVER_VERSION: " . $miDB->getAttribute(PDO::ATTR_SERVER_VERSION) . "<br>";
            echo "CLIENT_VERSION: " . $miDB->getAttribute(PDO::ATTR_CLIENT_VERSION) . "<br>";
            echo "AUTOCOMMIT: " . $miDB->getAttribute(PDO::ATTR_AUTOCOMMIT) . "<br>";
        } catch (PDOException $pdoEx) { // En caso de error salta la excepcion
            echo ("ERROR DE CONEXIÓN " . $pdoEx->getMessage());
        }
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



<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>codigo07</title>
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
                <a class="navbar-brand text-white" href="/index.html">Ejercicio07</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>
        <?php
        require_once '../config/confDB.php';
        include_once('../core/231018libreriaValidacion.php');

// Declaro una variable de entrada para mostrar o no la tabla con los valores de la BD
        $entradaOK = true;

//Abro un bloque try catch para tener un mayor control de los errores
        try {
            // CONEXION CON LA BD
            $miDB = new PDO(DSN, USERNAME, PASSWORD);

            //Preparamos la consulta que previamente vamos a ejecutar
            $resultadoConsulta = $miDB->prepare('SELECT * FROM T02_Departamento');

            //Ejecutamos la consulta
            $resultadoConsulta->execute();

            //Guardo el primer registro como un objeto
            $oResultado = $resultadoConsulta->fetchObject();

            // Inicializamos un array vacío para almacenar todos los departamentos
            $aDepartamentos = [];

            /**
             * Recorro los registros que devuelve la consulta y obtengo por cada valor su resultado
             */
            while ($oResultado) {
                //Guardamos los valores en un array asociativo
                $aDepartamento = [
                    'codDepartamento' => $oResultado->T02_CodDepartamento,
                    'fechaCreacionDepartamento' => $oResultado->T02_FechaCreacionDepartamento,
                    'descDepartamento' => $oResultado->T02_DescDepartamento,
                    'VolumenDeNegocio' => $oResultado->T02_VolumenDeNegocio,
                    'FechaBajaDepartamento' => $oResultado->T02_FechaBajaDepartamento
                ];

                // Añadimos el array $aDepartamento al array $aDepartamentos
                $aDepartamentos[] = $aDepartamento;

                //Guardo el registro actual y avanzo el puntero al siguiente registro que obtengo de la consulta
                $oResultado = $resultadoConsulta->fetchObject();
            }


            /**
             * La funcion json_encode devuelve un string con la representacion JSON
             * Le pasamos el array aDepartamentos y utilizanos el atributo JSON_PRRETY_PRINT para que use espacios en blanco para formatear los datos devueltos.
             * JSON_UNESCAPED_UNICODE: Codifica caracteres Unicode multibyte literalmente
             */
            $json = json_encode($aDepartamentos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

            /**
             * Mediante la funcion file_put_contents() podremos escribir informacion en un fichero
             * Pasandole como parametros la ruta donde queresmos que se guarde y el que queremos sobrescribir
             * 
             */
            //Comprueba si el directorio existe y lo crea si no existe
            $directory = "../tmp/";
            if (!file_exists($directory)) {
                mkdir($directory, 0777, true);
            }
            file_put_contents("../tmp/departamentos.json", $json);
            

            //Mediante echo mostramos el numero de bytes escritos
            echo ("<br>Exportado correctamente a el directorio /tmp del proyecto tema 4 en el servidor");

            //Controlamos las excepciones mediante la clase PDOException
        } catch (PDOException $miExcepcionPDO) {
            /**
             * Revierte o deshace los cambios
             * Esto solo se usara si estamos usando consultas preparadas
             */
            $miDB->rollback();

            //Almacenamos el código del error de la excepción en la variable '$errorExcepcion'
            $errorExcepcion = $miExcepcionPDO->getCode();

            // Almacenamos el mensaje de la excepción en la variable '$mensajeExcepcion'
            $mensajeExcepcion = $miExcepcionPDO->getMessage();

            // Mostramos el mensaje de la excepción
            echo "<span style='color: red'>Error: </span>" . $mensajeExcepcion . "<br>";

            // Mostramos el código de la excepción
            echo "<span style='color: red'>Código del error: </span>" . $errorExcepcion;

            //En culaquier cosa cerramos la sesion
        } finally {
            // El metodo unset sirve para cerrar la sesion con la base de datos
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

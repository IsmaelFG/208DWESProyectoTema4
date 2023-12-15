<?php
/**
 * @author Ismael Ferreras García
 * @version 1.0 
 * @since 01/12/2023
 * Archivo de configuración de la BD
 */
// Archivo de configuración de la BD del Instituto
if ($_SERVER['SERVER_NAME'] == 'daw208.isauces.local') {
    define('DSN', 'mysql:host=192.168.20.19;dbname=DB208DWESProyectoTema4'); // Host 'IP' y nombre de la base de datos
    define('USERNAME', 'user208DWESProyectoTema4'); // Nombre de usuario de la base de datos
    define('PASSWORD', 'paso'); // Contraseña de la base de datos
    // Archivo de configuración de la BD de Explotación
} elseif ($_SERVER['SERVER_NAME'] == 'daw208.ieslossauces.es') {
    define('DSN', 'mysql:host=db5014806782.hosting-data.io;dbname=dbs12302442'); // Host y nombre de la base de datos
    define('USERNAME', 'dbu3996658'); // Nombre de usuario de la base de datos
    define('PASSWORD', 'daw2_Sauces'); // Contraseña de la base de datos
}
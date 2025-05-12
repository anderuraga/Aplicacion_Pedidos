<?php
define('BASE_URL', '/elorrieta/');
// Incluye el archivo que contiene la clase App, que se encarga del enrutamiento de la aplicación.
require_once 'core/App.php';

// Incluye el archivo que contiene la clase Controller, base para los controladores de la aplicación.
require_once 'core/Controller.php';

// Configuración de autocarga: permite cargar automáticamente las clases de controladores y modelos cuando se necesiten.
spl_autoload_register(function ($class) {
    // Si existe un archivo con el nombre de la clase en la carpeta de controladores, lo carga.
    if (file_exists("../app/controllers/$class.php")) {
        require_once "../app/controllers/$class.php";
    } 
    // Si no se encontró en controladores, busca en la carpeta de modelos.
    elseif (file_exists("../app/models/$class.php")) {
        require_once "../app/models/$class.php";
    }
});

// Se crea una nueva instancia de la clase App, lo que inicia el proceso de enrutamiento y carga del controlador adecuado.
$app = new App();
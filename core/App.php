<?php

define('HOMEDIR',__DIR__);

class App {
    // Propiedades por defecto: el controlador, el método y los parámetros
    protected $controller = 'LoginController'; // Controlador predeterminado
    protected $method = 'index';              // Método predeterminado
    protected $params = [];                   // Parámetros de la URL

    public function __construct() {
        // Parseamos la URL (ej: /usuario/perfil/1 → ['usuario', 'perfil', '1'])
       $url = $this->parseUrl();

        // Si hay un controlador correspondiente al primer segmento de la URL
        if (isset($url[0]) && file_exists(__DIR__ ."/../app/controllers/" . $url[0] . "Controller.php")) {
            $this->controller = $url[0] . "Controller"; // Cambiamos el controlador
            unset($url[0]); // Lo eliminamos del array para que queden solo método y parámetros
        }

        // Incluimos el archivo del controlador
        require_once __DIR__ ."/../app/controllers/" . $this->controller . ".php";

        // Instanciamos el controlador a partir del string que tenemos guardado
        $this->controller = new $this->controller;

        // Si hay un segundo segmento en la URL y es un método válido del controlador
        if (isset($url[1]) && method_exists($this->controller, $url[1])) {
            $this->method = $url[1]; // Establecemos el método            
            unset($url[1]); // Lo eliminamos del array
        }

        // Los elementos restantes del array se consideran parámetros
        $this->params = $url ? array_values($url) : [];

        // Comprueba si el usuario logeado puede acceder al controller
        if(!$this->controller->tiene_permiso()){
            //TODO Seguridad: Implementar que pasa cuando hay permisos para acceder a la página.
            echo "No tienes permiso para esta página";
            die();
        }

        // Llamamos al método del controlador con los parámetros (si hay)
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    // Función que interpreta la URL
    private function parseUrl() {
        if (isset($_GET['url'])) {
            // Elimina barras al final, limpia caracteres especiales y separa por "/"
            return explode("/", filter_var(rtrim($_GET['url'], "/"), FILTER_SANITIZE_URL));
        }
        return [];
    }
}
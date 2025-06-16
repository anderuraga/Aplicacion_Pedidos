<?php
class ErrorController extends Controller
{
    public function index($codigo, $mensaje='')
    {
        if (empty($mensaje)) {
            $mensaje = $this->obtenerMensajeHTTP($codigo);
        }

        $this->view("error/index", ['codigo' => $codigo, 'mensaje' => $mensaje]);
    }

    private function obtenerMensajeHTTP($code) {
        $mensajes = [
            400 => 'Solicitud incorrecta.',
            401 => 'No autorizado.',
            403 => 'Acceso denegado.',
            404 => 'Página no encontrada.',
            500 => 'Error interno del servidor.',
            503 => 'Servicio no disponible.',
        ];
        return $mensajes[$code] ?? 'Se ha producido un error.';
    }
}
?>
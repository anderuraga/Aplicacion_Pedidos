<?php
function customErrorHandler($errno, $errstr, $errfile, $errline)
{
    // Directorio de logs
    $logsDir = __DIR__ . '/../logs';
    if (!is_dir($logsDir)) {
        mkdir($logsDir, 0777, true);
    }

    // Nombre de fichero con fecha y hora
    $timestamp = date('Y-m-d_H-i-s');
    $logFile = "$logsDir/error-{$timestamp}.txt";

    // Mensaje de error
    $errorMessage  = "[" . date('Y-m-d H:i:s') . "]\n";
    $errorMessage .= "Tipo: $errno\n";
    $errorMessage .= "Mensaje: $errstr\n";
    $errorMessage .= "Archivo: $errfile\n";
    $errorMessage .= "Línea: $errline\n\n";

    // Guardar en fichero independiente
    error_log($errorMessage, 3, $logFile);

    // Responder con código 500 y redirigir
    http_response_code(500);
    header("Location: ". BASE_URL . "Error/500");
    exit();
}

// Registrar manejador de errores
set_error_handler('customErrorHandler');

// Capturar errores fatales al cierre
register_shutdown_function(function () {
    $error = error_get_last();
    if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR], true)) {
        customErrorHandler($error['type'], $error['message'], $error['file'], $error['line']);
    }
});
?>

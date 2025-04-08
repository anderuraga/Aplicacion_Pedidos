<?php
function recurso($ruta) {
    return BASE_URL . ltrim($ruta, '/');
}
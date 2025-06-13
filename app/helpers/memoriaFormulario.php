<?php
class MemoriaFormulario
{
    public function guardar($nombre): void
    {
        $_SESSION['formularios'][$nombre] = $_POST;
    }

    public function cargar($nombre)
    {
        if(!)
        $vars = json_encode($_SESSION['formularios'][$nombre]); ?>
        <script>
            let rellenado = <?= $vars ?>;
            $('input').each(function (index) {
                
            });
        </script>
        <?php unset($_SESSION['formularios'][$nombre]);
    }
}
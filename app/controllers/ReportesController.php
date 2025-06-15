<?php
require_once __DIR__ . '/../helpers/auth.php';

class ReportesController extends Controller
{
    public function index()
    {
        if (isset($_GET['anio'])) {
            $anio = $_GET['anio'];
        } else {
            $anio = date('Y');
        }
        /**
         * @var PedidosDAO
         */
        $pedidosDAO = $this->dao("Pedidos");
        $infoFacturas = $pedidosDAO->reportes($anio);

        /**
         * @var AreasGastosDAO
         */
        $areasGastosDAO = $this->dao("AreasGastos");
        $infoAreasGastos = $areasGastosDAO->reportes($anio);

        /**
         * @var ProveedoresDAO
         */
        $proveedoresDAO = $this->dao("Proveedores");
        $infoProveedores = $proveedoresDAO->reportes($anio);

        /**
         * @var TiposServicioDAO
         */
        $tiposServicioDAO = $this->dao("TiposServicio");
        $tiposServicio = $tiposServicioDAO->listar();

        $data = [
            'anio' => $anio,
            'infoFacturas' => $infoFacturas,
            'infoAreasGastos' => $infoAreasGastos,
            'infoProveedores' => $infoProveedores,
            'tiposServicio' => $tiposServicio,
        ];

        $this->view("reportes/index",$data);
    }

    #[\Override]
    public function tiene_permiso(): bool
    {
        return requireAdmin();
    }
}

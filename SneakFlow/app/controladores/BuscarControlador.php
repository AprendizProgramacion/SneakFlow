<?php
require_once __DIR__ . '/../modelos/BusquedaModelo.php'; // Asegúrate de que la ruta sea correcta

class BuscarControlador {
    private $busquedaModelo;

    public function __construct() {
        $this->busquedaModelo = new BusquedaModelo();
    }

    public function buscarProductos() {
        // Verificar si hay un término de búsqueda
        if (isset($_POST['query']) && !empty(trim($_POST['query']))) {
            $busqueda = htmlspecialchars(trim($_POST['query']));
            $resultados = $this->busquedaModelo->buscarProductos($busqueda);

            // Cargar la vista con los resultados
            include_once __DIR__ . '../../../public/vistas/Productos/buscar.php';
        } else {
            // Si no hay término de búsqueda, generar una alerta
            echo "<script>alert('Por favor ingresa un término de búsqueda.'); window.location.href = 'productos';</script>";
            exit();
        }
    }
}
?>

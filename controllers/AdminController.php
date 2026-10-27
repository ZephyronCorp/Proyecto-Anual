<?php
require_once __DIR__ . '/../models/ProductoModel.php';

class AdminController {
        private $conexion;
        private $productoModel;

        public function __construct($conexion) {
            requerirRol(1); // Verificar que el usuario tenga rol de administrador
            
            $this->conexion = $conexion;
            $this->productoModel = new ProductoModel($conexion);
        }
       
        public function panel() {
            // Obtener el nombre del administrador desde la sesión
            $nombreAdmin = usuarioActualNombre();
            $productosStockBajo = $this->productoModel->listarStockBajo();
            // Incluir la vista del panel de administración
            require __DIR__ . '/../views/admin.php';
        }
}
?>
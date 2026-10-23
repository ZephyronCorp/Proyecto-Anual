<?php

class AdminController {
        private $conexion;

        public function __construct($conexion) {
            requerirRol(1); // Verificar que el usuario tenga rol de administrador
            
            $this->conexion = $conexion;
        }
       
        public function panel() {
            // Obtener el nombre del administrador desde la sesión
            $nombreAdmin = usuarioActualNombre();
            
            // Incluir la vista del panel de administración
            require __DIR__ . '/../views/admin.php';
        }
}
?>
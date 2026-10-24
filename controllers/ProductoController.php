
<?php

class ProductoController
{
    private $conexion;
    private $productoModel;
    // Constructor: recibe la conexión y crea el modelo.
    public function __construct($conexion)
    {
        $this->conexion = $conexion;
        $this->productoModel = new ProductoModel($conexion);
    }

    // Muestra el catálogo, con filtro opcional por categoría.
    public function mostrarCatalogo()
    {
        $idCategoriaSeleccionada = isset($_GET['categoria'])? $_GET['categoria']: null;

        //Texto de busqueda
        $busqueda = trim($_GET['q'] ?? ''); // Elimina espacios en blanco al inicio y al final
        $busqueda = mb_substr($busqueda, 0, 50); // Limitar a 50 caracteres

        $listaDeProductos = $this->productoModel->listarProductos($idCategoriaSeleccionada);
        $listaDeCategorias = $this->productoModel->listarCategorias();

        require __DIR__ . '/../views/Catalogo.php';
    }
    // Muestra el detalle de un producto.
    public function mostrarDetalle()
    {
        if (
            !isset($_GET['id']) ||
            !ctype_digit((string) $_GET['id']) ||
            (int) $_GET['id'] <= 0
        ) {
            http_response_code(400);
            echo "<p>ID de producto inválido.</p>";
            return;
        }

        $idProducto = (int) $_GET['id'];
        $producto = $this->productoModel->obtenerProductoPorId($idProducto);
        
        if (!$producto) {
            http_response_code(404);
            echo "<p>El producto solicitado no existe.</p>";
            return;
        }
        require __DIR__ . '/../views/unProducto.php';
    }
}

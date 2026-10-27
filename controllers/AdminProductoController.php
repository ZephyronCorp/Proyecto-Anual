<?php

require_once __DIR__ . '/../models/ProductoModel.php';
require_once __DIR__ . '/../config/imagenes.php';

class AdminProductoController {
    private $conexion;
    private $productoModel;

    public function __construct($conexion) {
        requerirRol(1);

        $this->conexion = $conexion;
        $this->productoModel = new ProductoModel($conexion);
    }

    // Muestra todos los productos.
    public function listar() {
        $productos = $this->productoModel->listarTodosAdmin();

        // Solo se muestran los mensajes de esta lista.
        $avisos = [
            'creado' => 'Producto creado correctamente.',
            'editado' => 'Producto actualizado correctamente.',
            'desactivado' => 'El producto fue dado de baja y ya no se ve en el catálogo.',
            'reactivado' => 'El producto volvió a estar disponible.'
        ];

        $clave = $_GET['msg'] ?? '';
        $aviso = (is_string($clave) && isset($avisos[$clave]))
            ? $avisos[$clave]
            : '';

        require __DIR__ . '/../views/admin/productos_lista.php';
    }

    // Crea un producto.
    public function crear() {
        $errores = [];
        $producto = $this->productoVacio();
        $categorias = $this->productoModel->listarCategorias();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $producto = $this->leerFormulario();
            $errores = $this->validar($producto, $categorias);

            if (empty($errores)) {
                $img = guardarImagenProducto($_FILES['imagen'] ?? null);

                if (!$img['ok']) {
                    $errores[] = $img['error'];
                } else {
                    $producto['imagen'] = $img['nombre'];

                    if ($this->productoModel->crear($producto)) {
                        redirigir('admin_productos', '&msg=creado');
                    }

                    // Si falla el guardado, borramos la imagen nueva.
                    borrarImagenProducto($img['nombre']);

                    $errores[] = 'No se pudo guardar el producto. Intentá de nuevo.';
                }
            }
        }

        $titulo = 'Nuevo producto';
        $urlAccion = 'index.php?pagina=admin_producto_crear';

        require __DIR__ . '/../views/admin/productos_form.php';
    }

    // Modifica un producto.
    public function editar() {
        $idProducto = filter_var(
            $_GET['id'] ?? null,
            FILTER_VALIDATE_INT
        );

        $actual = ($idProducto !== false && $idProducto > 0)
            ? $this->productoModel->obtenerParaAdmin($idProducto)
            : null;

        if (!$actual) {
            redirigir('admin_productos');
        }

        $errores = [];
        $producto = $actual;
        $categorias = $this->productoModel->listarCategorias();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $producto = $this->leerFormulario();

            // Conserva la imagen actual si no se elige otra.
            $producto['imagen'] = $actual['imagen'];

            $errores = $this->validar($producto, $categorias);

            if (empty($errores)) {
                $img = guardarImagenProducto($_FILES['imagen'] ?? null);

                if (!$img['ok']) {
                    $errores[] = $img['error'];
                } else {
                    $subioNueva = ($img['nombre'] !== null);

                    if ($subioNueva) {
                        $producto['imagen'] = $img['nombre'];
                    }

                    if ($this->productoModel->actualizar($idProducto, $producto)) {
                        // Borra la anterior después de guardar los cambios.
                        if ($subioNueva) {
                            borrarImagenProducto($actual['imagen']);
                        }

                        redirigir('admin_productos', '&msg=editado');
                    }

                    // Si falla el guardado, borramos la imagen nueva.
                    if ($subioNueva) {
                        borrarImagenProducto($img['nombre']);
                    }

                    $errores[] = 'No se pudo actualizar el producto. Intentá de nuevo.';
                }
            }
        }

        $titulo = 'Editar producto';
        $urlAccion = 'index.php?pagina=admin_producto_editar&id=' . (int)$idProducto;

        require __DIR__ . '/../views/admin/productos_form.php';
    }

    // Da de baja un producto o lo reactiva.
    public function cambiarEstado() {
        // Esta acción se permite únicamente por POST.
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirigir('admin_productos');
        }

        $idProducto = filter_var(
            $_GET['id'] ?? null,
            FILTER_VALIDATE_INT
        );

        $activo = (($_POST['activo'] ?? '') === '1') ? 1 : 0;

        if (
            $idProducto !== false &&
            $idProducto > 0 &&
            $this->productoModel->obtenerParaAdmin($idProducto)
        ) {
            $this->productoModel->cambiarActivo($idProducto, $activo);

            redirigir(
                'admin_productos',
                $activo ? '&msg=reactivado' : '&msg=desactivado'
            );
        }

        redirigir('admin_productos');
    }

    // Valores iniciales para crear un producto.
    private function productoVacio() {
        return [
            'nombre' => '',
            'descripcion' => '',
            'precio' => '',
            'stock' => '0',
            'stock_minimo' => '5',
            'id_categoria' => '',
            'imagen' => null
        ];
    }

    // Lee los datos del formulario.
    private function leerFormulario() {
        return [
            'nombre' => trim($_POST['nombre'] ?? ''),
            'descripcion' => trim($_POST['descripcion'] ?? ''),
            'precio' => trim($_POST['precio'] ?? ''),
            'stock' => trim($_POST['stock'] ?? ''),
            'stock_minimo' => trim($_POST['stock_minimo'] ?? ''),
            'id_categoria' => trim($_POST['id_categoria'] ?? ''),
            'imagen' => null
        ];
    }

    // Valida los datos y devuelve los errores.
    private function validar($p, $categorias) {
        $errores = [];

        if (mb_strlen($p['nombre']) < 2 || mb_strlen($p['nombre']) > 100) {
            $errores[] = 'El nombre debe tener entre 2 y 100 caracteres.';
        }

        if (mb_strlen($p['descripcion']) > 500) {
            $errores[] = 'La descripción no puede superar los 500 caracteres.';
        }

        $precio = filter_var($p['precio'], FILTER_VALIDATE_FLOAT);

        if ($precio === false || $precio <= 0 || $precio > 9999999) {
            $errores[] = 'El precio debe ser un número mayor que 0.';
        }

        $stock = filter_var($p['stock'], FILTER_VALIDATE_INT);

        if ($stock === false || $stock < 0) {
            $errores[] = 'El stock debe ser un número entero (0 o más).';
        }

        $minimo = filter_var($p['stock_minimo'], FILTER_VALIDATE_INT);

        if ($minimo === false || $minimo < 0) {
            $errores[] = 'El stock mínimo debe ser un número entero (0 o más).';
        }

        // Comprueba que la categoría exista.
        $idsValidos = array_map(
            'intval',
            array_column($categorias, 'id_categoria')
        );

        if (!in_array((int)$p['id_categoria'], $idsValidos, true)) {
            $errores[] = 'Elegí una categoría de la lista.';
        }

        return $errores;
    }
}
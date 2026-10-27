<?php

require_once __DIR__ . '/../models/UsuarioModel.php';

class AdminUsuarioController {
    private $conexion;
    private $usuarioModel;

    // Roles permitidos: administrador y cliente.
    private $rolesValidos = [1, 2];

    // Solo se muestran los mensajes de esta lista.
    private $avisos = [
        'rol_cambiado' => [
            'tipo' => 'exito',
            'texto' => 'El rol del usuario fue actualizado.'
        ],
        'desactivado' => [
            'tipo' => 'exito',
            'texto' => 'La cuenta fue desactivada. Esa persona ya no puede iniciar sesión.'
        ],
        'reactivado' => [
            'tipo' => 'exito',
            'texto' => 'La cuenta fue reactivada.'
        ],
        'propio' => [
            'tipo' => 'error',
            'texto' => 'No podés cambiar tu propio rol ni desactivar tu propia cuenta.'
        ],
        'invalido' => [
            'tipo' => 'error',
            'texto' => 'No se pudo realizar la acción: los datos no son válidos.'
        ],
        'fallo' => [
            'tipo' => 'error',
            'texto' => 'Ocurrió un problema al guardar el cambio. Intentá de nuevo.'
        ]
    ];

    public function __construct($conexion) {
        requerirRol(1);

        $this->conexion = $conexion;
        $this->usuarioModel = new UsuarioModel($conexion);
    }

    // Muestra todos los usuarios.
    public function listar() {
        $usuarios = $this->usuarioModel->listarTodosAdmin();
        $roles = $this->rolesValidos;
        $idActual = (int)usuarioActualId();

        $clave = $_GET['msg'] ?? '';

        $aviso = (is_string($clave) && isset($this->avisos[$clave]))
            ? $this->avisos[$clave]
            : null;

        require __DIR__ . '/../views/admin/usuarios_lista.php';
    }

    // Cambia el rol de un usuario.
    public function cambiarRol() {
        // Solo se permite mediante POST.
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirigir('admin_usuarios');
        }

        $idUsuario = $this->leerIdDeLaUrl();

        $idRol = filter_var(
            $_POST['id_rol'] ?? null,
            FILTER_VALIDATE_INT
        );

        // Comprueba que el ID y el rol sean válidos.
        if (
            $idUsuario === null ||
            !in_array($idRol, $this->rolesValidos, true)
        ) {
            redirigir('admin_usuarios', '&msg=invalido');
        }

        // El administrador no puede cambiar su propio rol.
        if ($idUsuario === (int)usuarioActualId()) {
            redirigir('admin_usuarios', '&msg=propio');
        }

        // Comprueba que el usuario exista.
        if (!$this->usuarioModel->obtenerPorId($idUsuario)) {
            redirigir('admin_usuarios', '&msg=invalido');
        }

        // Guarda el nuevo rol.
        if ($this->usuarioModel->cambiarRol($idUsuario, $idRol)) {
            redirigir('admin_usuarios', '&msg=rol_cambiado');
        }

        redirigir('admin_usuarios', '&msg=fallo');
    }

    // Lee el ID de la URL y devuelve un entero positivo o null.
    private function leerIdDeLaUrl() {
        $idUsuario = filter_var(
            $_GET['id'] ?? null,
            FILTER_VALIDATE_INT
        );

    return ($idUsuario !== false && $idUsuario > 0)
        ? $idUsuario
        : null;
}

}
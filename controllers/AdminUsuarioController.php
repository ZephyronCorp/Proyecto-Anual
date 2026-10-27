<?php

require_once __DIR__ . '/../models/UsuarioModel.php';

class AdminUsuarioController {
    private $conexion;
    private $usuarioModel;

    // Roles permitidos: administrador y cliente.
    private $rolesValidos = [1, 3];

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
}
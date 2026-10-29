<?php

require_once __DIR__ . '/../models/MensajeModel.php';

class AdminMensajeController {
    private $conexion;
    private $mensajeModel;

    private $maxRespuesta = 1000;

    // Filtros permitidos para la bandeja.
    private $filtrosValidos = [
        'sin_responder' => 'Sin responder',
        'respondidos' => 'Respondidos'
    ];

    // Avisos permitidos.
    private $avisos = [
        'respondido' => [
            'tipo' => 'exito',
            'texto' => 'La respuesta fue guardada. El cliente ya puede verla.'
        ],
        'ya_respondido' => [
            'tipo' => 'error',
            'texto' => 'Ese mensaje ya había sido respondido. Tu respuesta no se guardó.'
        ],
        'respuesta_invalida' => [
            'tipo' => 'error',
            'texto' => 'La respuesta no puede estar vacía ni superar los 1000 caracteres.'
        ],
        'invalido' => [
            'tipo' => 'error',
            'texto' => 'No se pudo realizar la acción: los datos no son válidos.'
        ],
        'fallo' => [
            'tipo' => 'error',
            'texto' => 'Ocurrió un problema al guardar. Intentá de nuevo.'
        ]
    ];

    public function __construct($conexion) {
        requerirRol(1);

        $this->conexion = $conexion;
        $this->mensajeModel = new MensajeModel($conexion);
    }

    // Muestra la bandeja de mensajes.
    public function listar() {
        $filtro = $_GET['filtro'] ?? '';

        if (!is_string($filtro) || !isset($this->filtrosValidos[$filtro])) {
            $filtro = '';
        }

        $mensajes = $this->mensajeModel->listarAdmin($filtro);
        $filtrosValidos = $this->filtrosValidos;
        $aviso = $this->leerAviso();

        require __DIR__ . '/../views/admin/mensajes_lista.php';
    }

    // Muestra una consulta con los datos del cliente.
    public function ver() {
        $id = $this->leerIdDeLaUrl();

        $mensaje = ($id !== null)
            ? $this->mensajeModel->obtenerParaAdmin($id)
            : null;

        if (!$mensaje) {
            redirigir('admin_mensajes', '&msg=invalido');
        }

        $this->mostrarDetalle($mensaje, $this->leerAviso(), '');
    }

    // Valida y guarda la respuesta del administrador.
    public function responder() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirigir('admin_mensajes');
        }

        $id = $this->leerIdDeLaUrl();
        $respuesta = leerTextoPost('respuesta');

        $mensaje = ($id !== null)
            ? $this->mensajeModel->obtenerParaAdmin($id)
            : null;

        // Comprueba que el mensaje exista.
        if (!$mensaje) {
            redirigir('admin_mensajes', '&msg=invalido');
        }

        // No permite responder nuevamente una consulta.
        if ($mensaje['respuesta'] !== null) {
            redirigir(
                'admin_mensaje_detalle',
                '&id=' . $id . '&msg=ya_respondido'
            );
        }

        // Si hay errores, conserva la respuesta escrita.
        if ($respuesta === '' || mb_strlen($respuesta) > $this->maxRespuesta) {
            $this->mostrarDetalle(
                $mensaje,
                $this->avisos['respuesta_invalida'],
                $respuesta
            );
            return;
        }

        if ($this->mensajeModel->responder($id, $respuesta)) {
            redirigir(
                'admin_mensaje_detalle',
                '&id=' . $id . '&msg=respondido'
            );
        }

        // Otro administrador pudo haber respondido mientras tanto.
        redirigir(
            'admin_mensaje_detalle',
            '&id=' . $id . '&msg=ya_respondido'
        );
    }

    // Prepara las variables para la vista del detalle.
    private function mostrarDetalle($mensaje, $aviso, $textoRespuesta) {
        $maxRespuesta = $this->maxRespuesta;

        require __DIR__ . '/../views/admin/mensajes_detalle.php';
    }

    // Obtiene un aviso de la lista permitida.
    private function leerAviso() {
        $clave = $_GET['msg'] ?? '';

        return (is_string($clave) && isset($this->avisos[$clave]))
            ? $this->avisos[$clave]
            : null;
    }

    // Lee un identificador entero positivo desde la URL.
    private function leerIdDeLaUrl() {
        $id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);

        return ($id !== false && $id > 0) ? $id : null;
    }
}
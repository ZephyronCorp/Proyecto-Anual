<?php

require_once __DIR__ . '/../models/MensajeModel.php';

class MensajeController {
    private $conexion;
    private $mensajeModel;

    // El asunto admite hasta 200 caracteres en tu base.
    // Para el contenido usamos el límite de 1000 de la guía.
    private $maxAsunto = 200;
    private $maxTexto = 1000;

    private $avisos = [
        'enviado' => [
            'tipo' => 'exito',
            'texto' => '¡Gracias! Recibimos tu consulta. Vas a ver la respuesta en esta misma pantalla.'
        ],
        'fallo' => [
            'tipo' => 'error',
            'texto' => 'No pudimos guardar tu consulta. Intentá de nuevo.'
        ]
    ];

    public function __construct($conexion) {
        requerirLogin();

        $this->conexion = $conexion;
        $this->mensajeModel = new MensajeModel($conexion);
    }

    // Muestra el formulario de contacto.
    public function mostrarFormulario() {
        $this->mostrarVistaContacto('', '', []);
    }

    // Valida y guarda la consulta enviada.
    public function enviar() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirigir('contacto');
        }

        $asunto = leerTextoPost('asunto');
        $texto = leerTextoPost('texto');

        $errores = [];

        if ($asunto === '') {
            $errores[] = 'El asunto es obligatorio.';
        } elseif (mb_strlen($asunto) > $this->maxAsunto) {
            $errores[] = 'El asunto no puede superar los '
                . $this->maxAsunto . ' caracteres.';
        } elseif (preg_match('/[\r\n]/', $asunto)) {
            $errores[] = 'El asunto tiene que estar en una sola línea.';
        }

        if ($texto === '') {
            $errores[] = 'El mensaje es obligatorio.';
        } elseif (mb_strlen($texto) > $this->maxTexto) {
            $errores[] = 'El mensaje no puede superar los '
                . $this->maxTexto . ' caracteres.';
        }

        // Conserva los datos escritos si hay errores.
        if (!empty($errores)) {
            $this->mostrarVistaContacto($asunto, $texto, $errores);
            return;
        }

        // El usuario se obtiene de la sesión.
        $idUsuario = (int)usuarioActualId();

        if ($this->mensajeModel->crear($idUsuario, $asunto, $texto)) {
            redirigir('mis_mensajes', '&msg=enviado');
        }

        redirigir('contacto', '&msg=fallo');
    }

    // Muestra solamente los mensajes del usuario actual.
    public function misMensajes() {
        $idUsuario = (int)usuarioActualId();

        $mensajes = $this->mensajeModel->listarPorUsuario($idUsuario);
        $aviso = $this->leerAviso();

        require __DIR__ . '/../views/mis_mensajes.php';
    }

    // Prepara las variables que utiliza la vista de contacto.
    private function mostrarVistaContacto($asunto, $texto, $errores) {
        $maxAsunto = $this->maxAsunto;
        $maxTexto = $this->maxTexto;
        $aviso = $this->leerAviso();

        require __DIR__ . '/../views/contacto.php';
    }

    // Solo permite mostrar los avisos definidos en el controlador.
    private function leerAviso() {
        $clave = $_GET['msg'] ?? '';

        return (is_string($clave) && isset($this->avisos[$clave]))
            ? $this->avisos[$clave]
            : null;
    }
}
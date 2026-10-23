<?php

require_once __DIR__ . '/../models/UsuarioModel.php';

class UsuarioController
{
    private $conexion;
    private $usuarioModel;

    public function __construct($conexion){
        $this->conexion = $conexion;
        $this->usuarioModel = new UsuarioModel($conexion);
    }

    public function registro(){
        // Inicializa variables para almacenar errores y mensajes de éxito
        $errores = [];
        $nombre = '';
        $apellido = '';
        $email = '';
        $mensajeOk = '';  
        
        // Verifica si el formulario ha sido enviado
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $nombre = trim($_POST['nombre'] ?? '');
            $apellido = trim($_POST['apellido'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $contrasena = $_POST['contrasena'] ?? '';
            $confirmar_contrasena = $_POST['confirmar_contrasena'] ?? '';

            // Validaciones de los campos del formulario
            if(mb_strlen($nombre) < 2 || mb_strlen($nombre) > 50){
                $errores[] = "El nombre debe tener entre 2 y 50 caracteres.";
            }

            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $errores[] = "El correo electrónico no es válido.";
            } elseif($this->usuarioModel->existeEmail($email)){
                $errores[] = "El correo electrónico ya está registrado.";
            }

            if(strlen($contrasena) < 8){
                $errores[] = "La contraseña debe tener al menos 8 caracteres.";
            }

            if($contrasena !== $confirmar_contrasena){
                $errores[] = "Las contraseñas no coinciden.";
            }

            // Si no hay errores, procede a registrar al usuario
            if (empty($errores)) {
                $contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);

                if ($this->usuarioModel->crear($nombre, $apellido, $email, $contrasenaHash, 3)) {
                    header("Location: index.php?pagina=login&registro=ok");
                exit;
                } else {
                $errores[] = "No se pudo crear la cuenta. Intentá de nuevo.";
                }
            }
    }
    require __DIR__ . '/../views/register.php';
}
    public function login(){
        $errores = [];
        $email = '';
        $mensajeOk = '';

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $email = trim($_POST['email'] ?? '');
            $contrasena = $_POST['contrasena'] ?? '';

            if($email === '' || $contrasena === ''){
                $errores[] = "Todos los campos son obligatorios";
            } else {
                $usuario = $this->usuarioModel->buscarPorEmail($email);

                if($usuario && password_verify($contrasena, $usuario['contrasena'])){
                    iniciarSesionUsuario($usuario);
                    if (isset($usuario['rol']) && $usuario['rol'] === 1) {
                        header("Location: index.php?pagina=admin");
                    } else {
                        header("Location: index.php?pagina=home");
                    }
                } else {
                    $errores[] = "Correo electrónico o contraseña incorrectos";
                }
    }
    }
        require __DIR__ . '/../views/login.php';
    }   

    public function logout(){
        cerrarSesion();
        redirigir('login');
        exit;
    }
}
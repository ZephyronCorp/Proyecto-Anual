<?php 

/*
    Escapa caracteres especiales en una cadena para prevenir ataques XSS.
 */
function escapar($texto){
    return htmlspecialchars((string)$texto, ENT_QUOTES, 'UTF-8');
}

function redirigir($pagina, $extra = ''){
    header("Location: index.php?pagina=" . $pagina . $extra);
    exit;
}

// Verifica si el usuario ha iniciado sesión
function estaLogueado() {
    return isset($_SESSION['id_usuario']);
}

// Obtiene el ID del usuario actualmente logueado
function usuarioActualId() {
    return $_SESSION['id_usuario'] ?? null;
}

// Obtiene el nombre del usuario actualmente logueado
function usuarioActualNombre() {
    return $_SESSION['nombre'] ?? null;
}

// Obtiene el apellido del usuario actualmente logueado
function usuarioActualApellido() {
    return $_SESSION['apellido'] ?? null;
}

// Obtiene el rol del usuario actualmente logueado
function usuarioActualRol() {
    return $_SESSION['id_rol'] ?? null;
}

// Verifica si el usuario actual es un administrador
function esAdmin() {
    return isset($_SESSION['id_rol']) && $_SESSION['id_rol'] === 1;
}

// Inicia sesión para un usuario dado
function iniciarSesionUsuario($usuario) {
    session_regenerate_id(true); // Previene ataques de fijación de sesión
    $_SESSION['id_usuario'] = $usuario['id_usuario'];
    $_SESSION['nombre'] = $usuario['nombre'];
    $_SESSION['apellido'] = $usuario['apellido'];
    $_SESSION['id_rol'] = $usuario['id_rol'];
}

// Cierra la sesión del usuario actual
function cerrarSesion() {
    $_SESSION = []; // Limpia todas las variables de sesión
    session_destroy();// Destruye la sesión
}

// Requiere que el usuario haya iniciado sesión para acceder a ciertas páginas
function requerirLogin() {
    if (!estaLogueado()) {
        redirigir('login');
    }
}

function requerirRol($rol) {
    requerirLogin(); // Asegura que el usuario esté logueado antes de verificar el rol
    if (usuarioActualRol() !== $rol) {
        http_response_code(403);// Código de estado HTTP 403: Prohibido
        require __DIR__ . '/../views/sin_permiso.php'; // Muestra una página de error 403
        exit;
    }
}

// Comprueba que la cuenta siga activa y actualiza los datos de la sesión.
function sincronizarSesion($usuarioModel) {
    if (!estaLogueado()) {
        return;
    }

    $usuario = $usuarioModel->obtenerPorId(usuarioActualId());

    if (!$usuario || (int)$usuario['activo'] !== 1) {
        cerrarSesion();
        redirigir('login', '&cuenta=desactivada');
    }

    $_SESSION['id_rol'] = (int)$usuario['id_rol'];
    $_SESSION['nombre'] = $usuario['nombre'];
    $_SESSION['apellido'] = $usuario['apellido'];
}
<?php
    $servidor = "localhost";
    $usuario = "root";
    $contrasena = "";
    $baseDeDatos = "zonajoystick";
    // Crear conexión
    $conexion = mysqli_connect($servidor, $usuario, $contrasena, $baseDeDatos);
    // Verificar conexión
    if (!$conexion) {
        die("Conexión fallida: " . mysqli_connect_error());
    }

?>
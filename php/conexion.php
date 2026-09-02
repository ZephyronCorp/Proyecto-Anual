<?php
    $servidor = "localhost";
    $usuario = "root";
    $contrasena = "";
    $baseDeDatos = "zonajoystick";

    $conexion = mysqli_connect($servidor, $usuario, $contrasena, $baseDeDatos);

    if (!$conexion) {
        die("Conexión fallida: " . mysqli_connect_error());
    }

?>
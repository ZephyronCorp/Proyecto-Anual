
<?php

class UsuarioModel
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    /*Verifica si un email ya está registrado
    Convierte el email en un tipo de dato string utilizando bind_param
    */
    public function existeEmail($email){
        $stmt = $this->conexion->prepare("SELECT * FROM Usuario WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->num_rows > 0;
    }


    public function crear($nombre, $apellido, $email, $contrasena, $id_rol){
        $stmt = $this->conexion->prepare(
        "INSERT INTO Usuario (nombre, apellido, email, contrasena, id_rol) VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("ssssi", $nombre, $apellido, $email, $contrasena, $id_rol);
        return $stmt->execute();
    }

    public function buscarPorEmail($email){
        $stmt = $this->conexion->prepare("SELECT id_usuario, nombre, apellido, email, contrasena, id_rol FROM Usuario WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}

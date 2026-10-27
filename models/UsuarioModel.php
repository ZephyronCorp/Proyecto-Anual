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
        $stmt = $this->conexion->prepare("SELECT id_usuario, nombre, apellido, email, contrasena, id_rol, activo FROM Usuario WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function listarTodosAdmin(){
        $sql = "SELECT u.id_usuario, u.nombre, u.apellido, u.email,u.id_rol, u.activo, u.fecha_registro,COUNT(p.id_pedido) AS cantidad_pedidos 
                FROM Usuario u LEFT JOIN Pedido p ON p.id_usuario = u.id_usuario
                GROUP BY u.id_usuario, u.nombre, u.apellido, u.email,u.id_rol, u.activo, u.fecha_registro
                ORDER BY u.activo DESC, u.nombre ASC";
        return $this -> conexion -> query($sql) -> fetch_all(MYSQLI_ASSOC);
    }

    //Obtener un usuario por id
    public function obtenerPorId($id){
        $stmt = $this->conexion->prepare(
            "SELECT id_usuario, nombre, apellido, email, id_rol, activo 
        FROM Usuario WHERE id_usuario = ?"
        );
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    //Modificacion del rol de un usuario
    public function cambiarRol($id, $rol){
        $stmt = $this->conexion->prepare("UPDATE Usuario SET id_rol = ? WHERE id_usuario = ?");
        $stmt->bind_param("ii", $rol, $id);
        return $stmt->execute();
    }

    //Baja lógica de un usuario o reactivacion
    public function cambiarActivo($id, $activo){
        $stmt = $this->conexion->prepare("UPDATE Usuario SET activo = ? WHERE id_usuario = ?");
        $stmt->bind_param("ii", $activo, $id);
        return $stmt->execute();
    }
 }

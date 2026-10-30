<?php

class MensajeModel{
    private $conexion;
    
    public function __construct($conexion){
        $this -> conexion = $conexion;
    }

    //---Metodos para el cliente---

    //Guarda una consulta nueva. Devuelve true si se ejecuto correctamente
    public function crear ($idUsuario, $asunto, $contenido){
        $stmt = $this->conexion->prepare(
         "INSERT INTO mensaje (id_usuario, asunto, contenido) VALUES (?, ?, ?)"
        );

        $stmt->bind_param("iss", $idUsuario, $asunto, $contenido);
        return $stmt->execute();
    }

    //Los mensajes de un usuario, del más nuevo al mas viejo.
    
    public function listarPorUsuario($idUsuario){
        $stmt = $this->conexion->prepare(
            "SELECT id_mensaje, asunto, contenido, fecha, respuesta, fecha_respuesta
            FROM Mensaje
            WHERE id_usuario = ?
            ORDER BY fecha DESC"
        );

        $stmt->bind_param("i",$idUsuario);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    //Métodos para el panel de administración

    //Todos los mensajes con los datos del cliente.
    public function listarAdmin($filtro = ''){
        $sql = "SELECT m.id_mensaje, m.asunto, m.fecha, (m.respuesta IS NOT NULL) AS respondido, u.nombre AS cliente_nombre, u.email AS cliente_email
        FROM Mensaje m
        INNER JOIN Usuario u ON u.id_usuario = m.id_usuario
        WHERE 1=1";

        $orden = " ORDER BY m.fecha DESC";

        if($filtro === 'sin_responder'){
            $sql.= " AND m.respuesta IS NULL";
            $orden = " ORDER BY m.fecha ASC";
        } elseif ($filtro === 'respondidos'){
            $sql .= " AND m.respuesta IS NOT NULL";
        }
        return $this->conexion->query($sql . $orden)->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerParaAdmin($idMensaje) {
        $stmt = $this->conexion->prepare(
            "SELECT m.*, u.nombre AS cliente_nombre,
                    u.email AS cliente_email
             FROM Mensaje m
             INNER JOIN Usuario u ON u.id_usuario = m.id_usuario
             WHERE m.id_mensaje = ?"
        );
        $stmt->bind_param("i", $idMensaje);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

     // Guarda la respuesta solamente si el mensaje todavía no fue respondido.
    public function responder($idMensaje, $respuesta) {
        $stmt = $this->conexion->prepare(
            "UPDATE Mensaje
             SET respuesta = ?, fecha_respuesta = NOW()
             WHERE id_mensaje = ? AND respuesta IS NULL"
        );

        $stmt->bind_param("si", $respuesta, $idMensaje);
        $stmt->execute();

        return $stmt->affected_rows === 1;
    }

    // Cuenta los mensajes sin responder para el aviso del panel.
    public function contarSinResponder() {
        $resultado = $this->conexion->query(
            "SELECT COUNT(*) AS cantidad
             FROM Mensaje
             WHERE respuesta IS NULL"
        );

        return (int)$resultado->fetch_assoc()['cantidad'];
    }
}
<?php

class PagoModel{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    // Registra el intento de pago Y actualiza el estado del pedido.
    // Devuelve true si salió bien, false si falló.
    public function registrarIntento($idPedido, $monto, $ultimos4, $resultado){
        $nuevoEstado =  ($resultado === 'aprobado') ? 'pagado' : 'rechazado';
        $this->conexion->begin_transaction();
        try {
            //Guardar el pago
            $stmt = $this->conexion->prepare(
            "INSERT INTO pago(id_pedido, monto, ultimos4, resultado) VALUES (?, ?, ?, ?)"
            );
            $stmt->bind_param("idss", $idPedido,$monto, $ultimos4, $resultado);        
            if(!$stmt->execute()){
                throw new Exception("No se pudo registrar el pago.");
            }

            //Actializar el estado del pedido
            $stmt = $this->conexion->prepare(
                "UPDATE pedido SET estado = ? WHERE id_pedido = ?"
            );
            $stmt->bind_param("si", $nuevoEstado, $idPedido);
            if (!$stmt->execute()) {
                throw new Exception("No se pudo actualizar el pedido");
            }

            $this->conexion->commit();
            return true;
        
        } catch (Throwable $e) {
            $this->conexion->rollback();
            return false;
        }
    }

        // Último pago aprobado de un pedido.
        public function obtenerAprobado($idPedido){
            $stmt = $this->conexion->prepare(
                "SELECT ultimos4, monto, fecha FROM pago WHERE id_pedido = ? AND resultado = 'aprobado' ORDER BY id DESC LIMIT 1"
            );

            $stmt->bind_param("i", $idPedido);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        } 

}

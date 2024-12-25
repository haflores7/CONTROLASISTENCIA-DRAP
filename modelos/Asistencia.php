<?php 
require_once "../admin/config/Conexion.php";

class Asistencia {
    public function verificarcodigo_persona($codigo_persona) {
        $sql = "SELECT u.*, d.nombre as nombre_departamento 
                FROM usuarios u 
                LEFT JOIN departamento d ON u.iddepartamento = d.iddepartamento 
                WHERE u.codigo_persona='$codigo_persona'";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function seleccionarcodigo_persona($codigo_persona) {
        $sql = "SELECT * FROM asistencia 
                WHERE codigo_persona = '$codigo_persona' 
                AND DATE(fecha_hora) = CURDATE() 
                ORDER BY fecha_hora DESC, idasistencia DESC 
                LIMIT 1";
        return ejecutarConsulta($sql);
    }

    public function verificar_entrada_existente($codigo_persona) {
        $sql = "SELECT COUNT(*) as total FROM asistencia 
                WHERE codigo_persona = '$codigo_persona' 
                AND DATE(fecha_hora) = CURDATE() 
                AND tipo = 'Entrada'";
        $result = ejecutarConsultaSimpleFila($sql);
        return $result['total'] > 0;
    }

    public function verificar_salida_existente($codigo_persona) {
        $sql = "SELECT COUNT(*) as total FROM asistencia 
                WHERE codigo_persona = '$codigo_persona' 
                AND DATE(fecha_hora) = CURDATE() 
                AND tipo = 'Salida'";
        $result = ejecutarConsultaSimpleFila($sql);
        return $result['total'] > 0;
    }

    public function registrar_entrada($codigo_persona, $tipo) {
        date_default_timezone_set('America/Lima');
        $fecha = date("Y-m-d");
        $fecha_hora = date("Y-m-d H:i:s");
        
        $sql = "INSERT INTO asistencia (codigo_persona, tipo, fecha, fecha_hora) 
                VALUES ('$codigo_persona', '$tipo', '$fecha', '$fecha_hora')";
        return ejecutarConsulta($sql);
    }

    public function registrar_salida($codigo_persona, $tipo) {
        date_default_timezone_set('America/Lima');
        $fecha = date("Y-m-d");
        $fecha_hora = date("Y-m-d H:i:s");
        
        $sql = "INSERT INTO asistencia (codigo_persona, tipo, fecha, fecha_hora) 
                VALUES ('$codigo_persona', '$tipo', '$fecha', '$fecha_hora')";
        return ejecutarConsulta($sql);
    }

    public function obtenerHistorial($codigo_persona) {
        $sql = "SELECT a.tipo, a.fecha_hora, u.nombre, u.apellidos, d.nombre as nombre_departamento
                FROM asistencia a
                INNER JOIN usuarios u ON a.codigo_persona = u.codigo_persona
                LEFT JOIN departamento d ON u.iddepartamento = d.iddepartamento
                WHERE a.codigo_persona = '$codigo_persona' 
                AND YEAR(a.fecha_hora) = 2024
                ORDER BY a.fecha_hora DESC 
                LIMIT 30";
        
        $result = ejecutarConsulta($sql);
        if($result->num_rows > 0) {
            $registros = [];
            while($row = $result->fetch_assoc()) {
                $registros[] = $row;
            }
            return $registros;
        }
        return false;
    }

    public function listarAsistenciasHoy() {
        $sql = "SELECT a.*, u.nombre, u.apellidos, d.nombre as departamento 
                FROM asistencia a
                INNER JOIN usuarios u ON a.codigo_persona = u.codigo_persona
                LEFT JOIN departamento d ON u.iddepartamento = d.iddepartamento
                WHERE YEAR(a.fecha_hora) = 2024
                ORDER BY a.fecha_hora DESC";
        return ejecutarConsulta($sql);
    }

    public function listarAsistenciasPorFecha($fecha_inicio, $fecha_fin, $codigo_persona = null) {
        $sql = "SELECT a.idasistencia, a.codigo_persona, a.tipo, a.fecha_hora, 
                u.nombre, u.apellidos, d.nombre as departamento 
                FROM asistencia a
                INNER JOIN usuarios u ON a.codigo_persona = u.codigo_persona
                LEFT JOIN departamento d ON u.iddepartamento = d.iddepartamento
                WHERE DATE(a.fecha_hora) BETWEEN '$fecha_inicio' AND '$fecha_fin'";
        
        if ($codigo_persona) {
            $sql .= " AND a.codigo_persona = '$codigo_persona'";
        }
        
        $sql .= " ORDER BY a.fecha_hora DESC";
        return ejecutarConsulta($sql);
    }

    public function listarAsistencias() {
        $sql = "SELECT a.idasistencia, a.codigo_persona, a.tipo, a.fecha_hora, 
                u.nombre, u.apellidos, d.nombre as departamento 
                FROM asistencia a
                INNER JOIN usuarios u ON a.codigo_persona = u.codigo_persona
                LEFT JOIN departamento d ON u.iddepartamento = d.iddepartamento
                ORDER BY a.fecha_hora DESC";
        return ejecutarConsulta($sql);
    }

    public function eliminar($idasistencia) {
        $sql = "DELETE FROM asistencia WHERE idasistencia='$idasistencia'";
        return ejecutarConsulta($sql);
    }

    public function eliminarTodo() {
        $sql = "DELETE FROM asistencia WHERE idasistencia > 0";
        $resultado = ejecutarConsulta($sql);
        
        if($resultado) {
            // Reiniciar el auto_increment
            $sql_reset = "ALTER TABLE asistencia AUTO_INCREMENT = 1";
            ejecutarConsulta($sql_reset);
            return true;
        }
        return false;
    }
}
?>

<?php 
require_once "global.php";

try {
    // Intentar primero con localhost
    $conexion = @mysqli_connect("localhost", DB_USERNAME, DB_PASSWORD, DB_NAME);
    
    if (!$conexion) {
        // Si falla, intentar con 127.0.0.1
        $conexion = @mysqli_connect("127.0.0.1", DB_USERNAME, DB_PASSWORD, DB_NAME);
        
        if (!$conexion) {
            throw new Exception("Error de conexión: " . mysqli_connect_error());
        }
    }
    
    mysqli_query($conexion, "SET NAMES '" . DB_ENCODE . "'");
    
} catch (Exception $e) {
    error_log("Error de conexión: " . $e->getMessage());
    die("Error de conexión a la base de datos. Por favor, verifica que MySQL esté corriendo.");
}

function ejecutarConsulta($sql) {
    global $conexion;
    $query = mysqli_query($conexion, $sql);
    if (!$query) {
        error_log("Error en la consulta: " . mysqli_error($conexion));
    }
    return $query;
}

function ejecutarConsultaSimpleFila($sql) {
    global $conexion;
    $query = mysqli_query($conexion, $sql);
    if (!$query) {
        error_log("Error en la consulta: " . mysqli_error($conexion));
        return null;
    }
    return mysqli_fetch_assoc($query);
}

function ejecutarConsulta_retornarID($sql) {
    global $conexion;
    $query = mysqli_query($conexion, $sql);
    if (!$query) {
        error_log("Error en la consulta: " . mysqli_error($conexion));
        return null;
    }
    return mysqli_insert_id($conexion);
}

function limpiarCadena($str) {
    global $conexion;
    $str = mysqli_real_escape_string($conexion, trim($str));
    return htmlspecialchars($str);
}
?>
<?php
// Al inicio del archivo
error_reporting(E_ALL);
ini_set('display_errors', 1);
set_time_limit(30); // Timeout de 30 segundos

// Verificar conexión a la base de datos
require_once "admin/config/Conexion.php";
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

//redireccionar a la vista de login

header('location: vistas/asistencia.php');  
 ?>
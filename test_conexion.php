<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Probando conexión...<br>";

$host = "127.0.0.1";
$user = "root";
$pass = "";
$db = "control_asistencia1";

try {
    $conn = mysqli_connect($host, $user, $pass, $db);
    if ($conn) {
        echo "Conexión exitosa!<br>";
        
        // Probar una consulta simple
        $result = mysqli_query($conn, "SELECT VERSION()");
        if ($result) {
            $row = mysqli_fetch_array($result);
            echo "Versión MySQL: " . $row[0];
        }
        
        mysqli_close($conn);
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?> 
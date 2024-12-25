<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Test de conexión MySQL<br>";
echo "PHP Version: " . phpversion() . "<br>";

// Prueba 1: Conexión simple
try {
    $conn1 = @mysqli_connect("localhost", "root", "");
    echo "Conexión 1 (localhost): " . ($conn1 ? "OK" : "FALLO") . "<br>";
} catch (Exception $e) {
    echo "Error 1: " . $e->getMessage() . "<br>";
}

// Prueba 2: Conexión con IP
try {
    $conn2 = @mysqli_connect("127.0.0.1", "root", "");
    echo "Conexión 2 (127.0.0.1): " . ($conn2 ? "OK" : "FALLO") . "<br>";
} catch (Exception $e) {
    echo "Error 2: " . $e->getMessage() . "<br>";
}

// Verificar si el puerto está en uso
$connection = @fsockopen("127.0.0.1", 3306);
if (is_resource($connection)) {
    echo "Puerto 3306 está abierto<br>";
    fclose($connection);
} else {
    echo "Puerto 3306 está cerrado<br>";
}

// Mostrar errores de MySQL si existen
if (mysqli_connect_errno()) {
    echo "Error MySQL: " . mysqli_connect_error() . "<br>";
}

// Información del sistema
echo "<br>Información del sistema:<br>";
echo "Sistema operativo: " . PHP_OS . "<br>";
echo "Servidor web: " . $_SERVER['SERVER_SOFTWARE'] . "<br>";

// Verificar extensión MySQL
echo "<br>Extensiones PHP cargadas:<br>";
$extensions = get_loaded_extensions();
foreach ($extensions as $extension) {
    if (strpos(strtolower($extension), 'mysql') !== false) {
        echo "- " . $extension . "<br>";
    }
}
?> 
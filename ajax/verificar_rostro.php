<?php
require_once "../modelos/Asistencia.php";

$asistencia = new Asistencia();

$codigo_persona = isset($_POST["codigo_persona"]) ? $_POST["codigo_persona"] : "";
$foto_actual = isset($_POST["foto_actual"]) ? $_POST["foto_actual"] : "";

// Obtener foto de referencia
$foto_referencia = $asistencia->obtenerFotoReferencia($codigo_persona);

if (!$foto_referencia) {
    echo json_encode(["match" => false, "mensaje" => "No hay foto de referencia registrada"]);
    exit;
}

// Aquí iría la lógica de comparación facial usando face-api.js o similar
$similitud = comparar_rostros($foto_actual, $foto_referencia);

echo json_encode([
    "match" => $similitud > 0.8,
    "similitud" => $similitud
]);
?> 
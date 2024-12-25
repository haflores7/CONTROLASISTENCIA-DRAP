<?php
require_once "../modelos/Asistencia.php";

$asistencia = new Asistencia();

$codigo_persona = isset($_POST["codigo_persona"]) ? $_POST["codigo_persona"] : "";
$huella_dispositivo = isset($_POST["huella_dispositivo"]) ? $_POST["huella_dispositivo"] : "";

$dispositivo_autorizado = $asistencia->verificarDispositivo($codigo_persona, $huella_dispositivo);

echo json_encode([
    "dispositivo_autorizado" => $dispositivo_autorizado
]);
?> 
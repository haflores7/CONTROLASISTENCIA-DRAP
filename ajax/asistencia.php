<?php 
// Mostrar errores de PHP (solo para desarrollo)
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error.log');

// Asegurarse de que la respuesta sea JSON
header('Content-Type: application/json');

try {
    require_once "../modelos/Asistencia.php";
    
    if (strlen(session_id()) < 1) 
        session_start();

    $asistencia = new Asistencia();
    
    // Obtener la operación del POST o GET
    $op = isset($_POST["op"]) ? $_POST["op"] : (isset($_GET["op"]) ? $_GET["op"] : null);
    
    if (!$op) {
        throw new Exception("No se especificó la operación");
    }

    $codigo_persona = isset($_POST["codigo_persona"]) ? limpiarCadena($_POST["codigo_persona"]) : "";
    
    error_log("Operación solicitada: " . $op);
    error_log("Código de persona: " . $codigo_persona);
    
    switch ($op) {
        case 'registrar_asistencia':
            if (empty($codigo_persona)) {
                throw new Exception("Código de persona no proporcionado");
            }

            // Verificar que el código de persona existe
            $persona = $asistencia->verificarcodigo_persona($codigo_persona);
            if (!$persona) {
                throw new Exception("Código de persona no válido");
            }

            // Obtener el último registro del día
            $sql = "SELECT * FROM asistencia 
                    WHERE codigo_persona = '$codigo_persona' 
                    AND DATE(fecha_hora) = CURDATE() 
                    ORDER BY fecha_hora DESC, idasistencia DESC 
                    LIMIT 1";
            
            $rspta = ejecutarConsulta($sql);
            $total = mysqli_num_rows($rspta);

            if ($total > 0) {
                $row = mysqli_fetch_assoc($rspta);
                $tipo = $row['tipo'];
                
                if ($tipo == "Entrada") {
                    // Si el último registro es entrada, registramos salida
                    $rspta = $asistencia->registrar_salida($codigo_persona, "Salida");
                    $mensaje = "Salida registrada";
                } else {
                    // Si el último registro es salida, registramos entrada
                    $rspta = $asistencia->registrar_entrada($codigo_persona, "Entrada");
                    $mensaje = "Entrada registrada";
                }
            } else {
                // Si no hay registros hoy, registramos entrada
                $rspta = $asistencia->registrar_entrada($codigo_persona, "Entrada");
                $mensaje = "Entrada registrada";
            }

            if($rspta) {
                echo json_encode([
                    'status' => 'success',
                    'mensaje' => $mensaje . ' correctamente'
                ]);
            } else {
                throw new Exception("Error al registrar la asistencia");
            }
            break;

        case 'buscar_historial':
            if (empty($codigo_persona)) {
                throw new Exception("Código de persona no proporcionado");
            }

            // Verificar que el código de persona existe
            $persona = $asistencia->verificarcodigo_persona($codigo_persona);
            if (!$persona) {
                echo json_encode([
                    'success' => false,
                    'message' => 'No se encontró ningún usuario con ese código'
                ]);
                break;
            }

            // Obtener el historial de asistencias
            $registros = $asistencia->obtenerHistorial($codigo_persona);
            
            if ($registros) {
                // Formatear las fechas y horas
                foreach ($registros as &$registro) {
                    $fecha_hora = new DateTime($registro['fecha_hora']);
                    $registro['fecha_formateada'] = $fecha_hora->format('d/m/Y');
                    $registro['hora_formateada'] = $fecha_hora->format('H:i:s');
                }

                echo json_encode([
                    'success' => true,
                    'empleado' => [
                        'nombre' => $persona['nombre'] . ' ' . $persona['apellidos'],
                        'departamento' => $persona['nombre_departamento']
                    ],
                    'registros' => $registros
                ]);
            } else {
                echo json_encode([
                    'success' => true,
                    'empleado' => [
                        'nombre' => $persona['nombre'] . ' ' . $persona['apellidos'],
                        'departamento' => $persona['nombre_departamento']
                    ],
                    'registros' => []
                ]);
            }
            break;

        default:
            throw new Exception("Operación no válida: " . $op);
    }
} catch (Exception $e) {
    error_log("Error en asistencia.php: " . $e->getMessage());
    error_log("Trace: " . $e->getTraceAsString());
    
    echo json_encode([
        'status' => 'error',
        'mensaje' => 'Error: ' . $e->getMessage()
    ]);
}
?>
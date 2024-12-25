<?php
// URLs de face-api.js y modelos
$urls = [
    'face-api' => 'https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js',
    'tiny_face_detector' => [
        'manifest' => 'https://raw.githubusercontent.com/justadudewhohacks/face-api.js/master/weights/tiny_face_detector_model-weights_manifest.json',
        'shard1' => 'https://raw.githubusercontent.com/justadudewhohacks/face-api.js/master/weights/tiny_face_detector_model-shard1'
    ],
    'face_landmark_68' => [
        'manifest' => 'https://raw.githubusercontent.com/justadudewhohacks/face-api.js/master/weights/face_landmark_68_model-weights_manifest.json',
        'shard1' => 'https://raw.githubusercontent.com/justadudewhohacks/face-api.js/master/weights/face_landmark_68_model-shard1'
    ]
];

// Directorios de destino (usando las rutas existentes)
$jsDir = 'admin/public/js';
$modelsDir = 'admin/public/models';

// Verificar si los directorios existen
if (!file_exists($jsDir)) {
    echo "✗ Error: El directorio $jsDir no existe\n";
    exit(1);
}

if (!file_exists($modelsDir)) {
    if (!mkdir($modelsDir, 0777, true)) {
        echo "✗ Error: No se pudo crear el directorio $modelsDir\n";
        exit(1);
    }
    echo "✓ Directorio creado: $modelsDir\n";
}

// Función para descargar archivo
function downloadFile($url, $destino) {
    echo "Descargando: " . basename($destino) . "\n";
    
    $ch = curl_init($url);
    $fp = fopen($destino, 'wb');
    
    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');
    
    $exito = curl_exec($ch);
    $error = curl_error($ch);
    
    curl_close($ch);
    fclose($fp);
    
    if ($exito && file_exists($destino) && filesize($destino) > 0) {
        echo "✓ Archivo descargado correctamente: " . basename($destino) . "\n";
        return true;
    } else {
        echo "✗ Error al descargar " . basename($destino) . ": $error\n";
        return false;
    }
}

// Verificar si face-api.js ya existe
if (!file_exists($jsDir . '/face-api.min.js')) {
    // Descargar face-api.js solo si no existe
    $success = downloadFile($urls['face-api'], $jsDir . '/face-api.min.js');
} else {
    echo "✓ face-api.min.js ya existe\n";
    $success = true;
}

if ($success) {
    // Descargar modelos
    foreach (['tiny_face_detector', 'face_landmark_68'] as $model) {
        downloadFile($urls[$model]['manifest'], $modelsDir . "/{$model}_model-weights_manifest.json");
        downloadFile($urls[$model]['shard1'], $modelsDir . "/{$model}_model-shard1");
    }
}

echo "\nProceso completado.\n";
echo "\nArchivos en:\n";
echo "- JavaScript: $jsDir/face-api.min.js\n";
echo "- Modelos: $modelsDir/\n";

// Verificar la instalación
echo "\nVerificando archivos...\n";
$files = [
    $jsDir . '/face-api.min.js',
    $modelsDir . '/tiny_face_detector_model-weights_manifest.json',
    $modelsDir . '/tiny_face_detector_model-shard1',
    $modelsDir . '/face_landmark_68_model-weights_manifest.json',
    $modelsDir . '/face_landmark_68_model-shard1'
];

$allFilesExist = true;
foreach ($files as $file) {
    if (file_exists($file) && filesize($file) > 0) {
        echo "✓ " . basename($file) . " existe y tiene contenido\n";
    } else {
        echo "✗ " . basename($file) . " no existe o está vacío\n";
        $allFilesExist = false;
    }
}

if ($allFilesExist) {
    echo "\n✓ Todos los archivos necesarios están instalados correctamente\n";
} else {
    echo "\n✗ Algunos archivos no se instalaron correctamente. Por favor, revise los errores anteriores.\n";
}
?> 
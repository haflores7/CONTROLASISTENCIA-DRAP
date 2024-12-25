<?php
// URLs de los modelos
$modelos = [
    'tiny_face_detector_model-weights_manifest.json' => 'https://github.com/justadudewhohacks/face-api.js/raw/master/weights/tiny_face_detector_model-weights_manifest.json',
    'tiny_face_detector_model-shard1' => 'https://github.com/justadudewhohacks/face-api.js/raw/master/weights/tiny_face_detector_model-shard1',
    'face_landmark_68_model-weights_manifest.json' => 'https://github.com/justadudewhohacks/face-api.js/raw/master/weights/face_landmark_68_model-weights_manifest.json',
    'face_landmark_68_model-shard1' => 'https://github.com/justadudewhohacks/face-api.js/raw/master/weights/face_landmark_68_model-shard1',
    'face_recognition_model-weights_manifest.json' => 'https://github.com/justadudewhohacks/face-api.js/raw/master/weights/face_recognition_model-weights_manifest.json',
    'face_recognition_model-shard1' => 'https://github.com/justadudewhohacks/face-api.js/raw/master/weights/face_recognition_model-shard1'
];

// Crear directorio si no existe
$dir = __DIR__ . '/admin/public/models';
if (!file_exists($dir)) {
    mkdir($dir, 0777, true);
}

// Descargar cada modelo
foreach ($modelos as $nombre => $url) {
    $destino = $dir . '/' . $nombre;
    
    echo "Descargando $nombre...\n";
    
    // Usar cURL para descargar
    $ch = curl_init($url);
    $fp = fopen($destino, 'wb');
    
    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Para permitir HTTPS
    
    $exito = curl_exec($ch);
    
    if ($exito) {
        echo "✓ $nombre descargado correctamente\n";
    } else {
        echo "✗ Error al descargar $nombre: " . curl_error($ch) . "\n";
    }
    
    curl_close($ch);
    fclose($fp);
}

echo "\nProceso completado. Los modelos se han descargado en: $dir\n";
?> 
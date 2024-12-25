<?php
require_once "../config/Conexion.php";

class FacialRecognition {
    private $apiKey = 'TU_API_KEY_AQUI';
    private $endpoint = 'TU_ENDPOINT_AQUI';

    public function verificarRostro($imagenBase64, $empleadoId) {
        // Convertir base64 a imagen
        $imagen = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imagenBase64));
        
        // Configuración de la llamada a Azure
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->endpoint . '/face/v1.0/detect');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $imagen);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/octet-stream',
            'Ocp-Apim-Subscription-Key: ' . $this->apiKey
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        
        if ($err) {
            return [
                'error' => true,
                'mensaje' => 'Error en la verificación facial: ' . $err
            ];
        }
        
        $resultado = json_decode($response, true);
        
        // Verificar si se detectó un rostro
        if (empty($resultado)) {
            return [
                'error' => true,
                'mensaje' => 'No se detectó ningún rostro en la imagen'
            ];
        }
        
        // Aquí puedes agregar más lógica de verificación
        // Por ejemplo, comparar con una foto guardada previamente
        
        return [
            'error' => false,
            'mensaje' => 'Verificación facial exitosa'
        ];
    }
}
?> 
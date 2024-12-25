<?php
session_start();

// Forzar el uso de la IP local específica
$baseUrl = "https://192.168.1.7";  // Tu IP local específica
$registroUrl = $baseUrl . "/control_asistencia1/vistas/registro_movil.php";
$timestamp = floor(time() / 30);
$token = hash('sha256', $timestamp . '_DRAP_SECRET_KEY');
$urlCompleta = $registroUrl . "?token=" . $token;

// Para verificar la URL generada
error_log("URL QR generada: " . $urlCompleta);

// Verificar que el archivo registro_movil.php existe
if (!file_exists("registro_movil.php")) {
    error_log("Error: registro_movil.php no encontrado");
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ControlAsistencia | DRAP</title>
    <link rel="stylesheet" href="../admin/public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../admin/public/css/font-awesome.css">
    <link rel="stylesheet" href="../admin/public/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../admin/public/css/blue.css">
    <link rel="shortcut icon" href="../admin/public/img/images.png">
    <style>
        body.lockscreen {
            background: linear-gradient(135deg, #1a472a 0%, #2d8a3e 100%);
            min-height: 100vh;
        }

        .lockscreen-wrapper {
            margin: 2% auto;
            max-width: 500px;
            padding: 20px;
        }

        .lockscreen-logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .lockscreen-logo a {
            color: white;
            font-size: 32px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        .qr-section {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }

        .logo-container {
            margin-bottom: 20px;
        }

        .logo-drap {
            width: 120px;
            height: 120px;
            margin: 0 auto;
        }

        .access-container {
            margin: 25px 0;
        }

        .btn-mobile {
            background: #28a745;
            padding: 12px 25px;
            font-size: 18px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-mobile:hover {
            background: #218838;
            transform: translateY(-2px);
        }

        .qr-wrapper {
            margin: 20px 0;
        }

        #qr-registro {
            display: inline-block;
            padding: 15px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .admin-link {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: white;
            padding: 10px 20px;
            border-radius: 8px;
            color: #1a472a;
            text-decoration: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .admin-link:hover {
            background: #1a472a;
            color: white;
        }

        .text-muted {
            color: #6c757d;
            margin: 10px 0;
        }
    </style>
</head>
<body class="hold-transition lockscreen">

<div class="lockscreen-wrapper">
    <div class="lockscreen-logo">
        <a href="#"><b>Control Asistencia</b> | DRAP</a>
    </div>

    <div class="qr-section text-center">
        <div class="logo-container">
            <img src="../admin/files/negocio/images.png" alt="DRAP Logo" class="logo-drap">
        </div>

        <h4>Registro de Asistencia</h4>

        <div class="access-container">
            <a href="<?php echo $urlCompleta; ?>" class="btn btn-success btn-mobile">
                <i class="fa fa-mobile"></i> Acceder desde el móvil
            </a>
        </div>

        <div class="qr-wrapper">
            <p class="text-muted">O escanea este código QR:</p>
            <div id="qr-registro"></div>
        </div>
    </div>

    <a href="../admin/" class="admin-link">
        <i class="fa fa-lock"></i> Administración
    </a>
</div>

<!-- Scripts -->
<script src="../admin/public/js/jquery-3.1.1.min.js"></script>
<script src="../admin/public/js/bootstrap.min.js"></script>
<script src="../admin/public/js/bootbox.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script type="text/javascript" src="scripts/asistencia.js"></script>
<script>
$(document).ready(function() {
    // Agregar log para verificar la URL
    console.log("URL generada:", '<?php echo $urlCompleta; ?>');
    
    const qrContainer = document.getElementById("qr-registro");
    if (qrContainer) {
        while (qrContainer.firstChild) {
            qrContainer.removeChild(qrContainer.firstChild);
        }
        
        new QRCode(qrContainer, {
            text: '<?php echo $urlCompleta; ?>',
            width: 200,
            height: 200,
            colorDark : "#000000",
            colorLight : "#ffffff",
            correctLevel : QRCode.CorrectLevel.H
        });
    }
});
</script>

</body>
</html> 

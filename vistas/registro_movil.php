<?php
require_once "../admin/config/Conexion.php";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Registro de Asistencia | DRAP</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="../admin/public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../admin/public/css/font-awesome.css">
    <link rel="stylesheet" href="../admin/public/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../admin/public/css/_all-skins.min.css">
    <link rel="shortcut icon" href="../admin/public/img/images.png">
    
    <!-- Cargar face-api.js -->
    <script src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>

    <style>
        body {
            background: linear-gradient(135deg, #00b09b, #96c93d);
            min-height: 100vh;
            margin: 0;
            padding: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .main-container {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
            padding: 15px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .logo-container {
            text-align: center;
            margin-bottom: 15px;
            padding: 10px;
        }
        .logo-container img {
            width: 60px;
            height: auto;
            margin-bottom: 10px;
            border-radius: 50%;
            padding: 5px;
            background: white;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            animation: float 3s ease-in-out infinite;
        }
        .logo-container h2 {
            color: #2c3e50;
            font-size: 20px;
            font-weight: 600;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .login-form {
            background: white;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
        }
        .form-group {
            position: relative;
            margin-bottom: 0;
        }
        .form-control {
            height: 40px;
            padding-left: 35px;
            font-size: 14px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
        }
        .form-group i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            font-size: 16px;
        }
        .camera-container {
            background: white;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-bottom: 15px;
            text-align: center;
            position: relative;
            width: 340px;
            margin: 0 auto;
        }
        #video {
            width: 320px !important;
            height: 240px !important;
            border-radius: 8px;
            transform: scaleX(-1);
            object-fit: cover;
        }
        .overlay {
            position: absolute;
            top: 10px;
            left: 10px;
            right: 10px;
            bottom: 10px;
            z-index: 1;
        }
        #captured-photo {
            max-width: 280px;
            height: 210px;
            border-radius: 8px;
            display: none;
            margin: 0 auto;
        }
        .camera-controls {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 10px;
            margin-bottom: 10px;
        }
        .btn {
            height: 35px;
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 0 15px;
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            position: relative;
            overflow: hidden;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        .btn:before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255,255,255,0.2);
            transition: all 0.4s ease;
        }
        .btn:hover:before {
            left: 100%;
        }
        .btn-primary {
            background: linear-gradient(45deg, #4481eb, #04befe);
            color: white;
        }
        .btn-primary:hover {
            background: linear-gradient(45deg, #04befe, #4481eb);
            color: #fff;
        }
        .btn-success {
            background: linear-gradient(45deg, #11998e, #38ef7d);
            color: white;
        }
        .btn-success:hover {
            background: linear-gradient(45deg, #38ef7d, #11998e);
            color: #fff;
        }
        .btn-danger {
            background: linear-gradient(45deg, #fe5196, #f77062);
            color: white;
        }
        .btn-danger:hover {
            background: linear-gradient(45deg, #f77062, #fe5196);
        }
        .btn-warning {
            background: linear-gradient(45deg, #f6d365, #fda085);
            color: white;
        }
        .btn-warning:hover {
            background: linear-gradient(45deg, #fda085, #f6d365);
            color: #fff;
        }
        .btn-info {
            background: linear-gradient(45deg, #45b7d1, #2bdce3);
            color: white;
        }
        .btn-info:hover {
            background: linear-gradient(45deg, #2bdce3, #45b7d1);
            color: #fff;
        }
        .btn-small {
            height: 35px;
            padding: 0 15px;
            font-size: 13px;
        }
        .main-buttons {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 10px;
        }
        .main-buttons .btn {
            margin: 0;
            width: 100%;
            height: 40px;
        }
        .btn-historial {
            background: linear-gradient(45deg, #764ba2, #667eea);
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            width: 100%;
            position: relative;
            overflow: hidden;
        }
        .btn-historial:hover {
            background: linear-gradient(45deg, #667eea, #764ba2);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            color: #fff;
        }
        .btn-historial:before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255,255,255,0.2);
            transition: all 0.4s ease;
        }
        .btn-historial:hover:before {
            left: 100%;
        }
        .alert {
            padding: 8px;
            margin-bottom: 10px;
            font-size: 13px;
        }
        #mensaje {
            margin-bottom: 10px;
        }
        .admin-link {
            position: fixed;
            top: 20px;
            right: 20px;
            background: linear-gradient(135deg, #00b09b, #96c93d);
            color: white;
            padding: 12px 25px;
            border-radius: 30px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 15px rgba(0, 176, 155, 0.3);
            transition: all 0.3s ease;
            z-index: 1000;
            display: flex;
            align-items: center;
            gap: 8px;
            border: 2px solid rgba(255, 255, 255, 0.2);
        }
        .admin-link:hover {
            background: linear-gradient(135deg, #96c93d, #00b09b);
            transform: translateY(-2px) scale(1.03);
            box-shadow: 0 6px 20px rgba(0, 176, 155, 0.4);
            color: white;
            text-decoration: none;
        }
        .admin-link:active {
            transform: translateY(-1px);
            box-shadow: 0 3px 10px rgba(0, 176, 155, 0.3);
        }
        .admin-link i {
            font-size: 16px;
            background: rgba(255, 255, 255, 0.2);
            padding: 8px;
            border-radius: 50%;
            transition: all 0.3s ease;
        }
        .admin-link:hover i {
            background: rgba(255, 255, 255, 0.3);
            transform: rotate(360deg);
        }
        @keyframes pulse {
            0% {
                box-shadow: 0 4px 15px rgba(0, 176, 155, 0.3);
            }
            50% {
                box-shadow: 0 4px 20px rgba(0, 176, 155, 0.5);
            }
            100% {
                box-shadow: 0 4px 15px rgba(0, 176, 155, 0.3);
            }
        }
        .admin-link {
            animation: pulse 2s infinite;
        }
        .admin-link:hover {
            animation: none;
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        .btn.disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        
        .btn:not(.disabled) {
            cursor: pointer;
        }

        #btnCapture {
            transition: all 0.3s ease;
        }

        #btnCapture:not(.disabled):hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        canvas {
            position: absolute;
            top: 0;
            left: 0;
        }
        .modal-header {
            background: linear-gradient(135deg, #00b09b, #96c93d);
            color: white;
            border-radius: 5px 5px 0 0;
        }
        .modal-title {
            font-weight: 600;
        }
        .employee-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .info-item {
            margin: 8px 0;
        }
        .info-label {
            font-weight: bold;
            color: #2c3e50;
        }
        .table-asistencia {
            margin-top: 15px;
        }
        .badge-entrada {
            background-color: #28a745;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
        }
        .badge-salida {
            background-color: #dc3545;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
        }
        .table-asistencia th {
            background-color: #f1f8f1;
        }

        /* Estilos para el modal de éxito */
        .simple-success-circle {
            width: 80px;
            height: 80px;
            background-color: #4CAF50;
            border-radius: 50%;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #successModal .modal-content {
            border-radius: 10px;
            border: none;
        }

        #successModal .modal-body {
            padding: 2rem;
        }

        #successMessage {
            color: #333;
            font-size: 1.2rem;
            margin-top: 1rem;
        }

        .modal.fade .modal-dialog {
            transition: transform .3s ease-out;
        }

        .modal.show .modal-dialog {
            transform: none;
        }

        /* Estilos para el modal de historial */
        #asistenciasModal .modal-content {
            background: linear-gradient(145deg, #ffffff, #f5f5f5);
            border-radius: 20px;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        #asistenciasModal .modal-header {
            background: linear-gradient(135deg, #4481eb, #04befe);
            color: white;
            border-bottom: none;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        #asistenciasModal .modal-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 100%);
            z-index: 1;
        }

        #asistenciasModal .modal-title {
            font-size: 1.5rem;
            font-weight: 700;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
            position: relative;
            z-index: 2;
        }

        #asistenciasModal .close {
            color: white;
            text-shadow: none;
            opacity: 0.8;
            transition: all 0.3s ease;
            position: relative;
            z-index: 2;
        }

        #asistenciasModal .close:hover {
            opacity: 1;
            transform: rotate(90deg);
        }

        #asistenciasModal .modal-body {
            padding: 2rem;
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(10px);
        }

        .employee-info {
            background: linear-gradient(145deg, #f8f9fa, #ffffff);
            padding: 1.5rem;
            border-radius: 15px;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            border: 1px solid rgba(0,0,0,0.05);
            position: relative;
            overflow: hidden;
        }

        .employee-info::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #4481eb, #04befe);
        }

        .employee-info h5 {
            color: #2c3e50;
            font-weight: 700;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .employee-info h5 i {
            color: #4481eb;
            font-size: 1.2rem;
        }

        .info-item {
            margin: 0.8rem 0;
            padding: 0.5rem 0;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        .info-label {
            font-weight: 600;
            color: #4481eb;
            margin-right: 0.5rem;
        }

        .table-asistencia {
            margin-top: 1.5rem;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        .table-asistencia thead th {
            background: linear-gradient(145deg, #f1f8f1, #e8f5e9);
            color: #2c3e50;
            font-weight: 600;
            padding: 1rem;
            border: none;
        }

        .table-asistencia tbody td {
            padding: 1rem;
            vertical-align: middle;
            border: 1px solid rgba(0,0,0,0.05);
        }

        .badge-entrada {
            background: linear-gradient(45deg, #11998e, #38ef7d);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 500;
            box-shadow: 0 2px 5px rgba(56, 239, 125, 0.2);
            display: inline-block;
            min-width: 100px;
            text-align: center;
        }

        .badge-salida {
            background: linear-gradient(45deg, #fe5196, #f77062);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 500;
            box-shadow: 0 2px 5px rgba(254, 81, 150, 0.2);
            display: inline-block;
            min-width: 100px;
            text-align: center;
        }

        .table-asistencia tbody tr {
            transition: all 0.3s ease;
        }

        .table-asistencia tbody tr:hover {
            background-color: rgba(68, 129, 235, 0.05);
        }

        .table-responsive {
            border-radius: 10px;
            overflow: hidden;
        }
    </style>
</head>
<body>
    <a href="../admin/" class="admin-link">
        <i class="fa fa-lock"></i>
        <span>Admin</span>
    </a>

    <div class="main-container">
        <div class="logo-container">
            <img src="../admin/files/negocio/images.png" alt="Logo DRAP">
            <h2>Control de Asistencia</h2>
        </div>

        <div class="login-form">
            <div class="form-group">
                <i class="fa fa-user"></i>
                <input type="text" id="codigo" class="form-control" placeholder="Ingrese su código">
            </div>
        </div>

        <div class="camera-container">
            <video id="video" autoplay muted playsinline></video>
            <div id="overlay" class="overlay"></div>
        </div>

        <div class="camera-controls">
            <button class="btn btn-primary" id="btnToggleCamera">
                <i class="fa fa-video-camera"></i> Activar Cámara
            </button>
            <button class="btn btn-info" id="btnCapture" disabled>
                <i class="fa fa-camera"></i> Tomar Foto
            </button>
        </div>

        <div id="mensaje"></div>

        <div class="main-buttons">
            <button class="btn btn-success" id="btnRegistrar" disabled>
                <i class="fa fa-check"></i> Registrar Asistencia
            </button>
            <button class="btn btn-warning" id="btnRetake" style="display: none;">
                <i class="fa fa-refresh"></i> Retomar Foto
            </button>
            <button class="btn-historial" onclick="buscarHistorial()">
                <i class="fa fa-history"></i> Ver Historial
            </button>
        </div>

        <canvas id="captured-photo" style="display: none;"></canvas>
    </div>

    <!-- Modal para mostrar asistencias -->
    <div class="modal fade" id="asistenciasModal" tabindex="-1" role="dialog" aria-labelledby="asistenciasModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="asistenciasModalLabel">
                        <i class="fa fa-clock-o"></i> Historial de Asistencias
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="asistenciasModalBody">
                    <!-- El contenido se llenará dinámicamente -->
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Éxito -->
    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center p-4">
                    <div style="width: 80px; height: 80px; background-color: #4CAF50; border-radius: 50%; margin: 0 auto; display: flex; align-items: center; justify-content: center;">
                        <i class="fa fa-check" style="color: white; font-size: 40px;"></i>
                    </div>
                    <h4 style="color: #333; font-size: 1.2rem; margin-top: 1rem;" id="successMessage">¡Asistencia Registrada!</h4>
                </div>
            </div>
        </div>
    </div>

    <script src="../admin/public/js/jquery-3.1.1.min.js"></script>
    <script src="../admin/public/js/bootstrap.min.js"></script>
    <script>
        let video;
        let overlay;
        let stream;
        let modelosPath = '../admin/public/models';
        let capturedImage = null;
        let camaraActiva = false;
        let detectionInterval;

        // Verificar si face-api está cargado
        if (typeof faceapi === 'undefined') {
            document.getElementById('mensaje').innerHTML = `
                <div class="alert alert-danger">
                    Error: face-api.js no se cargó correctamente. Por favor, recargue la página.
                </div>
            `;
        }

        document.addEventListener('DOMContentLoaded', async () => {
            try {
                // Intentar cargar solo los modelos necesarios
                await Promise.all([
                    faceapi.nets.tinyFaceDetector.loadFromUri(modelosPath),
                    faceapi.nets.faceLandmark68Net.loadFromUri(modelosPath)
                ]);

                console.log('Modelos cargados correctamente');
                document.getElementById('btnToggleCamera').disabled = false;

                // Configurar event listeners
                document.getElementById('btnToggleCamera').addEventListener('click', toggleCamara);
                document.getElementById('btnCapture').addEventListener('click', capturarFoto);
                document.getElementById('btnRetake').addEventListener('click', volverTomarFoto);
                document.getElementById('btnRegistrar').addEventListener('click', registrarAsistencia);
            } catch (error) {
                console.error('Error detallado al cargar modelos:', error);
                document.getElementById('mensaje').innerHTML = `
                    <div class="alert alert-danger">
                        Error al cargar los modelos de reconocimiento facial. 
                        <br>
                        <small>Detalles: ${error.message}</small>
                        <br>
                        <small>Ruta de modelos: ${modelosPath}</small>
                    </div>
                `;
            }
        });

        async function startVideo() {
            if (camaraActiva) return;

            video = document.getElementById('video');
            overlay = document.getElementById('overlay');
            const btnToggleCamera = document.getElementById('btnToggleCamera');
            
            try {
                stream = await navigator.mediaDevices.getUserMedia({
                    video: {
                        width: { ideal: 320 },
                        height: { ideal: 240 },
                        facingMode: 'user'
                    }
                });
                
                video.srcObject = stream;
                
                // Esperar a que el video esté listo
                await new Promise((resolve) => {
                    video.onloadedmetadata = () => {
                        video.play();
                        resolve();
                    };
                });

                camaraActiva = true;
                btnToggleCamera.innerHTML = '<i class="fa fa-video-camera"></i> Desactivar Cámara';
                
                // Crear canvas con dimensiones fijas
                const canvas = faceapi.createCanvasFromMedia(video);
                canvas.width = 320;
                canvas.height = 240;
                overlay.innerHTML = '';
                overlay.append(canvas);

                const displaySize = { width: 320, height: 240 };
                faceapi.matchDimensions(canvas, displaySize);

                detectionInterval = setInterval(async () => {
                    if (!camaraActiva) return;

                    try {
                        const detections = await faceapi.detectAllFaces(
                            video, 
                            new faceapi.TinyFaceDetectorOptions({
                                inputSize: 320,
                                scoreThreshold: 0.5
                            })
                        );
                        
                        if (detections) {
                            const resizedDetections = faceapi.resizeResults(detections, displaySize);
                            const ctx = canvas.getContext('2d');
                            ctx.clearRect(0, 0, canvas.width, canvas.height);
                            faceapi.draw.drawDetections(canvas, resizedDetections);

                            // Habilitar/deshabilitar botón de captura
                            const btnCapture = document.getElementById('btnCapture');
                            if (detections.length > 0) {
                                console.log('Rostro detectado');
                                btnCapture.disabled = false;
                                btnCapture.classList.remove('disabled');
                            } else {
                                btnCapture.disabled = true;
                                btnCapture.classList.add('disabled');
                            }
                        }
                    } catch (error) {
                        console.error('Error en la detección facial:', error);
                    }
                }, 100);

                // Configurar botón de captura
                const btnCapture = document.getElementById('btnCapture');
                btnCapture.disabled = true;
                btnCapture.classList.add('disabled');
                btnCapture.style.display = 'block';
            } catch (error) {
                console.error('Error al acceder a la cámara:', error);
                document.getElementById('mensaje').innerHTML = `
                    <div class="alert alert-danger">
                        ${error.name === 'NotAllowedError' ? 
                            'Por favor, permita el acceso a la cámara.' : 
                            'Error al acceder a la cámara. Verifique que su dispositivo tiene una cámara conectada.'}
                    </div>
                `;
                btnToggleCamera.innerHTML = '<i class="fa fa-video-camera"></i> Activar Cámara';
            }
        }

        function detenerCamara() {
            const btnToggleCamera = document.getElementById('btnToggleCamera');
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
                stream = null;
            }
            if (detectionInterval) {
                clearInterval(detectionInterval);
                detectionInterval = null;
            }
            if (video) {
                video.srcObject = null;
            }
            if (overlay) {
                overlay.innerHTML = '';
            }
            camaraActiva = false;
            btnToggleCamera.innerHTML = '<i class="fa fa-video-camera"></i> Activar Cámara';
            
            // Ocultar y deshabilitar botón de captura
            const btnCapture = document.getElementById('btnCapture');
            btnCapture.disabled = true;
            btnCapture.classList.add('disabled');
        }

        async function toggleCamara() {
            const btnToggleCamera = document.getElementById('btnToggleCamera');
            btnToggleCamera.disabled = true;
            
            try {
                if (camaraActiva) {
                    detenerCamara();
                } else {
                    await startVideo();
                }
            } catch (error) {
                console.error('Error al toggle cámara:', error);
                document.getElementById('mensaje').innerHTML = `
                    <div class="alert alert-danger">
                        Error al manipular la cámara. Por favor, recargue la página.
                    </div>
                `;
            } finally {
                btnToggleCamera.disabled = false;
            }
        }

        async function capturarFoto() {
            if (!camaraActiva || !video) {
                console.log('No se puede capturar: cámara inactiva o video no inicializado');
                return;
            }

            try {
                const canvas = document.getElementById('captured-photo');
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                const ctx = canvas.getContext('2d');
                
                // Voltear horizontalmente la imagen capturada
                ctx.translate(canvas.width, 0);
                ctx.scale(-1, 1);
                ctx.drawImage(video, 0, 0);
                
                capturedImage = canvas.toDataURL('image/jpeg');
                
                detenerCamara();
                document.querySelector('.camera-container').style.display = 'none';
                document.getElementById('btnCapture').style.display = 'none';
                document.getElementById('btnToggleCamera').style.display = 'none';
                document.getElementById('btnRetake').style.display = 'block';
                document.getElementById('btnRegistrar').disabled = false;
                canvas.style.display = 'block';

                console.log('Foto capturada exitosamente');
            } catch (error) {
                console.error('Error al capturar foto:', error);
                document.getElementById('mensaje').innerHTML = `
                    <div class="alert alert-danger">
                        Error al capturar la foto. Por favor, intente nuevamente.
                    </div>
                `;
            }
        }

        async function volverTomarFoto() {
            document.querySelector('.camera-container').style.display = 'block';
            document.getElementById('captured-photo').style.display = 'none';
            document.getElementById('btnCapture').style.display = 'block';
            document.getElementById('btnToggleCamera').style.display = 'block';
            document.getElementById('btnRetake').style.display = 'none';
            document.getElementById('btnRegistrar').disabled = true;
            capturedImage = null;
            await startVideo();
        }

        async function registrarAsistencia() {
            const codigo = document.getElementById('codigo').value;
            
            if (!codigo) {
                document.getElementById('mensaje').innerHTML = `
                    <div class="alert alert-danger">Por favor ingrese su código</div>
                `;
                return;
            }

            if (!capturedImage) {
                document.getElementById('mensaje').innerHTML = `
                    <div class="alert alert-danger">Por favor capture una foto primero</div>
                `;
                return;
            }

            try {
                const response = await fetch('../ajax/asistencia.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `op=registrar_asistencia&codigo_persona=${codigo}&imagen_facial=${capturedImage}`
                });

                const data = await response.json();
                
                if (!data.error && data.status === 'success') {
                    // Mostrar modal de éxito
                    document.getElementById('successMessage').textContent = data.mensaje;
                    $('#successModal').modal('show');
                    
                    // Limpiar después de 2 segundos
                    setTimeout(() => {
                        $('#successModal').modal('hide');
                        document.getElementById('codigo').value = '';
                        document.getElementById('captured-photo').style.display = 'none';
                        document.getElementById('btnRetake').style.display = 'none';
                        document.getElementById('btnRegistrar').disabled = true;
                        document.querySelector('.camera-container').style.display = 'block';
                        document.getElementById('btnCapture').style.display = 'block';
                        document.getElementById('btnToggleCamera').style.display = 'block';
                        document.getElementById('mensaje').innerHTML = '';
                    }, 2000);
                } else {
                    document.getElementById('mensaje').innerHTML = `
                        <div class="alert alert-danger">${data.mensaje}</div>
                    `;
                }
            } catch (error) {
                console.error('Error al registrar asistencia:', error);
                document.getElementById('mensaje').innerHTML = `
                    <div class="alert alert-danger">Error al conectar con el servidor</div>
                `;
            }
        }

        async function buscarHistorial() {
            const codigo = document.getElementById('codigo').value;
            
            if (!codigo) {
                document.getElementById('mensaje').innerHTML = `
                    <div class="alert alert-danger">
                        <i class="fa fa-exclamation-circle"></i> Por favor ingrese su código para ver el historial
                    </div>
                `;
                return;
            }

            try {
                const response = await fetch('../ajax/asistencia.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'op=buscar_historial&codigo_persona=' + encodeURIComponent(codigo)
                });

                const data = await response.json();
                console.log('Respuesta del servidor:', data);

                if (!data.success) {
                    document.getElementById('mensaje').innerHTML = `
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle"></i> ${data.message || 'No se encontraron registros para este código'}
                        </div>
                    `;
                    return;
                }

                // Crear contenido del modal
                let modalContent = `
                    <div class="employee-info">
                        <h5><i class="fa fa-user-circle"></i> Información del Empleado</h5>
                        <div class="info-item">
                            <span class="info-label"><i class="fa fa-id-card"></i> Nombre:</span> 
                            <span>${data.empleado.nombre}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label"><i class="fa fa-building"></i> Departamento:</span> 
                            <span>${data.empleado.departamento}</span>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-asistencia">
                            <thead>
                                <tr>
                                    <th><i class="fa fa-calendar"></i> Fecha</th>
                                    <th><i class="fa fa-clock-o"></i> Hora</th>
                                    <th><i class="fa fa-sign-in"></i> Tipo</th>
                                </tr>
                            </thead>
                            <tbody>
                `;

                if (data.registros && data.registros.length > 0) {
                    data.registros.forEach(registro => {
                        const tipo = registro.tipo === 'Entrada' ? 
                            '<span class="badge-entrada"><i class="fa fa-sign-in"></i> Entrada</span>' : 
                            '<span class="badge-salida"><i class="fa fa-sign-out"></i> Salida</span>';

                        modalContent += `
                            <tr>
                                <td>${registro.fecha_formateada}</td>
                                <td>${registro.hora_formateada}</td>
                                <td class="text-center">${tipo}</td>
                            </tr>
                        `;
                    });
                } else {
                    modalContent += `
                        <tr>
                            <td colspan="3" class="text-center">
                                <i class="fa fa-info-circle"></i> No hay registros de asistencia
                            </td>
                        </tr>
                    `;
                }

                modalContent += `
                            </tbody>
                        </table>
                    </div>
                `;

                // Actualizar y mostrar el modal
                document.getElementById('asistenciasModalBody').innerHTML = modalContent;
                $('#asistenciasModal').modal('show');

            } catch (error) {
                console.error('Error completo:', error);
                document.getElementById('mensaje').innerHTML = `
                    <div class="alert alert-danger">
                        <i class="fa fa-exclamation-circle"></i> Error al obtener el historial
                        <br>
                        <small>Por favor, verifique que el código sea correcto e intente nuevamente.</small>
                    </div>
                `;
            }
        }

        // Limpiar al cerrar la página
        window.addEventListener('beforeunload', detenerCamara);
    </script>
</body>
</html> 


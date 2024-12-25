<?php
require_once "../admin/config/Conexion.php";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Registro de Asistencia con Reconocimiento Facial</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="../admin/public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../admin/public/css/font-awesome.css">
    <link rel="stylesheet" href="../admin/public/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../admin/public/css/_all-skins.min.css">
    <style>
        .login-box {
            margin-top: 2%;
        }
        #video {
            width: 320px;
            height: 240px;
            border: 1px solid #ddd;
            transform: scaleX(-1);
        }
        .camera-container {
            position: relative;
            width: 320px;
            height: 240px;
            margin: 0 auto;
        }
        #overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 320px;
            height: 240px;
            transform: scaleX(-1);
        }
        #captured-photo {
            width: 320px;
            height: 240px;
            border: 1px solid #ddd;
            margin: 10px auto;
            transform: scaleX(-1);
        }
        .detection-status {
            position: absolute;
            bottom: -30px;
            left: 0;
            width: 100%;
            text-align: center;
            font-size: 14px;
            color: #00a65a;
        }
        .btn-capture {
            margin: 10px 0;
        }
        .photo-preview {
            display: none;
            margin: 15px 0;
            text-align: center;
        }
        .camera-buttons {
            margin-top: 40px;
        }
    </style>
</head>
<body class="hold-transition login-page">
    <div class="login-box" style="width: 360px;">
        <div class="login-logo">
            <a href="#"><b>Registro de Asistencia</b></a>
        </div>
        <div class="login-box-body">
            <p class="login-box-msg">Registro con Reconocimiento Facial</p>
            <form method="post" id="frmAcceso">
                <div class="form-group has-feedback">
                    <input type="text" id="codigo" name="codigo" class="form-control" placeholder="Código">
                    <span class="fa fa-user form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="camera-container">
                            <video id="video" autoplay muted playsinline></video>
                            <canvas id="overlay"></canvas>
                        </div>
                        <div class="photo-preview">
                            <canvas id="captured-photo"></canvas>
                        </div>
                        <div class="camera-buttons">
                            <button type="button" id="btnCapture" class="btn btn-primary btn-block btn-flat btn-capture" disabled>
                                <i class="fa fa-camera"></i> Capturar Foto
                            </button>
                            <button type="button" id="btnRetake" class="btn btn-warning btn-block btn-flat" style="display: none;">
                                <i class="fa fa-refresh"></i> Tomar otra foto
                            </button>
                            <button type="button" id="btnRegistrar" class="btn btn-success btn-block btn-flat" disabled>
                                <i class="fa fa-check"></i> Registrar Asistencia
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            <br>
            <a href="registro_movil.php" class="text-center">Volver al registro normal</a>
        </div>
        <div id="mensaje"></div>
    </div>

    <script src="../admin/public/js/jquery-3.1.1.min.js"></script>
    <script src="../admin/public/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>
    <script>
        const video = document.getElementById('video');
        const overlay = document.getElementById('overlay');
        const capturedPhoto = document.getElementById('captured-photo');
        const btnCapture = document.getElementById('btnCapture');
        const btnRetake = document.getElementById('btnRetake');
        const btnRegistrar = document.getElementById('btnRegistrar');
        let isModelLoaded = false;
        let isCameraReady = false;
        let capturedImage = null;
        let detectionInterval;

        // Cargar modelos de face-api.js
        async function loadModels() {
            try {
                await faceapi.nets.tinyFaceDetector.loadFromUri('../admin/public/models');
                await faceapi.nets.faceLandmark68Net.loadFromUri('../admin/public/models');
                isModelLoaded = true;
                startVideo();
            } catch (err) {
                console.error('Error al cargar modelos:', err);
                $('#mensaje').html('<div class="alert alert-danger">Error al cargar modelos de reconocimiento facial</div>');
            }
        }

        // Iniciar video
        async function startVideo() {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({
                    video: {
                        width: { ideal: 320 },
                        height: { ideal: 240 },
                        facingMode: 'user'
                    }
                });
                video.srcObject = stream;
                video.onloadedmetadata = () => {
                    video.play();
                    isCameraReady = true;
                    startDetection();
                };
            } catch (err) {
                console.error("Error al acceder a la cámara:", err);
                $('#mensaje').html('<div class="alert alert-danger">Error al acceder a la cámara. Por favor, permita el acceso.</div>');
            }
        }

        // Iniciar detección
        function startDetection() {
            overlay.width = video.videoWidth || 320;
            overlay.height = video.videoHeight || 240;

            detectionInterval = setInterval(async () => {
                if (!isModelLoaded || !isCameraReady) return;

                try {
                    const detection = await faceapi.detectSingleFace(
                        video,
                        new faceapi.TinyFaceDetectorOptions({
                            inputSize: 160,
                            scoreThreshold: 0.3
                        })
                    );

                    const ctx = overlay.getContext('2d');
                    ctx.clearRect(0, 0, overlay.width, overlay.height);

                    if (detection) {
                        ctx.beginPath();
                        ctx.lineWidth = "3";
                        ctx.strokeStyle = "green";
                        ctx.rect(
                            detection.box.x,
                            detection.box.y,
                            detection.box.width,
                            detection.box.height
                        );
                        ctx.stroke();
                        btnCapture.disabled = false;
                    } else {
                        btnCapture.disabled = true;
                    }
                } catch (err) {
                    console.error('Error en detección:', err);
                }
            }, 100);
        }

        // Capturar foto
        btnCapture.addEventListener('click', async () => {
            const detection = await faceapi.detectSingleFace(
                video,
                new faceapi.TinyFaceDetectorOptions()
            );

            if (detection) {
                // Capturar la imagen
                capturedPhoto.width = video.videoWidth;
                capturedPhoto.height = video.videoHeight;
                const ctx = capturedPhoto.getContext('2d');
                ctx.drawImage(video, 0, 0);
                capturedImage = capturedPhoto.toDataURL('image/jpeg');

                // Mostrar la vista previa
                $('.camera-container').hide();
                $('.photo-preview').show();
                btnCapture.style.display = 'none';
                btnRetake.style.display = 'block';
                btnRegistrar.disabled = false;
            } else {
                $('#mensaje').html('<div class="alert alert-danger">No se detectó un rostro. Por favor, colóquese frente a la cámara.</div>');
            }
        });

        // Volver a tomar foto
        btnRetake.addEventListener('click', () => {
            $('.camera-container').show();
            $('.photo-preview').hide();
            btnCapture.style.display = 'block';
            btnRetake.style.display = 'none';
            btnRegistrar.disabled = true;
            capturedImage = null;
        });

        // Registrar asistencia
        $("#btnRegistrar").click(async function() {
            const codigo = $("#codigo").val();
            
            if (!codigo) {
                $('#mensaje').html('<div class="alert alert-danger">Por favor ingrese su código</div>');
                return;
            }

            if (!capturedImage) {
                $('#mensaje').html('<div class="alert alert-danger">Por favor capture una foto primero</div>');
                return;
            }

            // Enviar datos al servidor
            $.ajax({
                url: "../ajax/asistencia.php",
                type: "POST",
                data: {
                    'op': 'registrar_asistencia',
                    'codigo_persona': codigo,
                    'imagen_facial': capturedImage
                },
                success: function(response) {
                    try {
                        const resp = JSON.parse(response);
                        $('#mensaje').html('<div class="alert alert-' + 
                            (resp.error ? 'danger' : 'success') + '">' + resp.mensaje + '</div>');
                        
                        if (!resp.error) {
                            $("#codigo").val("");
                            btnRetake.click();
                        }
                    } catch(e) {
                        $('#mensaje').html('<div class="alert alert-success">' + response + '</div>');
                        $("#codigo").val("");
                        btnRetake.click();
                    }
                },
                error: function() {
                    $('#mensaje').html('<div class="alert alert-danger">Error en el servidor</div>');
                }
            });
        });

        // Iniciar el proceso
        loadModels();
    </script>
</body>
</html> 
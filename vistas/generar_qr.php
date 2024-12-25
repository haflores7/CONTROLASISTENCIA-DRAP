<!DOCTYPE html>
<html>
<head>
    <title>Generar Códigos QR | DRAP</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="../admin/public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../admin/public/css/font-awesome.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h2>Generación de Códigos QR</h2>
                
                <!-- Selector de empleados -->
                <div class="form-group">
                    <label>Seleccione un Empleado:</label>
                    <select id="empleado" class="form-control">
                        <option value="">-- Seleccione --</option>
                        <?php
                        require_once "../modelos/Asistencia.php";
                        $asistencia = new Asistencia();
                        $rspta = $asistencia->listar_empleados();
                        while ($reg = $rspta->fetch_object()) {
                            echo '<option value="' . $reg->codigo_persona . '">' . 
                                 $reg->nombre . ' ' . $reg->apellidos . ' - ' . $reg->codigo_persona . 
                                 '</option>';
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <button onclick="generarQR()" class="btn btn-primary mt-3">
                        <i class="fa fa-qrcode"></i> Generar Código QR
                    </button>
                </div>

                <!-- Vista previa del QR -->
                <div id="qrcode" style="margin-top:20px"></div>
                <button onclick="descargarQR()" class="btn btn-success mt-3" style="display:none" id="btnDescargar">
                    <i class="fa fa-download"></i> Descargar Código QR
                </button>

                <!-- Información del empleado -->
                <div id="info_empleado" class="mt-3"></div>
            </div>
        </div>
    </div>

    <script>
    let qrcode = null;

    function generarQR() {
        const select = document.getElementById('empleado');
        const codigo = select.value;
        const nombre = select.options[select.selectedIndex].text;

        if(!codigo) {
            alert('Por favor seleccione un empleado de la lista');
            return;
        }

        // Limpiar QR anterior si existe
        if(qrcode) {
            document.getElementById('qrcode').innerHTML = '';
        }

        // Generar nuevo QR
        qrcode = new QRCode(document.getElementById('qrcode'), {
            text: codigo,
            width: 256,
            height: 256,
            colorDark : '#000000',
            colorLight : '#ffffff',
            correctLevel : QRCode.CorrectLevel.H
        });

        // Mostrar información del empleado
        document.getElementById('info_empleado').innerHTML = `
            <div class="alert alert-info mt-3">
                <h4>Datos del Empleado</h4>
                <p><strong>Nombre:</strong> ${nombre}</p>
                <p><strong>Código:</strong> ${codigo}</p>
                <small class="text-muted">Este código QR está vinculado al empleado para el registro de asistencia</small>
            </div>
        `;

        document.getElementById('btnDescargar').style.display = 'inline-block';
    }

    function descargarQR() {
        const canvas = document.querySelector('#qrcode canvas');
        const empleado = document.getElementById('empleado');
        const nombre = empleado.options[empleado.selectedIndex].text.split(' - ')[0];
        
        if(canvas) {
            const link = document.createElement('a');
            link.download = 'QR-' + nombre.replace(/\s+/g, '-') + '.png';
            link.href = canvas.toDataURL();
            link.click();
        }
    }
    </script>
</body>
</html> 
var tabla;

//funcion que se ejecuta al inicio
function init(){
    $("#formulario").on("submit",function(e){
        registrar_asistencia(e);
    });

    // Inicializar el código QR
    inicializarQR();
}

//funcion limpiar
function limpiar(){
    $("#codigo_persona").val("");
    $("#mensaje").html("");
    setTimeout('document.location.reload()',2000);
}

function registrar_asistencia(e){
    e.preventDefault(); 
    
    var codigo = $("#codigo_persona").val();
    if(!codigo) {
        mostrarMensaje("Por favor ingrese un código", "error");
        return;
    }

    $("#btnGuardar").prop("disabled", true);
    var formData = new FormData($("#formulario")[0]);

    // Mostrar mensaje de carga
    mostrarMensaje("Procesando...", "info");

    $.ajax({
        url: "../ajax/asistencia.php?op=registrar_asistencia",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos) {
            console.log("Respuesta del servidor:", datos); // Para debug
            
            try {
                var response = JSON.parse(datos);
                mostrarMensaje(response.mensaje || "Operación completada", response.status === 'error' ? 'error' : 'success');
            } catch(e) {
                console.error("Error al parsear respuesta:", e); // Para debug
                mostrarMensaje("Error al procesar la respuesta del servidor", "error");
            }
            $("#btnGuardar").prop("disabled", false);
        },
        error: function(xhr, status, error) {
            console.error("Error AJAX:", {
                status: status,
                error: error,
                response: xhr.responseText
            }); // Para debug
            mostrarMensaje("Error de conexión con el servidor: " + error, "error");
            $("#btnGuardar").prop("disabled", false);
        }
    });
}

function mostrarMensaje(mensaje, tipo) {
    var alertClass = 'alert-info'; // Por defecto
    
    if (tipo === 'error') {
        alertClass = 'alert-danger';
    } else if (tipo === 'success') {
        alertClass = 'alert-success';
    }
    
    $("#mensaje").html('<div class="alert ' + alertClass + ' alert-dismissible fade show" role="alert">' +
        '<strong>' + (tipo === 'error' ? '¡Error!' : tipo === 'success' ? '¡Éxito!' : 'Información:') + '</strong> ' +
        mensaje +
        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
        '<span aria-hidden="true">&times;</span>' +
        '</button>' +
        '</div>');
    
    if (tipo !== 'info') { // No auto-ocultar mensajes de carga
        setTimeout(function() {
            $("#mensaje .alert").alert('close');
        }, 5000);
    }
}

function inicializarQR() {
    if(document.getElementById("qr-registro")) {
        var registroUrl = window.location.origin + "/control_asistencia1/vistas/registro_movil.php";
        new QRCode(document.getElementById("qr-registro"), {
            text: registroUrl,
            width: 200,
            height: 200,
            colorDark : "#000000",
            colorLight : "#ffffff",
            correctLevel : QRCode.CorrectLevel.H
        });
    }
}

init();
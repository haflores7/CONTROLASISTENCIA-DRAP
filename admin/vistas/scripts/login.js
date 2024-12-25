$("#frmAcceso").on('submit', function(e) {
    e.preventDefault();
    logina = $("#logina").val();
    clavea = $("#clavea").val();

    if ($("#logina").val() == "" || $("#clavea").val() == "") {
        bootbox.alert("Asegúrate de llenar todos los campos");
        return;
    }

    $.ajax({
        url: "../ajax/usuario.php?op=verificar",
        type: "POST",
        data: {
            "logina": logina,
            "clavea": clavea
        },
        success: function(data) {
            console.log('Respuesta del servidor:', data);
            try {
                let response = JSON.parse(data);
                if (response.status === 'success') {
                    console.log('Login exitoso, redirigiendo...');
                    window.location.href = "escritorio.php";
                } else {
                    console.log('Error de login:', response.mensaje);
                    bootbox.alert(response.mensaje || "Usuario y/o Password incorrectos");
                }
            } catch(e) {
                console.error('Error al procesar la respuesta:', e);
                console.error('Respuesta raw:', data);
                bootbox.alert("Error en la autenticación");
            }
        },
        error: function(xhr, status, error) {
            console.error('Error en la petición:', error);
            console.error('Estado:', status);
            console.error('Respuesta:', xhr.responseText);
            bootbox.alert("Error de conexión con el servidor");
        }
    });
});
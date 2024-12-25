<?php 
//activamos almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
    header("Location: login.html");
} else {
    require 'header.php';
?>
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h1 class="box-title">Usuarios</h1>
                            <div class="box-tools pull-right">
                                <button class="btn btn-danger" onclick="eliminarTodo()">
                                    <i class="fa fa-trash"></i> Eliminar Registros de Asistencia
                                </button>
                            </div>
                        </div>
                        <!--box-header-->
                        <!--centro-->
                        <div class="panel-body table-responsive" id="listadoregistros">
                            <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                                <thead>
                                    <th>Opciones</th>
                                    <th>Código</th>
                                    <th>Nombres</th>
                                    <th>Área</th>
                                    <th>Fecha Hora</th>
                                    <th>Asistencia</th>
                                    <th>Fecha</th>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <th>Opciones</th>
                                    <th>Código</th>
                                    <th>Nombres</th>
                                    <th>Área</th>
                                    <th>Fecha Hora</th>
                                    <th>Asistencia</th>
                                    <th>Fecha</th>
                                </tfoot>   
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
<?php 
    require 'footer.php';
?>
<script>
var tabla;

//función para eliminar registros
function eliminar(idasistencia) {
    bootbox.confirm("¿Está seguro de eliminar este registro?", function(result) {
        if(result) {
            $.post("../ajax/asistencia.php?op=eliminar", {idasistencia : idasistencia}, function(e) {
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    });
}

//función para eliminar todos los registros
function eliminarTodo() {
    bootbox.confirm({
        title: "Eliminar todos los registros",
        message: "<h4 class='text-danger'><i class='fa fa-exclamation-triangle'></i> ¿Está seguro de eliminar TODOS los registros de asistencia?</h4><p class='text-danger'><b>¡ADVERTENCIA!</b> Esta acción eliminará permanentemente todos los registros y no se puede deshacer.</p>",
        buttons: {
            confirm: {
                label: '<i class="fa fa-trash"></i> Sí, Eliminar Todo',
                className: 'btn-danger'
            },
            cancel: {
                label: '<i class="fa fa-times"></i> No, Cancelar',
                className: 'btn-default'
            }
        },
        callback: function(result) {
            if(result) {
                $.ajax({
                    url: "../ajax/asistencia.php?op=eliminarTodo",
                    type: "POST",
                    dataType: "json",
                    success: function(response) {
                        bootbox.alert({
                            title: "Resultado",
                            message: response.mensaje || "Todos los registros han sido eliminados",
                            callback: function() {
                                tabla.ajax.reload();
                            }
                        });
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        bootbox.alert({
                            title: "Error",
                            message: "Ocurrió un error al eliminar los registros: " + errorThrown
                        });
                    }
                });
            }
        }
    });
}

//funcion que se ejecuta al inicio
function init(){
    listar();
}

//funcion listar
function listar(){
    tabla=$('#tbllistado').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdf'
        ],
        "ajax": {
            url: '../ajax/asistencia.php?op=listar',
            type: "get",
            dataType : "json",
            error: function(e){
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [[ 4, "desc" ]],
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "search": "Buscar:",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        }
    }).DataTable();
}

init();
</script>
<style>
.btn-xs {
    padding: 1px 5px;
    font-size: 12px;
    line-height: 1.5;
    border-radius: 3px;
}

.btn-success.btn-xs {
    background-color: #28a745;
    border-color: #28a745;
}

.btn-danger.btn-xs {
    background-color: #dc3545;
    border-color: #dc3545;
}

.btn-success.btn-xs:hover {
    background-color: #218838;
    border-color: #1e7e34;
}

.btn-danger.btn-xs:hover {
    background-color: #c82333;
    border-color: #bd2130;
}

.fa {
    font-size: 11px;
}

/* Estilos para el contenedor de botones */
.action-buttons {
    display: inline-flex;
    gap: 5px;
    align-items: center;
}

/* Ajuste del ancho de la columna de acciones */
#tbllistado th:first-child,
#tbllistado td:first-child {
    min-width: 80px;
    text-align: center;
}

/* Estilo para el botón de eliminar todo */
.box-tools .btn-danger {
    margin-right: 5px;
    padding: 6px 12px;
    font-size: 14px;
}

.box-tools .btn-danger .fa {
    font-size: 14px;
    margin-right: 5px;
}
</style>
<?php 
}
ob_end_flush();
?>

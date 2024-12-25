<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

error_log("Verificando sesión en escritorio.php");
error_log("Variables de sesión disponibles: " . print_r($_SESSION, true));

if (!isset($_SESSION['nombre'])) {
    error_log("No hay sesión activa, redirigiendo a login");
    header("Location: login.html");
    exit();
}

error_log("Sesión válida para usuario: " . $_SESSION['nombre']);

require 'header.php';

// Incluir las clases necesarias
require_once "../modelos/Usuario.php";
$usuario = new Usuario();
?>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">        
        <!-- Main content -->
        <section class="content">
            <!-- Primera fila - Widgets de resumen -->
            <div class="row">
                <!-- Widget Espacio Usado -->
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card" style="background: linear-gradient(45deg, #28a745, #34ce57); border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 20px;">
                        <div class="card-body" style="padding: 20px;">
                            <div style="display: flex; align-items: center;">
                                <div style="background: rgba(255,255,255,0.2); padding: 15px; border-radius: 8px; margin-right: 15px;">
                                    <i class="fa fa-database" style="font-size: 24px; color: white;"></i>
                                </div>
                                <div>
                                    <h4 style="margin: 0; color: white;">Empleados Activos</h4>
                                    <div style="font-size: 24px; font-weight: bold; color: white;">
                                        <?php 
                                            $rspta = $usuario->listar();
                                            $activos = 0;
                                            while ($reg = $rspta->fetch_object()) {
                                                if($reg->estado == 1) $activos++;
                                            }
                                            echo $activos;
                                        ?>/100
                                    </div>
                                </div>
                            </div>
                            <div style="margin-top: 15px; font-size: 12px; color: white;">
                                <i class="fa fa-arrow-up"></i> Empleados Registrados
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Widget Reloj -->
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card" style="background: linear-gradient(45deg, #17a2b8, #20c997); border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 20px;">
                        <div class="card-body" style="padding: 20px;">
                            <div style="display: flex; align-items: center;">
                                <div style="background: rgba(255,255,255,0.2); padding: 15px; border-radius: 8px; margin-right: 15px;">
                                    <i class="fa fa-clock-o" style="font-size: 24px; color: white;"></i>
                                </div>
                                <div>
                                    <h4 style="margin: 0; color: white;">Hora Actual</h4>
                                    <div style="font-size: 24px; font-weight: bold; color: white;" id="reloj">
                                        --:--:--
                                    </div>
                                </div>
                            </div>
                            <div style="margin-top: 15px; font-size: 12px; color: white;">
                                <i class="fa fa-refresh"></i> Actualización en tiempo real
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Widget Asistencias -->
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card" style="background: linear-gradient(45deg, #ffc107, #ffdb4a); border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 20px;">
                        <div class="card-body" style="padding: 20px;">
                            <div style="display: flex; align-items: center;">
                                <div style="background: rgba(255,255,255,0.2); padding: 15px; border-radius: 8px; margin-right: 15px;">
                                    <i class="fa fa-users" style="font-size: 24px; color: white;"></i>
                                </div>
                                <div>
                                    <h4 style="margin: 0; color: white;">Asistencias Hoy</h4>
                                    <div style="font-size: 24px; font-weight: bold; color: white;">75</div>
                                </div>
                            </div>
                            <div style="margin-top: 15px; font-size: 12px; color: white;">
                                <i class="fa fa-check"></i> Registros del día
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Widget Departamentos -->
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card" style="background: linear-gradient(45deg, #dc3545, #ff4d5a); border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 20px;">
                        <div class="card-body" style="padding: 20px;">
                            <div style="display: flex; align-items: center;">
                                <div style="background: rgba(255,255,255,0.2); padding: 15px; border-radius: 8px; margin-right: 15px;">
                                    <i class="fa fa-building" style="font-size: 24px; color: white;"></i>
                                </div>
                                <div>
                                    <h4 style="margin: 0; color: white;">Departamentos</h4>
                                    <div style="font-size: 24px; font-weight: bold; color: white;">7</div>
                                </div>
                            </div>
                            <div style="margin-top: 15px; font-size: 12px; color: white;">
                                <i class="fa fa-check"></i> Áreas activas
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Segunda fila - Módulos de acceso rápido -->
            <div class="row">
                <!-- Módulo Asistencias -->
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="small-box module-box" data-color="linear-gradient(45deg, #6f42c1, #8250df)">
                        <div class="inner">
                            <h4>
                                <strong>Asistencias</strong>
                            </h4>
                            <p>Control de Registros</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-users"></i>
                        </div>
                        <a href="asistencia.php" class="small-box-footer">
                            Acceder <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Módulo Empleados -->
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="small-box module-box" data-color="linear-gradient(45deg, #fd7e14, #ff922b)">
                        <div class="inner">
                            <h4>
                                <strong>Empleados</strong>
                            </h4>
                            <p>Gestión de Personal</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-user"></i>
                        </div>
                        <a href="usuario.php" class="small-box-footer">
                            Acceder <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Módulo Departamentos -->
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="small-box module-box" data-color="linear-gradient(45deg, #0dcaf0, #3dd5f3)">
                        <div class="inner">
                            <h4>
                                <strong>Departamentos</strong>
                            </h4>
                            <p>Áreas de Trabajo</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-building"></i>
                        </div>
                        <a href="departamento.php" class="small-box-footer">
                            Acceder <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Módulo Tipos de Usuario -->
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="small-box module-box" data-color="linear-gradient(45deg, #e83e8c, #ff6cab)">
                        <div class="inner">
                            <h4>
                                <strong>Tipos de Usuario</strong>
                            </h4>
                            <p>Roles y Permisos</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-key"></i>
                        </div>
                        <a href="tipousuario.php" class="small-box-footer">
                            Acceder <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Gráficos -->
            <div class="row">
                <!-- Gráfico de Asistencias Diarias -->
                <div class="col-md-4">
                    <div class="card" style="background: white; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 20px;">
                        <div class="card-body" style="padding: 20px;">
                            <h3 style="margin-top: 0; color: #333;">Asistencias Diarias</h3>
                            <div style="height: 300px;">
                                <canvas id="dailySalesChart"></canvas>
                            </div>
                            <div style="margin-top: 15px; color: #28a745;">
                                <i class="fa fa-arrow-up"></i> 55% incremento en asistencias
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gráfico de Registro Mensual -->
                <div class="col-md-4">
                    <div class="card" style="background: white; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 20px;">
                        <div class="card-body" style="padding: 20px;">
                            <h3 style="margin-top: 0; color: #333;">Registro Mensual</h3>
                            <div style="height: 300px;">
                                <canvas id="emailSubsChart"></canvas>
                            </div>
                            <div style="margin-top: 15px; color: #666;">
                                Último registro hace 2 días
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gráfico de Eficiencia -->
                <div class="col-md-4">
                    <div class="card" style="background: white; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 20px;">
                        <div class="card-body" style="padding: 20px;">
                            <h3 style="margin-top: 0; color: #333;">Eficiencia Mensual</h3>
                            <div style="height: 300px;">
                                <canvas id="completedTasksChart"></canvas>
                            </div>
                            <div style="margin-top: 15px; color: #666;">
                                Rendimiento del último mes
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de Empleados -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card" style="background: white; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                        <div class="card-header" style="background: #28a745; color: white; padding: 15px 20px; border-radius: 10px 10px 0 0;">
                            <h3 style="margin: 0;">Empleados Recientes</h3>
                        </div>
                        <div class="card-body" style="padding: 20px;">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Departamento</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $rspta = $usuario->listar();
                                        $counter = 0;
                                        if ($rspta) {
                                            while ($reg = $rspta->fetch_object()) {
                                                if ($counter < 5) {
                                                    echo "<tr>
                                                            <td>" . htmlspecialchars($reg->idusuario ?? '', ENT_QUOTES, 'UTF-8') . "</td>
                                                            <td>" . htmlspecialchars(($reg->nombre ?? '') . ' ' . ($reg->apellidos ?? ''), ENT_QUOTES, 'UTF-8') . "</td>
                                                            <td>" . htmlspecialchars($reg->iddepartamento ?? '', ENT_QUOTES, 'UTF-8') . "</td>
                                                            <td>" . ($reg->estado ? 
                                                                '<span class="label label-success">Activo</span>' : 
                                                                '<span class="label label-danger">Inactivo</span>') . 
                                                            "</td>
                                                        </tr>";
                                                    $counter++;
                                                }
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
<!--Fin-Contenido-->
<?php
require 'footer.php';
?>
<script>
// Función para actualizar el reloj
function actualizarReloj() {
    const ahora = new Date();
    const hora = ahora.getHours().toString().padStart(2, '0');
    const minutos = ahora.getMinutes().toString().padStart(2, '0');
    const segundos = ahora.getSeconds().toString().padStart(2, '0');
    document.getElementById('reloj').innerHTML = `${hora}:${minutos}:${segundos}`;
}

setInterval(actualizarReloj, 1000);
actualizarReloj();

// Configuración de los gráficos
document.addEventListener('DOMContentLoaded', function() {
    // Gráfico de Asistencias Diarias
    new Chart(document.getElementById('dailySalesChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: ['L', 'M', 'M', 'J', 'V', 'S', 'D'],
            datasets: [{
                label: 'Asistencias',
                data: [12, 19, 15, 17, 14, 8, 5],
                borderColor: '#28a745',
                tension: 0.4,
                fill: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // Gráfico de Registro Mensual
    new Chart(document.getElementById('emailSubsChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
            datasets: [{
                label: 'Registros',
                data: [400, 430, 448, 470, 540, 580],
                backgroundColor: '#17a2b8'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // Gráfico de Eficiencia
    new Chart(document.getElementById('completedTasksChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: ['12p', '3p', '6p', '9p', '12p', '3a', '6a', '9a'],
            datasets: [{
                label: 'Eficiencia',
                data: [230, 750, 450, 300, 280, 240, 200, 190],
                borderColor: '#ffc107',
                tension: 0.4,
                fill: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
});
</script>
<style>
/* Estilos para las tarjetas */
.card {
    transition: all 0.3s ease !important;
}

.card:hover {
    transform: translateY(-5px) !important;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
}

.card:hover .fa {
    transform: scale(1.1);
}

.card .fa {
    transition: all 0.3s ease;
}

/* Estilos para los módulos de acceso rápido */
.module-box {
    position: relative;
    border-radius: 10px;
    overflow: hidden;
    margin-bottom: 20px;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.module-box::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: attr(data-color);
    transition: all 0.4s ease;
    z-index: 0;
}

.module-box .inner {
    position: relative;
    padding: 20px;
    z-index: 1;
    color: white;
}

.module-box .inner h4 {
    font-size: 20px;
    font-weight: 600;
    margin: 0;
    margin-bottom: 10px;
}

.module-box .inner p {
    font-size: 15px;
    margin: 0;
    opacity: 0.9;
}

.module-box .icon {
    position: absolute;
    top: 20px;
    right: 20px;
    font-size: 50px;
    color: rgba(255,255,255,0.3);
    transition: all 0.4s ease;
    z-index: 1;
}

.module-box .small-box-footer {
    position: relative;
    display: block;
    text-align: center;
    padding: 10px;
    color: white;
    background: rgba(0,0,0,0.1);
    text-decoration: none;
    z-index: 1;
    transition: all 0.4s ease;
}

.module-box:hover {
    transform: translateY(-5px) scale(1.02);
    box-shadow: 0 8px 16px rgba(40, 167, 69, 0.2);
}

.module-box:hover::before {
    background: linear-gradient(45deg, #28a745, #34ce57) !important;
}

.module-box:hover .icon {
    transform: scale(1.1) rotate(5deg);
    color: rgba(255,255,255,0.5);
}

.module-box:hover .small-box-footer {
    background: rgba(255,255,255,0.15);
    padding-right: 20px;
}

.module-box:hover .small-box-footer i {
    transform: translateX(4px);
}

.module-box .small-box-footer i {
    margin-left: 5px;
    transition: transform 0.3s ease;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

.module-box:active {
    transform: translateY(0) scale(0.98);
    animation: pulse 0.3s ease-in-out;
}

/* Estilos para las gráficas */
.card canvas {
    margin-top: 15px;
}

/* Estilos para la tabla */
.table {
    margin-bottom: 0;
}

.table thead th {
    border-bottom: 2px solid #e9ecef;
    font-weight: 600;
    color: #495057;
}

.table td {
    vertical-align: middle;
    padding: 12px 15px;
}

.label {
    padding: 5px 10px;
    border-radius: 15px;
    font-size: 12px;
    font-weight: 600;
}

.label-success {
    background: #28a745;
    color: white;
}

.label-danger {
    background: #dc3545;
    color: white;
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modules = document.querySelectorAll('.module-box');
    modules.forEach(module => {
        const color = module.getAttribute('data-color');
        module.style.background = color;
    });
});
</script>
<?php 

ob_end_flush();
?>
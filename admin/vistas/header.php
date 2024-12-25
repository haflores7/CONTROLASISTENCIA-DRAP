<?php 
if (strlen(session_id())<1) 
  session_start();
  ?>
 <!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <title>CONTROLASISTENCIA | DRAP</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3 -->
    <link rel="stylesheet" href="../public/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../public/css/font-awesome.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../public/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../public/css/_all-skins.min.css">
    <link rel="apple-touch-icon" href="../public/img/apple-touch-icon.png">
    <link rel="shortcut icon" href="../public/img/images.png">

    <!-- DATATABLES -->
    <link rel="stylesheet" type="text/css" href="../public/datatables/jquery.dataTables.min.css">    
    <link href="../public/datatables/buttons.dataTables.min.css" rel="stylesheet"/>
    <link href="../public/datatables/responsive.dataTables.min.css" rel="stylesheet"/>

    <link rel="stylesheet" type="text/css" href="../public/css/bootstrap-select.min.css">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
    /* Estilos personalizados para el logo */
    .logo-lg, .logo-mini {
        transition: all 0.3s ease;
    }

    .main-header .logo {
        transition: all 0.3s ease;
        background-color: #28a745 !important;
    }

    .main-header .logo:hover {
        background-color: #34ce57 !important;
    }

    /* Estilo para el texto admin en la esquina */
    .user-menu > a {
        display: flex !important;
        align-items: center;
        padding: 15px 15px !important;
        color: white !important;
        font-size: 14px;
    }

    .user-menu > a > img {
        width: 25px !important;
        height: 25px !important;
        border-radius: 50%;
        margin-right: 5px;
    }

    .user-menu > a > span {
        font-weight: 400;
        letter-spacing: 0.5px;
    }

    /* Ajustes del sidebar */
    .skin-blue .main-header .navbar {
        background-color: #28a745 !important;
    }

    .skin-blue .main-header .navbar .sidebar-toggle:hover {
        background-color: #34ce57 !important;
    }

    .skin-blue .main-header .navbar .nav > li > a:hover {
        background: #34ce57 !important;
    }

    .skin-blue .sidebar-menu > li:hover > a,
    .skin-blue .sidebar-menu > li.active > a {
        border-left-color: #28a745;
    }

    .btn-success {
        background-color: #28a745 !important;
        border-color: #28a745 !important;
    }

    .btn-success:hover {
        background-color: #34ce57 !important;
        border-color: #34ce57 !important;
    }

    /* Estilo para el menú de usuario en la esquina */
    .user-menu {
        position: absolute;
        right: 15px;
        top: 0;
    }

    .user-menu > a {
        display: flex !important;
        align-items: center;
        padding: 12px !important;
        color: white !important;
        font-size: 14px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 4px;
        margin: 8px 0;
    }

    .user-menu > a:hover {
        background: rgba(255, 255, 255, 0.2) !important;
    }

    .user-menu > a > img {
        width: 24px !important;
        height: 24px !important;
        border-radius: 50%;
        margin-right: 8px;
    }

    .user-menu > a > span {
        font-weight: 400;
        letter-spacing: 0.5px;
        text-transform: lowercase;
    }
    </style>

  </head>

<body class="hold-transition skin-blue sidebar-mini">
  <!-- Load Facebook SDK for JavaScript -->
<div id="fb-root"></div>

<!-- Your customer chat code -->
<div class="fb-customerchat"
  attribution=setup_tool
  page_id="280144326139427"
  theme_color="#0084ff"
  logged_in_greeting="Hola! deseas compartir algún sistema o descargar ?"
  logged_out_greeting="Hola! deseas compartir algún sistema o descargar ?">
</div>
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="escritorio.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>C.A</b> DRAP</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>DRAP</b> ADMIN</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Navegación</span>
          </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="../files/usuarios/default.png" class="user-image" alt="User Image">
                <span>admin</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <?php if (isset($_SESSION['imagen']) && file_exists("../files/usuarios/".$_SESSION['imagen'])) { ?>
                    <img src="../files/usuarios/<?php echo $_SESSION['imagen']; ?>" class="img-circle" alt="User Image">
                <?php } else { ?>
                    <img src="../files/usuarios/default.png" class="img-circle" alt="Default User Image">
                <?php } ?>
                <p>
                    <?php echo $_SESSION['nombre'].' '.$_SESSION['departamento']; ?>
                    <small>CONTROLASISTENCIA</small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Perfil</a>
                </div>
                <div class="pull-right">
                  <a href="../ajax/usuario.php?op=salir" class="btn btn-default btn-flat">Salir</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->

        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
<div class="user-panel">
        <div class="pull-left image">
          <?php if (isset($_SESSION['imagen']) && file_exists("../files/usuarios/".$_SESSION['imagen'])) { ?>
              <img src="../files/usuarios/<?php echo $_SESSION['imagen']; ?>" class="img-circle" style="width: 50px; height: 50px;" alt="User Image">
          <?php } else { ?>
              <img src="../files/usuarios/default.png" class="img-circle" alt="Default User Image">
          <?php } ?>
        </div>
        <div class="pull-left info">
          <p><?php echo $_SESSION['nombre']; ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu tree" data-widget="tree">
      <li class="header">MENÚ DE NAVEGACIÓN</li>


      <li><a href="escritorio.php"><i class="fa  fa-dashboard (alias)"></i> <span>Escritorio</span></a></li>

<!--
      <li class="treeview">
          <a href="#">
            <i class="fa fa-envelope"></i> <span>Mensajes</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="mensaje.php"><i class="fa fa-circle-o"></i> Mensaje</a></li>
          </ul>
      </li>

-->
<?php if ($_SESSION['tipousuario']=='Administrador') {
?>
      <li class="treeview">
          <a href="#">
            <i class="fa fa-folder"></i> <span>Acceso</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="usuario.php"><i class="fa fa-circle-o"></i> Usuarios</a></li>
            <li><a href="tipousuario.php"><i class="fa fa-circle-o"></i> Tipo Usuario</a></li>
            <li><a href="departamento.php"><i class="fa fa-circle-o"></i> Departamento</a></li>
          </ul>
      </li>

      <li class="treeview">
          <a href="#">
            <i class="fa fa-folder"></i> <span>Departamento</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="departamento.php"><i class="fa fa-circle-o"></i> Departamento</a></li>            
          </ul>
      </li>

          <li class="treeview">
          <a href="#">
            <i class="fa fa-folder"></i> <span>Asistencias</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="asistencia.php"><i class="fa fa-circle-o"></i> Asistencia</a></li>
            <li><a href="rptasistencia.php"><i class="fa fa-circle-o"></i> Reportes</a></li>
           
          </ul>
      </li>
<?php } ?>
<?php if ($_SESSION['tipousuario']!='Administrador') {
?>
          <li class="treeview">
          <a href="#">
            <i class="fa fa-folder"></i> <span>Mis Asistencias</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="asistenciau.php"><i class="fa fa-circle-o"></i> Asistencia</a></li>
            <li><a href="rptasistenciau.php"><i class="fa fa-circle-o"></i> Reportes</a></li>
           
          </ul>
      </li>
<?php } ?>
  
      <li><a href="#"><i class="fa fa-question-circle"></i> <span>Ayuda</span><small class="label pull-right bg-yellow">PDF</small></a></li>
         
        
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
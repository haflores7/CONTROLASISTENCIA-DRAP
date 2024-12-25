<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Control de Asistencia | Login</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="../public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../public/css/font-awesome.css">
    <link rel="stylesheet" href="../public/css/AdminLTE.min.css">
    <link rel="shortcut icon" href="../public/img/favicon.ico">
    <style>
        body {
            background: linear-gradient(135deg, #00b09b, #96c93d);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-box {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            padding: 30px;
            width: 360px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .login-logo {
            margin-bottom: 30px;
            text-align: center;
        }
        .login-logo img {
            width: 100px;
            height: auto;
            margin-bottom: 15px;
            border-radius: 50%;
            padding: 5px;
            background: white;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .login-logo h1 {
            color: #2c3e50;
            font-size: 24px;
            font-weight: 600;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .login-box-msg {
            color: #666;
            font-size: 16px;
            margin-bottom: 20px;
            text-align: center;
        }
        .form-group {
            position: relative;
            margin-bottom: 25px;
        }
        .form-control {
            height: 45px;
            padding-left: 45px;
            border-radius: 8px;
            border: 2px solid #e9ecef;
            font-size: 15px;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #00b09b;
            box-shadow: 0 0 0 0.2rem rgba(0, 176, 155, 0.25);
        }
        .form-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            font-size: 18px;
        }
        .btn-success {
            background: linear-gradient(135deg, #00b09b, #96c93d);
            border: none;
            height: 45px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 4px 15px rgba(0, 176, 155, 0.3);
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 10px;
        }
        .btn-success:hover {
            background: linear-gradient(135deg, #96c93d, #00b09b);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 176, 155, 0.4);
        }
        .alert {
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 20px;
            padding: 15px;
            border: none;
        }
        .alert-danger {
            background: linear-gradient(45deg, #ff6b6b, #ff8787);
            color: white;
        }
        .back-link {
            display: inline-flex;
            align-items: center;
            color: #6c757d;
            text-decoration: none;
            font-size: 14px;
            margin-top: 20px;
            transition: all 0.3s ease;
        }
        .back-link i {
            margin-right: 5px;
        }
        .back-link:hover {
            color: #00b09b;
            text-decoration: none;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .login-box {
            animation: fadeIn 0.5s ease-out;
        }
    </style>
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <img src="../files/negocio/images.png" alt="Logo">
            <h1>Control de Asistencia</h1>
        </div>
        <p class="login-box-msg">Ingrese sus credenciales de acceso</p>
        <form method="post" id="frmAcceso">
            <div class="form-group">
                <i class="fa fa-user"></i>
                <input type="text" id="logina" name="logina" class="form-control" placeholder="Usuario" autocomplete="off">
            </div>
            <div class="form-group">
                <i class="fa fa-lock"></i>
                <input type="password" id="clavea" name="clavea" class="form-control" placeholder="Contraseña">
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <button type="submit" class="btn btn-success btn-block">
                        <i class="fa fa-sign-in"></i> Ingresar
                    </button>
                </div>
            </div>
        </form>
        <a href="../vistas/registro_movil.php" class="back-link">
            <i class="fa fa-arrow-left"></i> Volver al registro
        </a>
    </div>

    <script src="../public/js/jquery-3.1.1.min.js"></script>
    <script src="../public/js/bootstrap.min.js"></script>
    <script src="../public/js/bootbox.min.js"></script>
    <script src="scripts/login.js"></script>
</body>
</html> 

<?php
//Incluímos inicialmente la conexión a la base de datos
require_once "../config/Conexion.php";

class Usuario
{
    //Implementamos nuestro constructor
    public function __construct()
    {

    }

    //Implementamos un método para insertar registros
    public function insertar($nombre,$apellidos,$login,$iddepartamento,$idtipousuario,$email,$clavehash,$imagen,$codigo_persona)
    {
        $sql="INSERT INTO usuarios (nombre,apellidos,login,iddepartamento,idtipousuario,email,password,imagen,estado,codigo_persona)
        VALUES ('$nombre','$apellidos','$login','$iddepartamento','$idtipousuario','$email','$clavehash','$imagen','1','$codigo_persona')";
        return ejecutarConsulta($sql);
    }

    //Implementamos un método para editar registros
    public function editar($idusuario,$nombre,$apellidos,$login,$iddepartamento,$idtipousuario,$email,$imagen,$codigo_persona)
    {
        $sql="UPDATE usuarios SET nombre='$nombre',apellidos='$apellidos',login='$login',iddepartamento='$iddepartamento',idtipousuario='$idtipousuario',email='$email',imagen='$imagen',codigo_persona='$codigo_persona' WHERE idusuario='$idusuario'";
        return ejecutarConsulta($sql);
    }

    //Implementamos un método para desactivar usuarios
    public function desactivar($idusuario)
    {
        $sql="UPDATE usuarios SET estado='0' WHERE idusuario='$idusuario'";
        return ejecutarConsulta($sql);
    }

    //Implementamos un método para activar usuarios
    public function activar($idusuario)
    {
        $sql="UPDATE usuarios SET estado='1' WHERE idusuario='$idusuario'";
        return ejecutarConsulta($sql);
    }

    //Implementar un método para mostrar los datos de un registro a modificar
    public function mostrar($idusuario)
    {
        $sql="SELECT * FROM usuarios WHERE idusuario='$idusuario'";
        return ejecutarConsultaSimpleFila($sql);
    }

    //Implementar un método para listar los registros
    public function listar()
    {
        $sql="SELECT * FROM usuarios";
        return ejecutarConsulta($sql);
    }

    //Implementar un método para listar los permisos marcados
    public function listarmarcados($idusuario)
    {
        $sql="SELECT * FROM usuario_permiso WHERE idusuario='$idusuario'";
        return ejecutarConsulta($sql);
    }

    //Función para verificar el acceso al sistema
    public function verificar($login,$clave)
    {
        $sql="SELECT u.idusuario,u.nombre,u.apellidos,u.login,u.idtipousuario,u.iddepartamento,u.email,u.imagen,u.login FROM usuarios u WHERE u.login='$login' AND u.password='$clave' AND u.estado='1'"; 
        return ejecutarConsulta($sql);  
    }
} 
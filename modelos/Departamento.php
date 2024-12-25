<?php

//Incluímos inicialmente la conexión a la base de datos
require_once "../config/Conexion.php";

class Departamento {
    //Implementamos nuestro constructor
    public function __construct()
    {

    }

    //Implementamos un método para insertar registros
    public function insertar($nombre,$descripcion,$idusuario)
    {
        $sql="INSERT INTO departamento (nombre,descripcion,fechacreada,idusuario)
        VALUES ('$nombre','$descripcion',now(),'$idusuario')";
        return ejecutarConsulta($sql);
    }

    //Implementamos un método para editar registros
    public function editar($iddepartamento,$nombre,$descripcion,$idusuario)
    {
        $sql="UPDATE departamento SET nombre='$nombre',descripcion='$descripcion',idusuario='$idusuario' WHERE iddepartamento='$iddepartamento'";
        return ejecutarConsulta($sql);
    }

    //Implementar un método para mostrar los datos de un registro a modificar
    public function mostrar($iddepartamento)
    {
        $sql="SELECT * FROM departamento WHERE iddepartamento='$iddepartamento'";
        return ejecutarConsultaSimpleFila($sql);
    }

    //Implementar un método para listar los registros
    public function listar()
    {
        $sql="SELECT * FROM departamento";
        return ejecutarConsulta($sql);
    }
} 
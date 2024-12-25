<?php
//Incluímos inicialmente la conexión a la base de datos
require_once "../config/Conexion.php";

class Tipousuario {
    //Implementamos nuestro constructor
    public function __construct()
    {

    }

    //Implementamos un método para insertar registros
    public function insertar($nombre,$descripcion,$idusuario)
    {
        $sql="INSERT INTO tipousuario (nombre,descripcion,fechacreada,idusuario)
        VALUES ('$nombre','$descripcion',now(),'$idusuario')";
        return ejecutarConsulta($sql);
    }

    //Implementamos un método para editar registros
    public function editar($idtipousuario,$nombre,$descripcion,$idusuario)
    {
        $sql="UPDATE tipousuario SET nombre='$nombre',descripcion='$descripcion',idusuario='$idusuario' WHERE idtipousuario='$idtipousuario'";
        return ejecutarConsulta($sql);
    }

    //Implementar un método para mostrar los datos de un registro a modificar
    public function mostrar($idtipousuario)
    {
        $sql="SELECT * FROM tipousuario WHERE idtipousuario='$idtipousuario'";
        return ejecutarConsultaSimpleFila($sql);
    }

    //Implementar un método para listar los registros
    public function listar()
    {
        $sql="SELECT * FROM tipousuario";
        return ejecutarConsulta($sql);
    }
} 
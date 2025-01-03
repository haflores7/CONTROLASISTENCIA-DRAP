<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Asistencia{


	//implementamos nuestro constructor
public function __construct(){

}

public function verificarcodigo_persona($codigo_persona) {
	$sql = "SELECT u.*, d.nombre as nombre_departamento 
			FROM usuarios u 
			LEFT JOIN departamento d ON u.iddepartamento = d.iddepartamento 
			WHERE u.codigo_persona='$codigo_persona'";
	return ejecutarConsultaSimpleFila($sql);
}

public function seleccionarcodigo_persona($codigo_persona) {
	$sql = "SELECT * FROM asistencia 
			WHERE codigo_persona = '$codigo_persona' 
			AND DATE(fecha_hora) = CURDATE() 
			ORDER BY fecha_hora DESC 
			LIMIT 1";
	return ejecutarConsulta($sql);
}

public function registrar_entrada($codigo_persona, $tipo) {
	date_default_timezone_set('America/Lima');
	$fecha = date("Y-m-d");
	$fecha_hora = date("Y-m-d H:i:s");
	
	$sql = "INSERT INTO asistencia (codigo_persona, tipo, fecha, fecha_hora) 
			VALUES ('$codigo_persona', '$tipo', '$fecha', '$fecha_hora')";
	return ejecutarConsulta($sql);
}

public function registrar_salida($codigo_persona, $tipo) {
	date_default_timezone_set('America/Lima');
	$fecha = date("Y-m-d");
	$fecha_hora = date("Y-m-d H:i:s");
	
	$sql = "INSERT INTO asistencia (codigo_persona, tipo, fecha, fecha_hora) 
			VALUES ('$codigo_persona', '$tipo', '$fecha', '$fecha_hora')";
	return ejecutarConsulta($sql);
}

//listar registros
public function listar(){
	$sql="SELECT a.idasistencia,a.codigo_persona,a.fecha_hora,a.tipo,a.fecha,u.nombre,u.apellidos,d.nombre as departamento FROM asistencia a INNER JOIN usuarios u INNER JOIN departamento d ON u.iddepartamento=d.iddepartamento WHERE a.codigo_persona=u.codigo_persona";
	return ejecutarConsulta($sql);
}

public function listaru($idusuario){
	$sql="SELECT a.idasistencia,a.codigo_persona,a.fecha_hora,a.tipo,a.fecha,u.nombre,u.apellidos,d.nombre as departamento FROM asistencia a INNER JOIN usuarios u INNER JOIN departamento d ON u.iddepartamento=d.iddepartamento WHERE a.codigo_persona=u.codigo_persona AND u.idusuario='$idusuario'";
	return ejecutarConsulta($sql);
}

public function listar_asistencia($fecha_inicio,$fecha_fin,$codigo_persona){
	$sql="SELECT a.idasistencia,a.codigo_persona,a.fecha_hora,a.tipo,a.fecha,u.nombre,u.apellidos FROM asistencia a INNER JOIN usuarios u ON  a.codigo_persona=u.codigo_persona WHERE DATE(a.fecha)>='$fecha_inicio' AND DATE(a.fecha)<='$fecha_fin' AND a.codigo_persona='$codigo_persona'";
	return ejecutarConsulta($sql);
}


}

 ?>

<?php  
session_start();
if($_SESSION['logueo']!=true){
	header("Location:./index.php");
}
include("./funciones.php");
	$datos 		= $_POST['datos']; 
	$id 		= $datos[0];
	$categoria	= $datos[1];
	$nombre		= $datos[2];
	$localidad	= $datos[2];

	$sql= "DELETE FROM lugares WHERE id = $id";
	$link	= Conexion();
	$res	= mysqli_query($link,$sql) or die(Error($sql,$link));
	@mysqli_close ($link);

	echo "Se eliminó el Lugar: <p> Nombre: ".$nombre."</p><p>Categoría: ".$categoria."</p><p>Localidad: ".$localidad."</p>";

?>
<?php  
session_start();
if($_SESSION['logueo']!=true){
	header("Location:./index.php");
}
include("./funciones.php");
$datos 		= $_POST['datos']; 
$id 		= $datos[0];
$nombre		= $datos[1];

$sql= "DELETE FROM lugares WHERE id = $id";
$link	= Conexion();
$res	= mysqli_query($link,$sql) or die(Error($sql,$link));
@mysqli_close ($link);

echo "Se eliminó el Lugar:<p>ID: ".$id."</p><p>Nombre: ".$nombre;

?>
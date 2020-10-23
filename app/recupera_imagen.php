<?php
include("./funciones.php");
$link 		= Conexion();		
$id 		= $_REQUEST['id'];
$sql 		= "SELECT imagen FROM lugares WHERE id=$id";		  
$res 	= mysqli_query($link,$sql) or die(mysqli_error($link));
@mysqli_close ($link);
$row	= mysqli_fetch_assoc($res);	
	
header('Content-Type: image/jpeg');
echo base64_decode($row['imagen']);
?>
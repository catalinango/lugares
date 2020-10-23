<?php  
session_start();
if($_SESSION['logueo']!=true){
	header("Location:./index.php");
}
include("./funciones.php");
$id 			= $_REQUEST['inputid']; 
$nombre 		= mb_strtoupper(addslashes($_REQUEST['inputnombre']),'utf-8');
$id_localidad 	= $_REQUEST['sellocalidad']; 
$precio			= $_REQUEST['inputprecio']; 
$latitud		= $_REQUEST['inputlatitud']; 	
$longitud		= $_REQUEST['inputlongitud']; 
$descripcion	= addslashes($_REQUEST['textdescripcion']); 
$camino			= addslashes($_REQUEST['textcamino']); 
$album 			= $_REQUEST['inputalbum']; 
$canal 			= $_REQUEST['inputcanal'];
$destacado		= $_REQUEST['radiodestaca'];
//$file 			= $_FILES['inputimagen'];

$link	= Conexion();

if($_FILES['inputimagen']['name']!= ""){
	$file 			= $_FILES['inputimagen'];	
	//--------------- Pasar la imagen a string -----------------//
	//$file 			= $_FILES['archivo'];    //Asignamos el contenido del parametro a una variable para su mejor manejo
	$tem_name 		= $file['tmp_name'];   //Obtenemos el directorio temporal en donde se ha almacenado el archivo;
	//Esta no se usan Nombre y Extension.
	//$fileName = $file['name'];                      //Obtenemos el nombre del archivo
	//$fileExtension = substr(strrchr($fileName, '.'), 1); //Obtenemos la extensión del archivo.       
	//Comenzamos a extraer la información del archivo
	$fp 			= fopen($tem_name, "rb");                    //abrimos el archivo con permiso de lectura
	$contenido 		= fread($fp, filesize($tem_name));    //leemos el contenido del archivo
	//Una vez leido el archivo se obtiene un string con caracteres especiales.
	$contenido 		= base64_encode($contenido);            //se guarda en base64
	fclose($fp);                                    //Cerramos el archivo
	//---------------------------------------------------------//
	$imagen			= $contenido;

}else{

	if($id == 0){ //es nuevo
		$sql="SELECT imagen FROM sin_imagen";
		$res=mysqli_query($link,$sql) or die(Error($sql,$link));
		$row_imagen = mysqli_fetch_assoc($res);
		$imagen=addslashes($row_imagen['imagen']);

	}else{ //existe pero no se le canto cargar imagen... porque edito el texto...
		$sql="SELECT imagen FROM lugares WHERE id=$id";
		$res=mysqli_query($link,$sql) or die(Error($sql,$link));
		$row_imagen = mysqli_fetch_assoc($res);
		$imagen=addslashes($row_imagen['imagen']);
	}
}


if($id == 0){
	//******************es nuevo
	$sql="INSERT INTO lugares (nombre, descripcion, precio, latitud, longitud, id_localidad, det_camino, imagen, url_fotos, url_videos, destacado) VALUES ('$nombre', '$descripcion', $precio, '$latitud', '$longitud', $id_localidad, '$camino', '$imagen', '$album', '$canal', '$destacado');";
	mysqli_query($link,$sql) or die(Error($sql,$link)); //no es necesario almacenarlo en un res...

	//recupero el id del anterior insertado...
	$sql="SELECT last_insert_id() as id FROM lugares";
	$res=mysqli_query($link,$sql) or die(Error($sql,$link));
	$row_lugar = mysqli_fetch_assoc($res);
	$id=$row_lugar['id'];

}else{
	//****************es edicion
	$sql="UPDATE lugares SET nombre='$nombre', descripcion='$descripcion', precio=$precio, latitud='$latitud', longitud='$longitud', id_localidad=$id_localidad, det_camino='$camino', imagen='$imagen', url_fotos='$album', url_videos='$canal', destacado = '$destacado' WHERE id =$id;";

	mysqli_query($link,$sql) or die(Error($sql,$link)); //no es necesario almacenarlo en un res...	
}

//se le quitan todas las categorias...
$sql="DELETE FROM categorias_lugares WHERE id_lugar=$id;";
mysqli_query($link,$sql) or die(Error($sql,$link));

//se incorporan las categorias seleccionadas...
if (isset($_POST['categorias'])){    	
   	foreach($_POST['categorias'] as $categoria) {
		$sql="INSERT INTO categorias_lugares (id_lugar,id_categoria) VALUES ($id,$categoria) ON DUPLICATE KEY UPDATE id_categoria=id_categoria;"; //on duplicate por control de concurrencia de usuario...
		mysqli_query($link,$sql) or die(Error($sql,$link)); //no es necesario almacenarlo en un res...            
   	}		
}

@mysqli_close ($link);
header("Location:../?p=7&l=$id&g=true");
?>
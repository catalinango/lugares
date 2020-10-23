<?php  
session_start();
if($_SESSION['logueo']!=true){
	header("Location:./index.php");
}
include("./funciones.php");
$datos 	= $_POST['datos']; 
$id 	= $datos[0];
$dni	= $datos[1];
$apyn	= mb_strtoupper(addslashes($datos[2]),'utf-8');
$email	= addslashes($datos[3]);
$clave	= $datos[4];
$id_rol	= $datos[5];	
	
$link	= Conexion();
$sql	= "SELECT * FROM usuarios WHERE dni='$dni' LIMIT 1;";
	$res	= mysqli_query($link,$sql)or die(Error($sql,$link));
	$row	= mysqli_fetch_assoc($res);

if($id == 0){
	//******************es nuevo
	if(mysqli_num_rows($res)<1){
	//******************es nuevo
		$sql	="INSERT INTO usuarios (dni, apyn, email, clave, id_rol) VALUES ('$dni', '$apyn', '$email', '$clave', $id_rol);";
		$res	= mysqli_query($link,$sql) or die(Error($sql,$link));

		$sql	= "SELECT a.id, a.apyn, a.dni, a.email, a.clave, a.id_rol, b.detalle AS rol FROM usuarios AS a INNER JOIN roles AS b ON a.id_rol=b.id WHERE dni='$dni';";
		$res	= mysqli_query($link,$sql) or die(Error($sql,$link));
		$row	= mysqli_fetch_assoc($res);

		echo "Se guardaron los siguientes Datos: <p>ID: ".$row['id']."</p><p>DNI: ".$row['dni']."</p><p>Nombre y Apellido: ".$row['apyn']."</p><p>Email: ".$row['email']."</p><p>Contraseña: ".$row['clave']."</p><p>Rol: ".$row['rol']."</p>";

	}else{
	//****************dni duplicado
	echo "El Usuario con DNI: ".$row['dni']."<p>Está registrado con los siguientes datos:</p><p>Nombre y Apellido: ".$row['apyn']."</p><p>Email: ".$row['email']."</p><p>Contraseña: ".$row['clave']."</p><p>Rol: ".$row['rol']."</p><p>Para EDITAR: seleccione el usuario en la tabla. </p><p>Para un NUEVO usuario: presione el botón NUEVO.</p>";
	}

}else{
	//****************es edicion
	$sql="UPDATE usuarios SET dni ='$dni', apyn ='$apyn', email ='$email', clave ='$clave', id_rol = $rol WHERE id =$id;";
	$res	= mysqli_query($link,$sql) or die(Error($sql,$link));

	$sql	= "SELECT a.id, a.apyn, a.dni, a.email, a.clave, a.id_rol, b.detalle AS rol FROM usuarios AS a INNER JOIN roles AS b ON a.id_rol=b.id WHERE dni='$dni';";
	$res	= mysqli_query($link,$sql) or die(Error($sql,$link));
	$row	= mysqli_fetch_assoc($res);

	echo "Se guardaron los siguientes Datos: <p>ID: ".$row['id']."</p><p>DNI: ".$row['dni']."</p><p>Nombre y Apellido: ".$row['apyn']."</p><p>Email: ".$row['email']."</p><p>Contraseña: ".$row['clave']."</p><p>Rol: ".$row['rol']."</p>";

}

@mysqli_close ($link);
?>
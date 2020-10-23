<?php
session_start();
include("./funciones.php");
$dni   	= $_REQUEST['dni'];
$link 	= Conexion();
$sql  	= "SELECT *, COUNT(*) AS cant FROM usuarios WHERE dni = '$dni';";
$res	= mysqli_query($link,$sql) or die(Error($sql,$link)); 
$row 	= mysqli_fetch_assoc ($res);
@mysqli_close ($link); 

$alert="No es un usuario registrado";	
if ($row['cant'] > 0){
	$destinatario = "catalinango@gmail.com";
	$remitente 	= $row['apyn'];
	$asunto = 'Lugares de Interes - Resetear Clave'; // Asunto del mail
	
	$cuerpo  = "Resear Clave del Siguiente Usuario: \r \n"; 
	$cuerpo .= "DNI: " . $row['dni'] . "\r\n";    
	$cuerpo  = "Nombre y Apellido: " . $remitente . "\r \n"; 
	$cuerpo .= "Email: " . $row['email'] . "\r \n";

	$headers  = "MIME-Version: 1.0\n";
    $headers .= "Content-type: text/plain; charset=utf-8\n";
    $headers .= "X-Priority: 3\n";
    $headers .= "X-MSMail-Priority: Normal\n";
    $headers .= "X-Mailer: PHP/".phpversion()."\n";
    $headers .= "From: \"".$row['dni']."\" <".$remitente.">\n";

    mail($destinatario, $asunto, $cuerpo, $headers);
	
	$alert="Se realizó la petición para Reseteo de Clave - Contacte a su administrador";	
}
?>
<script> 
	alert("<?php echo $alert?>");
   	location.href="./?p=0";
</script>
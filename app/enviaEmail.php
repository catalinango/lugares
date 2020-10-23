<?php
session_start();
$remitente      = $_POST['email'];
$destinatario   = $_SESSION['email']; 
$asunto         = 'Lugares de Interes - Consulta web'; 
if (!$_POST){

}else{
	 
    $cuerpo  = "Nombre: " . $_POST['nombrePersona'] . "\r \n"; 
    $cuerpo .= "Email: " . $_POST['emailPersona'] . "\r \n";
	$cuerpo .= "Consulta: " . $_POST['textoEmail'] . "\r\n";

    $headers  = "MIME-Version: 1.0\n";
    $headers .= "Content-type: text/plain; charset=utf-8\n";
    $headers .= "X-Priority: 3\n";
    $headers .= "X-MSMail-Priority: Normal\n";
    $headers .= "X-Mailer: PHP/".phpversion()."\n";
    $headers .= "From: \"".$_POST['nombrePersona']."\" <".$remitente.">\n";

    mail($destinatario, $asunto, $cuerpo, $headers);
}
?>
<script> 
    alert("Su consulta se ha enviado correctamente");
    location.href="../?p=0";
</script>
<?php
include './config.php';

function Conexion(){
	$link = mysqli_connect($_SESSION['DB_HOST'], $_SESSION['DB_USER'], $_SESSION['DB_PASSWORD'],$_SESSION['DB_NAME']);
        
    if (mysqli_connect_errno()){
       echo "No se pudo conectar a MySQL: " . mysqli_connect_error();
       exit();
    }
	return $link;
}

function  Error($linea, $link){
	echo "<br>Error Linea SQL.<br>".$linea."<BR>";	
	echo "<br>Error Codigo N:".mysqli_errno($link)."<br>".mysqli_error($link);
	mysqli_query($link,"rollback");
	@mysqli_close ($link);
	return;
}

function Begin($link){
	mysqli_query($link,"SET AUTOCOMMIT=0;") or die(Error("SET AUTOCOMMIT=0;",$link));
	mysqli_query($link,"START TRANSACTION;") or die(Error("START TRANSACTION;",$link));
}

function Commit($link){
	$res	=mysqli_query($link,"COMMIT;") or die(Error("COMMIT;",$link));
}

function Rollback($link){
	$res	=mysqli_query($link,"ROLLBACK;") or die(Error("ROLLBACK;",$link));
}


?>

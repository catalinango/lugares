<?php 
session_start();
$_SESSION['logueo']  = false;
$action = "./";
if(isset($_POST['usuario'])){
	$dni= $dni['usuario'];
}else{
	$dni = '0';
}
if(isset($_POST['usuario']) && isset($_POST['clave'])){
	$usua 	= $_POST['usuario'];
	$contra =	$_POST['clave'];

	include("./funciones.php");
	$link=Conexion();
	$sql="SELECT * FROM usuarios WHERE dni=$usua AND clave='$contra' LIMIT 1";
	$res=mysqli_query($link,$sql) or die(Error($sql,$link));
	$row = mysqli_fetch_assoc ($res);
				
	if($usua==$row['dni'] && $contra==$row['clave']){	
		$_SESSION['logueo']  = true;
		$_SESSION['nivel']  = $row['id_rol'];	
		$_SESSION['apyn']=$row['apyn'];
		header("Location:../");
	}else{
		?>
		<script>
			alert("Error: Verifique datos ingresados del usuario");
		</script>
		<?php
	}
}
@mysqli_close ($link);

?>

<!DOCTYPE HTML>
<html lang="es">
	<head>
		<title>Lugares | Iniciar Sesion</title>
		<link href="../css/bootstrap.css" rel='stylesheet' type='text/css' />
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<!-- Custom Theme files -->
		<link href="../css/style.css" rel='stylesheet' type='text/css' />
		<link href="../css/estilo.css" rel='stylesheet' type='text/css' />
		<!-- Custom Theme files -->
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta charset="utf-8">
		<link href="../css/nav.css" rel="stylesheet" type="text/css" media="all"/>
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700,800,900' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300:700' rel='stylesheet' type='text/css'>
		<!---- animated-css ---->
		<link href="../css/animate.css" rel="stylesheet" type="text/css" media="all">
		<!--font-Awesome-->
		<link rel="stylesheet" href="../plugins/font-awesome-4.7.0/css/font-awesome.min.css">

		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta charset="UTF-8">
		
		<script src="../plugins/jQuery/jquery-2.2.3.min.js" type="text/javascript"></script>
		<script src="../js/bootstrap.js"></script>
		<script src="../js/modernizr.custom.js" type="text/javascript"></script>	
		<script src="../js/jquery.openCarousel.js" type="text/javascript"></script>

		<script type="application/x-javascript" charset="utf-8">

		$(document).ready(function() {
			$('.solo-numero').keyup(function (){
			    this.value = (this.value + '').replace(/[^0-9]/g, '');
			    return false;
			});	
			var button = $('#loginButton');
    		var box = $('#loginBox');
    		var form = $('#loginForm');
    		button.removeAttr('href');
    		button.mouseup(function(login) {
	   			box.toggle();
       			button.toggleClass('active');
			});
			form.mouseup(function() { 
	   			return false;
			});
			$(this).mouseup(function(login) {
	   			if(!($(login.target).parent('#loginButton').length > 0)) {
	   				button.removeClass('active');
	   				box.hide();
	   			}    
			});

		});
		
		function loginPag(){
			ajax("main","./app/");
		}
		
		function cargarModal(titulo, contenido){
			$("#title-alerta").html(titulo);
			$("#content-alerta").html(contenido);
			$("#modal-alerta").modal("show");
		}

		function validaDNI(){
			//---- Validar DNI -----//
			if($("#usuario").val()=='DNI') {  
       			cargarModal("Error", "Debe ingresar un DNI");
       			return false;  
       		}
			if($("#usuario").val().length < 7) {  
       			cargarModal("Error", "Debe ingresar un DNI válido");
      			return false;  
			} 
  			if($("#usuario").val().length > 8) {  
       			cargarModal("Error", "Debe ingresar un DNI válido"); 
      			return false;
  			} 
  			return true;
  		}
  		function recuperarClave(){
  			
  			if($("#usuario").val()=='DNI') {  
       			cargarModal("Error", "Debe ingresar un DNI");
       			return false;  
       		}
			if($("#usuario").val().length < 7) {  
       			cargarModal("Error", "Debe ingresar un DNI válido");
      			return false;  
			} 
  			if($("#usuario").val().length > 8) {  
       			cargarModal("Error", "Debe ingresar un DNI válido"); 
      			return false;
  			} 

  			var dni = $("#usuario").val();
  			$("#recuperaClaveLink").attr("href", "./recuperaClave.php?dni="+ dni);
  			return true;
  		} 
		</script>
	</head>
	<body>
		<div class="modal fade" id="modal-alerta" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"><!-- Start Modal -->
   			<div class="modal-dialog">
      			<div class="modal-content">
         			<div class="modal-header">
        				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            			<h3><div id="title-alerta"></div></h3>
	     			</div>
    	     		<div id="content-alerta" class="modal-body">
     				</div>
         			<div class="modal-footer">
        				<div class="pull-left" id="footer-alerta"></div> <a href="#" data-dismiss="modal" class="btn btn-danger">OK</a>
	     			</div>
    	  		</div>
   			</div>
		</div><!-- Modal -->
		<!------------ Start Content ---------------->
    	<div class="main">        	
    		<div class="container">          	 
	 			<div class="row grids text-center">
					<h3 class="hist">Iniciar Sesion</h3>
					<div class="col-md-4"></div>	
					<div class="col-md-4 login-form history_grid" id="login-box">
						<form method="post" id="signup" name="signup" action="<?php echo $action;?>">
					  		<input type="text" id="usuario" name="usuario" class="textbox solo-numero" value="DNI" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'DNI';}" maxlength="8" size="8" required>
							<input type="password" id="clave" name="clave" class="textbox" value="" placeholder="Contraseña" required>
	    					<h3><a href="" id="recuperaClaveLink" onclick="return recuperarClave();"> Recuperar contraseña </a></h3>	
					    	<p><input type="submit" onclick="return validarDNI();" value=" Ingresar al Sistema "></p>
		        		</form>
	        		</div><!--/.col -->
		    		<div class="col-md-4"></div>
				</div>
    		</div>
  		</div><!-- Fin Main -->
	</body>
	<script type="application/x-javascript" charset="utf-8">
	 
	</script> 			
</html>


<?php 
session_start();
$pag	= (isset($_REQUEST['p'])) ?  $_REQUEST['p']: NULL; //Nro. de la página que se envía al main al utilizar header.
$lug	= (isset($_REQUEST['l'])) ? $_REQUEST['l'] : NULL; //Nro. del lugar trabajando.
$gra	= (isset($_REQUEST['g'])) ? $_REQUEST['g'] : NULL; //Nro. del lugar trabajando.
?>

<!DOCTYPE HTML>
<html lang="es">
	<head>
		<title>Lugares | Pcia :: Bs As</title>
		<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
		<!-- Custom Theme files -->
		<link href="css/style.css" rel='stylesheet' type='text/css' />
		<link href="css/estilo.css" rel='stylesheet' type='text/css' />
		<link href="css/nav.css" rel="stylesheet" type="text/css" media="all"/>
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700,800,900' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300:700' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic' rel='stylesheet' type='text/css'>
		<!--font-Awesome-->
		<link rel="stylesheet" href="plugins/font-awesome-4.7.0/css/font-awesome.min.css">

		<!-- DataTables -->
		<link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
		
		<link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta charset="utf-8">
		
		<script src="plugins/jQuery/jquery-2.2.3.min.js" type="text/javascript"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/modernizr.custom.js" type="text/javascript"></script>	
		<script src="js/jquery.openCarousel.js" type="text/javascript"></script>

		<script src="js/fwslider.js" type="text/javascript"></script>
		<script src="js/funciones.js" type="text/javascript"></script>
		<script src="js/wow.min.js"></script>
		

		<script src="plugins/datatables/jquery.dataTables.min.js"></script>
		<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
		<script src="js/inputfile.js"></script>
		
		<script type="application/x-javascript" charset="utf-8"> 
			
			addEventListener("load", function() {
				setTimeout(hideURLbar, 0); }, false
			);
			function hideURLbar(){ 
				window.scrollTo(0,1); 
			} 
			
			$(document).ready(function() {
	    	$('#slider').fwslider({
	        auto:     true,  //auto start
	        speed:    300,   //transition speed
	        pause:    4000,  //pause duration
	        panels:   5,     //number of image panels
	        width:    1680,
	        height:   500,
	        nav:      true   //show navigation
	    	});
			});
			new WOW().init();

			$(function() {
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
	 		
			function homePag(){ //Pag N°: 0
				ajax("main","./app/home.php");			
			}	
			function lugaresPag(){ //Pag N°: 1
				OcultarDiv('slider');
				LimpiarDiv('slider');
				ajax("main","./app/lugares.php");
			}
			function mapaPag(lugar){ //Pag N°: 2
				OcultarDiv('slider');
				LimpiarDiv('slider');
				ajax("main","./app/mapa_cont.php");		
			}
			function contactoPag(){ //Pag N°: 4
				OcultarDiv('slider');
				LimpiarDiv('slider');
				ajax("main","./app/contacto.php");		
			}
			function buscarAvanzPag(){ //Pag N°: 5
				OcultarDiv('slider');
				LimpiarDiv('slider');
				ajax("main","./app/buscarAvanz.php");
			}
			function listLugarPag(){ //Pag N°: 6
				OcultarDiv('slider');
				LimpiarDiv('slider');
				ajax("main","./app/listLugares.php");
			}
			function abmLugarPag(lugar,grabo){ //Pag N°: 7
				OcultarDiv('slider');
				LimpiarDiv('slider');
				if(lugar>0){
					if(grabo=="true"){alert("Datos Almacenados");}
					ajax("main","./app/abmLugar.php?id="+lugar);
				}else{
					ajax("main","./app/abmLugar.php?id=0");
				}
			}
			function abmUsuarioPag(){ //Pag N°: 8
				OcultarDiv('slider');
				LimpiarDiv('slider');
				ajax("main","./app/abmUsuario.php");	
			}

			function unLugarPag(id){ //Pag N°: 9
				OcultarDiv('slider');
				LimpiarDiv('slider');	
				ajax("main","./app/unLugar.php?id="+id);
			}
			function cargarModal(tipo, titulo, contenido, pie){
				$("#title-alerta").html(titulo);
				$("#content-alerta").html(contenido);
				$("#footer-alerta").html(pie);
				$("#modal-alerta").modal("show");
			}
		</script>
	</head>
	<body>
  	<!-- Header -->
		<div class="header">    
			<div class="header_top">
				<div class="container">
			  	<div class="headertop_nav">
						<ul>
						<?php 
						if ((isset($_SESSION['logueo']))&&($_SESSION['logueo']==true)){
							echo '<li>Hola '.$_SESSION['apyn'].'! / </li><li><a href="./app/logout.php">Cerrar Session </a></li>';
						}else{
							echo '<li><a href="app/">Ir a la Administración</a></li>';
						}
						?> 
						</ul>
					</div>
		    	
			 		<div class="clearfix"></div>
        </div>
		  </div>
 	  	<div class="header_bottom">
		  	<div class="container">	 			
					<div class="logo">
						<h1><a href="./">Lugares de Interés<span>Provincia de Buenos Aires</span></a></h1>
					</div>				
					<div class="navigation">	
						<div>
            	<label class="mobile_menu" for="mobile_menu">
            		<span>Menu</span>
            	</label>
            	<input id="mobile_menu" type="checkbox">
							<ul class="nav">
							<?php 
							if ((isset($_SESSION['logueo']))&&($_SESSION['logueo']==true)&&($_SESSION['nivel']<2)){
								echo '<li><a href="#" onclick="abmUsuarioPag();">Usuarios</a></li>';
							}else{
								echo '<li></li> ';
							}
							?> 
            		<li class="dropdown"><a href="#">Lugares</a>
              		<ul class="dropdown2">
                  	<li><a href="#" onclick="buscarAvanzPag();">Busqueda</a></li>
                  	<li><a href="#" onclick="lugaresPag();">Todos</a></li>
            			<?php 
						if ((isset($_SESSION['logueo']))&&($_SESSION['logueo']==true)){
							echo '<li><a href="#" onclick="abmLugarPag();">Nuevo</a></li>';
							echo '<li><a href="#" onclick="listLugarPag();">Modificar</a></li>';
							}
						?>	
                	</ul>
              	</li>               
              	<li><a href="#" onclick="mapaPag();">Mapa</a></li>
              	
              	<li><a href="#" onclick="contactoPag();">Contacto</a></li>
              	
              	<li><a href="./">Home</a></li>
            		<div class="clearfix"></div>
          		</ul>
						</div>			
	 				</div>
     			<div class="clearfix"></div>		   
    		</div>
  		</div>
			<div id="slider">
	  		<div><img src="images/laboca.jpg" class="img-responsive" alt="img01"/></div>
	  		<div><img src="images/puentelamujer.jpg" class="img-responsive" alt="img02"/></div>
	  		<div><img src="images/laboca.jpg" class="img-responsive" alt="img03"/></div>
	  		<div><img src="images/puentelamujer.jpg" class="img-responsive" alt="img04"/></div>
			</div>
  	</div><!-- Ends Header -->
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
    <div id="main" class="main"> </div>
			<!-- Footer -->
    	<div class="footer">
    	  <div class="container">   	 
      		<div class="footer_top">
          	<div class="row">
              <ul class="socials pull-right">
                <li><a href="https://plus.google.com/collections/featured"><i class="fa fa-google-plus"></i></a></li>
                <li><a href="https://es.pinterest.com/"><i class="fa fa-pinterest"></i></a></li>
                <li><a href="https://twitter.com/?lang=es"><i class="fa fa-twitter"></i></a></li>
                <li><a href="https://www.facebook.com/"><i class="fa fa-facebook"></i></a></li>
              </ul>
          		<div class="clearfix"></div>
            </div>
          </div>
          <div class="footer_bottom">
		      <div class="copy_right">
						<p>Diseñado con: <a href="http://w3layouts.com/">W3layouts</a> </p>
				  </div>
			<div class="footer_nav">
				  	<ul>
				   	 	<li><a href="./">Home</a></li>
				   	</ul>
				  </div>
				  <div class="clearfix"></div>
				</div>
		   </div>
   		</div><!-- Footer -->
   		<input type="text" id ="nroPag" class="hidden" value = "<?php echo $pag; ?>">
   		<input type="text" id ="nroLug" class="hidden" value = "<?php echo $lug; ?>">
   		<input type="text" id ="grabo" class="hidden" value = "<?php echo $gra; ?>">
	</body>
	<script type="application/x-javascript" charset="utf-8"> 
	$(function() {
		var pagina = $("#nroPag").val();
		var lugar = $("#nroLug").val();
		var grabo = $("#grabo").val();
		switch(parseInt(pagina)) {
    		case 0:
        		homePag();
        		break;
    		case 1:
        		lugaresPag();
        		break;
				case 2:
        		mapaPag(lugar);
        		break;
    		case 4:
        		contactoPag();
        		break;
    		case 5:
        		buscarAvanzPag();
        		break;
        	case 6:
        		listLugarPag();
        		break;
        	case 7:
        		abmLugarPag(lugar,grabo);
        		break;
    		case 8:
        		abmUsuarioPag();
        		break;
        	case 9:
        		unLugarPag(lugar);
        		break;	
        	default:
        		homePag();
		}
	});
	</script>
</html>


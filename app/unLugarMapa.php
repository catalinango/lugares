 <?php 
session_start();
include("./funciones.php");

$id 					= $_REQUEST['id'];
$link 					= Conexion();
$sql  				= "SELECT a.id, a.nombre, a.descripcion, a.precio, a.latitud, a.longitud, a.id_localidad, a.det_camino, a.imagen, a.url_fotos, a.url_videos, b.detalle AS det_localidad FROM lugares AS a, localidades AS b WHERE a.id_localidad=b.id AND a.id = $id LIMIT 1;";
$res  				= mysqli_query($link,$sql) or die(Error($sql,$link));
$row 					= mysqli_fetch_assoc ($res);
$sql    			="SELECT detalle FROM categorias INNER JOIN categorias_lugares ON categorias_lugares.id_lugar= $id GROUP BY detalle;";
$res_cat			= mysqli_query($link,$sql) or die(Error($sql,$link));

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
    <meta charset="UTF-8">
    
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
<!------------ Start Content ---------------->
<div class="reservation_top">
  <div class="container">          	 
	 	<div class="about">
	 		<h3><a href="#"><?php echo $row['nombre'];?></a></h3>
	 		 <div class="post1">
	 		 	<div class="post1_header">
    			<span class="post1_header_in">Localidad: <?php echo $row['det_localidad'];?></span>
    			<span class="post1_header_in"> Precio: <?php echo $row['precio'];?><br>
    			<span class="post1_header_in"> Categorías: 
    			<?php 
    			$i = 0;
    			$categorias = "";
    			
    			while($row_cat = mysqli_fetch_assoc ($res_cat)){ 
    				$i++;
    				if($i==1){
    					$categorias = $row_cat['detalle'];
    				}else{
    					$categorias = $categorias." - ".$row_cat['detalle'];
    				}
    			}
    			echo $categorias;
    			?>   
          </span>
  			</div>
	 		</div>
	 		<p><?php echo $row['descripcion'];?></p>
	   </div>
    </div>
    <div class="staff">
      <div class="container">
  	    <h2 class="staff_head"></h2>
          <div class="row">
    	     <div class="col-md-6 staff_grid">
    		<h3><a href="#"> Album de Fotos </a></h3>
    		<a href="#" class="mask map"><img src="./images/g1.jpg" class="map img-responsive zoom-img" alt="Imagen"/></a>
		    <p> </p><br><br>
  		</div>
    	<div class="col-md-6 staff_grid">
      	<h3><a href="#"> Canal de Youtube </a></h3>
      	<iframe class="map" src="https://www.youtube.com/embed/videoseries?list=PLu37pHjfhW0Qr3HxzMt2NKHeCBZupxgMW" frameborder="0" allowfullscreen></iframe>
      	<p> </p><br><br>
  	</div> 
  		<div class="clearfix"></div>             	
	</div>
</div>
</div>


</div>
</div></div></div></body></html>







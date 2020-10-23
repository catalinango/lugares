 <?php 
session_start();
include("./funciones.php");

$id 				= $_REQUEST['id'];
$link 				= Conexion();
$sql  				= "SELECT a.id, a.nombre, a.descripcion, a.precio, a.latitud, a.longitud, a.id_localidad, a.det_camino, a.imagen, a.url_fotos, a.url_videos, b.detalle AS det_localidad FROM lugares AS a, localidades AS b WHERE a.id_localidad=b.id AND a.id = $id LIMIT 1;";
$res  				= mysqli_query($link,$sql) or die(Error($sql,$link));
$row 				= mysqli_fetch_assoc ($res);
$sql    			="SELECT detalle FROM categorias INNER JOIN categorias_lugares ON categorias_lugares.id_lugar= $id GROUP BY detalle;";
$res_cat			= mysqli_query($link,$sql) or die(Error($sql,$link));

?>
<!------------ Start Content ---------------->
<div class="reservation_top">
  <div class="container">          	 
	 	<div class="about">
	 		<h3><a href="#"><?php echo $row['nombre'];?></a></h3>
	 		 <div class="post1">
	 		 	<div class="post1_header">
    			<span class="post1_header_in">Localidad: <a href="#"><?php echo $row['det_localidad'];?></a></span>
    			<span class="post1_header_in"> Precio: $<a href="#"><?php echo $row['precio'];?></a></span><br>
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
  			</div>
	 		</div>
	 		<p><?php echo $row['descripcion'];?></p>
	 		<h4>Como Llegar: </h4>
      <p><?php echo $row['det_camino'];?></p>
	 	</div>
	</div>
</div>
<div class="staff">
  <div class="container">
  	<h2 class="staff_head"></h2>
    <div class="row">
    	<div class="col-md-6 staff_grid">
    		<h3><a href="<?php echo $row["url_fotos"];?>"> Album de Fotos </a></h3>
    		<!--<a href="#" class="mask map"><img src="./images/g1.jpg" class="map img-responsive zoom-img" alt="Imagen"/></a>-->
    		<img src="data:image/jpeg;base64,<?php echo $row["imagen"];?>" class="map img-responsive" alt="<?php addslashes($row['nombre']);?>"/>
		    <p> </p><br><br>
  		</div>
    	<div class="col-md-6 staff_grid">
      	<h3><a href="<?php echo $row["url_videos"];?>"> Canal de Youtube </a></h3>
      	<iframe class="map" src="<?php echo $row["url_videos"];?>" frameborder="0" allowfullscreen></iframe>
      	<p> </p><br><br>
  	</div> 
  		<div class="clearfix"></div>             	
	</div>
</div>






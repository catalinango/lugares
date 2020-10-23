<?php 
session_start();
/*if($_SESSION['logueo']!=true){
	header("Location:./index.php");
}*/

include("./funciones.php");
$i		= 0;
$link	= Conexion();
$sql	= "SELECT a.id AS id_lugar, a.nombre, a.descripcion, a.precio, a.latitud, a.longitud, a.id_localidad, a.det_camino, a.imagen, a.url_fotos, a.url_videos, b.detalle AS det_localidad FROM lugares AS a, localidades AS b WHERE a.id_localidad=b.id";
$res 	= mysqli_query($link,$sql) or die(Error($sql,$link));
@mysqli_close ($link);
?>
<div class="reservation_top">
  <div class="container">          	 
	 	<div class="row room_grids text-center">
	 	   <?php
			while($row = mysqli_fetch_assoc ($res)){
				$i++;
			?>

	 	  <div class="col-md-4 text-center">
				<div class="view view-tenth">
					<a href="#" onclick="unLugarPag(<?php echo $row['id_lugar'];?>);">
						<div class="inner_content clearfix">
							<div class="product_image">
								<img src="./app/recupera_imagen.php?id=<?php echo $row['id_lugar'];?>" class="img-responsive" alt=""/>
								<div class="label-product">
              	   <span class="new">$ <?php echo $row['precio']; ?></span>
	              </div>
								<div class="mask" >
				          <h2><?php echo $row['nombre']; ?></h2>
				          <h3><?php echo substr($row['descripcion'] , 0,80).'...'; ?></h3>
			  	        <div class="info"><i class="fa fa-search-plus"></i></div>
			    	    </div>
			      	</div>
				    </div>
					</a> 
				</div>
				<div class="product_container wow bounceIn" data-wow-delay="0.4s">
				<h3><a href="#"><?php echo $row['nombre']; ?></a></h3>
				<div class="underheader-line"></div>
				<ul class="person">
				    <h4>Localidad: <?php echo $row['det_localidad']; ?></h4>
				</ul>
			</div>		
		</div>

		<?php
		}
		?>
		</br>				
	</div>
</div>	 
</div>
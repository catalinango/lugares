<?php 
session_start();
include("./funciones.php");
$i              = 0;
$link           = Conexion();
$sql            = "SELECT COUNT(*) AS cantidad, detalle, id_categoria AS id FROM categorias_lugares INNER JOIN categorias ON categorias.id=categorias_lugares.id_categoria GROUP BY id_categoria;";
$res_categorias = mysqli_query($link,$sql) or die(Error($sql,$link));
$sql            = "SELECT * FROM localidades;";
$res_localidades= mysqli_query($link,$sql) or die(Error($sql,$link));
@mysqli_close ($link);
?>

<div class="reservation_top">
  <div class="container">
      <div class="col-md-8" id="resultado"> </div>
      <div class="col-md-4">
        <!------------- BUSCAR ---------------->
    	  <div class="category_widget">
		      <div class="category_widget"><h3>Buscar Lugar</h3></div>
     		  <div class="search">
            <h3>por Nombre</h3>
            <form>
       		    <input value="" id="buscarNombre" type="text">
       			  <input value="" type="submit">
      			</form>
     		  </div>
        </div>
        <div class="category_widget">
	   		  <h3>Filtrar por Categoria</h3>
          <ul class="list-unstyled arrow">
            <?php 
            while($row_categoria = mysqli_fetch_assoc ($res_categorias)){
            ?>
            <li><a href="#"><?php echo $row_categoria['detalle'];?><span class="badge pull-right">    
            <?php echo $row_categoria['cantidad'];?></span></a></li>
            <?php
            }
            ?>
	   	   </ul>   
     	  </div>
     	  <div class="category_widget">
  		    <h3>Filtrar por Localidad</h3>
		      <ul class="list-unstyled arrow">
  		      <li>
              <select id="sellocalidad" name="sellocalidad" class="frm-field required">
                <option value="null">Seleccione Localidad</option>
                <?php 
                while($row_localidades = mysqli_fetch_assoc ($res_localidades)){
                ?><option value="<?php echo $row_localidades['id'];?>"><?php echo $row_localidades['detalle'];?></option>
                <?php 
                }
                ?>
              </select>
            </li>
            <br><br>
			    </ul>
    	  </div>
      </div><!------------- FIN BUSCAR ---------------->          
  </div><!-- Fin container -->
</div><!-- Fin reservation_top -->
<script type="application/x-javascript" charset="utf-8">
$(function(){
	var datosBuscar = [];
	$.post("./app/exeBusqueda.php",	{datos: datosBuscar},
		function(data, status){
				$("#resultado").html(data);
	});
});
</script>
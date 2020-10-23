<?php 
session_start();
include("./funciones.php");
$i      = 0;
$link   = Conexion();

$sql    ="SELECT lugares.id, lugares.nombre, lugares.descripcion, lugares.precio, localidades.detalle AS det_localidad FROM lugares INNER JOIN localidades ON lugares.id_localidad=localidades.id;";
$res    = mysqli_query($link,$sql) or die(Error($sql,$link));
$sql    ="SELECT detalle FROM categorias_lugares INNER JOIN localidades ON lugares.id=categorias_lugares.id_lugar;";
$res_cat= mysqli_query($link,$sql) or die(Error($sql,$link));

@mysqli_close ($link);
?>
<?php while($row = mysqli_fetch_assoc ($res)){ ?>
	<div class="post1">
    <h3><a href="#"><?php echo $row['nombre'];?></a></h3>
  <div class="post1_header">
    <span class="post1_header_in">Localidad: <a href="#"><?php echo $row['det_localidad'];?></a></span>
    <span class="post1_header_in" title="bookmark"> Precio: <a href="#"><?php echo $row['precio'];?></a></span>
    <span class="post1_header_in" title="bookmark"> Precio: <a href="#"><?php echo $row['precio'];?></a></span>
  </div>
  <div class="row">
    <div class="col-md-2">
      <a href="#" class="mask"><img src="./images/g1.jpg" class="img-responsive zoom-img" alt="Imagen"/></a>
    </div>
    <div class="col-md-10 history_grid">
      <?php echo $row['descripcion'];?>
      <nav class="cl-effect-7" id="cl-effect-7">
        <a href="#cl-effect-7" id="<?php echo $row['id'];?>">Leer Más</a>
      </nav>
    </div>
  </div>
  </div>
<?php } ?>     	  
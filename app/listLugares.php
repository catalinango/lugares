<?php 
session_start();
if($_SESSION['logueo']!=true){header("Location:./index.php");}
include("./funciones.php");
$i      = 0;

$link = Conexion();
$sql  = "SELECT a.id, a.nombre, a.precio, a.destacado, b.detalle AS det_localidad FROM lugares AS a, localidades AS b WHERE a.id_localidad=b.id";
$res  = mysqli_query($link,$sql) or die(Error($sql,$link));
@mysqli_close ($link);
?>

<div class="reservation wow fadeInLeft" data-wow-delay="0.4s" id="work">
  <div class="container">
    <div class="row main-reservation-text">
      <div class="col-xs-12">
        
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Seleccione un Lugar</h3>
          </div><!-- /.box-header -->
          <div id="box-tabla" class="box-body">
            <table id="tabla-lugares" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th class= "hidden">ID</th>
                  <th>#</th>
                  <th>Nombre Lugar</th>
                  <th>Localidad</th>
                  <th>Precio</th>
                  <th>Destacar</th>
                </tr>
              </thead>
              <tbody>
                <?php
				        while($row = mysqli_fetch_assoc ($res)){
					      $i++;
					      ?>
                <tr>
                  <td class="hidden"><?php echo $row['id'];?></td>
          	      <td><?php echo $i;?></td>
          	      <td><?php echo $row['nombre'];?></td>
          	      <td><?php echo $row['det_localidad'];?></td>
          	      <td><?php echo $row['precio'];?></td>
                  <td><?php if($row['destacado'] == 'S') {echo 'SI';} else {echo 'NO';} ?></td>
                </tr>
                <?php
				        }
				        ?>
              </tbody>
              <tfoot>
                <tr>
                  <th class= "hidden">ID</th>
                  <th>#</th>
                  <th>Nombre Lugar</th>
                  <th>Ciudad</th>
                  <th>Precio</th>
                  <th>Destacar</th>
                </tr>
              </tfoot>
            </table>
          </div><!-- /.box-body -->
        </div><!-- /.box -->
            
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container -->
</div>
<script type="application/x-javascript" charset="utf-8">
$('#tabla-lugares').DataTable({
  "paging": true,
  "lengthChange": true,
  "searching": true,
  "ordering": true,
  //"info": true,
  "autoWidth": true
});

var table = $('#tabla-lugares').DataTable();
  $('#tabla-lugares tbody').on('click', 'tr', function () {

  var data = table.row( this ).data(); 
  ajax("main","./app/abmLugar.php?id="+data[0]);
  return false;
});

</script>
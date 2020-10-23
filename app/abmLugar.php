<?php 
session_start();
if($_SESSION['logueo']!=true){header("Location:./index.php");}
include("./funciones.php");

$id 		= (isset($_REQUEST['id'])) ? $_REQUEST['id'] : 0;

$link 		= Conexion();
$sql_cat	= "SELECT * FROM categorias;";
$res_cat	= mysqli_query($link,$sql_cat) or die(Error($sql_cat,$link)); 
$sql_loc	= "SELECT * FROM localidades;";
$res_loc	= mysqli_query($link,$sql_loc) or die(Error($sql_loc,$link));

if ($id > 0) {
	$sql  		= "SELECT a.id, a.nombre, a.descripcion, a.precio, a.latitud, a.longitud, a.id_localidad, a.det_camino, a.imagen, a.url_fotos, a.url_videos, a.destacado, b.detalle AS det_localidad FROM lugares AS a, localidades AS b WHERE a.id_localidad=b.id AND a.id = $id LIMIT 1;";
	$res  		= mysqli_query($link,$sql) or die(Error($sql,$link));
	$row 		= mysqli_fetch_assoc ($res);
}

?>
<script type="application/x-javascript" charset="utf-8">
var NewLatitud, NewLongitud;

function valida(){

   		//---- Validar Nombre ----//
		if($("#inputnombre").val()=='Nombre') {  
			cargarModal("tipo","Alerta","Debe ingresar un nombre de lugar","");
       		return false;
   		}
		if($("#inputnombre").val().length < 5) {  
			cargarModal("tipo","Alerta","El nombre debe tener como mínimo 5 caracteres","");
       		return false;
   		} 
   		//---- Validar Localidad ----//
   		if($("#sellocalidad").val()=='null') {  
   			cargarModal("tipo","Alerta","Debe seleccionar una localidad","");
       		return false;  
   		}
   		//---- Validar Precio ----//
   		if($("#inputprecio").val()=='Precio'){
	    	$("#inputprecio").val(null);
    		return false;
    	}
   		//---- Validar Coordenadas ----//
    	if($("#inputlatitud").val()=="null") {  
	       	$("#inputlatitud").val(null);  
       		return false;  
   		}
   		if($("#inputlongitud").val()=="null") {  
	       	$("#inputlongitud").val(null);
       		return false;  
   		}
	return true;
	}

	function MapaBuscador(){
		//var buscador=window.open("./app/buscarMapa.php","Buscador","width=800,height=600");
		xpos=(screen.width/2)-400; 
        ypos=(screen.height/2)-300; 
        window.open('./app/buscarMapa.php','popup','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, width=800, height=600, left='+ xpos+', top='+ ypos);    
	}
</script>
<div class="reservation_top">     	
  <div class="container">    
    <h2 class="head">Información del Lugar</h2>
      <form id="formLugar" action="app/g_lugar.php" method="post" enctype="multipart/form-data">
        <div class="reservation-form">
          <div class="span2_of_1">	
	 		    	<input type="text" id="inputid" name="inputid" class="hidden" value="<?php if  ($id > 0) {echo $id; } else { echo '0';}?>">
							<div>
				  			<span>
				  				<h4>Destacar: 
									<input type="radio" name="radiodestaca" value="S" <?php if  ($id > 0) {
									  if($row['destacado']=='S') { echo "checked"; }
								  	}
								  	?> > SI 
								  	<input type="radio" name="radiodestaca" value="N" <?php if  ($id > 0) {
										if($row['destacado']=='N'){ echo "checked"; }
									}
									?> > NO </h4> 
				  			</span>
							</div>
							<div>
				  			<span><h4>Nombre</h4></span>
				  				<input type="text" id="inputnombre" name="inputnombre" class="textbox" value="Nombre" onfocus="this.select()">
							</div>
							<div class="sel_room">
								<h4>Localidad</h4>
								<select id="sellocalidad" name="sellocalidad" class="frm-field required">
									<option value="null" <?php if($id < 1){ echo "selected"; }?> >Seleccione Localidad</option>
				       		<?php 
				       		while($row_loc = mysqli_fetch_assoc ($res_loc)){
									?>
									<option value="<?php echo $row_loc['id'];?>" 
									<?php if($id > 0){
											if ($row['id_localidad'] == $row_loc['id']){ echo "selected"; }
										}
										?> >
										<?php echo $row_loc['detalle'];	?></option>
									<?php 
									}
									?>
	        			</select>
							</div>
						<div>
				  			<span><h4>Precio</h4></span>
				  				<input type="text" id="inputprecio" name="inputprecio" class="textbox numero-decimal currency" value="Precio" onfocus="this.select()">
						</div>
						<div class="sel_room">
							<h4>Coordenadas GPS</h4>
		  				<div class="col-md-4">
								<input type="text" id="inputlatitud" name="inputlatitud" class="textbox negativo-decimal" value="Latitud" onfocus="this.select()">
							</div>
							<div class="col-md-4">
								<input type="text" id="inputlongitud" name="inputlongitud" class="textbox negativo-decimal" value="Longitud" onfocus="this.select()">
				  		</div>
				  		
				  		<div class="col-md-4">
								<a href="#" onclick="MapaBuscador();" class="btn btn-danger"> BUSCAR UBICACION </a>
				  		</div>
				  		
				  	</div>

				  	<div class="sel_room">
							
							<div class="col-md-12"><span><h4>Categorías</h4></span>
								<?php

								while($row_cat = mysqli_fetch_assoc ($res_cat)){
									if  ($id > 0) {
									$sql_cat_lug	= "SELECT * FROM categorias_lugares WHERE id_lugar=".$id." AND id_categoria=".$row_cat['id']." LIMIT 1;";
									$res_cat_lug	= mysqli_query($link,$sql_cat_lug) or die(Error($sql_cat_lug, $link));
									$row_cat_lug 	= mysqli_fetch_assoc ($res_cat_lug);
									}
									?><input type="checkbox" name="categorias[]" 
										value="<?php echo $row_cat['id'];?>" 
										<?php if  ($id > 0) { 
												if (mysqli_num_rows($res_cat_lug) > 0) {
												if ($row_cat_lug['id_categoria'] == $row_cat['id']) { echo " checked"; }
												}
											}?> >&nbsp;
											<?php echo $row_cat['detalle'];?>&nbsp;&nbsp;<?php
								}
								@mysqli_close ($link); 
								?>
							</div>	
						</div>
						<div class="col-md-12">
				  			<span><h4>Imagen Principal - (380px x 263px)</h4></span>
				  			<input type="file" id="inputimagen" name="inputimagen" class="btn btn-inline btn-danger"><?php if($id > 0) {
								  echo "<br><img class='img-responsive' src='data:image/jpeg;base64,{$row["imagen"]}'>";};?>
				  		</div>
					</div>

					<div class="span2_of_1">
						<div>
				  			<span><h4>Ubicación</h4></span>
				  			<iframe class="map" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?q=<?php echo $row['latitud']; ?>,<?php echo $row['longitud']; ?>&hl=es;z=14&amp;output=embed" width="600" height="450" style="color:#666;font-size:12px;text-align:left" allowfullscreen></iframe>
						</div>
						<div>
				  			<span><h4>Descripción</h4></span>
				  			<textarea id="textdescripcion" name="textdescripcion" value="Ingrese la Descripción del lugar" onfocus="this.select()">Ingrese la descripción del lugar</textarea>
						</div>
						<div>
				  			<span><h4>Cómo llegar</h4></span>
				  				<textarea id="textcamino" name="textcamino" value="Detalle de cómo llegar al lugar" onfocus="this.select()">Detalle de cómo llegar al lugar</textarea>
						</div>		
				 	</div>
				  	<div class="clearfix"></div>
				  	<h2 class="head">Multimedia</h2>
		  			<div class="col-md-6">
		  				<div>
				  			<span><h4>Asociar Album de Imagenes</h4></span>
				  			<input type="text" id="inputalbum" name="inputalbum" class="textbox" value="Url" onfocus="if(this.value=='Url'){this.value = ''};" onblur="if (this.value == '') {this.value = 'Url';}">
						</div>
					</div>
		  			<div class="col-md-6">
		  				<div>
							<span><h4>Asociar Canal de Youtube</h4></span>
							<input type="text" id="inputcanal" name="inputcanal" class="textbox" value="Url" onfocus="if(this.value=='Url'){this.value = ''};" onblur="if (this.value == '') {this.value = 'Url';}">
						</div>
					</div>
		  		</div>	
		  		<div class="clearfix"></div>	
		  		<div class="contact-form">
		   	   	<?php if($id>0){ ?>	<a href="#" id="btnEliminar" title="ELIMINAR" class="btn btn-primary btn1 btn-normal btn-inline " target="_self">Eliminar</a>	
		   	   	<?php
		   	   	}
		   	   	?>
		   	   		<input type="button" id="btnNuevo" value="NUEVO" class="btn btn-primary btn1 btn-normal btn-inline">
		   	   		<input type="submit" onclick="return valida();" value="GUARDAR" class="btn btn-primary btn1 btn-normal btn-inline">
					<!--<input type="submit" value="GUARDAR" class="btn btn-primary btn1 btn-normal btn-inline">
					<a href="#" id="btnGuardar" title="Guardar" class="btn btn-primary btn1 btn-normal btn-inline " target="_self">Guardar</a>	 -->
				
				</div>
			</form>	
		</div>		
    </div>
</div>
<script type="application/x-javascript" charset="utf-8">
$(function(){
/*	var datosMapa = "0"; no funca
	$.post("./app/buscarMapa.php", {datos: datosMapa}, function(data, status){
	    $("#mapa").html(data);
	});*/

	$('.numero-decimal').keyup(function (){
    	this.value = (this.value + '').replace(/[^0-9.]/g, '');
    	return false;
	});
	$('.negativo-decimal').keyup(function (){
    	this.value = (this.value + '').replace(/[^0-9.-]/g, '');
    	return false;
	});
//----------------------------------- INICIO CurrencyFormat ------	
	(function($) {
	    $.fn.currencyFormat = function() {
    	    this.each( function( i ) {
        	    $(this).change( function( e ){
            	    if( isNaN( parseFloat( this.value ) ) ) return;
                	this.value = parseFloat(this.value).toFixed(2);
            	});
        	});
        return this; //for chaining
    	}
	})( jQuery );

	// apply the currencyFormat behaviour to elements with 'currency' as their class
	$(function() {
    	$('.currency').currencyFormat();
	});
//----------------------------------- FIN CurrencyFormat ------	
	$('#btnEliminar').click(function(){
		if(confirm("¿Desea ELIMINAR el Lugar: "+$("#inputnombre").val()+" ?")==true){
			var datosLugar = [];
			datosLugar.push($("#inputid").val());
   			datosLugar.push($("#inputnombre").val());
			
	   		$.post("./app/e_lugar.php",	{datos: datosLugar},
	   		function(data, status){
	    	cargarModal("alert","Listo!", data, "Estado: " + status);
        	listLugarPag();
    	});
    	return false;
		}
	});

	$('#btnNuevo').click(function(){
	   	$("#inputid").val("0");
		//$("#selcategoria").val("null");
	   	$("#inputnombre").val("Nombre");
		$("#sellocalidad").val("null");
		$("#inputprecio").val("Precio");
		$("#inputlatitud").val("Latitud");
		$("#inputlongitud").val("Longitud");
		$("#textdescripcion").val("Ingrese la descripción del lugar");
		$("#textcamino").val("Detalle de cómo llegar al lugar");
		$("#inputalbum").val("Url");
		$("#inputcanal").val("Url");
	    return false;
	});

	$(function() {
		if ($("#inputid").val() > 0){
	   	$(":checkbox").each(function() {
      });
	   	$("#inputnombre").val("<?php echo addslashes($row['nombre']); ?>");
			$("#textdescripcion").val("<?php echo addslashes($row['descripcion']); ?>");
			$("#inputprecio").val("<?php echo $row['precio']; ?>");
			$("#inputlatitud").val("<?php echo $row['latitud']; ?>");
			$("#inputlongitud").val("<?php echo $row['longitud']; ?>");
			$("#sellocalidad").val("<?php echo $row['id_localidad']; ?>");
			$("#textcamino").val("<?php echo addslashes($row['det_camino']); ?>");
			$("#inputalbum").val("<?php echo $row['url_fotos']; ?>");
			$("#inputcanal").val("<?php echo $row['url_videos']; ?>");
		}
	});
});
</script>

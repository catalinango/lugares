<?php 
session_start();
if($_SESSION['logueo']!=true){
	header("Location:./index.php");
}

include("./funciones.php");
$i			 = 0;

$link	  = Conexion();
$sql	  = "SELECT a.id, a.apyn, a.dni, a.email, a.clave, a.id_rol, b.detalle AS rol FROM usuarios AS a INNER JOIN roles AS b ON a.id_rol=b.id";
$res 	  = mysqli_query($link,$sql) or die(Error($sql,$link));
$sql      = "SELECT * FROM roles";
$res_rol  = mysqli_query($link,$sql) or die(Error($sql,$link));
@mysqli_close ($link);
?>
<div class="reservation_top">
    <div class="container">
        <div class="row post1">
            <div class="col-md-7 contact_left">
            	<div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Usuarios Registrados</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                      <table id="tablaUsuarios" class="table table-bordered table-hover">
                        <thead>
                          <tr>
                              <th class="hidden">ID</th>
                        			<th>#</th>
                        			<th>DNI</th>
                        			<th>Nombre y Apellido</th>
                        			<th>e-mail</th>
                        			<th>Clave</th>
                              <th class="hidden">ID Rol</th>
                        			<th>Rol</th>
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
                        			<td><?php echo $row['dni'];?></td>
                        			<td><?php echo ucwords(strtolower($row['apyn']));?></td>
                        			<td><?php echo $row['email'];?></td>
                        			<td><?php echo $row['clave'];?></td>
                              <td class="hidden"><?php echo $row['id_rol'];?></td>
                        			<td><?php echo $row['rol'];?></td>
                     	 		</tr>
                    		<?php
							}
							?>
                      		</tbody>
                    		<tfoot>
                     			<tr>
                              <th class="hidden">ID</th>
                        			<th>#</th>
                        			<th>DNI</th>
                        			<th>Nombre y Apellido</th>
                        			<th>e-mail</th>
                        			<th>Clave</th>
                              <th class="hidden">ID Rol</th>
                        			<th>Rol</th>
                      			</tr>
                    		</tfoot>
                  		</table>
                	</div><!-- /.box-body -->
              	</div><!-- /.box -->
            </div>
            <div class="col-md-5 contact_right">
            	<h3>Nuevo / Editar Usuario</h3>
            	<div class="contact-form">
					<form id="formUsuario" name="formUsuario">
            <input type="text" id="inputid" name="inputid" class="hidden" value="0">
						<input type="text" id="inputdni" name="inputdni" class="textbox solo-numero" value="DNI" maxlength="8" size="8" onfocus="if(this.value=='DNI'){this.value = ''};" onblur="if (this.value == '') {this.value = 'DNI';}">
						<input type="text" id="inputapyn" name="inputapyn"  class="textbox" value="Nombre y Apellido" onfocus="if(this.value=='Nombre y Apellido'){this.value = ''};" onblur="if (this.value == '') {this.value = 'Nombre y Apellido';}">
						<input type="text" class="textbox email" id="inputemail" name="inputemail" value="usuario@mail.com" onfocus="if(this.value=='usuario@mail.com'){this.value = ''};" onblur="if (this.value == '') {this.value = 'usuario@mail.com';}">
						<input type="text" class="textbox" id="inputclave" name="inputclave" value="Contraseña" onfocus="if(this.value=='Contraseña'){this.value = ''};" onblur="if (this.value == '') {this.value = 'Contraseña';}">
						<div class="sel_room">
              <select id="selrol" name="sellocalidad" class="frm-field required">
                  <option value="null"> Seleccione Rol de Usuario</option>
                  <?php 
                  while($row_roles = mysqli_fetch_assoc ($res_rol)){
                  ?><option value="<?php echo $row_roles['id'];?>"><?php echo $row_roles['detalle'];?></option>
                  <?php 
                  }
                  ?>
                </select>
                		</div>
                		</br></br>
                		<div class="personal_bottom">
                  			<a href="#" id="btnEliminar" title="Eliminar" class="btn btn-primary btn1 btn-normal btn-inline " target="_self">Eliminar</a> 
                  			<a href="#" id="btnGuardar" title="Guardar" class="btn btn-primary btn1 btn-normal btn-inline " target="_self"> Guardar </a> 
                        <a href="#" id="btnNuevo" title=" Nuevo " class="btn btn-primary btn1 btn-normal btn-inline pull-rigth" target="_self"> Nuevo </a> 
                		</div>
						<div class="clearfix"></div>
					</form>
				</div>
            </div>
            <div class="clearfix"></div>
		</div>
    </div>
</div>
<script type="application/x-javascript" charset="utf-8">
$(function(){
	$('#tablaUsuarios').find('tr').click( function(){
 		var datosUsuario = [];
  		var i = 0;
  		$(this).children("td").each(function (){
  			datosUsuario.push($(this).html());
    });
      $("#inputid").val(datosUsuario[0]); 
			$("#inputdni").val(datosUsuario[2]);
			$("#inputapyn").val(datosUsuario[3]);
			$("#inputemail").val(datosUsuario[4]);
			$("#inputclave").val(datosUsuario[5]);
			$("#selrol").val(datosUsuario[6]);
      return false;
		});

		$('.solo-numero').keyup(function (){
      this.value = (this.value + '').replace(/[^0-9]/g, '');
      return false;
    });

		$('.email').blur(function(){
      if($(".email").val().indexOf('@', 0) == -1 || $(".email").val().indexOf('.', 0) == -1) {
       	alert('El correo electrónico introducido no es correcto.');
       	setTimeout(function() { $("#inputemail").focus(); }, 50);	
      }
      return false;    
    });
		
    $('#btnGuardar').click( function(){
		//---- Validar DNI -----//
		if($("#inputdni").val()=='DNI') {  
        	alert("Debe ingresar un DNI");
        	return false;  
   		}
   		if($("#inputdni").val().length < 7) {  
        	alert("Debe ingresar un DNI válido");  
        	return false;  
   		} 
   		if($("#inputdni").val().length > 8) {  
        	alert("Debe ingresar un DNI válido");  
        	return false;  
   		} 
   		//---- Validar Nombre ----//
		if($("#inputapyn").val()=='Nombre y Apellido') {  
        	alert("Debe ingresar un Nombre y Apellido");  
        	return false;  
   		}
		if($("#inputapyn").val().length < 5) {  
        	alert("El nombre debe tener como mínimo 5 caracteres");  
        	return false;  
   		} 
   		//---- Validar Email ----//
   		if($("#inputapyn").val()=='usuario@mail.com') {  
        	alert("Debe ingresar un Email");  
        	return false;  
   		}
   		//---- Validar Contraseña ----//
		if($("#inputclave").val()=='Contraseña') {  
        	alert("Debe ingresar una Contraseña");  
        	return false;  
   		}
		if($("#inputclave").val().length < 4) {  
        	alert("La Contraseña debe tener como mínimo 4 caracteres");  
        	return false;  
   		}   
   		//---- Validar Rol ----//
    	if($("#selrol").val()=="null") {  
        	alert("Debe seleccionar un Rol");  
        	return false;  
   		}

		var datosUsuario = [];
		datosUsuario.push($("#inputid").val());
		datosUsuario.push($("#inputdni").val());
      	datosUsuario.push($("#inputapyn").val());
		datosUsuario.push($("#inputemail").val());
		datosUsuario.push($("#inputclave").val());
		datosUsuario.push($("#selrol").val());
		
		$.post("./app/g_usuario.php", {datos: datosUsuario},
			function(data, status){
		    	var datos = data;
         		var estado = status;
          		$("#title-alerta").html("Guardar datos del Usuario");
          		$("#content-alerta").html(data);
          		$("#footer-alerta").html("Estado: "+ status);
          		$("#modal-alerta").modal("show");
  				abmUsuarioPag();
	 	});
      	return false;
	});

	$('#btnEliminar').click( function(){
		var datosUsuario = [];
      	datosUsuario.push($("#inputid").val());
      	datosUsuario.push($("#inputdni").val());
      	datosUsuario.push($("#inputapyn").val());
		
		$.post("./app/e_usuario.php", {datos: datosUsuario},
        	function(data, status){
        		var datos = data;
        		var estado = status;
        		$("#title-alerta").html("Eliminar Usuario");
        		$("#content-alerta").html(data);
        		$("#footer-alerta").html("Estado: "+ status);
        		$("#modal-alerta").modal("show");
        		abmUsuarioPag();
      	});
      	return false; 
    });

    $('#btnNuevo').click(function(){
    	$("#inputid").val("0");
      	$("#inputdni").val("DNI");
      	$("#inputapyn").val("Nombre y Apellido");
      	$("#inputemail").val("usuario@mail.com");
      	$("#inputclave").val("Contraseña");
      	$("#selrol").val("null");
      	return false;
	});
		
});

</script>
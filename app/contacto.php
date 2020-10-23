<?php
session_start();
?>
         <div class="reservation_top">
           <div class="container">
             <div class="row">
            	<div class="col-md-5">
            		<div class="contact_left">
            			<h3>Información de Contacto</h3>
            			
						<iframe class="map" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3271.3965591711885!2d-57.963682984245075!3d-34.92159018189426!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x95a2e632b25004fb%3A0x844f6abf2f359957!2sUCALP+Facultad+Exactas!5e0!3m2!1ses-419!2sar!4v1477923333699" width="600" height="450" style="color:#666;font-size:12px;text-align:left" allowfullscreen></iframe> 
                        <br /><small></small>
                        <address class="address">
                    <p>Calle 47 1051, <br>La Plata, Buenos Aires</p>
                    <dl>
                        <dt></dt>1900 B1900AKS, 
                        <dd>Teléfono:<span> +54 221 254 2478</span></dd>
                        <dd>Fax: <span>+54 221 658 5784</span></dd>
                        <dd>E-mail:&nbsp; <a href="#">info@lugaresbsas.com</a></dd>
                        <dd>Web:&nbsp; <a href="www.catalinaguerrero.com.ar/lugaresbsas/">www.lugaresbsas.com.ar</a></dd>
                    </dl>
                </address>
            		</div>
            	</div>
            	<div class="col-md-7 contact_right">
            		<h3>Ingrese su Consulta/Sugerencia</h3>
            		<div class="contact-form">
							<form method="post" action="./app/enviaEmail.php">
								<input type="text" id="nombrePersona" name="nombrePersona" class="textbox" value="Nombre" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Nombre';}" required>
								<input type="text" id="emailPersona" name="emailPersona" class="textbox email" value="persona@mail.com" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'persona@mail.com';}" required>
								<textarea id="textoEmail" name="textoEmail" value="Ingrese su consulta/sugerencia aquí" onfocus="this.value= '';" onblur="if (this.value == '') {this.value = 'Ingrese su consulta/sugerencia aquí';}" required>Ingrese su consulta/sugerencia aquí</textarea>
								<a href="#" id="btnNuevo" title="Limpiar" class="btn btn-primary btn1 btn-normal btn-inline " target="_self">Eliminar</a>	
								<input type="submit" onclick="return validaContacto();" value="Enviar">
								<div class="clearfix"></div>
							</form>
						</div>
            	</div>
            </div>
           </div>
	     </div>
       </div>
<script type="application/x-javascript" charset="utf-8">
$(function(){
  //---- Validar Email ----//
  $('.email').blur(function(){
      if($(".email").val().indexOf('@', 0) == -1 || $(".email").val().indexOf('.', 0) == -1) {
        cargarModal("tipo","Alerta","El correo electrónico introducido no es correcto","");
        setTimeout(function() { $(".mail").focus(); }, 50); 
      }
      return false;    
  });

  $('#btnNuevo').click(function(){
      $("#nombrePersona").val("Nombre");
      $("#emailPersona").val("persona@mail.com");
      $("#textoEmail").val("Ingrese su consulta/sugerencia aquí");
      return false;
    });
});

function validaContacto(){
   		//---- Validar Nombre ----//
		if($("#nombrePersona").val()=='Nombre') {  
			cargarModal("tipo","Alerta","Debe ingresar un nombre","");
       		return false;
   		}
		if($("#nombrePersona").val().length < 5) {  
			cargarModal("tipo","Alerta","El nombre debe tener como mínimo 5 caracteres","");
       		return false;
   		} 
   		//---- Validar Email ----//
        if($("#inputapyn").val()=='persona@mail.com') {  
            alert("Debe ingresar un Email");  
            return false;  
        }
      //---- Validar Texto ----//
   		if($("#textoEmail").val()=='null') {  
   			cargarModal("tipo","Alerta","El texto debe tener como mínimo 5 caracteres","");
       		return false;  
   		}
	return true;	
}

</script>

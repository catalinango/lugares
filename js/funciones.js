var _fechayhoraactual = new Date();
var _mesactual=_fechayhoraactual.getMonth()+1;
var _anioactual=_fechayhoraactual.getFullYear();

var zonadiv;			
var http = nuevoAjax();
var ejecutarJS = '';
var ultimoAjaxPendiente=0;
var AjaxPendienteAct=false;

var _estado_ok='<center><img src="./img/check_verde.gif" alt="ok" height="16" width="16"></center>';
var _estado_procesando='<center><img src="./img/progreso.gif" alt="espere..." height="16" width="16"></center>';
var _estado_alerta_amarilla='<center><img src="./img/alerta-amarilla.png" alt="espere..." height="16" width="16"></center>';
var _barra_carga='<center>Cargando...<br><img src="./img/barra_carga.gif" alt="espere..." height="19" width="220"></center>';

//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function nuevoAjax(){ 
	var request = false;
	try {
		request = new XMLHttpRequest();
	} catch (trymicrosoft) {
		try {
			request = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (othermicrosoft) {
			try {
				request = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (failed) {
				request = false;
			}
		}
	}
 
	if (!request){
		alert("Error inicializando XMLHttpRequest!");
	}else{
		return request;
	}
};
						
//------------------------------------------------------------
function ajax(zona,url,siguiente){
	if(siguiente!=null){
		ejecutarJS = "<script type='text/javascript'>"+siguiente+"</script>";
	}else{
		ejecutarJS = "";
	}
	zonadiv=zona;
	http.onreadystatechange = rc_http;
	http.open("GET", url, true);				
	http.send(null);
}
			
//------------------------------------------------------------
function rc_http(){				
	if(http.readyState == 0){
		if(document.getElementById(zonadiv)!=null){document.getElementById(zonadiv).innerHTML = "<center>No inicializado</center>";}
	}

	if(http.readyState == 1){
		if(document.getElementById(zonadiv)!=null){
			//document.getElementById(zonadiv).innerHTML = _barra_carga;			 
		}
		document.body.style.cursor = "wait";
	}

	if(http.readyState == 2){
		if(document.getElementById(zonadiv)!=null){
			//document.getElementById(zonadiv).innerHTML = "<center>Cargado</center>";			
		}
		document.body.style.cursor = "wait";
	}				
			
	if(http.readyState == 3){
		if(document.getElementById(zonadiv)!=null){
			//document.getElementById(zonadiv).innerHTML = "<center>Interactivo</center>";			
		}
		document.body.style.cursor = "wait"; 
	}
			
	if(http.readyState == 4){
		if (http.status==200){
			document.body.style.cursor = "default";			
			
			if(document.getElementById(zonadiv)!=null){
				document.getElementById(zonadiv).innerHTML = http.responseText+ejecutarJS;
			}
			
			if (AjaxPendienteAct==true){AjaxPendientes();}
			
			runJS(http.responseText+ejecutarJS);
				
		}else if(http.status==404){
			document.body.style.cursor = "default";
			if(document.getElementById(zonadiv)!=null){
				document.getElementById(zonadiv).innerHTML = "<center>La direccion no existe</center>";
			}
			
			AjaxPendienteAct=false;
				
		}else{
			document.body.style.cursor = "default";
			if(document.getElementById(zonadiv)!=null){
				document.getElementById(zonadiv).innerHTML = "<center>Error:"+http.status+"<br> Reintente</center>";
			}
			
			AjaxPendienteAct=false;		
		};	
	};
};

//-------------------------------------------------------------------------------------------------------------------------------
function runJS(contenido){ 
 
    var search = contenido;
    var script;
 
    while( script = search.match(/(<script[^>]+javascript[^>]+>\s*(<!--)?)/i)){ 
		search = search.substr(search.indexOf(RegExp.$1) + RegExp.$1.length); 
 
		if (!(endscript = search.match(/((-->)?\s*<\/script>)/))) break; 
 
		block = search.substr(0, search.indexOf(RegExp.$1)); 
		search = search.substring(block.length + RegExp.$1.length); 
 
		var oScript = document.createElement('script'); 
		oScript.text = block; 
		document.getElementsByTagName("head").item(0).appendChild(oScript); 
    } 
}
//-------------------------------------------------------------------------------------------------------------------------------
function Left(str, n){
	if (n <= 0)
		return "";
	else if (n > String(str).length)
		return str;
	else
		return String(str).substring(0,n);
	}

//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function Right(str, n){
	if (n <= 0)
		return "";
	else if (n > String(str).length)
		return str;
	else {
		var iLen = String(str).length;
		return String(str).substring(iLen, iLen - n);
	}
}

//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function MeterEnDiv(cual,que){
	if(document.getElementById(cual)!=null & que!=null){
		document.getElementById(cual).innerHTML = que;
	}
};

//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function LimpiarDiv(cual){
	if(document.getElementById(cual)!=null){
		document.getElementById(cual).innerHTML ="";
	}
};

//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function SelectValorPorID(cual){	
	if(document.getElementById(cual)!=null){
		return 	document.getElementById(cual).options[document.getElementById(cual).selectedIndex].value;
	}		
}

//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function EliminarOpcionMarcadaSelect(cual){
	return 	document.getElementById(cual).options[document.getElementById(cual).selectedIndex] = null;
}

//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function SelectTextoPorID(cual){
	if(document.getElementById(cual)!=null){
		return 	document.getElementById(cual).options[document.getElementById(cual).selectedIndex].text;	
	}
}

//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function anioActual(){
	var fecha = new Date();
	var anio = fecha.getFullYear();	
	return anio;
}

//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

function volcarSelects(emisor, receptor,ordenado){
	emisor = document.getElementById(emisor);
	receptor = document.getElementById(receptor);
	posicion = receptor.options.length;
	selecionado = emisor.selectedIndex;
	
	if(selecionado != -1) {
		volcado = emisor.options[selecionado];
		receptor.options[posicion] = new Option(volcado.text, volcado.value);
		emisor.options[selecionado] = null;
		emisor.selectedIndex=selecionado;
		if(selecionado>emisor.length-1){
			emisor.selectedIndex=emisor.length-1;
		}
	}
	if (ordenado==true){OrdenarSelect(receptor);}
}

//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function OrdenarSelect(selElem){
	var tmpAry = new Array();
	for (var i=0;i<selElem.options.length;i++) {
		tmpAry[i] = new Array();
		tmpAry[i][0] = selElem.options[i].text;
		tmpAry[i][1] = selElem.options[i].value;
	}
	
	tmpAry.sort();
	while (selElem.options.length > 0) {
		selElem.options[0] = null;
	}
    
	for (var i=0;i<tmpAry.length;i++) {
		var op = new Option(tmpAry[i][0], tmpAry[i][1]);
		selElem.options[i] = op;
    }
    return;
}

//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function QueSeleccionoEnRadio(quediv,quegruporadio){
	var valor;
	
	var el=document.getElementById(quediv);
	var all=el.getElementsByTagName('input');
		
	var input, i=0;
	while(input=all[i++]) {
		if(input.id==quegruporadio){
			if(input.checked){valor=input.value;}
		}
	}	
	
	return valor;
}

//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function OcultarDiv(cualdiv){
	document.getElementById(cualdiv).style.display = 'none';	
	document.getElementById(cualdiv).style.filter= "alpha(opacity="+0+")";	//para IE					
	document.getElementById(cualdiv).style.opacity= 0;
}

//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function MostrarDiv(cualdiv){
	document.getElementById(cualdiv).style.display = 'block';
	document.getElementById(cualdiv).style.filter= "alpha(opacity="+100+")";	//para IE
	document.getElementById(cualdiv).style.opacity= 1;	
}

//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function ContenidoDelDiv(cual){
	if(document.getElementById(cual)!=null){
		return document.getElementById(cual).innerHTML;
	}
}

//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function imprimeDiv(nombre,encabezado){
	var ficha = document.getElementById(nombre);
	var ventimp = window.open(' ', 'popimpr');
				
	ventimp.document.write("<center><H3>"+encabezado+"</h3><br><br>"+ficha.innerHTML );
	ventimp.document.close();
	ventimp.print( );
	ventimp.close();
}


//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function framePrint(whichFrame){
	parent[whichFrame].focus();
	parent[whichFrame].print();
}

//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function esfecha(fecha){			
	var fechaArr = fecha.split('/');
	var dia = fechaArr[0];
	var mes = fechaArr[1];
	var aho = fechaArr[2];	
	var plantilla = new Date(aho, mes - 1, dia);//mes empieza de cero Enero = 0
	
	if(!plantilla || plantilla.getFullYear() == aho && plantilla.getMonth() == mes -1 && plantilla.getDate() == dia){
		return true;
	}else{
		return false;
	}
}

//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function esEntero(valor){    
    valor = parseInt(valor);
	
    if (isNaN(valor)) {
       return false;
    }else{       
       return true;
    }
}

//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function DiaSemana(tfecha){
	var dia = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
	xfecha = new Date(tfecha);
	nday = xfecha.getUTCDay();
	return dia[nday]; 
}
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function isNumberKey(evt){
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode > 31 && (charCode < 48 || charCode > 57)){
		/*document.getElementById("caja").innerHTML ="SOLO N&Uacute;MEROS"
		document.getElementById("caja").style.height = "100px";
		setTimeout(function(){ Cerrar(); }, 1000);
		*/
		alert("Ingrese sólamente Números");
		return false;
	}else{
		return true;
	}
}
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function isNumberDecimalKey(evt){	
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode > 31 && (charCode < 48 || charCode > 57)){
		if (charCode != 46) {
			/*document.getElementById("caja").innerHTML ="SOLO N&Uacute;MEROS"
			document.getElementById("caja").style.height = "100px";
			setTimeout(function(){ Cerrar(); }, 1000);
			*/
			alert("Ingrese sólamente Números - Use . para Decimales");
			return false;		
		}		
	}else{
		return true;
	}
}
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function mensajeConfirmar(_donde,_texto,_urlsi,_urlno){
	var _mensaje	= confirm(_texto);
	if (_mensaje == true) {
		if(typeof _urlsi == "undefined"){
			return;
		}else{
			ajax(_donde,_urlsi);
		}
		
	} else {
		if(typeof _urlno == "undefined"){
			return;
		}else{
			ajax(_donde,_urlno);
		}
	} 
}
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function mensajeAvisar(donde, texto, url){
	alert(texto);
	if(typeof url != "undefined"){
		ajax(donde,url);
	}
}
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function MostrarFila(Fila) {
var elementos = document.getElementsByName(Fila);
    for (i = 0; i< elementos.length; i++) {
		var visible = 'table-row';
       	elementos[i].style.display = visible;
    }
}
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function OcultarFila(Fila) {
    var elementos = document.getElementsByName(Fila);
    for (k = 0; k< elementos.length; k++) {
               elementos[k].style.display = "none";
    }
}

//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function check(cualCheck) {
    document.getElementById("cualCheck").checked = true;
}
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function uncheck(cualCheck) {
    document.getElementById("cualCheck").checked = false;
}
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function esfecha(fecha){			
	var fechaArr = fecha.split('/');
	var dia = fechaArr[0];
	var mes = fechaArr[1];
	var aho = fechaArr[2];	
	var plantilla = new Date(aho, mes - 1, dia);//mes empieza de cero Enero = 0
	
	if(!plantilla || plantilla.getFullYear() == aho && plantilla.getMonth() == mes -1 && plantilla.getDate() == dia){
		return true;
	}else{
		return false;
	}
}
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

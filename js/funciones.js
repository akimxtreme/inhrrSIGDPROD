// JavaScript Document
/*
	Fecha: 10-09-2012
	Autor: Ing. Domingo Ilarreta
	Correo: akimxtreme.dj@gmail.com
*/ 

// Función: Estilo que se ejecuta al llenar un campo correcto
function correcto(variable){
	variable.style.background="#FFFFFF";
	variable.style.color="#000000";
	}
// Función: Estilo que se ejecuta al llenar un campo incorrecto
function incorrecto(variable){
	//variable.style.background="#FCF";
	variable.style.background="#FF9966";
	variable.style.color="#333333";
	}
// Función: Se ejecuta al llenar un campo correo ó incorrecto 
function obligatorio(name_id) {
	var elemento = document.getElementById(name_id);
	// input type --- RADIO Y CHECKBOX ------------->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
	if(elemento.type=="radio" || elemento.type=="checkbox"){
		
		// campo confidencial ó publico ////////////////////////////////////////////////////////////////////////
		if(elemento.id=="confidencial" || elemento.id=="publico"){
			var confidencial = document.getElementById('confidencial');
			var publico = document.getElementById('publico');
			var div_condicion = document.getElementById('div_condicion');
			var div_unidades_acceso = document.getElementById('div_unidades_acceso');
			var div_acceso_confidencial = document.getElementById('div_acceso_confidencial');
			if(confidencial.checked){
				div_unidades_acceso.style.visibility="visible";div_unidades_acceso.style.position="static";
				div_acceso_confidencial.style.visibility="visible";div_acceso_confidencial.style.position="static";
				}else {div_unidades_acceso.style.visibility="hidden";div_unidades_acceso.style.position="fixed";
					   div_acceso_confidencial.style.visibility="hidden";div_acceso_confidencial.style.position="fixed";
					}
			if((!confidencial.checked) && (!publico.checked)){
				div_condicion.style.boxShadow="0px 0px 4px #FCF";
				incorrecto(div_condicion);
				}else{div_condicion.style.boxShadow="0px 0px 2px #333"; div_condicion.style.background="#09C";}
		}///////////////////////////////////////////////////////////////////////////////////////////////////////
		
		// campo fisico_digital ////////////////////////////////////////////////////////////////////////
		if(elemento.id=="fisico_digital"){
			var fisico_digital = document.getElementById('fisico_digital');
			var div_fisico_digital = document.getElementById('div_fisico_digital');
			
			if(!fisico_digital.checked){
				div_fisico_digital.style.boxShadow="0px 0px 4px #FCF";
				incorrecto(div_fisico_digital);
				}else{div_fisico_digital.style.boxShadow="0px 0px 2px #333"; div_fisico_digital.style.background="#09C";}
		}///////////////////////////////////////////////////////////////////////////////////////////////////////
		

		
		
		
	// <input> type --- TEXT , PASSWORD  <textarea> , <select>  ------------->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
	}else{
			if(elemento.value=="" || elemento.value=="Seleccione..."){
				incorrecto(elemento);
			}else {
					correcto(elemento);				
			 }
	 }
}


// Validaciónes onsubmit de todos los formularios

// solicitud_codigo
function sol_codigo() {
	validado=true;
	// Variables Obligatorias del Form: recepcion de documentos    
	var tipo_doc = document.getElementById('tipo_doc');
		// Variable asociada al tipo_doc
		var pon_unidad_h = document.getElementById('pon_unidad_h');
		
	var sigla_doc = document.getElementById('sigla_doc');
	var usuario_solic = document.getElementById('usuario_solic');
	var titulo_doc = document.getElementById('titulo_doc');
	
	//tipo_doc
	if(tipo_doc.value=="Seleccione..."){
		incorrecto(tipo_doc);
		validado=false;
		}else {correcto(tipo_doc);}
		
	//tipo_doc=="FOR" and pon_unidad_h
	if((tipo_doc.value=="FOR") && (pon_unidad_h.value=="")){
		alert('Compruebe que el <<PON>> asociado al tipo de documento <<FOR>> Exista en el sistema');
		validado=false;
		}
		
	//sigla_doc
	if(sigla_doc.value=="Seleccione..."){
		incorrecto(sigla_doc);
		validado=false;
		}else {correcto(sigla_doc);}
	
	//usuario_solic
	if(usuario_solic.value=="Seleccione..."){
		incorrecto(usuario_solic);
		validado=false;
		}else {correcto(usuario_solic);}
	//titulo_doc
	if(titulo_doc.value==""){
		incorrecto(titulo_doc);
		validado=false;
		}else {correcto(titulo_doc);}
	
	
return validado;
}
// acceso
function acceso() {
	validado=true;
	// Variables Obligatorias del Form: recepcion de documentos    
	var usuario = document.getElementById('usuario');
	var contrasenia = document.getElementById('contrasenia');
	
	//usuario
	if(usuario.value==""){
		incorrecto(usuario);
		validado=false;
		}else {correcto(usuario);}
	
	//contrasenia
	if(contrasenia.value==""){
		incorrecto(contrasenia);
		validado=false;
		}else {correcto(contrasenia);}
		
return validado;
}
// busqueda
function buscar() {
	validado=true;
	// Variables Obligatorias del Form: recepcion de documentos    
	var buscar_por = document.getElementById('buscar_por');
	var ingrese = document.getElementById('ingrese');
	
	//buscar_por
	if(buscar_por.value=="Seleccione..."){
		incorrecto(buscar_por);
		validado=false;
		}else {correcto(buscar_por);}
	
	//ingrese
	if(ingrese.value==""){
		incorrecto(ingrese);
		validado=false;
		}else {correcto(ingrese);}
		
return validado;
}
// recepcion_documentos
function recepcion_documento(){
	var validado=true;
	// Variables Obligatorias del Form: recepcion de documentos    
	var titulo_doc = document.getElementById('titulo_doc');
	var fecha_emision = document.getElementById('fecha_emision');
	var confidencial = document.getElementById('confidencial');
	
	var publico = document.getElementById('publico');
		// Variable asociada a confidencial y público
		var div_condicion = document.getElementById('div_condicion');
	
	var unid_acceso = document.getElementById('unid_acceso');
	
	var fisico_digital = document.getElementById('fisico_digital');
		// Variable asociada a fisico_digital
		var div_fisico_digital = document.getElementById('div_fisico_digital');
	
	var unidades_referencia = document.getElementById('unidades_referencia');
	var unidades_numero = document.getElementById('unidades_numero');
	var unidades_anio = document.getElementById('unidades_anio');
	var fecha_recepcion = document.getElementById('fecha_recepcion');
	// var archivo = document.getElementById('archivo');
		// Variable asociada a archivo
		var div_archivo = document.getElementById('div_archivo');
	//var observaciones = document.getElementById('observaciones');
	var pon_asoc_tipo_procedimiento = document.getElementById('pon_asoc_tipo_procedimiento');
	//titulo_doc
	if(titulo_doc.value==""){
		incorrecto(titulo_doc);
		validado=false;
		}else {correcto(titulo_doc);}
		
		
//fecha_recepcion		
	if(fecha_recepcion.value==""){
		incorrecto(fecha_recepcion);
		validado=false;
		}else {correcto(fecha_recepcion);}
	
	//fecha_emision
	if(fecha_emision.value==""){
		incorrecto(fecha_emision);
		validado=false;
		}else {
			correcto(fecha_emision);}
	
	// confidencial y publico
	if((!confidencial.checked) && (!publico.checked)){
		div_condicion.style.boxShadow="0px 0px 4px #FCF";
		incorrecto(div_condicion);
		validado=false;
		}else {div_condicion.style.boxShadow="0px 0px 2px #333"; div_condicion.style.background="#09C";}
	// fisico_digital
	if(!fisico_digital.checked){
		div_fisico_digital.style.boxShadow="0px 0px 4px #FCF";
		incorrecto(div_fisico_digital);
		validado=false;
		}else {div_fisico_digital.style.boxShadow="0px 0px 2px #333"; div_fisico_digital.style.background="#09C";}
	
	//unid_acceso	
	if((unid_acceso.value=="Seleccione...") && (confidencial.checked)){
		incorrecto(unid_acceso);
		validado=false;
		}else {correcto(unid_acceso);}	
	//unidades_referencia		
	if(unidades_referencia.value=="Seleccione..."){
		incorrecto(unidades_referencia);
		validado=false;
		}else {correcto(unidades_referencia);}
	//unidades_numero		
	if(unidades_numero.value=="" || unidades_numero.value.length<3){
		incorrecto(unidades_numero);
		validado=false;
		}else {correcto(unidades_numero);}	
	//unidades_anio		
	if(unidades_anio.value=="Seleccione..."){
		incorrecto(unidades_anio);
		validado=false;
		}else {correcto(unidades_anio);}	
	
	//unidades_anio		
	switch(pon_asoc_tipo_procedimiento.value){
		case "PON":
			var tipo_procedimiento = document.getElementById('tipo_procedimiento');
				
				if(tipo_procedimiento.value=="Seleccione..."){
					incorrecto(tipo_procedimiento);
					validado=false;
				}else {correcto(tipo_procedimiento);}	
		break;
		
		default:
		
		}
		
	
	
	//archivo
	/*	
	if(archivo){
	//extensiones_permitidas = new Array(".pdf", ".xlx", ".doc", ".docx", ".odt"); 
	extension = (archivo.value.substring(archivo.value.lastIndexOf("."))).toLowerCase(); 
		//if((archivo.value!="") || (extension==".pdf") || (extension==".xlx") || (extension==".doc") || (extension==".docx") || (extension==".odt"))	{
		if(extension==".pdf"){
			div_archivo.style.boxShadow="0px 0px 2px #333"; div_archivo.style.background="#09C";
		}else{	if(extension==".xls"){
					div_archivo.style.boxShadow="0px 0px 2px #333"; div_archivo.style.background="#09C";
				}else{	if(extension==".doc"){
							div_archivo.style.boxShadow="0px 0px 2px #333"; div_archivo.style.background="#09C";
						}else{if(extension==".docx"){
								div_archivo.style.boxShadow="0px 0px 2px #333"; div_archivo.style.background="#09C";
							  }else {	if(extension==".odt"){
											div_archivo.style.boxShadow="0px 0px 2px #333"; div_archivo.style.background="#09C";
							 			 }	else {div_archivo.style.boxShadow="0px 0px 4px #FCF"; incorrecto(div_archivo);validado = false;}	
								  }
							
						}
						
					
				
				}
			
			
		}
		
	
	}
	*/
	//observaciones		
	/*if(observaciones.value==""){
		incorrecto(observaciones);
		validado=false;
		}else {correcto(observaciones);}*/
	
			
	
	
return validado;
}
function evaluacion(){
	var validado = true;
	
	// Variables Obligatorias del Form: recepcion de documentos    
	var num_registro_unidad = document.getElementById('num_registro_unidad');
	//var num_registro_numero = document.getElementById('num_registro_numero');
	var num_registro_anio = document.getElementById('num_registro_anio');
	var archivo = document.getElementById('archivo');
	for(i=1; i<=8; i++){
		var idr_si = "cumplimiento_si" + i;
		var idr_no = "cumplimiento_no" + i;
		
		var idtd_si = "criterio_si" + i;
		var idtd_no = "criterio_no" + i;
		
		// validando todos los <input type="radio"> con id = criterio_si(n) y criterio_no(n)
	if((!document.getElementById(idr_si).checked) && (!document.getElementById(idr_no).checked)){
			document.getElementById(idtd_si).style.background="#FF9966";
			document.getElementById(idtd_no).style.background="#FF9966";
			validado = false;
			
			}
				
	}
	
		
	//num_registro_unidad		
	if(num_registro_unidad.value=="Seleccione..."){
		incorrecto(num_registro_unidad);
		validado=false;
		}else {correcto(num_registro_unidad);}
	//num_registro_numero	
	/*	
	if(num_registro_numero.value=="" || num_registro_numero.value.length<3){
		incorrecto(num_registro_numero);
		validado=false;
		}else {correcto(num_registro_numero);}	
	*/
	//num_registro_anio		
	if(num_registro_anio.value=="Seleccione..."){
		incorrecto(num_registro_anio);
		validado=false;
		}else {correcto(num_registro_anio);}
	//archivo		
	if(archivo){
		var extensiones_permitidas = new Array(".pdf", ".xls", ".xlsx", ".doc", ".docx", ".odt", ".ods");
		
			if (archivo.value=="") {
				//Si no tengo archivo, es que no se ha seleccionado un archivo en el formulario
				incorrecto(archivo);
				alert('Introduzca un Archivo');
				validado=false;
				//mierror = "No has seleccionado ningún archivo";
			}else{
				//recupero la extensión de este nombre de archivo
				var extension = (archivo.value.substring(archivo.value.lastIndexOf("."))).toLowerCase();
				//compruebo si la extensión está entre las permitidas
				switch (extension){
					case extensiones_permitidas[0]:
						correcto(archivo);
					break;
					case extensiones_permitidas[1]:
						correcto(archivo);
					break;
					case extensiones_permitidas[2]:
						correcto(archivo);
					break;
					case extensiones_permitidas[3]:
						correcto(archivo);
					break;
					case extensiones_permitidas[4]:
						correcto(archivo);
					break;
					case extensiones_permitidas[5]:
						correcto(archivo);
					break;
					case extensiones_permitidas[6]:
						correcto(archivo);
					break;
					default:
					incorrecto(archivo);
					validado = false;
					}
				
      		}
	}
	/*
	// confidencial y publico
	if((!confidencial.checked) && (!publico.checked)){
		div_condicion.style.boxShadow="0px 0px 4px #FCF";
		incorrecto(div_condicion);
		validado=false;
		}else {div_condicion.style.boxShadow="0px 0px 2px #333"; div_condicion.style.background="#09C";}*/
	
	return validado;	
	}


//Funcion Javascript para Validar solo Números en un campo Input...
 function solonumeros(evt)
      {
		var keyPressed = (evt.which) ? evt.which : event.keyCode
        return !(keyPressed > 31 && (keyPressed < 48 || keyPressed > 57));
      }
// Funcion Javascript para Validar solo Letras en un Campo Input
function soloLetras(e){
       key = e.keyCode || e.which;
       tecla = String.fromCharCode(key).toLowerCase();
       letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
       especiales = [8,37,39,46];

       tecla_especial = false
       for(var i in especiales){
            if(key == especiales[i]){
                tecla_especial = true;
                break;
            }
        }

        if(letras.indexOf(tecla)==-1 && !tecla_especial){
            return false;
        }
    }
// Funcion Javascript para Correos Electrónicos
function correoElectronico(name_id){
	var elemento = document.getElementById(name_id);
	if (elemento.value!=""){
		var dato = elemento.value;
		var expresion = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/;  
				if (!expresion.test(dato)){
					if(elemento.name==name_id){
						incorrecto(elemento);
					}
			}else{
				correcto(elemento);
				}
	
	}else{
		incorrecto(elemento);
		
		}
	}

function pon_asociado(){
	var tipo_doc = document.getElementById('tipo_doc');
	var pon_asociado = document.getElementById('pon_asociado');
	
	if(tipo_doc.value=="FOR"){
		pon_asociado.style.visibility="visible";
		pon_asociado.style.position="static";
		}else{
			pon_asociado.style.visibility="hidden";
			pon_asociado.style.position="absolute";	
			}
	
	}
function unidades_referencia(variable){
	var boton_multiple = document.getElementById('boton_multiple').value = variable;
	}
function criterio(id_tdSi, id_tdNo,radioSi,radioNo){
	/*alert(id_td + "---" + id_radio);*/
	var radio_si = document.getElementById(radioSi);
	var radio_no = document.getElementById(radioNo);
	var td_si = document.getElementById(id_tdSi).style;
	var td_no = document.getElementById(id_tdNo).style;
	if(radio_si.checked){
		td_si.background="#66CC33";
		td_no.background="#CCCCCC";				
	}
	if(radio_no.checked){
		td_no.background="red";
		td_si.background="#CCCCCC";				
	}
	
	// campo cumplimiento_si(n) y cumplimiento_no(n) ////////////////////////////////////////////////////////////////////////
		
	}

// distribucion
function f_distribucion() {
	var	validado = true;
// Función que valida campos básicos
	function f_validacion (elemento){
		var camp = document.getElementById(elemento);
		
			if((camp.value=="") || (camp.value=="Seleccione...")){
				incorrecto(camp);
				validado = false;
				
			}else{
				correcto(camp);
				}
	}// fin de la funcion (f_validacion)
// Funcion que valida todos los campos generados en el caso de que la condión se publica ó privada
	function generados(contador){
		
		switch(contador){
			
			// Valida false cuando el contador es = 0
			case 0:
			validado = false;
			break;
			
			default:
			//alert(contador);
				for(k=0;k<=contador;k++){
					var campo = document.getElementById('copia['+ k +']');
					if(campo.value=="" || campo.value=="VACIO"){
						k=contador;
						campo.value='VACIO';
						validado=false;
						}
				}// fin de for
				
		}// fin del switch
		
	}// fin de la funcion (generados)
		
	
	var condicion = document.getElementById('condicion').value;
	
	// Evalua la variable condición 
	switch(condicion){
		case 'publico':
			// Acciones en Caso de ser un Documento publico
			
			// llama a la funcion "f_validacion" para casos basicos
			// Validando el campo (id = emision)
			f_validacion("emision");
			// Validando el campo num_registro_unidad
			f_validacion('num_registro_unidad');
			// Validando el campo num_registro_anio
			f_validacion('num_registro_anio');
			
			// Validando el campo (id = unid_acceso)
			
			f_validacion("unid_acceso");
			// declaración la variable "div" que llama al (div id=field), que contiene los campos de unidades generados.
			var div = document.getElementById('field');
			// declaración la variable "elemArray" que funcionará como contador para ayudar a validad los (n=cantidad) de campos generados.
			var elemArray = div.getElementsByTagName('br').length;
			// Validando todos los campos copia()
			generados(elemArray);
			
		break;
		
		case 'privado':
		// Validando el campo emision
		f_validacion("emision");
		// Validando el campo num_registro_unidad
		f_validacion('num_registro_unidad');
		// Validando el campo num_registro_anio
		f_validacion('num_registro_anio');
		
		var elemArray = document.getElementById('cont_copia').value;
		
		// Validando todos los campos copia()
		generados(elemArray);
		
		break;
	}// fin del switch(condicion)
	
return validado;

}

// crear dinamicamente tags
icremento =0;
function crear(obj) {

  var valor = document.getElementById('unid_acceso').value;
  var seleccion = document.getElementById('unid_acceso').selectedIndex;
  var texto = document.getElementById('unid_acceso').childNodes[seleccion+1].innerHTML;
 
 // var texto = document.getElementById('unid_acceso').innerHTML;
  field = document.getElementById('field'); 
  hijo = field.getElementsByTagName('input');
  

    if(hijo.value=="Seleccione..."){}
	
	  contenedor = document.createElement('div'); 
	  contenedor.id = 'div'+icremento; 
	  contenedor.style.cssFloat = "left";
	  contenedor.style.width = "50%";
	  field.appendChild(contenedor); 
	  // Creando Titulo que muestra el Nombre de la unidad
	  boton = document.createElement('label'); 
	  boton.className = 'formulario';
	  boton.innerHTML = texto; 
	  contenedor.appendChild(boton); 
	  // creando campo hidden para almacenar las siglas de la unidad	
	  boton = document.createElement('input'); 
	  boton.type = 'hidden'; 
	  boton.name = 'unidad[' + icremento + ']'; 
	  boton.id = 'unidad[' + icremento + ']'; 
	  boton.className = 'formulario';
	  boton.readOnly = 'readonly';
	  boton.value = valor; 
	  contenedor.appendChild(boton); 
	  
	  boton = document.createElement('input'); 
	  boton.type = 'text'; 
	  boton.name = 'copia[' + icremento + ']'; 
	  boton.id = 'copia[' + icremento + ']'; 
	  boton.className = 'formulario';
	  boton.setAttribute('onkeypress', 'return solonumeros(event)');
	  boton.maxLength = '2';
	  contenedor.appendChild(boton); 
	   
	  boton = document.createElement('input'); 
	  boton.type = 'button'; 
	  boton.title = 'Borrar Unidad'; 
	  boton.value = 'Borrar'; 
	  boton.style.cssFloat = "left";
	  boton.className = 'formulario_boton';
	 // boton.style.margin = '0px 10% 0px -20px';
	  //boton.style.background = 'red';
	  boton.name = 'div'+icremento; 
	  boton.onclick = function () {borrar(this.name)} 
	  contenedor.appendChild(boton); 
	  // Crear un <br> que funcionará de contador
	  boton = document.createElement('br'); 
	  contenedor.appendChild(boton); 
	  icremento++;
  
}
function borrar(obj) {
  field = document.getElementById('field'); 
  field.removeChild(document.getElementById(obj)); 
}


// distribucion
function f_devolucion() {
	var	validado = true;
	
// Función que valida campos básicos
	function f_validacion (elemento){
		var camp = document.getElementById(elemento);
			if((camp.value=="") || (camp.value=="Seleccione...") || (camp.value==0)){
				incorrecto(camp);
				validado = false;
			}else{
				correcto(camp);
				}
	}// fin de la funcion (f_validacion)
	
	// Funcion para validar campos de numericos de solo 3 (tres) caracteres
	function f_tres_caract (elemento){
		var camp = document.getElementById(elemento);
		
			if((camp.value=="") || (camp.value=="Seleccione...") || (camp.value.length<3)){
				incorrecto(camp);
				validado = false;
			}else{
				correcto(camp);
				}
	}// fin de la funcion (f_tres_caract)
	
	f_validacion('fecha_recep');
	f_validacion('num_registro_unidad');
	f_validacion('num_registro_anio');
	//f_tres_caract ('num_registro_numero')
	f_validacion('nro_copias');
	
	//
	//
	//num_registro_numero
	//
	//
return validado;	
}

function f_implementacion(){
	var validado = true;
	// Función que valida campos básicos
	function f_validacion (elemento){
		var camp = document.getElementById(elemento);
			if((camp.value=="") || (camp.value=="Seleccione...") || (camp.value==0)){
				incorrecto(camp);
				validado = false;
			}else{
				correcto(camp);
				}
	}// fin de la funcion (f_validacion)
	
	f_validacion('emision');
	f_validacion('num_registro_unidad');
	f_validacion('num_registro_anio');
	//alert("Formulario de Implementación");
	return validado;
	}

function f_sol_modificacion(){
	var validado = true;
	
	// Función que valida campos básicos
	function f_validacion (elemento){
		var camp = document.getElementById(elemento);
			if((camp.value=="") || (camp.value=="Seleccione...") || (camp.value==0)){
				incorrecto(camp);
				validado = false;
			}else{
				correcto(camp);
				}
	}// fin de la funcion (f_validacion)
	
	f_validacion('num_registro_unidad');
	f_validacion('num_registro_anio');
	f_validacion('descripcion');

	//alert("Solicitud de Modificación");
	return validado;
	}

// agregar_revision
function agregar_rev(){
	var validado=true;
	// Variables Obligatorias del Form: recepcion de documentos    
	var titulo_doc = document.getElementById('titulo_doc');
	var fecha_emision = document.getElementById('fecha_emision');
	var confidencial = document.getElementById('confidencial');
	
	var fisico_digital = document.getElementById('fisico_digital');
		// Variable asociada a fisico_digital
		var div_fisico_digital = document.getElementById('div_fisico_digital');
	
	var unidades_referencia = document.getElementById('unidades_referencia');
	var unidades_numero = document.getElementById('unidades_numero');
	var unidades_anio = document.getElementById('unidades_anio');
	
	var fecha_recepcion = document.getElementById('fecha_recepcion');
	var usuario_solic = document.getElementById('usuario_solic');
	
	//titulo_doc
	if(titulo_doc.value==""){
		incorrecto(titulo_doc);
		validado=false;
		}else {correcto(titulo_doc);}
		
		
//fecha_recepcion		
	if(fecha_recepcion.value==""){
		incorrecto(fecha_recepcion);
		validado=false;
		}else {correcto(fecha_recepcion);}
	
	//fecha_emision
	if(fecha_emision.value==""){
		incorrecto(fecha_emision);
		validado=false;
		}else {
			correcto(fecha_emision);}
	
	
	// fisico_digital
	if(!fisico_digital.checked){
		div_fisico_digital.style.boxShadow="0px 0px 4px #FCF";
		incorrecto(div_fisico_digital);
		validado=false;
		}else {div_fisico_digital.style.boxShadow="0px 0px 2px #333"; div_fisico_digital.style.background="#09C";}
	
	//unidades_referencia		
	if(unidades_referencia.value=="Seleccione..."){
		incorrecto(unidades_referencia);
		validado=false;
		}else {correcto(unidades_referencia);}
	//unidades_numero		
	if(unidades_numero.value=="" || unidades_numero.value.length<3){
		incorrecto(unidades_numero);
		validado=false;
		}else {correcto(unidades_numero);}	
	//unidades_anio		
	if(unidades_anio.value=="Seleccione..."){
		incorrecto(unidades_anio);
		validado=false;
		}else {correcto(unidades_anio);}	
	//usuario_solic		
	if(usuario_solic.value=="Seleccione..."){
		incorrecto(usuario_solic);
		validado=false;
		}else {correcto(usuario_solic);}	
	
		
	
return validado;
}

// funcion hipervinculo para la Lista Maestra

function consulta(valor,valor2){
	href = 'consulta.php?consulta='+ valor+'&titulo='+valor2;
	location.href= href;
	}
	
//funcion de validación para el Formulario de Consulta de Documentos Controlados

// distribucion
function consulta_form() {
	var	validado = true;
	
// Función que valida campos básicos
	function f_validacion (elemento){
		var camp = document.getElementById(elemento);
			if((camp.value=="") || (camp.value=="Seleccione...") || (camp.value==0)){
				incorrecto(camp);
				validado = false;
			}else{
				correcto(camp);
				}
	}// fin de la funcion (f_validacion)
	
	//f_validacion('');
	
return validado;	
}

/* ************************************************************************************** */
/*
Script para validad el Formulario de Modificación de Contraseña
que tiene por nombre "Modificar Contraseña de Usuario"
*/

function modificar_cuenta(){
	
	var validado = true;
	
	// Función que valida campos básicos
	function f_validacion (elemento){
		var camp = document.getElementById(elemento);
			if((camp.value=="") || (camp.value=="Seleccione...") || (camp.value==0)){
				incorrecto(camp);
				validado = false;
			}else{
				if(document.getElementById('nueva') || document.getElementById('nueva_repite')){
					var nueva = document.getElementById('nueva');
					var nueva_repite = document.getElementById('nueva_repite');
						if(nueva.value==nueva_repite.value){
							correcto(nueva);
							correcto(nueva_repite);
							
							}else{
								incorrecto(nueva);
								incorrecto(nueva_repite);
								validado = false;
								alert("El Campo 'Nueva Contraseña' y 'Repite Nueva Contraseña' deben ser iguales");
								stop;
								}
						
					}else{
						correcto(camp);
					}
				}
	}// fin de la funcion (f_validacion)
	
	f_validacion('actual');
	f_validacion('nueva');
	f_validacion('nueva_repite');
	
	
	return validado;
	}
/* ************************************************************************************** */


/*Menu Secciones*/

		function change_section(elemento){
			
			var ul = document.getElementById('pestanias').getElementsByTagName('ul')[0]; 
			var li = ul.getElementsByTagName('li');
			var span = document.getElementById('pestanias').getElementsByTagName('span');
			var cantidad = span.length;
			
			for(i=0;i<=cantidad;i++){
				if(i==elemento){
					span[elemento].style.visibility = "visible";
					span[elemento].style.position = "static";
					li[elemento].style.background = "#0099FF";
					li[elemento].style.color = "#FFFFFF";
					}else{
						span[i].style.visibility = "hidden";
						span[i].style.position = "absolute";
						li[i].style.background = "";
						li[i].style.color = "";
						}
				}
			
			}
/* ************************************************************************************** */	
	//agregar_usuario
// Función para Validar el Formulario "Agregar Usuario"
function agregarUsuario(){
	var validado = true;
	
	// Función que valida campos básicos
	function f_validacion (elemento){
		var camp = document.getElementById(elemento);
			if((camp.value=="") || (camp.value=="Seleccione...")){
				incorrecto(camp);
				validado = false;
			}else{
				correcto(camp);
							
			}
	}// fin de la funcion (f_validacion)
	// Función que valida campos básicos
	function f_validacion_length (elemento){
		var camp = document.getElementById(elemento);
			if((camp.value=="") || (camp.value=="Seleccione...") || (camp.value.length<4)){
				incorrecto(camp);
				validado = false;
			}else{
				correcto(camp);
							
			}
	}// fin de la funcion (f_validacion_length)
	// Funcion Javascript para Correos Electrónicos
function f_validacionCorreoE(name_id){
	var elemento = document.getElementById(name_id);
	if (elemento.value!=""){
		var dato = elemento.value;
		var expresion = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/;  
				if (!expresion.test(dato)){
					if(elemento.name==name_id){
						incorrecto(elemento);
						validado = false;
					}
			}else{
				correcto(elemento);
				}
	
	}else{
		incorrecto(elemento);
		validado = false;
		}
	}// fin de la funcion (f_validacion)
	f_validacion_length ('usuario');
	f_validacion ('cedula');
	f_validacion ('nombre');
	f_validacion ('apellido');
	f_validacion ('unidad');
	f_validacion ('privilegio');
	f_validacionCorreoE ('correo');
	
	return validado;
	
	}
/* ************************************************************************************** */

/* ************************************************************************************** */	
	//consultaUsuario
// Función para Validar el Formulario "Buscar Usuario - (Modificación)"
function consultaUsuario(){
	var validado = true;
	
	// Función que valida campos básicos
	function f_validacion (elemento){
		var camp = document.getElementById(elemento);
			if((camp.value=="") || (camp.value=="Seleccione...")){
				incorrecto(camp);
				validado = false;
			}else{
				correcto(camp);
							
			}
	}// fin de la funcion (f_validacion)
	
	f_validacion ('buscar_usuario');
	f_validacion ('campo');
		
	return validado;
	
	}
	
/* ************************************************************************************** */

/* ************************************************************************************** */	
	//consultaUsuario
// Función para Validar el Formulario "Buscar Usuario - (Modificación)"
function modificarUsuario(){
	var validado = true;
	
	// Función que valida campos básicos
	function f_validacion (elemento){
		var camp = document.getElementById(elemento);
			if((camp.value=="") || (camp.value=="Seleccione...")){
				incorrecto(camp);
				validado = false;
			}else{
				correcto(camp);
							
			}
	}// fin de la funcion (f_validacion)
	
	f_validacion ('usuario');
	f_validacion ('cedula');
	f_validacion ('nombre');
	f_validacion ('unidad');
	f_validacion ('privilegio');
	
	return validado;
	
	}
	
/* ************************************************************************************** */

/* ************************************************************************************** */	
	//agregar_unidad
// Función para Validar el Formulario "Agregar Unidad"
function agregarUnidad(){
	var validado = true;
	
	// Función que valida campos básicos
	function f_validacion (elemento){
		var camp = document.getElementById(elemento);
			if((camp.value=="") || (camp.value=="Seleccione...")){
				incorrecto(camp);
				validado = false;
			}else{
				correcto(camp);
							
			}
	}// fin de la funcion (f_validacion)
	
	f_validacion ('unidad');
	f_validacion ('sigla_unid');
	f_validacion ('sigla_doc');
		
	return validado;
	
	}
/* ************************************************************************************** */


/* ************************************************************************************** */	
	//consultaUnidad
// Función para Validar el Formulario "Buscar Unidad - (Modificación)"
function consultaUnidad(){
	var validado = true;
	
	// Función que valida campos básicos
	function f_validacion (elemento){
		var camp = document.getElementById(elemento);
			if((camp.value=="") || (camp.value=="Seleccione...")){
				incorrecto(camp);
				validado = false;
			}else{
				correcto(camp);
							
			}
	}// fin de la funcion (f_validacion)
	
	f_validacion ('buscar_unidad');
	f_validacion ('campo');
		
	return validado;
	
	}
	
/* ************************************************************************************** */
/* ************************************************************************************** */	
	//modificarUnidad
// Función para Validar el Formulario "Buscar Unidad - (Modificación)"
function modificarUnidad(){
	var validado = true;
	// Función que valida campos básicos
	function f_validacion (elemento){
		var camp = document.getElementById(elemento);
			if((camp.value=="") || (camp.value=="Seleccione...")){
				incorrecto(camp);
				validado = false;
			}else{
				correcto(camp);
							
			}
	}// fin de la funcion (f_validacion)
	
	f_validacion ('unidad');
	f_validacion ('sigla_unid');
	f_validacion ('sigla_doc');
	return validado;
	}
/* ************************************************************************************** */


/* ************************************************************************************** */	
	//agregarTipoDoc
// Función para Validar el Formulario "Agregar Tipo de Documento"
function agregarTipoDoc(){
	var validado = true;
	// Función que valida campos básicos
	function f_validacion (elemento){
		var camp = document.getElementById(elemento);
			if((camp.value=="") || (camp.value=="Seleccione...")){
				incorrecto(camp);
				validado = false;
			}else{
				correcto(camp);
							
			}
	}// fin de la funcion (f_validacion)
	
	// Función que valida campos básicos
	function f_validacion_length (elemento){
		var camp = document.getElementById(elemento);
			if((camp.value=="") || (camp.value=="Seleccione...") || (camp.value.length!=3)){
				incorrecto(camp);
				validado = false;
			}else{
				correcto(camp);
							
			}
	}// fin de la funcion (f_validacion_length)
	
	f_validacion ('nombre');
	f_validacion_length ('sigla_doc');
	return validado;
	
	}
/* ************************************************************************************** */


/* ************************************************************************************** */	
	//consultaTipoDoc
// Función para Validar el Formulario "Buscar Unidad - (Modificación)"
function consultaTipoDoc(){
	var validado = true;
	
	// Función que valida campos básicos
	function f_validacion (elemento){
		var camp = document.getElementById(elemento);
			if((camp.value=="") || (camp.value=="Seleccione...")){
				incorrecto(camp);
				validado = false;
			}else{
				correcto(camp);
							
			}
	}// fin de la funcion (f_validacion)
	
	f_validacion ('buscar_tipodoc');
	f_validacion ('campo');
		
	return validado;
	
	}
	
/* ************************************************************************************** */

/* ************************************************************************************** */	
	//modificarTipoDoc
// Función para Validar el Formulario "Buscar Unidad - (Modificación)"
function modificarTipoDoc(){
	var validado = true;
	// Función que valida campos básicos
	function f_validacion (elemento){
		var camp = document.getElementById(elemento);
			if((camp.value=="") || (camp.value=="Seleccione...")){
				incorrecto(camp);
				validado = false;
			}else{
				correcto(camp);
							
			}
	}// fin de la funcion (f_validacion)
	
	// Función que valida campos básicos
	function f_validacion_length (elemento){
		var camp = document.getElementById(elemento);
			if((camp.value=="") || (camp.value=="Seleccione...") || (camp.value.length!=3)){
				incorrecto(camp);
				validado = false;
			}else{
				correcto(camp);
							
			}
	}// fin de la funcion (f_validacion_length)
	f_validacion ('nombre');
	f_validacion_length ('sigla_doc');
	return validado;
	}
/* ************************************************************************************** */

/* ************************************************************************************** */	
	//consultaCriterio
// Función para Validar el Formulario "Buscar Unidad - (Modificación)"
function consultaCriterio(){
	var validado = true;
	
	// Función que valida campos básicos
	function f_validacion (elemento){
		var camp = document.getElementById(elemento);
			if((camp.value=="") || (camp.value=="Seleccione...")){
				incorrecto(camp);
				validado = false;
			}else{
				correcto(camp);
							
			}
	}// fin de la funcion (f_validacion)
	
	f_validacion ('buscar_crit_evaluacion');
	f_validacion ('campo');
		
	return validado;
	
	}
	
/* ************************************************************************************** */


/* ************************************************************************************** */	
	//modificarCriterio
// Función para Validar el Formulario "Buscar Unidad - (Modificación)"
function modificarCriterio(){
	var validado = true;
	// Función que valida campos básicos
	function f_validacion (elemento){
		var camp = document.getElementById(elemento);
			if((camp.value=="") || (camp.value=="Seleccione...")){
				incorrecto(camp);
				validado = false;
			}else{
				correcto(camp);
							
			}
	}// fin de la funcion (f_validacion)
	
	f_validacion ('titulo');
	f_validacion ('detalles');
	return validado;
	}
/* ************************************************************************************** */

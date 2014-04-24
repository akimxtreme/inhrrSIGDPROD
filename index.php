<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/plantilla.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="icon" href="imagenes/planta_vacunas.png"/>
<!-- InstanceBeginEditable name="doctitle" -->
<title>Bienvenido al Sistema de Gestión de Documentos - Planta Productora de Vacunas</title>
<!-- InstanceEndEditable -->
<link href="css/global.css" rel="stylesheet" type="text/css" />
<script src="js/funciones.js" type="text/javascript"></script>
<?php include ('funciones.php'); ?>
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
</head>
<body>
<div class="contenedor">
<div class="banner"><img class="banner" src="imagenes/banner_sigdpro.png" title="Sistema de Gestión Documental de la Planta Productora de Vacunas" alt="Sistema de Gestión Documental de la Planta Productora de Vacunas" /></div>
<div class="contenido"><!-- InstanceBeginEditable name="EditRegion3" -->

<script type="text/javascript">
// Validar PON
		function validar_pon2(str){
				var xmlhttp; 
				if (str=="")
				  {
				  document.getElementById("validar_pon2").innerHTML="";
				  return;
				  }
				if (window.XMLHttpRequest)
				  {// code for IE7+, Firefox, Chrome, Opera, Safari
				  xmlhttp=new XMLHttpRequest();
				  }
				else
				  {// code for IE6, IE5
				  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				  }
				xmlhttp.onreadystatechange=function()
				  {
				  if (xmlhttp.readyState==4 && xmlhttp.status==200)
					 {
					 document.getElementById("validar_pon2").innerHTML=xmlhttp.responseText;
					 }
				  }
			  	xmlhttp.open("GET","validar_pon2.php?u="+str,true);
				xmlhttp.send();
			}
</script>

<?php
include ('conexion.php');
$sql="SELECT * FROM cat_tipodoc WHERE sigla_doc='PON'";
				$seleccion=mysql_query($sql,$conexion);
				while ($row = mysql_fetch_array($seleccion)){
						$campo_1=$row["nombre"];
						$campo_2=$row["sigla_doc"];
				}
						



echo '<div class="ordenar">';

// <><><><><><><><><><><><> Formulario de Solicitud de Códigos <><><><><><><><><><><><><><><><>
formulario_inicio ("Solicitud de Código","formulario","solicitud_codigo","bd_acciones.php","POST","sol_codigo(this);","","","","");
select ("Tipo de Documento","formulario","tipo_doc","pon_asociado(this);","","cat_tipodoc","formulario","","Seleccione el Tipo de Documento que desea Elaborar<br>Ej: DOC - Documentos Generales");
select ("Unidad","formulario","sigla_doc","sigla_doc","","unidades","formulario","","Seleccione la Unidad que Solicita el Código<br>Ej: PE - Presidencia");

div_multiple_inicio("PON asociado al FOR","formulario","formulario_multiple","","pon_asociado","","Seleccione y Compruebe el Procedimiento de Operación Normalizado (PON) que estará asociado a un Formulario (FOR)");	
		text ("","formulario_multiple","pon_tipo_documento","pon_asociado",$campo_2,"1","","readonly","","","","");
		select ("","formulario_multiple","pon_unidad","","","unidades","","","");
		text ("","formulario_multiple","pon_numero","","000","3","","","2","","","");
		img("validar_pon2((document.getElementById('pon_tipo_documento').value) + '_' + (document.getElementById('pon_unidad').value) + '_' + (document.getElementById('pon_numero').value) );","formulario_multiple","boton_multiple","Comprobar","Comprobar");
		
		echo '<div id="validar_pon2">';
		hidden('pon_unidad_h',"");
       	echo '</div>';
div_multiple_cierre();


text ("Revisión","formulario","rev","rev","0","1","","readonly","","","","Muestra la Revisión Inicial que tendrá el Documento<br>Ej: Rev 0");
select ("Solicitado por","formulario","usuario_solic","usuario_solic","","personal","formulario","","Seleccione el Personal que Solicita el Código<br> Ej: Rafael R.");
textarea ("Título del documento","formulario_textarea","titulo_doc","titulo_doc","","","","","formulario_textarea","","obligatorio","Ingrese el Título que tendrá el Documento.<br> Debe ser mayor (&raquo;) a 20 caracteres y menor (&laquo;) a 200");
boton ("Generar Código","formulario","generar_codigo","generar_codigo","","formulario_boton");
formulario_cierre ();
// <><><><><><><><><><><><><><><><>><><><><><><><><><><><><><><><>><><><><><><><><><><><><><><>


// <><><><><><><><><><><><> Formulario de Acceso al Módulo de Administración <><><><><><><><><>
formulario_inicio ("Acceso al Sistema","formulario","acceso_sistema","bd_acciones.php","POST","acceso(this);","","","Espacio del Administrador","");
text ("Usuario","formulario","usuario","usuario","","25","","","","","","Indique el Nombre de Usuario para el Ingreso al Sistema<br> Ej: rrangel");
contrasenia ("Contraseña","formulario","contrasenia","contrasenia","","25","","","","","","Ingrese la Contraseña para el Ingreso al Sistema");
boton ("Acceder","formulario","acceder","acceder","","formulario_boton");
formulario_cierre ();
// <><><><><><><><><><><><><><><><>><><><><><><><><><><><><><><><>><><><><><><><><><><><><><><>
/*

// <><><><><><><><><><><><> Menú de búsqueda por tipo de documento <><><><><><><><><><><><><><>
menu_tipo_documento("Tipo de Documento","menu");
// <><><><><><><><><><><><><><><><>><><><><><><><><><><><><><><><>><><><><><><><><><><><><><><>
*/
echo '</div>';

/*
// <><><><><><><><><><><><> Formulario de Búsqueda Rápida <><><><><><><><><><><><><><><><><><><>
formulario_inicio ("Búsqueda Rápida","formulario","busqueda","index.php","POST","buscar(this);","","","Búsqueda Rápida","");
select ("Buscar por","formulario","buscar_por","buscar_por","","buscar","formulario","");
text ("Ingrese","formulario","ingrese","ingrese","","25","","","","","");
boton ("Buscar","formulario","busqueda_por","busqueda_por","","formulario_boton");
formulario_cierre ();
*/
// <><><><><><><><><><><><><><><><>><><><><><><><><><><><><><><><>><><><><><><><><><><><><><><>
?>




<!--
<table class="formulario">
<tr class="formulario">
<th class="formulario" id="codigo">Código</th>
<th class="formulario" id="titulo_documento">Título del Documento</th>
<th class="formulario" id="nro_revision">Nº Revisión</th>
<th class="formulario" id="estado">Estado</th>
<th class="formulario" id="fecha">Fecha</th>
<th class="formulario" id="condicion">Condición</th>
<th class="formulario" id="archivo">Ver Archivo</th>
</tr>


<tr class="formulario">
<td class="codigo">LIS_GPVV_018</td>
<td class="titulo_documento">Titulo de Prueba Titulo de Prueba Titulo de Prueba Titulo de Prueba</td>
<td class="nro_revision">5</td>
<td class="estado"><div class="aprobado" title="Aprobado">&radic;</div></td>
<td class="fecha">24-08-2012</td>
<td class="condicion"><img class="condicion" src="imagenes/publico.png" title="Acceso Público" /></td>
<td class="archivo"><img class="archivo" src="imagenes/archivo.png" title="Descarga Pública" /></td>
</tr>


<tr class="formulario">
<td class="codigo">LIS_GPVV_018</td>
<td class="titulo_documento">Titulo de Prueba Titulo de Prueba Titulo de Prueba Titulo de Prueba lo de Prueba Titulo de Prueba Titulo de Prueb</td>
<td class="nro_revision">5</td>
<td class="estado"><div class="aprobado" title="Aprobado">&radic;</div></td>
<td class="fecha">24-08-2012</td>
<td class="condicion"><img class="condicion" src="imagenes/publico.png" title="Acceso Público" /></td>
<td class="archivo"><img class="archivo" align="middle" src="imagenes/archivo.png" title="Descarga Pública" /></td>
</tr>


<tr class="formulario">
<td class="codigo">LIS_GPVV_018</td>
<td class="titulo_documento">Titulo de Prueba Titulo de Prueba Titulo de Prueba Titulo de Prueba</td>
<td class="nro_revision">5</td>
<td class="estado"><div class="aprobado" title="Aprobado">&radic;</div></td>
<td class="fecha">24-08-2012</td>
<td class="condicion"><img class="condicion" src="imagenes/privado.png" title="Acceso Restringido" /></td>
<td class="archivo"><img class="archivo" src="imagenes/archivo.png" title="Descarga Restringida Solo Usuarios con Privilegios" /></td>
</tr>



</table>
-->
<!-- InstanceEndEditable --></div>
<div class="pie"></div>
</div>
</body>
<!-- InstanceEnd --></html>
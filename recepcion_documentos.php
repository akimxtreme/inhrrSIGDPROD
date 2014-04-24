<?php session_start(); ?>
<?php 
// Variables de sesión
$usuario =$_SESSION['usuario'];
$nombre_usuario =$_SESSION['nombre_usuario'];
$privilegio = $_SESSION['privilegio'];
$ultimoAcceso =$_SESSION['ultimoAcceso'];
	if($privilegio==777 || $privilegio==2){
		include_once('inactividad.php');
		inactivo($ultimoAcceso);	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/plantilla.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="icon" href="imagenes/planta_vacunas.png"/>
<!-- InstanceBeginEditable name="doctitle" -->
<title>Recepción de Documentos</title>
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







// Unidades con acceso a un documento confidencial
		function acceso_confidencial(str){
			if(str=="")
				var xmlhttp; 
				if (str=="")
				  {
				  document.getElementById("acceso_confidencial").innerHTML="";
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
					 document.getElementById("acceso_confidencial").innerHTML=xmlhttp.responseText;
					 }
				  }
			  	//xmlhttp.open("POST","acceso_confidencial.php?u="+str,true);
				xmlhttp.open("GET",'acceso_confidencial.php?u='+ document.getElementById("unid_acceso").value+'&cod='+ document.getElementById("cod_doc_h").value);
				xmlhttp.send();
			}
// Borrar Unidades con acceso a un documento confidencial
		function borrar_unidad(str){
			
			
				var xmlhttp; 
				if (str=="")
				  {
				  document.getElementById("acceso_confidencial").innerHTML="";
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
					 document.getElementById("acceso_confidencial").innerHTML=xmlhttp.responseText;
					 }
				  }
			  	//xmlhttp.open("GET","borrar_unidad.php?u="+str,true);
				xmlhttp.open("GET",'borrar_unidad.php?u='+ document.getElementById("boton_multiple").value+'&cod='+ document.getElementById("cod_doc_h").value);
				xmlhttp.send();
			}
</script>



<?php 
configuracion ($nombre_usuario,$privilegio);
inf_codigo("inf_codigo","");

echo '<div class="ordenar">';
// Menú de búsqueda por tipo de documento
menu_tipo_documento("Módulos del Sistema","modulos_sistema");
echo '<h1 class="tituto_tipo_documento">Recepción de Documentos</h1>';	
echo '</div>';
// Variables del Formulario
$recibir=$_POST['recibir'];
isset($recibir);
if($recibir == 'recibir'){
				# inicio - validaciones
$cod_doc=$_POST['cod_doc'];
$rev=$_POST['rev'];



// Selecciona los Datos Basícos del Documento mediante la variable $cod_doc
include ('conexion.php');
$sql = "SELECT * FROM inf_codigo WHERE cod_doc='$cod_doc' AND rev='$rev'";
$seleccion=mysql_query($sql,$conexion);

				while ($row = mysql_fetch_array($seleccion)){
						$campo_1=$row["cod_doc"];
						$campo_2=$row["tipo_doc"];
						$campo_3=$row["sigla_doc"];
						$campo_4=$row["rev"];
						$campo_5=$row["usuario_solic"];
						$campo_6=$row["titulo_doc"];
						$unidad= substr($campo_3,0, 2);
						$dependiente= substr($campo_3,2, 4);
						
						// Tipo de documento	
						$sql_2 = "SELECT * FROM cat_tipodoc WHERE sigla_doc='$campo_2'";
						$seleccion_2=mysql_query($sql_2,$conexion);
						while ($row_2 = mysql_fetch_array($seleccion_2)){
							$tipo_documento=$row_2["nombre"];
						}
						// Nombre Unidad	
						$sql_2 = "SELECT * FROM unidades WHERE sigla_unid='$unidad'";
						$seleccion_2=mysql_query($sql_2,$conexion);
						while ($row_2 = mysql_fetch_array($seleccion_2)){
							$unidad_adscripcion=$row_2["denominacion"];
						}
						// Nombr Unidad perteneciente
						$sql_3 = "SELECT * FROM unidades WHERE sigla_unid = '$dependiente'";
						$seleccion_3=mysql_query($sql_3,$conexion);
						while ($row_3 = mysql_fetch_array($seleccion_3)){
							$pertenece=$row_3["denominacion"];
						}
				}

$pon_procedimiento = $campo_2;

// Formulario de Solicitud de Códigos
echo '<div class="ordenar">';
formulario_inicio ("Formulario de Recepción de Documentos","formulario","recepcion_documentos","bd_acciones.php","POST","recepcion_documento(this);","","","","");
	//pestania("Recepción","formulario","recepcion(this);");
	subtitulos("Datos Básicos del Documento","");
	text ("Código del Documento","formulario","cod_doc","cod_doc",$campo_1,"","disabled","","","","","Muestra el Código del Documento<br>Ej: ".$campo_1);
	hidden('cod_doc_h',$campo_1);
	$campo_2 = $campo_2 . " (" . $tipo_documento . ")";
	text ("Tipo de Documento","formulario","tipo_doc","tipo_doc",$campo_2,"","disabled","","","","","Muestra las Siglas y la Denominación Tipo del Documento");
	hidden('tipo_doc_h',$campo_2);
	$unidad = $unidad . " (" . $unidad_adscripcion . ")";
	text ("Unidad de Adscripción","formulario","unidad_adscripcion","unidad_adscripcion",$unidad,"","disabled","","","","","");
	hidden('unidad_adscripcion_h',$unidad);
	if ($dependiente==""){$dependiente = $unidad;}else{
	$dependiente = $dependiente . " (" . $pertenece . ")";}
	text ("Unidad a la que pertenece","formulario","unidad_pertenece","unidad_pertenece",$dependiente,"","disabled","","","","","","");
	hidden('unidad_pertenece_h',$dependiente);
	text ("Número de Revisión","formulario","rev","rev",$campo_4,"","disabled","","","","","Muestra el Número de Revisión del Documento");
	hidden('rev_h',$campo_4);
	textarea ("Título del documento","formulario_textarea","titulo_doc","titulo_doc",$campo_6,"","","","formulario_textarea","","obligatorio","Ingrese el Título que tendrá el Documento.<br> Debe ser mayor (») a 20 caracteres y menor («) a 200");
	
	subtitulos("Recepción","");
	paginas_calendario(); // Páginas que hacen funcionar el calendario (Llamada)
	fecha ("Fecha de Emisión","formulario","fecha_emision","fecha_emision","","","","","Ingrese la Fecha de Emisión del Documento<br>Debe ser menor ó igual (&le;) a la Fecha Actual");
	
	fecha ("Fecha de Recepción","formulario","fecha_recepcion","fecha_recepcion","","","","","Ingrese la Fecha de Recepción del Documento<br>Debe ser menor ó igual (&le;) a la Fecha Actual");
	
	div_multiple_inicio("Referencias del Memorándum","formulario","formulario_multiple","","","","Ingrese el Código del Memorandum<br>Ej: PE-001-2013");
		select ("","formulario_multiple","unidades_referencia","unidades_referencia","","unidades_memo","","","");
		text ("","formulario_multiple","unidades_numero","unidades_numero","","3","","","2","","","");
		select ("","formulario_multiple","unidades_anio","unidades_anio","","unidades_anio","","","");
	div_multiple_cierre();
	
	div_multiple_inicio("Condición","formulario","formulario_sub","div_condicion","","","Seleccione la Condición del Documento.<br> (Confidencial ó Público)");
		radio_checkbox("Confidencial","formulario_sub","condicion","confidencial","confidencial","Confidencial","radio","");
		radio_checkbox("Público","formulario_sub","condicion","publico","publico","Público","radio","");
	div_multiple_cierre();
	
	select ("Unidad con Acceso al Documento","formulario","unid_acceso","acceso_confidencial(this.value);","","unidades","div_unidades_acceso","","Confidencial:<br>Seleccione la(s) Unidade(s) que tendrán el Acceso al Documento");
	$tabla = ";". $campo_1;
	div_multiple_inicio("","formulario","formulario_multiple","acceso_confidencial","div_acceso_confidencial","","");
	select_multiple ("","multiple","unidades_confidencial","","",$tabla,"","","");
	img("borrar_unidad(this.value);","boton_confidencial","boton_multiple","X","");
	div_multiple_cierre();
	
	
	
	
	
	
	div_multiple_inicio("Recopilación de Archivo","formulario","formulario_sub","div_fisico_digital","","","Seleccione la opción si recibió el Documento en Físico y Digital");
		radio_checkbox("Físico / Digital","formulario_sub","fisico_digital","fisico_digital","fisico_digital","Físico / Digital","checkbox","");
	div_multiple_cierre();
	
	if($pon_procedimiento==="PON"){
	select ("Tipo de Procedimiento","formulario","tipo_procedimiento","tipo_procedimiento","","tipo_procedimiento","","","Seleccione para medir la Vigencia del PON.<br> Administrativo: 5 años.<br>Técnico: 2 años.");
	hidden('pon_asoc_tipo_procedimiento',$pon_procedimiento);
	}else{
		hidden('pon_asoc_tipo_procedimiento','otro');
		}
	//select ("Tipo de Procedimiento","formulario","unidades_anio","unidades_anio","","unidades_anio","","");
	//text ("Tipo de Procedimiento","formulario","cod_doc","cod_doc",$campo_1,"","disabled","","","","");
		
	textarea ("Observaciones","formulario_textarea","observaciones","observaciones","","","","","formulario_textarea","","","Opcional:<br>Ingrese alguna información adicional");
	
	
	//input_file("","adjunto","Adjunto","file","Seleccione...");
	boton ("Guardar","formulario","guardar_recepcion_documentos","guardar_recepcion_documentos","","formulario_boton");

	formulario_cierre ();
	echo '</div>';
}else {echo '<html><head><meta http-equiv="REFRESH" content="0; url=cod_asignados.php"></head></html>';}

// Cierre de session
}else{
	echo '<html><head><meta http-equiv="REFRESH" content="0; url=index.php"></head></html>';
	} 
?>

<!-- InstanceEndEditable --></div>
<div class="pie"></div>
</div>
</body>
<!-- InstanceEnd --></html>
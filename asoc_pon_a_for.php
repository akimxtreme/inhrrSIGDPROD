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
<title>Asociar Procedimiento(s) de Operación Normalizado(s) a un Formulario</title>
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
		function asociar_pon(str){
			if(str=="")
				var xmlhttp; 
				if (str=="")
				  {
				  document.getElementById("pon_asoc_for").innerHTML="";
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
					 document.getElementById("pon_asoc_for").innerHTML=xmlhttp.responseText;
					 }
				  }
			  	//xmlhttp.open("POST","acceso_confidencial.php?u="+str,true);
				xmlhttp.open("GET",'pon_asociados.php?u='+ document.getElementById("pon").value+'&cod='+ document.getElementById("cod_doc_h").value);
				xmlhttp.send();
			}
// Borrar Unidades con acceso a un documento confidencial
		function borrar_pon(str){
			
			
				var xmlhttp; 
				if (str=="")
				  {
				  document.getElementById("pon_asoc_for").innerHTML="";
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
					 document.getElementById("pon_asoc_for").innerHTML=xmlhttp.responseText;
					 }
				  }
			  	//xmlhttp.open("GET","borrar_unidad.php?u="+str,true);
				var valor = document.getElementById("pon_asoc").value;
				xmlhttp.open("GET",'borrar_pon.php?u='+valor+'&cod='+ document.getElementById("cod_doc_h").value);
				xmlhttp.send();
			}
</script>



<?php 
configuracion ($nombre_usuario,$privilegio);
inf_codigo("inf_codigo","");

echo '<div class="ordenar">';
// Menú de búsqueda por tipo de documento
menu_tipo_documento("Módulos del Sistema","modulos_sistema");
// Variables del Formulario
$asociar=$_POST['asociar'];
isset($asociar);
if($asociar == 'asociar'){
				# inicio - validaciones
$cod_doc=$_POST['cod_doc'];
$rev=$_POST['rev'];

echo '<h1 class="tituto_tipo_documento">Asociar Procedimiento(s) de Operación Normalizado(s) al Formulario: '.$cod_doc.'</h1>';	
echo '</div>';




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
formulario_inicio ("Asociar Procedimiento(s) de Operación Normalizado(s) al Formulario: $cod_doc","formulario","pon_asociados","","POST","","","","","");
	subtitulos("Datos Básicos del Documento","");
	text ("Código del Documento","formulario","cod_doc","cod_doc",$campo_1,"","disabled","","","","","Muestra el Código del Documento<br>Ej: ".$campo_1);
	hidden('cod_doc_h',$campo_1);
	$campo_2 = $campo_2 . " (" . $tipo_documento . ")";
	text ("Tipo de Documento","formulario","tipo_doc","tipo_doc",$campo_2,"","disabled","","","","","Muestra las Siglas y la Denominación Tipo del Documento");
	$unidad = $unidad . " (" . $unidad_adscripcion . ")";
	text ("Unidad de Adscripción","formulario","unidad_adscripcion","unidad_adscripcion",$unidad,"","disabled","","","","","");
	if ($dependiente==""){$dependiente = $unidad;}else{
	$dependiente = $dependiente . " (" . $pertenece . ")";}
	text ("Unidad a la que pertenece","formulario","unidad_pertenece","unidad_pertenece",$dependiente,"","disabled","","","","","");
	
	
	subtitulos("Asociaciones","");
	select ("Procedimientos de Operación Normalizados - (PON)","formulario","pon","asociar_pon(this.value);","","PON","","","Seleccione el Procedimiento de Operación Normalizado (PON) que estará asociado a un Formulario (FOR)");
	$tabla = ";". $campo_1;
	$pon_asoc = "PON_ASOC-" . $cod_doc;
	div_multiple_inicio("PON Asociado(s) a un FOR","formulario","formulario_multiple","pon_asoc_for","","","Procedimiento(s) de Operación Normalizado(s) (PON) asociados a un Formulario (FOR)");
	select_multiple ("","multiple","pon_asoc","","",$pon_asoc,"","","");
	img("borrar_pon(this.value);","boton_confidencial","boton_multiple","X","");
	div_multiple_cierre();
	formulario_cierre ();
	echo '</div>';
}else {echo '<html><head><meta http-equiv="REFRESH" content="0; url=buscar_for.php"></head></html>';}
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
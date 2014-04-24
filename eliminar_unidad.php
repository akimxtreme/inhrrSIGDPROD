<?php session_start(); ?>
<?php 
// Variables de sesión
$usuario =$_SESSION['usuario'];
$nombre_usuario =$_SESSION['nombre_usuario'];
	$privilegio = $_SESSION['privilegio'];
	if($privilegio==777){
		include_once('inactividad.php');
		inactivo($ultimoAcceso);	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/plantilla.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="icon" href="imagenes/planta_vacunas.png"/>
<!-- InstanceBeginEditable name="doctitle" -->
<title>Eliminar Unidad</title>
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

<?php
/*Obteniendo la Variable usuario*/
$unidad_eliminar = $_POST['unidad_eliminar'];
isset($unidad_eliminar);
if($unidad_eliminar==""){
	echo '<html><head><meta http-equiv="REFRESH" content="0; url=buscar_unidad_eliminar.php"></head></html>';
	}else {
include("conexion.php");
$sql="SELECT denominacion, sigla_doc FROM unidades WHERE sigla_unid='$unidad_eliminar'";
$seleccion=mysql_query($sql,$conexion);
	while ($row = mysql_fetch_array($seleccion)){
			$denominacion=$row[0];
			$sigla_doc=$row[1];					
	}
mysql_close();
configuracion ($nombre_usuario, $privilegio);
inf_codigo("inf_codigo","");

echo '<div class="ordenar">';
// Menú de búsqueda por tipo de documento
menu_tipo_documento("Módulos del Sistema","modulos_sistema");
echo '<h1 class="tituto_tipo_documento">Eliminar Usuario</h1>';	
echo '</div>';
echo '<div class="ordenar">';
section();
echo '</div>';
// Formulario de Solicitud de Códigos
echo '<div class="ordenar">';
formulario_inicio ("Eliminar Unidad","formulario","","bd_acciones.php","POST","","","","","");
	text ("Nombre de la Unidad","formulario","usuario","usuario","$denominacion ($unidad_eliminar)","","disabled","","","","","Muestra el Nombre Completo de la Unidad y sus Siglas");
	hidden("sigla_unid",$unidad_eliminar);
	text ("Unidad a la que Depende","formulario","usuario","usuario",$sigla_doc,"","disabled","","","","","Muestra las Siglas de la Unidad a la que Depende");
	boton ("Eliminar Unidad","formulario","eliminar_cuenta_unidad","eliminar_cuenta_unidad","","formulario_boton");
formulario_cierre ();
echo '</div>';
}
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
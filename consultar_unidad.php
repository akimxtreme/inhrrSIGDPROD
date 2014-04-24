<?php session_start(); ?>
<?php 
// Variables de sesión
$usuario =$_SESSION['usuario'];
$nombre_usuario =$_SESSION['nombre_usuario'];
$privilegio = $_SESSION['privilegio'];
$ultimoAcceso =$_SESSION['ultimoAcceso'];
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
<title>Modificar Usuario</title>
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
$unidad_consultar = $_POST['unidad_consultar'];
isset($unidad_consultar);
if($unidad_consultar==""){
	echo '<html><head><meta http-equiv="REFRESH" content="0; url=buscar_unidad_consulta.php"></head></html>';
	}else {
include("conexion.php");
$sql="SELECT denominacion, sigla_doc FROM unidades WHERE sigla_unid='$unidad_consultar'";
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
	echo '<h1 class="tituto_tipo_documento">Consultar Unidad</h1>';	
	
echo '</div>';
echo '<div class="ordenar">';
	section();
echo '</div>';

$class = 'style=" border: 1px solid #CCCCCC; text-align:left; background:#FFFFFF; color:#000000; width:72%;"';
$class_2 = 'style="width:27%;"';
// Formulario de Solicitud de Códigos
echo '<div class="ordenar">';
echo '
<table class="formulario_global" style="width:99%;">
<tr class="formulario">
<th class="formulario_2" style=" text-shadow: 0px 0px 2px #000000; width:99%; border: none;">DATOS DE LA CUENTA</th>
</tr>
<tr class="formulario">
<th class="formulario" id="titulo_documento" '. $class_2 .'>Nombre de la Unidad</th>
<th class="formulario" '. $class .'>'. $denominacion . " (" . $sigla_doc . ")" . '</th>';
if($unidad_modificar!='PE'){
echo'
<th class="formulario" id="titulo_documento" '. $class_2 .'>Depende / Unidad</th>
<th class="formulario" '. $class .'>'. $sigla_doc .'</th>';
}
echo '
</tr>
</table>
';

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
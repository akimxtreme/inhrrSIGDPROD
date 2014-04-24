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
<title>Consultar Criterio</title>
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
$criterio_consultar = $_POST['criterio_consultar'];
isset($criterio_consultar);
if($criterio_consultar==""){
	echo '<html><head><meta http-equiv="REFRESH" content="0; url=buscar_criterio_consulta.php"></head></html>';
	}else {
include("conexion.php");
$sql="SELECT id, titulo, detalles FROM cat_crit_evaluacion WHERE id='$criterio_consultar'";
$seleccion=mysql_query($sql,$conexion);
	while ($row = mysql_fetch_array($seleccion)){
			$id=$row[0];
			$titulo=$row[1];
			$detalles=$row[2];
	}
mysql_close();
configuracion ($nombre_usuario, $privilegio);
inf_codigo("inf_codigo","");

echo '<div class="ordenar">';

	// Menú de búsqueda por tipo de documento
	menu_tipo_documento("Módulos del Sistema","modulos_sistema");
	echo '<h1 class="tituto_tipo_documento">Consultar Criterio</h1>';	
	
echo '</div>';
echo '<div class="ordenar">';
	section();
echo '</div>';
$class = 'style=" border: 1px solid #CCCCCC; text-align:left; background:#FFFFFF; color:#000000; width:72%;"';
$class_2 = 'style="width:27%"';
$class_3 = 'style="height:35px; width:27%"';
$class_4 = 'style="height:35px; border: 1px solid #CCCCCC; text-align:left; background:#FFFFFF; color:#000000; width:72%;"';
$class_5 = 'style="height:140px; width:27%"';
$class_6 = 'style="height:140px; border: 1px solid #CCCCCC; text-align:left; background:#FFFFFF; color:#000000; width:72%;"';
// Formulario de Solicitud de Códigos
echo '<div class="ordenar">';
echo '
<table class="formulario_global" style="width:99%;">
<tr class="formulario">
<th class="formulario_2" style=" text-shadow: 0px 0px 2px #000000; width:99.3%; border: none;">Criterio nº '. $modif_criterio .'</th>
</tr>
<tr class="formulario">
<th class="formulario" id="titulo_documento" '. $class_3 .'>Nº de Criterio</th>
<th class="formulario" '. $class_4 .'>Criterio ' . $modif_criterio . '</th>'.
'<th class="formulario" id="titulo_documento" '. $class_3 .'>Título</th>'.
'<th class="formulario" '. $class_4 .'>Criterio ' . $titulo . '</th>'.
'<th class="formulario" id="titulo_documento" '. $class_5 .'>Detalles</th>'.
'<th class="formulario" '. $class_6 .'>Criterio ' . $detalles . '</th>';
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
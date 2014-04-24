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
<title>Buscar Criterio</title>
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
configuracion ($nombre_usuario,$privilegio);
inf_codigo("inf_codigo","");

echo '<div class="ordenar">';
// Menú de búsqueda por tipo de documento
menu_tipo_documento("Módulos del Sistema","modulos_sistema");
echo '<h1 class="tituto_tipo_documento">Búsqueda Criterio</h1>';	
echo '</div>';


// Formulario de Solicitud de Códigos
echo '<div class="ordenar">';
	section();
?>
<?php

echo '</div>';
// Formulario de Solicitud de Códigos
echo '<div class="ordenar">';
formulario_inicio ("Buscar Criterio","formulario","busqueda","","POST","consultaCriterio(this);","","","","");
	select ("Buscar por","formulario","buscar_crit_evaluacion","","","buscar_crit_evaluacion","","","Seleccione el Tipo de Búsqueda.<br>Ej: Número de Criterio");
	text ("Ingrese","formulario","campo","campo","","","","","","","","Ingrese la información a buscar.<br>Ejemplo para buscar por Número de Criterio: 5");	
	boton ("Buscar Criterio","formulario","buscar","buscar","","formulario_boton");

	formulario_cierre ();
	// <><><><><><><><><><><><><><><><>><><><><><><><><><><><><><><><>><><><><><><><><><><><><><><>
echo '</div>';


			echo '<div class="ordenar">
			
			<table class="formulario" style="margin:0px 0px 0px 2%;">
			<tr class="formulario">
			<th class="formulario" id="nro_revision">Criterio</th>
			<th class="formulario" id="obs_documento">Título del Criterio</th>
			<th class="formulario" id="codigo">Acción</th>
			</tr>';



$buscar=$_POST['buscar'];
isset($buscar);
if($buscar == 'buscar'){
	
	$buscar_crit_evaluacion = $_POST['buscar_crit_evaluacion'];
	$campo = $_POST['campo'];
	
	include ('conexion.php');
	$sql = "SELECT id, titulo, detalles FROM cat_crit_evaluacion WHERE $buscar_crit_evaluacion LIKE '%$campo%'";
	$seleccion=mysql_query($sql,$conexion);
 	
				while ($row = mysql_fetch_array($seleccion)){
						$campo_1=$row['id'];
						$campo_2=$row["titulo"];
						$campo_3=$row["detalles"];
						echo'<tr class="formulario">
						<td class="nro_revision">'. $campo_1 .'</td>
						<td class="obs_documento" style="text-align:left;">'. $campo_2 .'</td>
						<td class="codigo">
							<form action="consultar_criterio.php" method="post" name="consultar_criterio" id="">
							<input type="hidden" name="criterio_consultar" id="" value="'. $campo_1 .'" />
							<button type="submit" name="consultar_criterio" id="" value="consultar_criterio">Detalles</button>
							</form>
						</td>
						</tr>';
								
										
						}
						
						echo '</table></div>';
	
}else{
include ('conexion.php');
$sql = "SELECT id, titulo, detalles FROM cat_crit_evaluacion";
	$seleccion=mysql_query($sql,$conexion);
 	
				while ($row = mysql_fetch_array($seleccion)){
						$campo_1=$row['id'];
						$campo_2=$row["titulo"];
						$campo_3=$row["detalles"];
						echo'<tr class="formulario">
						<td class="nro_revision">'. $campo_1 .'</td>
						<td class="obs_documento" style="text-align:left;">'. $campo_2 .'</td>
						<td class="codigo">
							<form action="consultar_criterio.php" method="post" name="consultar_criterio" id="">
							<input type="hidden" name="criterio_consultar" id="" value="'. $campo_1 .'" />
							<button type="submit" name="consultar_criterio" id="" value="consultar_criterio">Detalles</button>
							</form>
						</td>
						</tr>';
								
										
						}
						
						
						echo '</table></div>';
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
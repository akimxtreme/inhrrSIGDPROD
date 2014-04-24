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
<title>Buscar Unidad a Modificar</title>
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
echo '<h1 class="tituto_tipo_documento">Búsqueda de Unidad - (Modificación)</h1>';	
echo '</div>';


// Formulario de Solicitud de Códigos
echo '<div class="ordenar">';
	section();
?>

		
		


<?php

echo '</div>';
// Formulario de Solicitud de Códigos
echo '<div class="ordenar">';
formulario_inicio ("Buscar Unidad","formulario","busqueda","","POST","consultaUnidad(this);","","","","");
	select ("Buscar por","formulario","buscar_unidad","","","buscar_unidad","","","Seleccione el Tipo de Búsqueda<br>Ej: Siglas");
	text ("Ingrese","formulario","campo","campo","","","","","","","","Ingrese la información a buscar<br>Ejemplo para buscar por Siglas: PE");	
	boton ("Buscar Unidad","formulario","buscar","buscar","","formulario_boton");

	formulario_cierre ();
	// <><><><><><><><><><><><><><><><>><><><><><><><><><><><><><><><>><><><><><><><><><><><><><><>
echo '</div>';


			echo '<div class="ordenar">
			
			<table class="formulario">
			<tr class="formulario">
			<th class="formulario" id="numero">nº</th>
			<th class="formulario" id="codigo">Siglas</th>
			<th class="formulario" id="usuario_sist">Nombre de la Unidad</th>
			<th class="formulario" id="evaluar">Siglas Unidad Dependiente</th>
			<th class="formulario" id="evaluar">Acción</th>
			</tr>';



$buscar=$_POST['buscar'];
isset($buscar);
if($buscar == 'buscar'){
	
	$buscar_unidad = $_POST['buscar_unidad'];
	$campo = $_POST['campo'];
	
	include ('conexion.php');
	$sql = "SELECT * FROM unidades WHERE $buscar_unidad LIKE '%$campo%'";
	$seleccion=mysql_query($sql,$conexion);
 	$cantidad_de_registros = 1;
				while ($row = mysql_fetch_array($seleccion)){
						$campo_1=$row['sigla_unid'];
						$campo_2=$row["denominacion"];
						$campo_3=$row["sigla_doc"];
											
						echo'<tr class="formulario">
						<td class="numero">'. $cantidad_de_registros++ .'</td>
						<td class="codigo">'. $campo_1 .'</td>
						<td class="usuario_sist">'. $campo_2 .'</td>
						<td class="evaluar">'. $campo_3 .'</td>
						<td class="evaluar">
							<form action="modificar_unidad.php" method="post" name="modificar_unidad" id="">
							<input type="hidden" name="unidad_modificar" id="" value="'. $campo_1 .'" />
							<button type="submit" name="modificar_unidad" id="" value="modificar_unidad">Modificar Unidad</button>
							</form>
						</td>
						</tr>';
								
										
						}
						
						echo '</table></div>';
	
}else{
include ('conexion.php');
$sql = "SELECT * FROM unidades";
$seleccion=mysql_query($sql,$conexion);
$cantidad_de_registros = 1;
				while ($row = mysql_fetch_array($seleccion)){
						$campo_1=$row['sigla_unid'];
						$campo_2=$row["denominacion"];
						$campo_3=$row["sigla_doc"];
											
						echo'<tr class="formulario">
						<td class="numero">'. $cantidad_de_registros++ .'</td>
						<td class="codigo">'. $campo_1 .'</td>
						<td class="usuario_sist">'. $campo_2 .'</td>
						<td class="evaluar">'. $campo_3 .'</td>
						<td class="evaluar">
							<form action="modificar_unidad.php" method="post" name="modificar_unidad" id="">
							<input type="hidden" name="unidad_modificar" id="" value="'. $campo_1 .'" />
							<button type="submit" name="modificar_unidad" id="" value="modificar_unidad">Modificar Unidad</button>
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
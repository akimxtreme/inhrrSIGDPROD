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
<title>Buscar Usuario</title>
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
echo '<h1 class="tituto_tipo_documento">Búsqueda de Usuario</h1>';	
echo '</div>';


// Formulario de Solicitud de Códigos
echo '<div class="ordenar">';
	section();
?>

		
		


<?php

echo '</div>';
// Formulario de Solicitud de Códigos
echo '<div class="ordenar">';
formulario_inicio ("Buscar Usuario","formulario","busqueda","","POST","consultaUsuario(this);","","","","");
	select ("Buscar por","formulario","buscar_usuario","","","buscar_usuario","","","Seleccione el Tipo de Búsqueda<br>Ej: Usuario");
	text ("Ingrese","formulario","campo","campo","","","","","","","","Ingrese la información a buscar<br>Ejemplo para buscar un usuario: rrangel");	
	boton ("Buscar Usuario","formulario","buscar","buscar","","formulario_boton");

	formulario_cierre ();
	// <><><><><><><><><><><><><><><><>><><><><><><><><><><><><><><><>><><><><><><><><><><><><><><>
echo '</div>';


			echo '<div class="ordenar">
			
			<table class="formulario">
			<tr class="formulario">
			<th class="formulario" id="numero">nº</th>
			<th class="formulario" id="codigo">Usuario</th>
			<th class="formulario" id="usuario_sist">Nombre Completo</th>
			<th class="formulario" id="codigo">Cédula</th>
			<th class="formulario" id="evaluar">Unidad</th>
			<th class="formulario" id="archivo">Privilegio</th>
			<th class="formulario" id="codigo">Acción</th>
			</tr>';



$buscar=$_POST['buscar'];
isset($buscar);
if($buscar == 'buscar'){
	
	$buscar_usuario = $_POST['buscar_usuario'];
	$campo = $_POST['campo'];
	
	include ('conexion.php');
	$sql = "SELECT * FROM usuario WHERE $buscar_usuario LIKE '%$campo%'  AND (privilegio='777' OR privilegio='2' OR privilegio='1')  AND cod_unidad!='IF'";
	$seleccion=mysql_query($sql,$conexion);
 	$cantidad_de_registros = 1;
				while ($row = mysql_fetch_array($seleccion)){
						$campo_1=$row['usuario'];
						$campo_2=$row["nombre_usuario"];
						$campo_3=$row["cedula"];
						$campo_4=$row["privilegio"];
						$campo_5=$row["unidad"];
						
						if($campo_3==""){
							$campo_3 = "---------";
							}
						switch($campo_4){
							case 777: 
							$campo_4="Administrador del Sistema";
							$titulo = "administrador.png";
							break;
							
							case 2:
							$campo_4="Operador";
							$titulo = "operador.png";
							break;
							
							case 1:
							$campo_4 = "Usuario de Consulta";
							$titulo = "usuario.png";
							break;
							}
														
						echo'<tr class="formulario">
						<td class="numero">'. $cantidad_de_registros++ .'</td>
						<td class="codigo">'. $campo_1 .'</td>
						<td class="usuario_sist">'. $campo_2 .'</td>
						<td class="codigo">'. $campo_3 .'</td>
						<td class="evaluar">'. $campo_5 .'</td>
						<td class="archivo"><img class="archivo" src="imagenes/'. $titulo .'" title="'. $campo_4 .'" /></a></td>
						<td class="codigo">
							<form action="consultar_usuario.php" method="post" name="consultar" id="">
							<input type="hidden" name="consultar_usuario" id="" value="'. $campo_1 .'" />
							<button type="submit" name="consultar" id="" value="consultar">Consultar</button>
							</form>
						</td>
						</tr>';
								
										
						}
						
						echo '</table></div>';
	
}else{
include ('conexion.php');
$sql = "SELECT * FROM usuario WHERE (privilegio='777' OR privilegio='2' OR privilegio='1')  AND cod_unidad!='IF'";
$seleccion=mysql_query($sql,$conexion);
$cantidad_de_registros = 1;
				while ($row = mysql_fetch_array($seleccion)){
						$campo_1=$row['usuario'];
						$campo_2=$row["nombre_usuario"];
						$campo_3=$row["cedula"];
						$campo_4=$row["privilegio"];
						$campo_5=$row["unidad"];
						
						if($campo_3==""){
							$campo_3 = "---------";
							}
						switch($campo_4){
							case 777: 
							$campo_4="Administrador del Sistema";
							$titulo = "administrador.png";
							break;
							
							case 2:
							$campo_4="Operador";
							$titulo = "operador.png";
							break;
							
							case 1:
							$campo_4 = "Usuario de Consulta";
							$titulo = "usuario.png";
							break;
							}
														
						echo'<tr class="formulario">
						<td class="numero">'. $cantidad_de_registros++ .'</td>
						<td class="codigo">'. $campo_1 .'</td>
						<td class="usuario_sist">'. $campo_2 .'</td>
						<td class="codigo">'. $campo_3 .'</td>
						<td class="evaluar">'. $campo_5 .'</td>
						<td class="archivo"><img class="archivo" src="imagenes/'. $titulo .'" title="'. $campo_4 .'" /></a></td>
						<td class="codigo">
							<form action="consultar_usuario.php" method="post" name="consultar" id="">
							<input type="hidden" name="consultar_usuario" id="" value="'. $campo_1 .'" />
							<button type="submit" name="consultar" id="" value="consultar">Consultar</button>
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
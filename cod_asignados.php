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
<title>Sistema de Gestión Documental de la Planta Productora de Vacunas - Códigos Asignados</title>
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
echo '<h1 class="tituto_tipo_documento">Códigos Asignados</h1>';	

echo '</div>';

echo '<div class="ordenar">';
// <><><><><><><><><><><><> Formulario de Búsqueda Rápida <><><><><><><><><><><><><><><><><><><>
formulario_inicio ("Búsqueda de Códigos Asignados","formulario","busqueda","","POST","buscar(this);","","","Búsqueda Rápida","");
select ("Buscar por","formulario","buscar_por","buscar_por","","buscar","formulario","","Seleccione el Tipo de Búsqueda<br>Ej: Código");
text ("Ingrese","formulario","ingrese","ingrese","","100","","","","","","Ingrese la información a buscar<br>Ejemplo para buscar un código: FOR_PE_011");
boton ("Buscar","formulario","busqueda_por","busqueda_por","","formulario_boton");
formulario_cierre ();
// <><><><><><><><><><><><><><><><>><><><><><><><><><><><><><><><>><><><><><><><><><><><><><><>
echo '</div>';


			echo '<div class="ordenar">
			
			<table class="formulario">
			<tr class="formulario">
			<th class="formulario" id="numero">nº</th>
			<th class="formulario" id="codigo">Código Asignado</th>
			<th class="formulario" id="titulo_documento">Título del Documento</th>
			<th class="formulario" id="numero">Rev</th>
			<th class="formulario" id="unidad">Unidad Documentación</th>
			<th class="formulario" id="evaluar">Recepción de Documentos</th>
			</tr>';



$busqueda_por=$_POST['busqueda_por'];
isset($busqueda_por);
if($busqueda_por == 'busqueda_por'){
	$buscar_por = $_POST['buscar_por'];
	$ingrese = $_POST['ingrese'];
	include ('conexion.php');
	$sql = "SELECT * FROM inf_codigo WHERE $buscar_por = '$ingrese' AND estatus='0'";
	$seleccion=mysql_query($sql,$conexion);
 	$cantidad_de_registros = 1;
				while ($row = mysql_fetch_array($seleccion)){
						$campo_1=$row["cod_doc"];
						$campo_2=$row["tipo_doc"];
						$campo_3=$row["sigla_doc"];
						$campo_4=$row["rev"];
						$campo_5=$row["usuario_solic"];
						$campo_6=$row["titulo_doc"];
						$unidad= substr($campo_3,0, 2);
						$dependiente= substr($campo_3,2, 4);
						
						
						
						// Nombre Unidad	
						$sql_2 = "SELECT * FROM unidades WHERE sigla_doc='$campo_3'";
						$seleccion_2=mysql_query($sql_2,$conexion);
						while ($row_2 = mysql_fetch_array($seleccion_2)){
							$unidad_bd=$row_2["denominacion"];
						}
						// Nombr Unidad perteneciente
						$sql_3 = "SELECT * FROM unidades WHERE sigla_unid = '$dependiente'";
						$seleccion_3=mysql_query($sql_3,$conexion);
						while ($row_3 = mysql_fetch_array($seleccion_3)){
							$dependiente_bd=$row_3["denominacion"];
						}
						/*if($dependiente_bd==""){
							$dependiente_bd =$unidad_bd;
							}
							*/
						echo'<tr class="formulario">
						<td class="numero">'. $cantidad_de_registros++ .'</td>
						<td class="codigo">'. $campo_1 .'</td>
						<td class="titulo_documento">'. $campo_6 .'</td>
						<td class="numero">'. $campo_4 .'</td>
						<td class="unidad">'. $unidad_bd .'</td>
						<td class="evaluar">
							<form action="recepcion_documentos.php" method="post" name="recepcion_documentos" id="">
							<input type="hidden" name="cod_doc" id="" value="'. $campo_1 .'" />
							<input type="hidden" name="rev" id="" value="'. $campo_4 .'" />
							<button type="submit" name="recibir" id="" value="recibir">Recepción de Documentos</button>
							</form>
						</td>
						</tr>';
										
						}
						
						echo '</table></div>';
	
}else{
include ('conexion.php');
$sql = 'SELECT * FROM inf_codigo WHERE estatus="0" LIMIT 5';
$seleccion=mysql_query($sql,$conexion);
$cantidad_de_registros = 1;
				while ($row = mysql_fetch_array($seleccion)){
						$campo_1=$row["cod_doc"];
						$campo_2=$row["tipo_doc"];
						$campo_3=$row["sigla_doc"];
						$campo_4=$row["rev"];
						$campo_5=$row["usuario_solic"];
						$campo_6=$row["titulo_doc"];
						$unidad= substr($campo_3,0, 2);
						$dependiente= substr($campo_3,2, 4);
						
						
						
						// Nombre Unidad	
						$sql_2 = "SELECT * FROM unidades WHERE sigla_doc='$campo_3'";
						$seleccion_2=mysql_query($sql_2,$conexion);
						while ($row_2 = mysql_fetch_array($seleccion_2)){
							$unidad_bd=$row_2["denominacion"];
						}
						// Nombr Unidad perteneciente
						$sql_3 = "SELECT * FROM unidades WHERE sigla_unid = '$dependiente'";
						$seleccion_3=mysql_query($sql_3,$conexion);
						while ($row_3 = mysql_fetch_array($seleccion_3)){
							$dependiente_bd=$row_3["denominacion"];
						}
						
						echo'<tr class="formulario">
						<td class="numero">'. $cantidad_de_registros++ .'</td>
						<td class="codigo">'. $campo_1 .'</td>
						<td class="titulo_documento">'. $campo_6 .'</td>
						<td class="numero">'. $campo_4 .'</td>
						<td class="unidad">'. $unidad_bd .'</td>
						<td class="evaluar">
							<form action="recepcion_documentos.php" method="post" name="recepcion_documentos" id="">
							<input type="hidden" name="cod_doc" id="" value="'. $campo_1 .'" />
							<input type="hidden" name="rev" id="" value="'. $campo_4 .'" />
							<button type="submit" name="recibir" id="" value="recibir">Recepción de Documentos</button>
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
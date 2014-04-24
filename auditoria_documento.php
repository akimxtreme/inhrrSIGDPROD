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
<title>Sistema de Gestión Documental de la Planta Productora de Vacunas - Auditoría del Documento</title>
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
echo '<h1 class="tituto_tipo_documento">Auditoría del Documento</h1>';	

echo '</div>';

echo '<div class="ordenar">';
// <><><><><><><><><><><><> Formulario de Búsqueda Rápida <><><><><><><><><><><><><><><><><><><>
formulario_inicio ("Búsqueda del Documento","formulario","busqueda","","POST","buscar(this);","","","Búsqueda Rápida","");
select ("Buscar por","formulario","buscar_por","buscar_por","","buscar","formulario","","Seleccione el Tipo de Búsqueda<br>Ej: Código");
text ("Ingrese","formulario","ingrese","ingrese","","100","","","","","","Ingrese la información a buscar<br>Ejemplo para buscar un código: FOR_PE_011");
boton ("Buscar","formulario","busqueda_por","busqueda_por","","formulario_boton");
formulario_cierre ();
// <><><><><><><><><><><><><><><><>><><><><><><><><><><><><><><><>><><><><><><><><><><><><><><>
echo '</div>';


			echo '<div class="ordenar">
			
			<table class="formulario" style="margin: 0px 0px 0px 14%">
			<tr class="formulario">
			<th class="formulario" id="numero">nº</th>
			<th class="formulario" id="unidad">Código del documento</th>
			<th class="formulario" id="unidad">Revisiones Controladas</th>
			<th class="formulario" id="titulo_documento">Detalles</th>
			</tr>';



$busqueda_por=$_POST['busqueda_por'];
isset($busqueda_por);
if($busqueda_por == 'busqueda_por'){
	$buscar_por = $_POST['buscar_por'];
	$ingrese = $_POST['ingrese'];
	//echo $buscar_por . "<br>";
	//echo $ingrese;
	include ('conexion.php');
	// (1) Seleccionando todos los documentos controlados 
$sql = "SELECT DISTINCT cod_doc FROM inf_codigo WHERE $buscar_por LIKE '%$ingrese%' AND (estatus=777 OR estatus=999 OR estatus=333 OR estatus=111)";
$seleccion = mysql_query($sql);
$cont = mysql_num_rows($seleccion);
if($cont>0){
$cantidad_de_registros = 1;
while($row = mysql_fetch_array($seleccion)){
	// Codigo de un documento controlado
	$codigo_doc = $row['cod_doc'];
// (2) Cuenta la Revisiones Controladas del Documento
$sql2 = "SELECT * FROM inf_codigo WHERE cod_doc='$codigo_doc' AND (estatus=777 OR estatus=999 OR estatus=333 OR estatus=111)";
$seleccion2 = mysql_query($sql2);
$total_doc = mysql_num_rows($seleccion2);
//echo $codigo_doc . " - " . $total_doc . "<br><br>";
	echo'<tr class="formulario">
			<td class="numero">'. $cantidad_de_registros++ .'</td>
			<td class="unidad">'. $codigo_doc .'</td>
			<td class="unidad">'. $total_doc .'</td>
			<td class="titulo_documento">
				<form action="detalles_documento.php" method="post" name="detalles_documento">
					<input type="hidden" name="cod_doc" id="" value="'. $codigo_doc .'" />
					<input type="hidden" name="cantidad" id="" value="'. $total_doc .'" />
					<button type="submit" name="detalles" id="" value="detalles">Detalles Generales del Documento</button>
				</form>
			</td>
		</tr>';
} //---> (1) Fin
}
echo '</table></div>';

	
}else{
include ('conexion.php');
// (1) Seleccionando todos los documentos controlados 
$sql = "SELECT DISTINCT cod_doc FROM inf_codigo WHERE (estatus=777 OR estatus=999 OR estatus=333 OR estatus=111)";
$seleccion = mysql_query($sql);
$cantidad_de_registros = 1;
	while($row = mysql_fetch_array($seleccion)){
		// Codigo de un documento controlado
		$codigo_doc = $row[0];
// (2) Cuenta la Revisiones Controladas del Documento
$sql2 = "SELECT * FROM inf_codigo WHERE cod_doc='$codigo_doc' AND (estatus=777 OR estatus=999 OR estatus=333 OR estatus=111)";
$seleccion2 = mysql_query($sql2);
$total_doc = mysql_num_rows($seleccion2);
//echo $codigo_doc . " - " . $total_doc . "<br><br>";
	echo'<tr class="formulario">
			<td class="numero">'. $cantidad_de_registros++ .'</td>
			<td class="unidad">'. $codigo_doc .'</td>
			<td class="unidad">'. $total_doc .'</td>
			<td class="titulo_documento">
				<form action="detalles_documento.php" method="post" name="detalles_documento">
					<input type="hidden" name="cod_doc" id="" value="'. $codigo_doc .'" />
					<input type="hidden" name="cantidad" id="" value="'. $total_doc .'" />
					<button type="submit" name="detalles" id="" value="detalles">Detalles Generales del Documento</button>
				</form>
			</td>
		</tr>';
} //---> (1) Fin
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
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
$usuario_modificar = $_POST['usuario_modificar'];
isset($modif_cuenta_usuario);
if($usuario_modificar==""){
	echo '<html><head><meta http-equiv="REFRESH" content="0; url=buscar_usuario_modif.php"></head></html>';
	}else {
include("conexion.php");
$sql="SELECT usuario, nombre_usuario, cedula, cod_unidad, unidad, privilegio, id FROM usuario WHERE usuario='$usuario_modificar'";
$seleccion=mysql_query($sql,$conexion);
	while ($row = mysql_fetch_array($seleccion)){
			$nombre_completo=$row[1];
			$cedula=$row[2];
			$cod_unidad=$row[3];
			$unidad=$row[4];
			$tipo_privilegio=$row[5];		
			$id=$row[6];						
	}
mysql_close();
configuracion ($nombre_usuario, $privilegio);	
inf_codigo("inf_codigo","");

echo '<div class="ordenar">';

	// Menú de búsqueda por tipo de documento
	menu_tipo_documento("Módulos del Sistema","modulos_sistema");
	echo '<h1 class="tituto_tipo_documento">Modificar Usuario</h1>';	
	
echo '</div>';
echo '<div class="ordenar">';
	section();
echo '</div>';
// Tipo de Usuario
switch($tipo_privilegio){
	case 777: 
	$tipo_usuario="Administrador del Sistema";
	break;
					
	case 2:
	$tipo_usuario="Operador";
	break;
							
	case 1:
	$tipo_usuario = "Usuario de Consulta";
	break;
	}
	if($cedula==""){
		$cedula = "---------------";
		}

$class = 'style=" border: 1px solid #CCCCCC; text-align:left; background:#FFFFFF; color:#000000; width:72%;"';
$class_2 = 'style="width:27%;"';
// Formulario de Solicitud de Códigos
echo '<div class="ordenar">';
echo '
<table class="formulario_global" style="width:47%;">
<tr class="formulario">
<th class="formulario_2" style=" text-shadow: 0px 0px 2px #000000; width:99%; border: none;">DATOS DE LA CUENTA</th>
</tr>
<tr class="formulario">
<th class="formulario" id="titulo_documento" '. $class_2 .'>Usuario</th>
<th class="formulario" '. $class .'>'. $usuario_modificar .'</th>
<th class="formulario" id="titulo_documento" '. $class_2 .'>Nombre Completo</th>
<th class="formulario" '. $class .'>'. $nombre_completo .'</th>';
if($cedula!=""){
echo '
<th class="formulario" id="titulo_documento" '. $class_2 .'>Cédula de Identidad</th>
<th class="formulario" '. $class .' >'. $cedula .'</th>';
}
echo '
<th class="formulario" id="titulo_documento" '. $class_2 .'>Unidad</th>
<th class="formulario" '. $class .'>'. $unidad .'</th>
<th class="formulario" id="titulo_documento" '. $class_2 .'>Privilegio</th>
<th class="formulario" '. $class .'>'. $tipo_usuario .'</th>
</tr>
</table>
';

formulario_inicio ("Modificar Usuario","formulario","modif_cuenta","bd_acciones.php","POST","modificarUsuario(this);","","","","");
	
	text ("Nombre de Usuario","formulario","usuario","usuario",$usuario_modificar,"14","","","","","","Cambia el Nombre del Usuario");
	text ("Cédula","formulario","cedula","cedula",$cedula,"8","","","2","","","Cambia la Cédula de Indentidad del Usuario");
	text ("Nombre de Usuario","formulario","nombre","nombre",$nombre_completo,"","","","","","","Cambia el Nombre Completo del Usuario");	
	hidden("id",$id);
	$actual_unidad = "actual_u#" . $usuario_modificar; 
	select ("Unidad donde Labora","formulario","unidad","","",$actual_unidad,"","","Cambia la Unidad donde Labora el Usuario");
	$actual_privilegio = "actual_p#" . $usuario_modificar; 
	select ("Privilegio","formulario","privilegio","","",$actual_privilegio,"","","Cambia el Privilegio del Usuario en el Sistema");
	boton ("Modificar Usuario","formulario","modif_cuenta_usuario","modif_cuenta_usuario","","formulario_boton");
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
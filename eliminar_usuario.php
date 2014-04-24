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
<title>Eliminar Usuario</title>
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
$eliminar_usuario = $_POST['eliminar_usuario'];
isset($eliminar_usuario);
if($eliminar_usuario==""){
	echo '<html><head><meta http-equiv="REFRESH" content="0; url=buscar_usuario_eliminar.php"></head></html>';
	}else {
include("conexion.php");
$sql="SELECT usuario, nombre_usuario, cedula, cod_unidad, unidad, privilegio, id FROM usuario WHERE usuario='$eliminar_usuario'";
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
echo '<h1 class="tituto_tipo_documento">Eliminar Usuario</h1>';	
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
formulario_inicio ("Eliminar Usuario","formulario","","bd_acciones.php","POST","","","","","");
	text ("Nombre de Usuario","formulario","usuario_e","usuario_e",$eliminar_usuario,"","disabled","","","","","Muestra el Nombre de Usuario");
	hidden('usuario',$eliminar_usuario);
	text ("Cédula","formulario","cedula","cedula",$cedula,"8","disabled","","2","","","Muestra la Cédula de Identidad del Usuario");
	text ("Nombre de Usuario","formulario","nombre","nombre",$nombre_completo,"","disabled","","","","","Muestra el Nombre Completo del Usuario");	
	text ("Unidad","formulario","nombre","nombre",$unidad,"","disabled","","","","","Muestra la Unidad donde Labora el Usuario");	
	text ("Privilegio","formulario","nombre","nombre",$tipo_usuario,"","disabled","","","","","Muestra el Privilegio del Usuario en el Sistema");	
	boton ("Eliminar Usuario","formulario","eliminar_cuenta_usuario","eliminar_cuenta_usuario","","formulario_boton");
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
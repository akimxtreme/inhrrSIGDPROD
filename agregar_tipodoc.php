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
<title>Agregar Tipo de Documento</title>
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
echo '<h1 class="tituto_tipo_documento">Agregar Tipo de Documento</h1>';	
echo '</div>';


// Formulario de Solicitud de Códigos
echo '<div class="ordenar">';
	section();
?>

		
		


<?php

echo '</div>';
// Formulario de Solicitud de Códigos
echo '<div class="ordenar">';
formulario_inicio ("Agregar Tipo de Documento","formulario","agregar_tipodoc","bd_acciones.php","POST","agregarTipoDoc(this);","","","","");
	text ("Nombre del Tipo de Documento","formulario","nombre","nombre","","","","","","","","Ingrese el nombre Completo del Nuevo Tipo de Documento.<br>Ej: Descripciones");
	text ("Siglas del Tipo de Documento","formulario","sigla_doc","sigla_doc","","3","","","","","","Ingrese las Siglas del Nuevo Tipo de Documento, solo 3 (tres) caracteres.<br>Ej: DES");
	boton ("Agregar Tipo de Documento","formulario","agregar_tipodoc","agregar_tipodoc","","formulario_boton");
formulario_cierre ();
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
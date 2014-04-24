<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/plantilla.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="icon" href="imagenes/planta_vacunas.png"/>
<!-- InstanceBeginEditable name="doctitle" -->
<title>Código Asignado</title>
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
include "conexion.php";
// ACCION: CONSULTA LA TABLA inf_codigo
$codigo_asignado=$_GET['cod'];
isset($codigo_asignado);
if($codigo_asignado!=""){
		$sql="SELECT * FROM inf_codigo WHERE cod_doc='$codigo_asignado'";
		$seleccion=mysql_query($sql,$conexion);
		while ($row = mysql_fetch_array($seleccion)){
				$cod_doc=$row["cod_doc"];
				$tipo_doc=$row["tipo_doc"];
				$sigla_doc=$row["sigla_doc"];
				$rev=$row["rev"];
				$usuario_solic=$row["usuario_solic"];
				$titulo_doc=$row["titulo_doc"];
		}

echo '<div class="solicitud_codigo">';
echo '<span class="solicitud_codigo">';
	
		echo '<strong class="solicitud_codigo">TIPO DE DOCUMENTO: </strong>';
		echo '<p class="solicitud_codigo">' . $tipo_doc . '</p>';
		echo '<strong class="solicitud_codigo">SIGLAS DE LA UNIDAD: </strong>';
		echo '<p class="solicitud_codigo">' . $sigla_doc . '</p>';
		echo '<strong class="solicitud_codigo">Nº DE REVISION: </strong>';
		echo '<p class="solicitud_codigo">' . $rev . '</p>';
		echo '<strong class="solicitud_codigo">USUARIO SOLICITANTE: </strong>';
		echo '<p class="solicitud_codigo">' . $usuario_solic . '</p>';
		echo '<strong class="solicitud_codigo">TITULO DEL DOCUMENTO: </strong>';
		echo '<p class="solicitud_codigo">' . $titulo_doc . '</p>';
		
	
	
	echo '</span>';
	
	echo '<h2 class="solicitud_codigo">Usted debe elaborar su documento con el siguiente código que le ha asignado el sistema:</h2>';
	echo '<h1 class="solicitud_codigo">'. $cod_doc .'</h1>';
	
	
	echo '<a class="solicitud_codigo" href="index.php">Volver a Principal</a>';
	echo'</div>';
}else {
	echo '<html><head><meta http-equiv="REFRESH" content="0; url=index.php"></head></html>';
	}
// <><><><><><><><><><><><><><><><>><><><><><><><><><><><><><><><>><><><><><><><><><><><><><><>
?>
<!-- InstanceEndEditable --></div>
<div class="pie"></div>
</div>
</body>
<!-- InstanceEnd --></html>
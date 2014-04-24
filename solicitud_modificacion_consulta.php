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
<title>Sistema de Gestión Documental de la Planta Productora de Vacunas - Consulta de Solicitud de Modificación</title>
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
configuracion ($nombre_usuario, $privilegio);	
inf_codigo("inf_codigo","");

echo '<div class="ordenar">';
// Menú de búsqueda por tipo de documento
menu_tipo_documento("Módulos del Sistema","modulos_sistema");
echo '<h1 class="tituto_tipo_documento">Consulta Solicitud de Modificación</h1>';	
echo '</div>';
// Variables del Formulario
				# inicio - validaciones
$cod_doc=$_GET['cod_doc'];
$rev=$_GET['rev'];

// Acción: Consulta

// Selecciona el Nº de Registro y la Descripcion de la tabla solicitudes_mod
include ('conexion.php');
$sql = "SELECT nro_registro, descrip_mod FROM solicitudes_mod WHERE cod_doc='$cod_doc' AND rev='$rev'";
$seleccion=mysql_query($sql,$conexion);
				while ($row = mysql_fetch_array($seleccion)){
						$nro_registro=$row[0];
						$descrip_mod=$row[1];
				}
// Selecciona los datos de la tabla inf_codigo
$sql = "SELECT * FROM inf_codigo WHERE cod_doc='$cod_doc' AND rev='$rev'";
$seleccion=mysql_query($sql,$conexion);

				while ($row = mysql_fetch_array($seleccion)){
						$campo_1=$row["cod_doc"];
						$campo_2=$row["tipo_doc"];
						$campo_3=$row["sigla_doc"];
						$campo_5=$row["usuario_solic"];
						$campo_6=$row["titulo_doc"];
						$unidad= substr($campo_3,0, 2);
						$dependiente= substr($campo_3,2, 4);
				}

		echo '<div class="ordenar">';
		echo '<table class="formulario" align="center" style="margin: 0 0 0 10%;">';
		
		echo '<tr class="formulario">';
		echo '<th class="formulario_2" id="titulo_global">Solicitud de Modificación del Documento  '. $cod_doc.' (Rev: '. $rev .')</th>';
		echo '</tr>';
	
		echo '<tr class="formulario">';
		
		echo '<th class="formulario" id="titulo_global">Código del Documento</th>';
		echo '<th class="formulario_3" id="titulo_global">'. $cod_doc .'</th>';
		
		echo '<th class="formulario" id="titulo_global">Número de Revisión</th>';
		echo '<th class="formulario_3" id="titulo_global">'. $rev .'</th>';
		
		echo '<th class="formulario" id="titulo_global">Número de Registro</th>';
		echo '<th class="formulario_3" id="titulo_global">'. $nro_registro .'</th>';
		
		echo '<th class="formulario" id="titulo_global">Título del Documento</th>';
		echo '<th class="formulario_3" id="titulo_global" style="height:50px;">'. $campo_6 .'</th>';
		
		echo '<th class="formulario" id="titulo_global">Descripción</th>';
		//echo '<th class="formulario_3" id="titulo_global" style="height:100px;">'. $descrip_mod .'</th>';
		echo '<th class="formulario_3" id="titulo_global" style=" height:100px;">'. $descrip_mod .'</th>';
														
		echo '</table>';
		echo '</div>';


echo '<a style="margin: 10px;" class="formulario_boton" href="buscar_agregar_revision.php" title="Ir Agregar Revisión">Ir Agregar Revisión</a>';


}else{
	echo '<html><head><meta http-equiv="REFRESH" content="0; url=index.php"></head></html>';
	} 

?>

<!-- InstanceEndEditable --></div>
<div class="pie"></div>
</div>
</body>
<!-- InstanceEnd --></html>
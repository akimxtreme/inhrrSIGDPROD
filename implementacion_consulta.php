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
<title>Sistema de Gestión Documental de la Planta Productora de Vacunas - Consulta de Implementación de Documento</title>
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
echo '<h1 class="tituto_tipo_documento">Consulta Implementación del Documento</h1>';	
echo '</div>';
// Variables del Formulario
				# inicio - validaciones
$cod_doc=$_GET['cod_doc'];
$rev=$_GET['rev'];

// Acción: Consulta

// Selecciona los Datos Basícos del Documento mediante la variable $cod_doc
include ('conexion.php');
$sql = "SELECT nro_registro FROM implementacion_doc WHERE cod_doc='$cod_doc' AND rev='$rev'";
$seleccion=mysql_query($sql,$conexion);

				while ($row = mysql_fetch_array($seleccion)){
						$nro_registro=$row["nro_registro"];
				}
$sql = "SELECT * FROM inf_codigo WHERE cod_doc='$cod_doc' AND rev='$rev'";
$seleccion=mysql_query($sql,$conexion);

				while ($row = mysql_fetch_array($seleccion)){
						$campo_1=$row["cod_doc"];
						$campo_2=$row["tipo_doc"];
						$campo_3=$row["sigla_doc"];
						$campo_4=$row["rev"];
						$campo_5=$row["usuario_solic"];
						$campo_6=$row["titulo_doc"];
						$unidad= substr($campo_3,0, 2);
						$dependiente= substr($campo_3,2, 4);
				}









// Formulario de Solicitud de Códigos
/*
echo '<div class="ordenar">';
echo '<h1 class="en_desarrollo">Módulo en Desarrollo</h1>';

echo '</div>';
*/
formulario_inicio ("Consulta Implementación del Documento","formulario","recepcion_documentos","bd_acciones.php","POST","evaluacion(this);","multipart/form-data","","","");
subtitulos("Datos Básicos del Documento","");
text ("Código del Documento","formulario","cod_doc","cod_doc",$campo_1,"","disabled","","","","","Muestra el Código del Documento<br>Ej: ".$campo_1);
hidden('cod_doc_h',$campo_1);
text ("Número de Registro","formulario","nro_registro","nro_registro",$nro_registro,"","disabled","","","","","Muestra  el Número de Registro de Implementación");
text ("Número de Revisión","formulario","rev","rev",$campo_4,"","disabled","","","","","Muestra el Número de Revisión del Documento");
hidden('rev_h',$campo_4);
text ("Tipo de Documento","formulario","tipo_doc","tipo_doc",$campo_2,"","disabled","","","","","");
hidden('tipo_doc_h',$campo_2);
textarea ("Título del documento","formulario_textarea","titulo_doc","titulo_doc",$campo_6,"disabled","","","formulario_textarea","","obligatorio","Muestra el Título del Documento");
hidden('titulo_doc_H',$campo_6);

echo '<div class="ordenar">';
echo '<table class="formulario" align="center" style="margin: 0 0 0 25%;">';
echo '<tr class="formulario">
<th class="formulario_2" id="titulo_documento">Constancia de Implementación del Documento<br> '. $cod_doc.' (Rev: '. $campo_4 .')</th>
</tr>';
	// Consulta para Tomar el nombre de cada unidad
	include ('conexion.php');
	//$sql2 = "SELECT sigla_unid, nombre_completo, fecha FROM constancia_implementacion WHERE cod_doc='$cod_doc' AND rev='$campo_4'";
	$sql2 = "SELECT unidad FROM copias WHERE cod_doc='$cod_doc' AND rev='$campo_4'";
	$seleccion2=mysql_query($sql2,$conexion);
	$cont=mysql_num_rows($seleccion2);
	while ($row2 = mysql_fetch_array($seleccion2)){
	$variable =  array(
						$row2[0]
						  );
						  
			$sql3 = "SELECT denominacion FROM unidades WHERE sigla_unid='". $variable[0] ."'";
			$seleccion3=mysql_query($sql3,$conexion);
			while ($row3 = mysql_fetch_array($seleccion3)){
				$variable3 =  array(
						$row3[0]
						  );
						  
						  echo '
							<tr class="formulario">
							<th class="formulario" id="titulo_documento">'. $variable3[0] .'</th>
							
							<th class="formulario" id="recibir">Fecha</th>
							</tr>';
							$sql4 = "SELECT nombre_completo, fecha FROM constancia_implementacion WHERE cod_doc='$cod_doc' AND rev='$campo_4' AND sigla_unid='". $variable[0] ."'";
							$seleccion4=mysql_query($sql4,$conexion);
							while ($row4 = mysql_fetch_array($seleccion4)){
								$variable4 =  array(
													$row4[0],
													$row4[1]
						 							);
									echo '<tr class="formulario">';
									echo '<td class="titulo_documento">'. $variable4[0] .'</td>';
									echo '<td class="recibir">'. $variable4[1] .'</td>';
									echo '</tr>';
													
							}
				}
	}
	
		
echo '</table></div>';


formulario_cierre ();

}else{
	echo '<html><head><meta http-equiv="REFRESH" content="0; url=index.php"></head></html>';
	} 

?>





<!-- InstanceEndEditable --></div>
<div class="pie"></div>
</div>
</body>
<!-- InstanceEnd --></html>
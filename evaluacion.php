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
<title>Sistema de Gestión Documental de la Planta Productora de Vacunas - Formulario de Evaluación</title>
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
echo '<h1 class="tituto_tipo_documento">Control de Documentos</h1>';	
echo '</div>';
// Variables del Formulario
$evaluar=$_POST['evaluar'];
isset($evaluar);
if($evaluar == 'evaluar'){
				# inicio - validaciones
$cod_doc=$_POST['cod_doc'];
$rev=$_POST['rev'];


// Acción: Consulta

// Selecciona los Datos Basícos del Documento mediante la variable $cod_doc
include ('conexion.php');
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

// Formulario de Evaluación
formulario_inicio ("Formulario de Evaluación","formulario","evaluacion_documentos","bd_acciones.php","POST","evaluacion(this);","multipart/form-data","","","");
subtitulos("Datos Básicos del Documento","");
text ("Código del Documento","formulario","cod_doc","cod_doc",$campo_1,"","disabled","","","","","Muestra el Código del Documento<br>Ej: ".$campo_1);
hidden('cod_doc_h',$campo_1);
text ("Número de Revisión","formulario","rev","rev",$campo_4,"","disabled","","","","","Muestra el Número de Revisión del Documento");
hidden('rev_h',$campo_4);
//text ("Tipo de Documento","formulario","tipo_doc","tipo_doc",$campo_2,"","disabled","","","","","");
hidden('tipo_doc_h',$campo_2);
textarea ("Título del documento","formulario_textarea","titulo_doc","titulo_doc",$campo_6,"disabled","","","formulario_textarea","","obligatorio","Muestra el Título del Documento");
hidden('titulo_doc_H',$campo_6);

div_multiple_inicio("Número de Registro","formulario","formulario_multiple","","","","Seleccione el año del Número de Registro<br>Ej: 2013");
		select ("","formulario_multiple","num_registro_unidad","unidades_referencia","","unidades_do","","","");
		select ("","formulario_multiple","num_registro_anio","unidades_anio","","unidades_anio","","","");
		//text ("","formulario_multiple","num_registro_numero","unidades_numero","","3","","","2","","");
div_multiple_cierre();

div_multiple_inicio("Archivo (.pdf, .xls, .xlsx, .doc, .docx, .odt, .ods)","formulario","formulario_sub","div_archivo","","","Ingrese la ruta de ubicación del Documento.<br>Formatos Compatibles: (.pdf, .xls, .xlsx, .doc, .docx, .odt, .ods)");
	archivo("", "archivo", "archivo", "archivo", "", "","");
div_multiple_cierre();

subtitulos("Criterios a Evaluar","");


echo '<div class="ordenar">
		
<table class="formulario">
<tr class="formulario">
<th class="formulario" id="codigo">Criterios</th>
<th class="formulario" id="criterio">Título</th>
<th class="formulario" id="recibir">Cumple</th>
<th class="formulario" id="eliminar">No Cumple</th>
</tr>';
include ('conexion.php');
$sql = 'SELECT * FROM cat_crit_evaluacion';
$seleccion=mysql_query($sql,$conexion);
$cantidad_de_registros = 1;
	while ($row = mysql_fetch_array($seleccion)){
		$campo_1=$row["id"];
		$campo_2=$row["titulo"];
		$campo_3=$row["detalles"];
		$js_si="'criterio_si".$campo_1."'";
		$js_no="'criterio_no".$campo_1."'";
		$js2_si="'cumplimiento_si".$campo_1."'";
		$js2_no="'cumplimiento_no".$campo_1."'";
					
		$cantidad_de_registros++;
		echo'<tr class="formulario">
		<td class="codigo">'. "Criterio " . $campo_1 .'</td>
		<td class="criterio" id="criterio'. $campo_1 .'">'. $campo_2 .'<div class="criterio" id="div_criterio'. $campo_1 .'"><h4 class="criterio">Criterio'. $campo_1 .'</h4>'. $campo_3 .'</div></td>
		<td class="recibir" id="criterio_si'. $campo_1 .'"><input type="radio" name="cumplimiento'. $campo_1 .'"  id="cumplimiento_si'. $campo_1 .'" onclick="criterio('. $js_si .','. $js_no .','. $js2_si .','. $js2_no .');" value="si_cumple" title="cumplimiento'. $campo_1 .'" /></td>
		<td class="eliminar" id="criterio_no'. $campo_1 .'"><input type="radio"  name="cumplimiento'. $campo_1  .'" id="cumplimiento_no'. $campo_1 .'" onclick="criterio('. $js_si .','. $js_no .','. $js2_si .','. $js2_no .');" value="no_cumple" title="cumplimiento'. $campo_1 .'" /></td>
			</tr>';
		}
echo '</table></div>';


boton ("Guardar Evaluación","formulario","guardar_evaluacion","guardar_evaluacion","","formulario_boton");


formulario_cierre ();
}else {echo '<html><head><meta http-equiv="REFRESH" content="0; url=buscar_evaluacion.php"></head></html>';}
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
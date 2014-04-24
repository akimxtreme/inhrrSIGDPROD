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
				# inicio - validaciones
$cod_doc=$_GET['cod_doc'];
$rev=$_GET['rev'];

// Acción: Consulta

// Selecciona los Datos Basícos del Documento mediante la variable $cod_doc
include ('conexion.php');
$sql = "SELECT nro_registro FROM evaluacion_doc WHERE cod_doc='$cod_doc' AND rev='$rev'";
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
						$campo_7=$row["estatus"];
						$unidad= substr($campo_3,0, 2);
						$dependiente= substr($campo_3,2, 4);
				}

formulario_inicio ("Formulario de Evaluación","formulario","recepcion_documentos","bd_acciones.php","POST","evaluacion(this);","multipart/form-data","","","");
subtitulos("Datos Básicos del Documento","");
text ("Código del Documento","formulario","cod_doc","cod_doc",$campo_1,"","disabled","","","","","Muestra el Código del Documento<br>Ej: ".$campo_1);
hidden('cod_doc_h',$campo_1);
text ("Número de Registro","formulario","nro_registro","nro_registro",$nro_registro,"","disabled","","","","","Muestra el Número de Registro de la Evaluación");
text ("Número de Revisión","formulario","rev","rev",$campo_4,"","disabled","","","","","Muestra el Número de Revisión del Documento");
hidden('rev_h',$campo_4);
text ("Tipo de Documento","formulario","tipo_doc","tipo_doc",$campo_2,"","disabled","","","","","Muestra las Siglas del Tipo de Documento");
hidden('tipo_doc_h',$campo_2);
textarea ("Título del documento","formulario_textarea","titulo_doc","titulo_doc",$campo_6,"disabled","","","formulario_textarea","","obligatorio","Muestra el Titulo del Documento");
hidden('titulo_doc_H',$campo_6);

echo '<div class="ordenar">
		
<table class="formulario" align="center" style="margin: 0 0 0 35%;">
<tr class="formulario">
<th class="formulario" id="codigo">Criterios</th>

<th class="formulario" id="recibir">Cumple</th>
</tr>';
include ('conexion.php');

		$sql2 = "SELECT crit1,crit2,crit3,crit4,crit5,crit6,crit7,crit8 FROM evaluacion_doc WHERE cod_doc='$cod_doc'";
		$seleccion2=mysql_query($sql2,$conexion);
		while ($row2 = mysql_fetch_array($seleccion2)){
		$criterio =  array(
						$row2['crit1'],
						$row2['crit2'],
						$row2['crit3'],
						$row2['crit4'],
						$row2['crit5'],
						$row2['crit6'],
						$row2['crit7'],
						$row2['crit8']
						  );
		}
		
		for($i=0;$i<=7;$i++){
			$j = $i+1;
			echo'<tr class="formulario">';
				echo'<td class="codigo">Criterio '. $j .'</td>';
				if($criterio[$i]=="si"){
					echo'<td class="recibir" style="color:#FFFFFF;font-weight:bold;text-transform:uppercase;background:#66CC33;">';
					echo $criterio[$i];
					echo '</td>';
				}else{
					echo'<td class="recibir" style="color:#FFFFFF;font-weight:bold;text-transform:uppercase;background:red;">';
					echo $criterio[$i];
					echo '</td>';
					}
				
		
			
			echo '	
		</tr>';
		}
			
		
			
		
		
			
			
		
echo '</table></div>';

//boton ("Guardar Evaluación","formulario","guardar_evaluacion","guardar_evaluacion","","formulario_boton");
if($campo_7==3){
echo '<a style="margin:10px;" class="formulario_boton" href="buscar_distribucion.php" title="Ir a Distribución">Ir a Distribución</a>';
echo '<a style="margin: 10px;" class="formulario_boton" href="reportes/control_doc.php?cod_doc='. $cod_doc .'&rev='. $rev.'" title="Imprimir Control" target="_blank">Imprimir Control</a>';
echo '<a style="margin: 10px;" class="formulario_boton" href="reportes/control_doc_etiqueta.php?cod_doc='. $cod_doc .'&rev='. $rev.'" title="Imprimir Etiqueta" target="_blank">Imprimir Etiqueta</a>';
}else{
echo '<a style="margin:10px;" class="formulario_boton" href="buscar_devolucion.php" title="Ir a Distribución">Ir a Devolución</a>';	
	}


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
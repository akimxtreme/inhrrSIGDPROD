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
<title>Sistema de Gestión Documental de la Planta Productora de Vacunas - Consulta de Devolución del Documento</title>
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
echo '<h1 class="tituto_tipo_documento">Consulta Devolución del Documento</h1>';	
echo '</div>';
// Variables del Formulario
				# inicio - validaciones
$cod_doc=$_GET['cod_doc'];
$rev=$_GET['rev'];

// Acción: Consulta

// Selecciona los Datos Basícos del Documento mediante la variable $cod_doc
include ('conexion.php');
$sql = "SELECT nro_registro, fecha_recep, nro_copia, observaciones FROM devolucion_doc WHERE cod_doc='$cod_doc' AND rev='$rev'";
$seleccion=mysql_query($sql,$conexion);

				while ($row = mysql_fetch_array($seleccion)){
						$nro_registro=$row["nro_registro"];
						$fecha_recep=$row["fecha_recep"];
						$nro_copia=$row["nro_copia"];
						$observaciones=$row["observaciones"];
						
						 	
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


formulario_inicio ("Consulta Devolución del Documento","formulario","recepcion_documentos","bd_acciones.php","POST","evaluacion(this);","multipart/form-data","","","");
subtitulos("Datos Básicos del Documento","");
text ("Código del Documento","formulario","cod_doc","cod_doc",$campo_1,"","disabled","","","","","Muestra el Código del Documento<br>Ej: ".$campo_1);
hidden('cod_doc_h',$campo_1);
text ("Número de Registro","formulario","nro_registro","nro_registro",$nro_registro,"","disabled","","","","","Muestra el Número de Registro de la Devolución");
text ("Número de Revisión","formulario","rev","rev",$campo_4,"","disabled","","","","","Muestra el Número de Revisión del Documento");
hidden('rev_h',$campo_4);
text ("Tipo de Documento","formulario","tipo_doc","tipo_doc",$campo_2,"","disabled","","","","","");
text ("Fecha de Recepción","formulario","tipo_doc","tipo_doc",$fecha_recep,"","disabled","","","","","Muestra la Fecha de Recepción del Documento");
text ("Número de Cópias","formulario","tipo_doc","tipo_doc",$nro_copia,"","disabled","","","","","Muestra la Cantidad de Copias recibidas por la unidad solicitante.");
hidden('tipo_doc_h',$campo_2);

textarea ("Título del documento","formulario_textarea","titulo_doc","titulo_doc",$campo_6,"disabled","","","formulario_textarea","","obligatorio","Muestra el Título del Documento");
hidden('titulo_doc_H',$campo_6);
if($observaciones!=""){
	textarea ("Observaciones","formulario_textarea","observaciones","observaciones",$observaciones,"disabled","","","formulario_textarea","","","Muestra Información Adicional referente a la Devolución.");	
	}
subtitulos("Motivo de la Devolución","");
	echo '<div class="ordenar">';
	echo'<table class="formulario">
			<tr class="formulario">
			<th class="formulario" id="numero">nº</th>
			<th class="formulario" id="unidad">Criterios No Cumplidos</th>
			<th class="formulario" id="obs_documento">Descripción</th>
			</tr>';
	
	function detalles($num){
		include ('conexion.php');
		$num = $num + 1; 
		$sql = "SELECT detalles FROM cat_crit_evaluacion WHERE id=". $num;
		$seleccion=mysql_query($sql,$conexion);
		$cont=mysql_num_rows($seleccion);
			
			while ($row = mysql_fetch_array($seleccion)){
				$obs = array(
							$row[0],
							);
				}
		echo '<td style="text-align:justify; height:85px;" class="obs_documento">'. $obs[0] .'</td>';
		
		}
	
	
	
				
	$sql = "SELECT crit1,crit2,crit3,crit4,crit5,crit6,crit7,crit8 FROM evaluacion_doc WHERE cod_doc='$cod_doc' AND rev='$rev'";
	$seleccion=mysql_query($sql,$conexion);
	$cont=mysql_num_rows($seleccion);
	
	while ($row = mysql_fetch_array($seleccion)){
			$campos = array(
						$row[0],
						$row[1],
						$row[2],
						$row[3],
						$row[4],
						$row[5],
						$row[6],
						$row[7]
							);
				}
				$contador = 1;
				for($i=0;$i<=7;$i++){
					
					if ($campos[$i]=="no"){
						echo '<tr class="formulario">';
							echo '<td  style="height:85px;" class="numero">'. $contador++ .'</td>';
							$j = $i + 1;
							echo '<td style=" font-weight:bold; height:85px;" class="unidad">Criterio ' . $j . '</td>';
							detalles($i);
						echo '</tr>';
						}
					
					
					}
								
			
			
			
		echo '</table></div>';	
	
echo '<a style="margin: 10px;" class="formulario_boton" href="reportes/devolucion_doc.php?cod_doc='. $cod_doc .'&rev='. $rev .'" title="Imprimir Control" target="_blank">Imprimir Devolucion</a>';
//echo '<a style="margin: 10px;" class="formulario_boton" href="#" title="Imprimir Etiqueta">Imprimir Etiqueta</a>';
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
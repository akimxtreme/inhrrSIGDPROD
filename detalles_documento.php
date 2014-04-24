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
<title>Sistema de Gestión Documental de la Planta Productora de Vacunas - Detalles Generales del Documento</title>
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
echo '<h1 class="tituto_tipo_documento">Detalles Generales del Documento</h1>';	

echo '</div>';
$codigo_documento = $_POST['cod_doc'];
$cantidad = $_POST['cantidad'];
/*
echo $codigo_documento . " - ";
echo $cantidad;
*/
echo '<div class="ordenar">';
	echo '<div class="detalles">';
	/*
	Función Información que maqueta el Contenido del Documento a Consultar
	*/
	function informacion($titulo, $contenido,$tipo){
		// $titulo = Se refiere al Titulo EJ: Fecha de Emisión
		// $contenido = EJ: 2013-06-09
		// $tipo = Verifica la variable $contenido es un array
		switch($tipo){
			case "h":
			echo '<h1>'. $titulo .':</h1>';
			echo '<p>'. $contenido .'</p>';
			break;
			case "adjunto":
			echo '<p><strong>'. $titulo .': </strong><a href="'. $contenido .'" target="_blank" title="Descargar Documento Controlado">Descargar Archivo &raquo</a></p>';
			break;
			case "rev_anteriores":
			$contador_rev = $contenido - 1;
			if($contador_rev!=0){
				echo '<p><strong>Revisiones Anteriores: </strong>';
				
					for($i=0;$i<$contador_rev;$i++){
						echo '<a href="detalles_doc_anteriores.php?cod_anterior='. $titulo .'&rev_anterior='. $i .'" target="_blank" title="Consultar Detalles">Rev'.$i.' &raquo;</a>  ';
						}
				echo '</p>';
				}
			
			break;
			default:
			if($contenido!=""){
				echo '<p><strong>'. $titulo .': </strong> '. $contenido .'</p>';
			}
		}
		
	}
	/*
	Función que muestra los detalles del Usuario
	*/
	function datos_usuario($usuario){
		include('conexion.php');
		$sql = "SELECT nombre_usuario FROM usuario WHERE usuario='$usuario'";
		$seleccion = mysql_query($sql);
		while($row=mysql_fetch_array($seleccion)){
			$nombreUsuario = $row[0];
			}		
		return $nombreUsuario;
	}
	/*
	Funcion para los Títulos
	*/
	function titulos_secciones($titulo,$tipo){
		if($titulo!="" || $tipo!=""){
		echo '<'. $tipo .'>'. $titulo .'</'. $tipo .'>';
		}
		}
	/*
	Consulta los Detalles Generales del Documento
	*/
	
	echo '<div>';
	titulos_secciones("DETALLES GENERALES DEL DOCUMENTO","h1");
	informacion("Código del Documento",$codigo_documento,"");
	informacion("Cantidad de Revisiones Controladas",$cantidad,"");
	informacion($codigo_documento,$cantidad,"rev_anteriores");
		
	$sql = "SELECT tipo_doc, sigla_doc, usuario_solic, titulo_doc, fecha_ing FROM inf_codigo WHERE cod_doc='$codigo_documento' AND rev='0'";
	$seleccion = mysql_query($sql);
		while($row=mysql_fetch_array($seleccion)){
			$tipo_doc = $row['tipo_doc'];
			$sigla_doc = $row['sigla_doc'];
			$usuario_solic = $row['usuario_solic'];
			$titulo_doc = $row['titulo_doc'];
			$fecha_ing = $row['fecha_ing'];
			}
		
	/*
	Denominación del Tipo de Documento
	*/
	$sql = "SELECT nombre FROM cat_tipodoc WHERE sigla_doc='$tipo_doc'";
	$seleccion = mysql_query($sql);
		while($row=mysql_fetch_array($seleccion)){
			$denominacion = $row[0];
		}
	informacion("Código Solicitado por",$usuario_solic,"");
	informacion("Fecha de la Solicitud",$fecha_ing,"");
	informacion("Tipo de Documento",$denominacion,"");
	informacion("Siglas del Tipo de Documento",$tipo_doc,"");
		
	/*
	Consulta la Condición del Documento
	*/
	$sql = "SELECT condicion FROM rec_doc WHERE cod_doc='$codigo_documento' AND rev='0'";
	$seleccion = mysql_query($sql);
		while($row=mysql_fetch_array($seleccion)){
			$condicion = $row[0];
			}
	informacion("Condición",$condicion,"");
	/*
	Consulta la Unidades con Acceso a un Documento Confidencial
	*/
	if($condicion!="Público"){
		echo '<p><strong>Unidad(es) con Acceso al Documento:</strong>';
		$sql = "SELECT denominacion, sigla_unid FROM unidades_confidencial WHERE cod_doc='$codigo_documento'";
		$seleccion = mysql_query($sql);
			while($row=mysql_fetch_array($seleccion)){
				$unidad_conf = $row[0];
				$sigla_unidad_conf = $row[1];
				echo "($sigla_unidad_conf) $unidad_conf. ";
				}
		echo '</p>';
	}
	echo '</div>';
	
	echo '<div>';
	titulos_secciones("ULTIMA REVISIÓN CONTROLADA","h1");
	$ultima_rev = $cantidad - 1;
	echo '<p><strong>Nº de Revisión: </strong> '. $ultima_rev .'</p>';
	
	$sql="SELECT 
					   inf_codigo.cod_doc, 
					   inf_codigo.tipo_doc, 
					   inf_codigo.sigla_doc, 
					   inf_codigo.usuario_solic,
					   inf_codigo.titulo_doc,
					   inf_codigo.fecha_ing,
					   
					   rec_doc.fecha_emision, 
					   rec_doc.condicion, 
					   rec_doc.memo_unidad, 
					   rec_doc.memo_correlativo,
					   rec_doc.memo_fecha,
					   rec_doc.fecha_recep,
					   rec_doc.rec_archivo,
					   rec_doc.observaciones,
					   rec_doc.usuario_ing,
					   rec_doc.fecha_ing,
					   
					   evaluacion_doc.nro_registro,
					   evaluacion_doc.crit1,
					   evaluacion_doc.crit2,
					   evaluacion_doc.crit3,
					   evaluacion_doc.crit4,
					   evaluacion_doc.crit5,
					   evaluacion_doc.crit6,
					   evaluacion_doc.crit7,
					   evaluacion_doc.crit8,
					   evaluacion_doc.tipo_adjunto,
					   evaluacion_doc.ruta_adjunto,
					   evaluacion_doc.fecha_eval,
					   evaluacion_doc.usuario_ing,
					   evaluacion_doc.fecha_ing,
					   
					   distribucion_doc.nro_registro,
					   distribucion_doc.fecha_emision,
					   distribucion_doc.nro_copias,
					   distribucion_doc.usuario_ing,
					   distribucion_doc.fecha_ing,
					   
					   implementacion_doc.nro_registro,
					   implementacion_doc.fecha,
					   implementacion_doc.usuario_ing,
					   implementacion_doc.fecha_ing
				FROM inf_codigo 
				INNER JOIN rec_doc
				INNER JOIN evaluacion_doc
				INNER JOIN distribucion_doc
				INNER JOIN implementacion_doc
				ON 
				   (inf_codigo.rev='$ultima_rev' AND 
				   rec_doc.rev='$ultima_rev' AND 
				   evaluacion_doc.rev='$ultima_rev' AND 
				   distribucion_doc.rev='$ultima_rev' AND 
				   implementacion_doc.rev='$ultima_rev' 
				   )
				   AND 
				   
				   (inf_codigo.cod_doc='$codigo_documento' AND 
				   rec_doc.cod_doc='$codigo_documento' AND 
				   evaluacion_doc.cod_doc='$codigo_documento' AND 
				   distribucion_doc.cod_doc='$codigo_documento' AND 
				   implementacion_doc.cod_doc='$codigo_documento' 
				   )
				   ";
	$seleccion = mysql_query($sql);
			while($row=mysql_fetch_array($seleccion)){
				
				$inf_codigoCod_doc = $row[0];
				$inf_codigoTipo_doc = $row[1];
				$inf_codigoSigla_doc = $row[2];
				$inf_codigoUsuario_solic = $row[3];
				$inf_codigoTitulo_doc = $row[4];
				$inf_codigoFecha_ing = $row[5];
				
				$rec_docFecha_emision = $row[6];
				$rec_docCondicion = $row[7];
				$rec_docMemo_unidad = $row[8];
				$rec_docMemo_correlativo = $row[9];
				$rec_docMemo_fecha = $row[10];
				$rec_docFecha_recep = $row[11];
				$rec_docRec_archivo = $row[12];
				$rec_docObservaciones = $row[13];
				$rec_docUsuario_ing = $row[14];
				$rec_docFecha_ing = $row[15];
				
				$evaluacion_docNro_registro = $row[16];
				$evaluacion_docCrit1 = $row[17];
				$evaluacion_docCrit2 = $row[18];
				$evaluacion_docCrit3 = $row[19];
				$evaluacion_docCrit4 = $row[20];
				$evaluacion_docCrit5 = $row[21];
				$evaluacion_docCrit6 = $row[22];
				$evaluacion_docCrit7 = $row[23];
				$evaluacion_docCrit8 = $row[24];
				$evaluacion_docTipo_adjunto = $row[25];
				$evaluacion_docRuta_adjunto = $row[26];
				$evaluacion_docFecha_eval = $row[27];
				$evaluacion_docUsuario_ing = $row[28];
				$evaluacion_docFecha_ing = $row[29];
				
				$distribucion_docNro_registro = $row[30];
				$distribucion_docFecha_emision = $row[31];
				$distribucion_docNro_copias = $row[32];
				$distribucion_docUsuario_ing = $row[33];
				$distribucion_docFecha_ing = $row[34];
				
				$implementacion_docNro_registro = $row[35];
				$implementacion_docFecha = $row[36];
				$implementacion_docUsuario_ing = $row[37];
				$implementacion_docFecha_ing = $row[38];
				
					   
				//$var = $row[];
								
				}
	
	informacion("Solicitado por",$inf_codigoUsuario_solic,"");
	informacion("Título del Documento",$inf_codigoTitulo_doc,"");
	informacion("Fecha de Ingreso",$inf_codigoFecha_ing,"");
	titulos_secciones("Recepción del Documento","h5");
	informacion("Fecha de Emisión",$rec_docFecha_emision,"");
	informacion("Fecha de Recepción",$rec_docFecha_recep,"");
	// variable memo
	$memo = $rec_docMemo_unidad .'-'. $rec_docMemo_correlativo .'-'. $rec_docMemo_fecha;
	informacion("Nº de Memorándum",$memo,"");
	informacion("Recopilación del Archivo",$rec_docRec_archivo,"");
	informacion("Observaciones",$rec_docObservaciones,"");
	
		echo '<div class="historico">';
			$usuarioNombre = $rec_docUsuario_ing . " (" . datos_usuario($rec_docUsuario_ing) . ") ";
			informacion("Información ingresada por",$usuarioNombre,"h");
			informacion("Fecha de Ingreso",$rec_docFecha_ing,"h");
			
		echo '</div>';
	titulos_secciones("Evaluación del Documento","h5");
	informacion("N° de Registro",$evaluacion_docNro_registro,"");
	$link = $evaluacion_docRuta_adjunto . $evaluacion_docTipo_adjunto;
	informacion("Archivo Controlado",$link,"adjunto");
	informacion("Fecha de la Evaluación",$evaluacion_docFecha_eval,"");
		echo '<div class="historico">';
			$usuarioNombre = $evaluacion_docUsuario_ing . " (" . datos_usuario($evaluacion_docUsuario_ing) . ") ";
			informacion("Información ingresada por",$usuarioNombre,"h");
			informacion("Fecha de Ingreso",$evaluacion_docFecha_ing,"h");
		echo '</div>';
	titulos_secciones("Distribución del Documento","h5");	
	informacion("N° de Registro",$distribucion_docNro_registro,"");
	informacion("Fecha de Emisión",$distribucion_docFecha_emision,"");
	informacion("Cantidad de Copias",$distribucion_docNro_copias,"");
		echo '<div class="historico">';
			$usuarioNombre = $distribucion_docUsuario_ing . " (" . datos_usuario($distribucion_docUsuario_ing) . ") ";
			informacion("Información ingresada por",$usuarioNombre,"h");
			informacion("Fecha de Ingreso",$distribucion_docFecha_ing,"h");
		echo '</div>';
	titulos_secciones("Unidades con Copias Controladas","h5");
	$sql0 = "SELECT DISTINCT unidad FROM codigo_unid_distribucion_doc WHERE cod_doc='$codigo_documento' AND rev='$ultima_rev'";
	$seleccion0 = mysql_query($sql0);
		while($row0=mysql_fetch_array($seleccion0)){
			$siglas_unid_cont = $row0[0];
			
			$sql1 = "SELECT denominacion FROM unidades WHERE sigla_unid='$siglas_unid_cont'";
			$seleccion1 = mysql_query($sql1);
				while($row1=mysql_fetch_array($seleccion1)){
					$denominacion_unid = $row1[0];
				}
			
			informacion($siglas_unid_cont,$denominacion_unid,"");
		}
	titulos_secciones("Implementación del Documento","h5");	
	informacion("N° de Registro",$distribucion_docNro_registro,"");
	informacion("Fecha de la Implementación",$implementacion_docFecha,"");
		echo '<div class="historico">';
			$usuarioNombre = $implementacion_docUsuario_ing . " (" . datos_usuario($implementacion_docUsuario_ing) . ") ";
			informacion("Información ingresada por",$usuarioNombre,"h");
			informacion("Fecha de Ingreso",$implementacion_docFecha_ing,"h");
		echo '</div>';
		
	if($ultima_rev!=0){
		$rev_anterior = $ultima_rev -1;
	titulos_secciones("Solicitud de Modificación","h5");
	$sql = "SELECT nro_registro, descrip_mod FROM solicitudes_mod WHERE cod_doc='$codigo_documento' AND rev='$rev_anterior'";
	$seleccion = mysql_query($sql);
	while($row = mysql_fetch_array($seleccion)){
		$sol_nro_registro = $row[0];
		$sol_descrip_mod = $row[1];
	}
	informacion("N° de Registro",$sol_nro_registro,"");
	informacion("Descripción",$sol_descrip_mod,"");
	}
	echo '</div>';
	
	
	echo '</div>';
	
	
echo '</div>';



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
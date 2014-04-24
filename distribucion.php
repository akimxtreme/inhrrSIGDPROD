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
<title>Distribución</title>
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
echo '<h1 class="tituto_tipo_documento">Distribución</h1>';	
echo '</div>';
// Variables del Formulario
$recibir=$_POST['recibir'];
isset($recibir);
if($recibir == 'recibir'){
				# inicio - validaciones
$cod_doc=$_POST['cod_doc'];
$rev=$_POST['rev'];



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
						
						// Tipo de documento	
						$sql_2 = "SELECT * FROM cat_tipodoc WHERE sigla_doc='$campo_2'";
						$seleccion_2=mysql_query($sql_2,$conexion);
						while ($row_2 = mysql_fetch_array($seleccion_2)){
							$tipo_documento=$row_2["nombre"];
						}
						// Nombre Unidad	
						$sql_2 = "SELECT * FROM unidades WHERE sigla_unid='$unidad'";
						$seleccion_2=mysql_query($sql_2,$conexion);
						while ($row_2 = mysql_fetch_array($seleccion_2)){
							$unidad_adscripcion=$row_2["denominacion"];
						}
						// Nombr Unidad perteneciente
						$sql_3 = "SELECT * FROM unidades WHERE sigla_unid = '$dependiente'";
						$seleccion_3=mysql_query($sql_3,$conexion);
						while ($row_3 = mysql_fetch_array($seleccion_3)){
							$pertenece=$row_3["denominacion"];
						}
				}



// Formulario de Solicitud de Códigos
echo '<div class="ordenar">';
formulario_inicio ("Formulario de Distribución","formulario","distribucion","bd_acciones.php","POST","f_distribucion(this);","","","","");
	//pestania("Recepción","formulario","recepcion(this);");
	subtitulos("Datos Básicos del Documento","");
	text ("Código del Documento","formulario","cod_doc","cod_doc",$campo_1,"","disabled","","","","","Muestra el Código del Documento<br>Ej: ".$campo_1);
	hidden('cod_doc_h',$campo_1);
	$campo_2 = $campo_2 . " (" . $tipo_documento . ")";
	text ("Tipo de Documento","formulario","tipo_doc","tipo_doc",$campo_2,"","disabled","","","","","Muestra las Siglas y la Denominación Tipo del Documento");
	hidden('tipo_doc_h',$campo_2);
	$unidad = $unidad . " (" . $unidad_adscripcion . ")";
	text ("Unidad de Adscripción","formulario","unidad_adscripcion","unidad_adscripcion",$unidad,"","disabled","","","","","");
	hidden('unidad_adscripcion_h',$unidad);
	if ($dependiente==""){$dependiente = $unidad;}else{
	$dependiente = $dependiente . " (" . $pertenece . ")";}
	text ("Unidad a la que pertenece","formulario","unidad_pertenece","unidad_pertenece",$dependiente,"","disabled","","","","","");
	hidden('unidad_pertenece_h',$dependiente);
	text ("Número de Revisión","formulario","rev","rev",$campo_4,"","disabled","","","","","Muestra el Número de Revisión del Documento");
	hidden('rev_h',$campo_4);
	textarea ("Título del documento","formulario_textarea","titulo_doc","titulo_doc",$campo_6,"disabled","","","formulario_textarea","","obligatorio","Muestra el Título del Documento");
	
	subtitulos("Distribución de Documentos","");
	paginas_calendario(); // Páginas que hacen funcionar el calendario (Llamada)
	fecha ("Fecha de Emisión","formulario","emision","emision","","","","","Ingrese la Fecha de Emisión del Documento<br>Debe ser menor ó igual (&le;) a la Fecha Actual");
	// VALIDAR NRO DE REGISTRO
	div_multiple_inicio("Número de Registro","formulario","formulario_multiple","","","","Seleccione el año del Número de Registro<br>Ej: 2013");
		select ("","formulario_multiple","num_registro_unidad","unidades_referencia","","unidades_do","","","");
		select ("","formulario_multiple","num_registro_anio","unidades_anio","","unidades_anio","","","");
		//text ("","formulario_multiple","num_registro_numero","unidades_numero","","3","","","2","","");
div_multiple_cierre();
	
	
			
	// Tipo de documento	
	$sql = "SELECT * FROM unidades_confidencial WHERE cod_doc='$cod_doc'";
	$seleccion=mysql_query($sql,$conexion);
	$cont=mysql_num_rows($seleccion);
	if($cont>=1){
		$contador = 1;
		$incremento = 0;
		
		
		echo '<div class="ordenar">';
	echo'<table class="formulario">
			<tr class="formulario">
			<th class="formulario" id="numero">nº</th>
			<th class="formulario" id="unidad">Codigo de la Unidad</th>
			<th class="formulario" id="unidad">Unidad Documentación</th>
			<th class="formulario" id="titulo_documento">Unidad</th>
			<th class="formulario" id="unidad">Cantidad de Copias</th>
			</tr>';
		
	while ($row = mysql_fetch_array($seleccion)){
			$campos = array(
						$row[0],
						$row[1],
						$row[2],
						$row[3],
						$row[4]
							);
				echo '<tr class="formulario">';
				echo '<td class="numero">'. $contador++ .'</td>';
				echo '<td class="unidad">'. $campos[2] .'</td>';
				echo '<td class="unidad">'. $campos[4] .'</td>';
				echo '<td class="titulo_documento">'. $campos[3] .'</td>';
				echo '<td class="unidad">';
				text ("","formulario jj","copia[". $incremento ."]","copia[". $incremento ."]","","2","","","2","","","");
				hidden('unidad[]',$campos[2]);
				//text ("","formulario_multiple","unidades_numero","unidades_numero","","3","","","2","","");
				echo '</td>';
				echo '</tr>';
				$incremento++;
				
			}
			hidden('cont_copia',$cont);
			// Campo que indica si es documento privado ó público
			hidden('condicion','privado');
			
		echo '</table></div>';	
	}else{
				
	select ("Unidades con Copias controladas","formulario","unid_acceso","crear(this);","","unidades_copias","","","Seleccione las Unidades que tendrán Copias Controladas e indique la cantidad<br>Ej: PE  2 (dos) copias");
	
	
	echo '<div style="width:100%;float:left;" id="field">';
	
	echo '</div>';
		// Campo que indica si es documento privado ó público
			hidden('condicion','publico');
	 }
	
	
	
	
	
	
	
	
	boton ("Guardar Distribución","formulario","guardar_distribucion","guardar_distribucion","","formulario_boton");

	formulario_cierre ();
	echo '</div>';
}else {echo '<html><head><meta http-equiv="REFRESH" content="0; url=cod_asignados.php"></head></html>';}

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
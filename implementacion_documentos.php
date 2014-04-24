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
<title>Implementación de Documentos</title>
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
echo '<h1 class="tituto_tipo_documento">Implementación de Documentos</h1>';	
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
formulario_inicio ("Formulario de Implementación de Documentos","formulario","implementacion","bd_acciones.php","POST","f_implementacion(this);","","","","");
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
	
	subtitulos("Implementación de Documentos","");
	paginas_calendario(); // Páginas que hacen funcionar el calendario (Llamada)
	fecha ("Fecha de Emisión","formulario","emision","emision","","","","","Ingrese la Fecha de Emisión del Documento<br>Debe ser menor ó igual (&le;) a la Fecha Actual");
	// VALIDAR NRO DE REGISTRO
	div_multiple_inicio("Número de Registro","formulario","formulario_multiple","","","","Seleccione el año del Número de Registro<br>Ej: 2013");
		select ("","formulario_multiple","num_registro_unidad","unidades_referencia","","unidades_do","","","");
		select ("","formulario_multiple","num_registro_anio","unidades_anio","","unidades_anio","","","");
		//text ("","formulario_multiple","num_registro_numero","unidades_numero","","3","","","2","","");
div_multiple_cierre();
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	/*
		Consulta todos las unidades que reciben copias del Documento en la tabla "copias" para asi seleccionar el personal 
		en la tabla "personal"
	*/
	// Obtiene las siglas de la unidades que reciben una copia del documento
	$sql = "SELECT unidad FROM copias WHERE cod_doc='$cod_doc' AND rev='$rev'";
	$seleccion=mysql_query($sql,$conexion);
	$cont=mysql_num_rows($seleccion);
	$l = 1;
	if($cont>=1){
		while ($row = mysql_fetch_array($seleccion)){
				$sigla_unid=$row[0];
				//echo "<h1>". $sigla_unid . "</h1>";
				// Obtiene la denominacion de las unidades que reciben una copia del documento
				$sql2 = "SELECT denominacion FROM unidades WHERE sigla_unid='$sigla_unid'";
				$seleccion2=mysql_query($sql2,$conexion);
				while ($row2 = mysql_fetch_array($seleccion2)){
					$denominacion=$row2[0];
					//echo "<h1>". $denominacion . "</h1>";
					
	echo'<table class="formulario">
			<tr class="formulario">
			<th class="formulario_2" id="titulo_documento">'. $denominacion .'</th>
			</tr>
			<tr class="formulario">
			
			<th class="formulario" id="numero">nº</th>
			<th class="formulario" id="titulo_documento">Nombre(s) y Apellido(s)</th>
			<th class="formulario" id="unidad">Fecha</th>
			</tr>';
					
					
					
						// Obtiene el personal que labora en la unidad que recibió una copia del documento
						$sql3 = "SELECT nombres,apellidos FROM personal WHERE sigla_unid='$sigla_unid'";
						$seleccion3=mysql_query($sql3,$conexion);
						$cont=mysql_num_rows($seleccion3);
						hidden('cont[]',$cont);
						hidden('cont2[]',$sigla_unid);
						$j=1;
						$k=0;
						while ($row3 = mysql_fetch_array($seleccion3)){
						$nombres=$row3['nombres'];
						$apellidos=$row3['apellidos'];
						//echo "<h1>". $nombres . ", " . $apellidos . "</h1>";
						echo '<tr class="formulario">';
						echo '<td class="numero">'. $j++ .'</td>';
						echo '<td class="titulo_documento">'. $nombres . ', ' . $apellidos . '</td>';
						echo '<td class="unidad">';
						$k++;
						$nombre_completo = $nombres . " " . $apellidos;
						hidden("$sigla_unid"."_p"."[]",$nombre_completo);
						fecha("","formulario","$sigla_unid"."[$k]","$sigla_unid$k","","","","","");
						echo '</td>';
						echo '</tr>';	
						
						
						}// fin 3
				
				} // fin 2
		
	echo '</table>';	
		$l++;
		}// fin 1
		
	
		
		
		}
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
			
		
	
				
	
		
	boton ("Guardar Implementación","formulario","guardar_implementacion","guardar_implementacion","","formulario_boton");

	formulario_cierre ();
	
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
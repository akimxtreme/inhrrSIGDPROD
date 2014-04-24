<?php
session_start();
?>
<?php
$users = array(
			$_SESSION['usuario'],
			$_SESSION['nombre_usuario'],
			$_SESSION['privilegio']
			);

?>

<?php
echo '<link href="css/global.css" rel="stylesheet" type="text/css" />';
//<><><><><><><><> ACCIONES - FORM DE ACCESO AL MODULOS DE ADMINISTRADOR  <><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><>
$acceder=$_POST['acceder'];
isset($acceder);
if($acceder == 'acceder'){
include "conexion.php";
/*Validacion del formulario para solicitar cuenta */
// Obtencion de variables
$usuario1= $_POST['usuario'];
$contrasenia1= $_POST['contrasenia'];
//minusculas
//$usuario1 = strtoupper ($usuario1);
//$contrasenia1 = strtoupper ($contrasenia1);
// encriptando la contraseña en md5
$contrasenia1 = md5 ($contrasenia1); 

//validando accesos
// Administradores
$sql = "SELECT * FROM usuario WHERE usuario='$usuario1' AND contrasenia='$contrasenia1'";
$q=mysql_query($sql,$conexion);
$cont=mysql_num_rows($q);
if($cont>=1){
	
	while ($fila = mysql_fetch_array($q)){
	$usuario = $fila['usuario'];
	$privilegio = $fila['privilegio'];
	$nombre_usuario = $fila['nombre_usuario'];
		$_SESSION['usuario']= $usuario;
		$_SESSION['privilegio']= $privilegio;
		$_SESSION['nombre_usuario']= $nombre_usuario;
		$_SESSION["ultimoAcceso"]= date("Y-n-j H:i:s");
		$md5_123456= md5('123456');
		if($contrasenia1==$md5_123456){
			?><script>alert("¡Su Contraseña fue Reiniciada por el Sistema, Debe Cambiarla por otra Nueva!. Será enviado al Formulario de Cambio de Contraseña");</script><?
			echo '<html><head><meta http-equiv="REFRESH" content="0; url=configuracion_cuenta.php"></head></html>';
			}else{
				switch($privilegio){
				
				case 777:
					echo '<html><head><meta http-equiv="REFRESH" content="0; url=cod_asignados.php"></head></html>';
				break;
				case 2:
					echo '<html><head><meta http-equiv="REFRESH" content="0; url=cod_asignados.php"></head></html>';
				break;
				case 1:
					echo '<html><head><meta http-equiv="REFRESH" content="0; url=consulta.php"></head></html>';
				break;
				
				}
			}
		
}
}else{
echo '<html><head><meta http-equiv="REFRESH" content="0; url=index.php"></head></html>';
		?><script>alert("Datos No V\u00e1lidos");</script><?
}
mysql_free_result($q);

}// <><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><>

// <><><><><><><><> ACCIONES - FORM SOLICITUD DE CODIGOS <><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><>

$generar_codigo=$_POST['generar_codigo'];
isset($generar_codigo);
if($generar_codigo == 'generar_codigo'){
	// VARIABLES
	$tipo_doc=$_POST['tipo_doc']; 			// Tipo de Documento COD -- Ej: LIS --
	$sigla_doc=$_POST['sigla_doc']; 		// Unidad COD -- Ej: PE "Presidencia"
	$rev=$_POST['rev'];						// Revisión "0"
	$usuario_solic=$_POST['usuario_solic']; // Usuario Solicitante -- Ej: Domingo Ilarreta
	$titulo_doc=$_POST['titulo_doc']; 		// Título del Documento -- Ej: Título de Prueba
	$tipo = strtolower($tipo_doc);	
	if($tipo=="for"){ $tipo = "form";}		// Transforma en minúscula la Variable $tipo_doc. Ej: PON = pon
	$fecha_ing= date('Y-m-d');				// función que genera la fecha actual -- Ej: 2012-09-23
	$estatus= "0";							// asigna el 1er estatus del documento -- Ej: "0"
	/*
	echo "<pre>";
	print_r($_POST);
	echo "</pre>"; 
	*/
	// CONEXION A LA BD
	include ('conexion.php');
	// Consulta si existe la sigla de la unidad en la tabla 'nro_codigo'
	$sql = "SELECT * FROM nro_codigo WHERE cod_unidad='$sigla_doc'";	// Hace la pregunta
	$registros = mysql_query($sql,$conexion); 							// Realiza la consulta a la BD
	$cantidad_de_registros = mysql_num_rows($registros);				// Contador de registros
		
		if($cantidad_de_registros==0){
			
			// Inserta el registro en la tabla nro_codigo
			$cantidad_de_registros++; // INC el registro a 1
			$sql = "INSERT INTO nro_codigo (cod_unidad,$tipo) VALUES ('$sigla_doc','$cantidad_de_registros')";
			$accion=mysql_query($sql,$conexion);
			
			}else{
				// Toma de una unidad la cantidad de registros de un tipo de documento
					while ($fila = mysql_fetch_array($registros)){
					$tipo_doc_bd=$fila[$tipo];
					}
					
				// Incrementa la variable $tipo_doc_bd + 1
					$tipo_doc_bd = $tipo_doc_bd + 1;
				// Asigna el valor de $tipo_doc_bd a $cantidad_de_registros
					$cantidad_de_registros = $tipo_doc_bd;
				// Actualiza el registro en la tabla nro_codigo
				if($tipo_doc=="FOR"){
					
				$sql="UPDATE nro_codigo SET form='$tipo_doc_bd' WHERE cod_unidad='$sigla_doc'";
				$accion=mysql_query($sql,$conexion);
				}else{
					$sql="UPDATE nro_codigo SET $tipo='$tipo_doc_bd' WHERE cod_unidad='$sigla_doc'";
					$accion=mysql_query($sql,$conexion);
					}
				}
				
		// Modifica la variable $cantidad_de_registros para construir el código del documento
		$contar = strlen ($cantidad_de_registros);
				switch($contar){
					case 0: {$cantidad_de_registros = "00" . $cantidad_de_registros;}
					break;
					case 1: {$cantidad_de_registros = "00" . $cantidad_de_registros;}
					break;
					case 2: {$cantidad_de_registros = "0" . $cantidad_de_registros;}
					break;
					
				}
		// Construcción del Código del Documento
		$cod_doc = $tipo_doc . "_" . $sigla_doc . "_" .$cantidad_de_registros; // Ej: LIS_GPVV_002
		// Consulta la tabla inf_codigo
		$sql = "SELECT * FROM inf_codigo WHERE cod_doc='$cod_doc' AND rev='$rev'";
		$seleccion=mysql_query($sql,$conexion);
		$cont=mysql_num_rows($seleccion);
		if($cont==0){
			// Inserta el registro en la tabla inf_codigo
			$sql = "INSERT INTO inf_codigo (cod_doc, tipo_doc, sigla_doc, rev, usuario_solic, titulo_doc, fecha_ing, estatus) VALUE ('$cod_doc','$tipo_doc','$sigla_doc','$rev','$usuario_solic','$titulo_doc','$fecha_ing', '$estatus')";
			$accion=mysql_query($sql,$conexion);
			
				switch($tipo_doc){
					case "FOR":
						$pon_tipo_documento = $_POST['pon_tipo_documento']; // Ej: PON
						$pon_unidad = $_POST['pon_unidad']; 				// EJ: ACCC
						$pon_numero = $_POST['pon_numero'];					// Ej: 015
						$pon_asociado = $pon_tipo_documento . '_' . $pon_unidad . '_' . $pon_numero; // PON_ACCC_015
						
						$sql6 = "SELECT * FROM pon_asoc_for WHERE cod_doc='$cod_doc' AND pon_asoc='$pon_asociado'";
						$q=mysql_query($sql6,$conexion);
						$cont=mysql_num_rows($q);
						if($cont==0){
							$sql = "INSERT INTO pon_asoc_for (cod_doc, pon_asoc) VALUES ('$cod_doc','$pon_asociado')";
							$accion=mysql_query($sql,$conexion);
							}
					break;
					}
			
				
			echo '<html><head><meta http-equiv="REFRESH" content="0; url=codigo_asignado.php?cod='. $cod_doc . '"></head></html>';
		}else{
			// Te envia a la página principal
			echo '<html><head><meta http-equiv="REFRESH" content="0; url="index.php"></head></html>';	
					
			 }
}//<><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><>

// <><><><><><><><> ACCIONES - FORM RECEPCION DE DOCUMENTOS <><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><>

$guardar_recepcion_documentos=$_POST['guardar_recepcion_documentos'];
isset($guardar_recepcion_documentos);
if($guardar_recepcion_documentos == 'guardar_recepcion_documentos'){
	// VARIABLES
	$cod_doc=$_POST['cod_doc_h']; 			
	$tipo_doc=$_POST['tipo_doc_h']; 		
	$unidad_adscripcion=$_POST['unidad_adscripcion_h'];						
	$unidad_pertenece=$_POST['unidad_pertenece_h']; 
	$rev=$_POST['rev_h']; 
	$titulo_doc=$_POST['titulo_doc']; 
	$fecha_emision=$_POST['fecha_emision']; 
	$condicion=$_POST['condicion']; 
	$memo_unidad=$_POST['unidades_referencia']; 
	$memo_correlativo=$_POST['unidades_numero']; 
	$memo_fecha=$_POST['unidades_anio']; 		
	$fecha_recep=$_POST['fecha_recepcion']; 
	$rec_archivo=$_POST['fisico_digital']; 
	$observaciones=$_POST['observaciones']; 	
	$usuario_ing="Domingo Ilarreta";	
	$fecha_ing= date('Y-m-d');
	$pon_asoc_tipo_procedimiento= $_POST['pon_asoc_tipo_procedimiento'];
		

	if($condicion=="Confidencial"){
		$unid_acceso ="";
		}
				
	include "conexion.php";
	
	$sql="UPDATE inf_codigo SET estatus='1' WHERE cod_doc='$cod_doc' AND rev='$rev'";	
	$ingreso=mysql_query($sql,$conexion);	

	$sql="SELECT * FROM rec_doc WHERE cod_doc='$cod_doc' AND rev='$rev'";
	$seleccion=mysql_query($sql,$conexion);
	$cantidad_de_registros = mysql_num_rows($seleccion);
	if($cantidad_de_registros > 0){
		echo '<a class="error" href="cod_asignados.php">Código '. $cod_doc .' ya se encuentra almacenado en el Sistema - Intente con otro.</a>';
		echo '<a class="error" href="cod_asignados.php">VOLVER A PRINCIPAL</a>';
		}else {
			$sql="UPDATE inf_codigo SET titulo_doc ='$titulo_doc' WHERE cod_doc='$cod_doc' AND rev='$rev'";	
			$ingreso=mysql_query($sql,$conexion);
			
			$sql = "INSERT INTO rec_doc (cod_doc, fecha_emision, condicion, memo_unidad, memo_correlativo, memo_fecha, fecha_recep, rec_archivo, observaciones, usuario_ing, fecha_ing, rev) VALUE ('$cod_doc','$fecha_emision', '$condicion', '$memo_unidad' , '$memo_correlativo', '$memo_fecha', '$fecha_recep', '$rec_archivo', '$observaciones', '". $users[0] ."', '$fecha_ing', '$rev')";
			$accion=mysql_query($sql,$conexion);
			
			//Solo para Tipo de Documento PON
			if($pon_asoc_tipo_procedimiento==="PON"){
				// Declarando la variable
				$tipo_procedimiento = $_POST['tipo_procedimiento'];
				
				$sql="SELECT cod_doc FROM pon_asoc_tipo_procedimiento WHERE cod_doc='$cod_doc'";
				$seleccion=mysql_query($sql,$conexion);
				$cantidad_de_registros = mysql_num_rows($seleccion);
				if($cantidad_de_registros===0){
					$sql = "INSERT INTO pon_asoc_tipo_procedimiento (cod_doc, cod_tipo_procedimiento) VALUES ('$cod_doc', '$tipo_procedimiento')";
					$seleccion = mysql_query($sql,$conexion);					
					}
				
			}// fin solo para Tipo de Documento PON
			
			// Solo para Documentos Confidenciales
				if($condicion=="Confidencial"){
					
				$sql="SELECT * FROM tmp_unidades_confidencial WHERE cod_doc='$cod_doc'";
				$seleccion=mysql_query($sql,$conexion);
				$cantidad_de_registros = mysql_num_rows($seleccion);
					while ($row = mysql_fetch_array($seleccion)){
								$sigla_unid_tmp=$row["sigla_unid"];
								$denominacion_tmp=$row["denominacion"];
								$sigla_doc_tmp=$row["sigla_doc"];
								$cod_doc_tmp=$row["cod_doc"];
								if($cantidad_de_registros!= 0){
								$sql = "INSERT INTO unidades_confidencial (sigla_unid,denominacion,sigla_doc,cod_doc) VALUE ('$sigla_unid_tmp','$denominacion_tmp','$sigla_doc_tmp','$cod_doc_tmp')";
								$accion=mysql_query($sql,$conexion);
								}
					
					
					}
					$sql="TRUNCATE TABLE tmp_unidades_confidencial";
					$seleccion=mysql_query($sql,$conexion);
					
				}
			
			echo '<html><head><meta http-equiv="REFRESH" content="0; url=buscar_evaluacion.php"></head></html>';
			}
	
}//<><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><>

// <><><><><><><><> ACCIONES - FORM EVALUACION <><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><>

$guardar_evaluacion=$_POST['guardar_evaluacion'];
isset($guardar_evaluacion);
if($guardar_evaluacion == 'guardar_evaluacion'){
	// VARIABLES
	$cod_doc=$_POST['cod_doc_h']; 			
		$num_registro_unidad=$_POST['num_registro_unidad'];		
		$num_registro_anio=$_POST['num_registro_anio'];		
		$num_registro_numero=$_POST['num_registro_numero'];		
	//$nro_registro= $num_registro_unidad . "_" . $num_registro_anio . "_" . $num_registro_numero; 	// Ej: GPVV_2012_001
	$rev=$_POST['rev_h'];
	$crit1=$_POST['cumplimiento1'];
	$crit2=$_POST['cumplimiento2']; 
	$crit3=$_POST['cumplimiento3']; 
	$crit4=$_POST['cumplimiento4']; 
	$crit5=$_POST['cumplimiento5']; 
	$crit6=$_POST['cumplimiento6']; 
	$crit7=$_POST['cumplimiento7'];
	$crit8=$_POST['cumplimiento8'];
	/////////////////////////////////////////
	
	// Evaluación
	$formulario = 'EVALUACION';
		
	// CONEXION A LA BD
	include ('conexion.php');
	// Generando el correlativo del código
	$sql = "SELECT * FROM nro_codigo_formularios WHERE formulario='$formulario' AND anio='$num_registro_anio'";	// Hace la pregunta
	$registros = mysql_query($sql,$conexion); 							// Realiza la consulta a la BD
	$cantidad_de_registros = mysql_num_rows($registros);				// Contador de registros
	
	if($cantidad_de_registros==0){	// Inserta un nuevo registro
		$cantidad_de_registros++;
		
		$sql = "INSERT INTO nro_codigo_formularios (formulario,anio, nro_codigo_formularios) VALUE ('$formulario','$num_registro_anio','$cantidad_de_registros')";
		$accion=mysql_query($sql,$conexion);
		
	
		$contar = strlen ($cantidad_de_registros);
				switch($contar){
					case 0: {$cantidad_de_registros = "00" . $cantidad_de_registros;}
					break;
					case 1: {$cantidad_de_registros = "00" . $cantidad_de_registros;}
					break;
					case 2: {$cantidad_de_registros = "0" . $cantidad_de_registros;}
					break;
					
				}
			
				
		$nro_registro= $num_registro_unidad . "_" . $num_registro_anio . "_" . $cantidad_de_registros; 	// Ej: VV_2012_001
	
	}else{															// Actualiza un registro existente
				while ($fila = mysql_fetch_array($registros)){
				$tipo_doc_bd=$fila['nro_codigo_formularios'];
				}
				
				$tipo_doc_bd++;
				
				
				
				$sql="UPDATE nro_codigo_formularios SET nro_codigo_formularios='$tipo_doc_bd' WHERE formulario='$formulario' AND anio='$num_registro_anio'";
				$accion=mysql_query($sql,$conexion);
				
				
				$contar = strlen ($tipo_doc_bd);
				switch($contar){
					case 0: {$tipo_doc_bd = "00" . $tipo_doc_bd;}
					break;
					case 1: {$tipo_doc_bd = "00" . $tipo_doc_bd;}
					break;
					case 2: {$tipo_doc_bd = "0" . $tipo_doc_bd;}
					break;
					
				}
		$nro_registro= $num_registro_unidad . "_" . $num_registro_anio . "_" . $tipo_doc_bd; 	// Ej: VV_2012_001
	}
	
	/////////////////////////////////////////
	$dpto = substr($cod_doc,6,2); // Subtrae las siglas del Dpto EJ: PE (Presidencia)
		// Valida la cantidad de carateres del codigo del documento ($cod_doc) es mayor a 12
		if(strlen($cod_doc)!="12"){ 
			$dpto = substr($cod_doc,4,2); // Subtrae las siglas del Dpto EJ: PE (Presidencia)
			}
		$siglas_doc = substr($cod_doc,0,3); // Subtrae las siglas del Tipo de Documento del Dpto EJ: FOR (Presidencia)	
 $uploaddir = "archivos/unidades/" . $dpto . "/" . $siglas_doc . "/"; // ruta donde se almacenada el archivo.
 $adjunto = $_FILES['archivo']['name']; // nombre del archivo que se subirá  (Ej: nombre_archivo.pdf)
 $nvo_nombre = $adjunto; // declaro $nvo_nombre para conservar $adjunto 
 $extension = end(explode('.',$adjunto)); //saca la extension sin el punto(Ej:"pdf"), el end() es para agarrar el ultimo punto en caso d q el nombre contenga mas de 1 punto 
 $onlyName = substr($adjunto,0,strlen($adjunto)-(strlen($extension)+1)); //saca el nombre del archivo sin la extensión (Ej:"nombre_archivo") 
 $nvo_nombre = $cod_doc. "_" . $rev ."." . $extension;  // Armando el nombre completo del archivo (Ej: archivo.pdf)
	
	//$tipo_adjunto=$_POST['archivo'];
	
	////////////////////////////////////////
	//$ruta_adjunto="adjuntos/";
	$fecha_eval=date('Y-m-d');
	$usuario_ing= $usuario; 
	$fecha_ing=date('Y-m-d');
	
	include "conexion.php";

	$si="si_cumple";
	$no="no_cumple";
	
	// Verifica si es un documento para revaluar
	$sql="SELECT * FROM inf_codigo WHERE cod_doc='$cod_doc' AND rev='$rev' AND estatus='666'";
	$seleccion=mysql_query($sql,$conexion);
	$revaluacion = mysql_num_rows($seleccion);
	if($revaluacion > 0){
		
		//Toma toda la información del código a revaluar ubicado en la Tabla evaluacion_doc para luego ser almacenada en el historial de la tabla evaluacion_devolucion_anterior
		$sql="SELECT nro_registro, crit1, crit2, crit3, crit4, crit5, crit6, crit7, crit8, fecha_eval, usuario_ing, fecha_ing FROM evaluacion_doc WHERE cod_doc='$cod_doc' AND rev='$rev'";
		$seleccion=mysql_query($sql,$conexion);
			while ($row = mysql_fetch_array($seleccion)){
			$nro_registro_evaluacion=$row[0];
			$crit1_reva=$row[1];
			$crit2_reva=$row[2];
			$crit3_reva=$row[3];
			$crit4_reva=$row[4];
			$crit5_reva=$row[5];
			$crit6_reva=$row[6];
			$crit7_reva=$row[7];
			$crit8_reva=$row[8];
			$fecha_evaluacion=$row[9];
			$usuario_ing_evaluacion=$row[10];
			$fecha_ingreso_evaluacion=$row[11];
			}
		
		
		//Toma toda la información del código a revaluar ubicado en la Tabla devolucion_doc para luego ser almacenada en el historial de la tabla evaluacion_devolucion_anterior
		$sql="SELECT nro_registro, fecha_recep, nro_copia , observaciones , usuario_ing , fecha_ing FROM devolucion_doc WHERE cod_doc='$cod_doc' AND rev='$rev'";
		$seleccion=mysql_query($sql,$conexion);
			while ($row = mysql_fetch_array($seleccion)){
			$nro_registro_devolucion=$row[0];
			$fecha_recep_devolucion=$row[1];
			$nro_copias_devolucion=$row[2];
			$observaciones_devolucion=$row[3];
			$usuario_ing_devolucion=$row[4];
			$fecha_ing_devolucion=$row[5];
			}
		
			// Verifica que no exista un registro existente
			$sql="SELECT * FROM evaluacion_devolucion_anterior WHERE cod_doc='$cod_doc' AND rev='$rev' AND nro_registro_evaluacion='$nro_registro_evaluacion'";
			$seleccion=mysql_query($sql,$conexion);
			$existente = mysql_num_rows($seleccion);
			if($existente == 0){
				// Guardando la informacion de la tabla evaluacion_doc y devolucion_doc
				$sql = "INSERT INTO evaluacion_devolucion_anterior (cod_doc, nro_registro_evaluacion, rev, crit1, crit2, crit3, crit4, crit5, crit6, crit7, crit8, fecha_evaluacion, usuario_ing_evaluacion, fecha_ingreso_evaluacion, nro_registro_devolucion, fecha_recep_devolucion, nro_copias_devolucion, observaciones_devolucion, usuario_ing_devolucion, fecha_ing_devolucion) VALUE ('$cod_doc','$nro_registro_evaluacion', '$rev', '$crit1_reva', '$crit2_reva' , '$crit3_reva', '$crit4_reva', '$crit5_reva', '$crit6_reva', '$crit7_reva', '$crit8_reva', '$fecha_evaluacion', '$usuario_ing_evaluacion', '$fecha_ingreso_evaluacion', '$nro_registro_devolucion', '$fecha_recep_devolucion', '$nro_copias_devolucion', '$observaciones_devolucion', '$usuario_ing_devolucion', '$fecha_ing_devolucion' )";
				$accion=mysql_query($sql,$conexion);
				
				// Elimina el registro de las tablas evaluacion_doc y devolucion_doc
				 // Delete regsitro evaluacion_doc
				$sql = "DELETE FROM evaluacion_doc WHERE cod_doc='$cod_doc' AND rev='$rev'";
				$seleccion=mysql_query($sql,$conexion);
				 // Delete regsitro devolucion_doc
				$sql = "DELETE FROM devolucion_doc WHERE cod_doc='$cod_doc' AND rev='$rev'";
				$seleccion=mysql_query($sql,$conexion);
				
			 } // fin del contador existente
		
		
		} // fin del if de revaluacion
		
		
	if(($crit1==$si) && ($crit2==$si) && ($crit3==$si) && ($crit4==$si) && ($crit5==$si) && ($crit6==$si) && ($crit7==$si) && ($crit8==$si)){
		$sql="UPDATE inf_codigo SET estatus='3' WHERE cod_doc='$cod_doc' AND rev='$rev'";	
		$ingreso=mysql_query($sql,$conexion);
		
 
 $uploadFile = $uploaddir.$nvo_nombre; 

 $error = $_FILES['archivo']['error'];
 $subido = false;
 if(isset($_POST['guardar_evaluacion']) && $error==UPLOAD_ERR_OK) { 
  
   $subido = move_uploaded_file($_FILES['archivo']['tmp_name'], $uploadFile);  
  } 
   		
  	$sql="SELECT * FROM evaluacion_doc WHERE cod_doc='$cod_doc' AND rev='$rev'";
	$seleccion=mysql_query($sql,$conexion);
	$cantidad_de_registros = mysql_num_rows($seleccion);
	if($cantidad_de_registros > 0){
		echo '<a class="error" href="buscar_evaluacion.php">Código '. $cod_doc .' ya se encuentra almacenado en el Sistema - Intente con otro.</a>';
		echo '<a class="error" href="buscar_evaluacion.php">VOLVER A PRINCIPAL</a>';
		}else {
			$sql = "INSERT INTO evaluacion_doc (cod_doc, nro_registro, rev, crit1, crit2, crit3, crit4, crit5, crit6, crit7, crit8, tipo_adjunto, ruta_adjunto, fecha_eval, usuario_ing, fecha_ing) VALUE ('$cod_doc','$nro_registro', '$rev', '$crit1', '$crit2' , '$crit3', '$crit4', '$crit5', '$crit6', '$crit7', '$crit8', '$nvo_nombre', '$uploaddir', '$fecha_eval', '". $users[0] ."', '$fecha_ing')";
			$accion=mysql_query($sql,$conexion);
			
			//echo '<html><head><meta http-equiv="REFRESH" content="0; url=reportes/control_doc.php?cod_doc='. $cod_doc .'"></head></html>';
			echo '<a class="error" href="evaluacion_aprobado.php?cod_doc='. $cod_doc .'&rev='. $rev.'">Ver Evaluación</a>';
			//echo '<html><head><meta http-equiv="REFRESH" content="0; url="evaluacion_aprobado.php?cod_doc='. $cod_doc .'"></head></html>';
			}
  
		
		
		
		}else{
			$sql="UPDATE inf_codigo SET estatus='2' WHERE cod_doc='$cod_doc' AND rev='$rev'";	
			$ingreso=mysql_query($sql,$conexion);
			
			
			$sql="SELECT * FROM evaluacion_doc WHERE cod_doc='$cod_doc' AND rev='$rev'";
	$seleccion=mysql_query($sql,$conexion);
	$cantidad_de_registros = mysql_num_rows($seleccion);
	if($cantidad_de_registros > 0){
		echo '<a class="error" href="buscar_evaluacion.php">Código '. $cod_doc .' ya se encuentra almacenado en el Sistema - Intente con otro.</a>';
		echo '<a class="error" href="buscar_evaluacion.php">VOLVER A PRINCIPAL</a>';
		}else {
			$sql = "INSERT INTO evaluacion_doc (cod_doc, nro_registro, rev, crit1, crit2, crit3, crit4, crit5, crit6, crit7, crit8, tipo_adjunto, ruta_adjunto, fecha_eval, usuario_ing, fecha_ing) VALUE ('$cod_doc','$nro_registro', '$rev', '$crit1', '$crit2' , '$crit3', '$crit4', '$crit5', '$crit6', '$crit7', '$crit8', '', '', '$fecha_eval', '". $users[0] ."', '$fecha_ing')";
			$accion=mysql_query($sql,$conexion);
			
			//echo '<html><head><meta http-equiv="REFRESH" content="0; url=reportes/control_doc.php?cod_doc='. $cod_doc .'"></head></html>';
			//echo '<html><head><meta http-equiv="REFRESH" content="0; url=evaluacion_aprobado.php?cod_doc='. $cod_doc .'"></head></html>';
			echo '<a class="error" href="evaluacion_aprobado.php?cod_doc='. $cod_doc .'&rev='. $rev.'">Ver Evaluación</a>';
			//echo '<a class="error" href="buscar_devolucion.php">Ver Evaluación</a>';
			
			//echo '<html><head><meta http-equiv="REFRESH" content="0; url="buscar_devolucion.php"></head></html>';
			}
		}

	
	
}//<><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><>

$guardar_distribucion=$_POST['guardar_distribucion'];
isset($guardar_distribucion);
if($guardar_distribucion == 'guardar_distribucion'){
/*	
echo "<pre>";
print_r($_POST);
echo "</pre>"; 
*/	
$cod_doc = $_POST['cod_doc_h'];	// Almacena el Código del Documento
$rev = $_POST['rev_h']; // Almacena el número de revisión del documento
$emision = $_POST['emision']; // Almacena la fecha de revisión del documento
$num_registro_unidad = $_POST['num_registro_unidad']; // Almacena la sigla DO (Documenttación)
$num_registro_anio = $_POST['num_registro_anio']; // Almacena el año del número de registro
$fecha_ing= date('Y-m-d');				// función que genera la fecha actual -- Ej: 2012-09-23
$array = count($_POST['copia']); // (contador): Almacena la cantidad de unidades que tendras copias controladas del documento Ej: (2)

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Asigna el correlativo para el Número de Registro para la Distribución de Documentos

	// Evaluación
	$formulario = 'DISTRIBUCION'; // Almacena el nombre del tipo de formulario
		
	// CONEXION A LA BD
	include ('conexion.php');
	// Generando el correlativo del código
	$sql = "SELECT * FROM nro_codigo_formularios WHERE formulario='$formulario' AND anio='$num_registro_anio'";	// Hace la pregunta
	$registros = mysql_query($sql,$conexion); 							// Realiza la consulta a la BD
	$cantidad_de_registros = mysql_num_rows($registros);				// Contador de registros
	
	if($cantidad_de_registros==0){	// Inserta un nuevo registro
		$cantidad_de_registros++;
		
		$sql = "INSERT INTO nro_codigo_formularios (formulario,anio, nro_codigo_formularios) VALUE ('$formulario','$num_registro_anio','$cantidad_de_registros')";
		$accion=mysql_query($sql,$conexion);
		
	
		$contar = strlen ($cantidad_de_registros);
				switch($contar){
					case 0: {$cantidad_de_registros = "00" . $cantidad_de_registros;}
					break;
					case 1: {$cantidad_de_registros = "00" . $cantidad_de_registros;}
					break;
					case 2: {$cantidad_de_registros = "0" . $cantidad_de_registros;}
					break;
					
				}
			
				
		$nro_registro= $num_registro_unidad . "_" . $num_registro_anio . "_" . $cantidad_de_registros; 	// Ej: VV_2012_001
	
	}else{															// Actualiza un registro existente
				while ($fila = mysql_fetch_array($registros)){
				$tipo_doc_bd=$fila['nro_codigo_formularios'];
				}
				
				$tipo_doc_bd++;
				
				
				
				$sql="UPDATE nro_codigo_formularios SET nro_codigo_formularios='$tipo_doc_bd' WHERE formulario='$formulario' AND anio='$num_registro_anio'";
				$accion=mysql_query($sql,$conexion);
				
				
				$contar = strlen ($tipo_doc_bd);
				switch($contar){
					case 0: {$tipo_doc_bd = "00" . $tipo_doc_bd;}
					break;
					case 1: {$tipo_doc_bd = "00" . $tipo_doc_bd;}
					break;
					case 2: {$tipo_doc_bd = "0" . $tipo_doc_bd;}
					break;
					
				}
		$nro_registro= $num_registro_unidad . "_" . $num_registro_anio . "_" . $tipo_doc_bd; 	// Ej: VV_2012_001
	}
	


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Unidades con privilegios para visualizar el documento.
for($i=0;$i<$array;$i++){
	$copia = $_POST['copia'][$i];
	$unidad = $_POST['unidad'][$i];
	
	$sql="SELECT cod_doc,rev,unidad FROM copias WHERE cod_doc='$cod_doc' AND rev='$rev' AND unidad='$unidad'";
	$seleccion=mysql_query($sql,$conexion);
	$cantidad_de_registros = mysql_num_rows($seleccion);
	if($cantidad_de_registros == 0){
		$sql = "INSERT INTO copias (cod_doc, rev, unidad, copias) VALUE ('$cod_doc', '$rev', '$unidad', '$copia')";
		$accion=mysql_query($sql,$conexion);
	
		}
	$total = $total + $copia;
	//echo $copia . "<br><br>";
	
	}	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Guardando datos en la tabla distribucion_doc
$sql = "SELECT * FROM distribucion_doc WHERE cod_doc='$cod_doc' AND rev='$rev'";
$q=mysql_query($sql,$conexion);
$cont=mysql_num_rows($q);
if($cont==0){

	$sql = "INSERT INTO distribucion_doc (cod_doc, rev, nro_registro, fecha_emision, nro_copias, usuario_ing, fecha_ing) VALUE ('$cod_doc', '$rev', '$nro_registro', '$emision', '$total', '$users[0]', '$fecha_ing')";
	$accion=mysql_query($sql,$conexion);
	
	$sql="UPDATE inf_codigo SET estatus='4' WHERE cod_doc='$cod_doc' AND rev='$rev'";	
	$ingreso=mysql_query($sql,$conexion);
	
	$incremento = 0;
	// Toma todas las siglas y el nro de copias de la unidad
	$sql = "SELECT unidad, copias FROM copias WHERE cod_doc='$cod_doc' AND rev='$rev'";
	$seleccion=mysql_query($sql,$conexion);
	$contador=mysql_num_rows($seleccion);
			while ($row = mysql_fetch_array($seleccion)){
			$siglas_unidad=$row[0]; 		// Siglas de la unidad Ej: (DO)
			$total_copias_unidad=$row[1]; 	// Número total de copias de la unidad Ej: (7)
			
					for($y=0;$y<$total_copias_unidad;$y++){
							$incremento++;
							$sql3 = "INSERT INTO codigo_unid_distribucion_doc (cod_doc, rev, unidad, codigo) VALUE ('$cod_doc', '$rev', '$siglas_unidad', '$incremento')";
							$accion=mysql_query($sql3,$conexion);				
						
						}
					
			}
	
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Opción que te lleva a la fase de implementacion del Documento
//echo '<html><head><meta http-equiv="REFRESH" content="0; url=buscar_implementacion_documentos.php"></head></html>';
echo '<html><head><meta http-equiv="REFRESH" content="0; url=distribucion_consulta.php?cod_doc='. $cod_doc .'&rev='. $rev .'"></head></html>';

	}

$guardar_devolucion=$_POST['guardar_devolucion'];
isset($guardar_devolucion);
if($guardar_devolucion == 'guardar_devolucion'){
	
	// VARIABLES
	$cod_doc = $_POST['cod_doc_h']; // Almacena el Código del Documento
	$rev = $_POST['rev_h']; // Almacena el número de Revisión del Documento
	$fecha_recep = $_POST['fecha_recep']; // Almacena la Fecha del Recepción
	$num_registro_unidad = $_POST['num_registro_unidad']; // Almacena la Sigla DO (Documentación) del número de registro
	$num_registro_anio = $_POST['num_registro_anio']; // Almacena el año del número de registro
	$nro_copias = $_POST['nro_copias']; // Almacena el número de copias
	$observaciones = $_POST['observaciones']; // Almacena las observaciones adicionales que indican el motivo de la devolución del documento.
	$fecha_ing= date('Y-m-d'); // función que genera la fecha actual -- Ej: 2012-09-23
	// CONEXION A LA BD
	include ('conexion.php');
	
// Guardando datos en la tabla evaluacion_doc
$sql = "SELECT * FROM devolucion_doc WHERE cod_doc='$cod_doc' AND rev='$rev'";
$q=mysql_query($sql,$conexion);
$cont=mysql_num_rows($q);
if($cont==0){
	
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Asigna el correlativo para el Número de Registro para la Devolución de Documentos

	// Devolución
	$formulario = 'DEVOLUCION'; // Almacena el nombre del tipo de formulario
		
	
	// Generando el correlativo del código
	$sql = "SELECT * FROM nro_codigo_formularios WHERE formulario='$formulario' AND anio='$num_registro_anio'";	// Hace la pregunta
	$registros = mysql_query($sql,$conexion); 							// Realiza la consulta a la BD
	$cantidad_de_registros = mysql_num_rows($registros);				// Contador de registros
	
	if($cantidad_de_registros==0){	// Inserta un nuevo registro
		$cantidad_de_registros++;
		
		$sql = "INSERT INTO nro_codigo_formularios (formulario,anio, nro_codigo_formularios) VALUE ('$formulario','$num_registro_anio','$cantidad_de_registros')";
		$accion=mysql_query($sql,$conexion);
		
	
		$contar = strlen ($cantidad_de_registros);
				switch($contar){
					case 0: {$cantidad_de_registros = "00" . $cantidad_de_registros;}
					break;
					case 1: {$cantidad_de_registros = "00" . $cantidad_de_registros;}
					break;
					case 2: {$cantidad_de_registros = "0" . $cantidad_de_registros;}
					break;
					
				}
			
				
		$nro_registro= $num_registro_unidad . "_" . $num_registro_anio . "_" . $cantidad_de_registros; 	// Ej: VV_2012_001
	
	}else{															// Actualiza un registro existente
				while ($fila = mysql_fetch_array($registros)){
				$tipo_doc_bd=$fila['nro_codigo_formularios'];
				}
				
				$tipo_doc_bd++;
				
				
				
				$sql="UPDATE nro_codigo_formularios SET nro_codigo_formularios='$tipo_doc_bd' WHERE formulario='$formulario' AND anio='$num_registro_anio'";
				$accion=mysql_query($sql,$conexion);
				
				
				$contar = strlen ($tipo_doc_bd);
				switch($contar){
					case 0: {$tipo_doc_bd = "00" . $tipo_doc_bd;}
					break;
					case 1: {$tipo_doc_bd = "00" . $tipo_doc_bd;}
					break;
					case 2: {$tipo_doc_bd = "0" . $tipo_doc_bd;}
					break;
					
				}
		$nro_registro= $num_registro_unidad . "_" . $num_registro_anio . "_" . $tipo_doc_bd; 	// Ej: VV_2012_001
	}
	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	
	
	$sql = "INSERT INTO devolucion_doc (cod_doc, rev, nro_registro, fecha_recep, nro_copia, observaciones, usuario_ing, fecha_ing) VALUE ('$cod_doc', '$rev', '$nro_registro', '$fecha_recep', '$nro_copias', '$observaciones', '$users[0]', '$fecha_ing')";
	$accion=mysql_query($sql,$conexion);
	
	$sql="UPDATE inf_codigo SET estatus='666' WHERE cod_doc='$cod_doc' AND rev='$rev'";	
	$ingreso=mysql_query($sql,$conexion);
	
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Opción que te lleva a la Consulta de la Devolución
echo '<html><head><meta http-equiv="REFRESH" content="0; url=devolucion_consulta.php?cod_doc='. $cod_doc .'&rev='. $rev .'"></head></html>';
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//include "conexion.php";
/*
echo "<pre>";
print_r($_POST);
echo "</pre>"; 
*/
}

$guardar_implementacion=$_POST['guardar_implementacion'];
isset($guardar_implementacion);
if($guardar_implementacion == 'guardar_implementacion'){
/*	
echo "<pre>";
print_r($_POST);
echo "</pre>"; 
*/	
$cod_doc = $_POST['cod_doc_h'];
$rev = $_POST['rev_h'];
$cont_unidades = count($_POST['cont']);
$num_registro_unidad = $_POST['num_registro_unidad'];
$num_registro_anio = $_POST['num_registro_anio'];
$fecha_emision = $_POST['emision'];
$fecha_ing= date('Y-m-d'); // función que genera la fecha actual -- Ej: 2012-09-23

//********NOTA: Falta generar el contador correlativo para crear la variable nro_registro**********//

	/********************************************************************************************/
	// Muestra todas la sigla de la unidad
	for($i=0;$i<$cont_unidades;$i++){
		// sigla de la unidad
		$sigla_unid = $_POST['cont2'][$i]; // Ej: PE (Presidencia)
		//echo '<br><h4>' . $sigla_unid . "</h4><br>";
		/*****************************************************************************************/
			// Muestra el Personal de cada unidad
			for($j=0;$j<count($_POST["$sigla_unid"."_p"]);$j++){
				// Personal de la unidad
				$personal_unid = $_POST["$sigla_unid" . "_p"][$j]; // Ej: Domingo Ilarreta [Nombre(s) y Apellido(s)]
				/*****************************************************************************************/
						// Muestra el la fecha en que firmó el personal en la constancia de implementación del documento
						$k = $j + 1;
						$fecha_personal_unid = $_POST["$sigla_unid"][$k]; // Ej: 2013-04-29
						//echo '<br><h4>' . $fecha_personal_unid . "</h4><br>";
				/*****************************************************************************************/
				/*
				echo '<br><h4>' . $personal_unid . "</h4><br>";
				*/
				//echo 'Unidad: ' . $sigla_unid . ', ' . 'Personal: ' . $personal_unid . ', ' . 'Fecha: ' . $fecha_personal_unid . '<br>';   
				///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				// Verifica que la fecha no esté vacia de lo contrario el usuario no se almacenará
				if($fecha_personal_unid!=0){
					// Guardando datos en la tabla implementacion_doc
					include ('conexion.php');
					$sql = "SELECT * FROM constancia_implementacion WHERE cod_doc='$cod_doc' AND rev='$rev' AND sigla_unid='$sigla_unid' AND nombre_completo='$personal_unid' AND fecha='$fecha_personal_unid'";
					$q=mysql_query($sql,$conexion);
					$cont=mysql_num_rows($q);
					if($cont==0){
						$sql = "INSERT INTO constancia_implementacion (cod_doc, rev, sigla_unid, nombre_completo, fecha) VALUE ('$cod_doc', '$rev', '$sigla_unid', '$personal_unid', '$fecha_personal_unid')";
						$accion=mysql_query($sql,$conexion);
					}
				}
				
				///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			} // fin del for para obtener los nombres completos de cada personal de la unidad
			//echo '<br>';
		/*****************************************************************************************/
	}// fin del for para obtener las sigla de la unidad
	/*********************************************************************************************/

	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Asigna el correlativo para el Número de Registro para la Devolución de Documentos

	// Devolución
	$formulario = 'IMPLEMENTACION'; // Almacena el nombre del tipo de formulario
		
	// CONEXION A LA BD
	include ('conexion.php');
	// Generando el correlativo del código
	$sql = "SELECT * FROM nro_codigo_formularios WHERE formulario='$formulario' AND anio='$num_registro_anio'";	// Hace la pregunta
	$registros = mysql_query($sql,$conexion); 							// Realiza la consulta a la BD
	$cantidad_de_registros = mysql_num_rows($registros);				// Contador de registros
	
	if($cantidad_de_registros==0){	// Inserta un nuevo registro
		$cantidad_de_registros++;
		
		$sql = "INSERT INTO nro_codigo_formularios (formulario, anio, nro_codigo_formularios) VALUE ('$formulario','$num_registro_anio','$cantidad_de_registros')";
		$accion=mysql_query($sql,$conexion);
		
	
		$contar = strlen ($cantidad_de_registros);
				switch($contar){
					case 0: {$cantidad_de_registros = "00" . $cantidad_de_registros;}
					break;
					case 1: {$cantidad_de_registros = "00" . $cantidad_de_registros;}
					break;
					case 2: {$cantidad_de_registros = "0" . $cantidad_de_registros;}
					break;
					
				}
			
				
		$nro_registro= $num_registro_unidad . "_" . $num_registro_anio . "_" . $cantidad_de_registros; 	// Ej: DO_2012_001
	
	}else{															// Actualiza un registro existente
				while ($fila = mysql_fetch_array($registros)){
				$tipo_doc_bd=$fila['nro_codigo_formularios'];
				}
				
				$tipo_doc_bd++;
				
				
				
				$sql="UPDATE nro_codigo_formularios SET nro_codigo_formularios='$tipo_doc_bd' WHERE formulario='$formulario' AND anio='$num_registro_anio'";
				$accion=mysql_query($sql,$conexion);
				
				
				$contar = strlen ($tipo_doc_bd);
				switch($contar){
					case 0: {$tipo_doc_bd = "00" . $tipo_doc_bd;}
					break;
					case 1: {$tipo_doc_bd = "00" . $tipo_doc_bd;}
					break;
					case 2: {$tipo_doc_bd = "0" . $tipo_doc_bd;}
					break;
					
				}
		$nro_registro= $num_registro_unidad . "_" . $num_registro_anio . "_" . $tipo_doc_bd; 	// Ej: DO_2012_002
	}
	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Guardando datos en la tabla implementacion_doc
$sql = "SELECT * FROM implementacion_doc WHERE cod_doc='$cod_doc' AND rev='$rev'";
$q=mysql_query($sql,$conexion);
$cont=mysql_num_rows($q);
if($cont==0){
	
	$sql = "INSERT INTO implementacion_doc (cod_doc, rev, nro_registro, fecha, usuario_ing, fecha_ing) VALUE ('$cod_doc', '$rev', '$nro_registro', '$fecha_emision', '$users[0]', '$fecha_ing')";
	$accion=mysql_query($sql,$conexion);
	
	$sql="UPDATE inf_codigo SET estatus='777' WHERE cod_doc='$cod_doc' AND rev='$rev'";	
	$ingreso=mysql_query($sql,$conexion);
	
	if($rev!=0){
		$rev_antigua = $rev - 1;	
		$sql="UPDATE inf_codigo SET estatus='111' WHERE cod_doc='$cod_doc' AND rev='$rev_antigua'";	
		$ingreso=mysql_query($sql,$conexion);
		
		}
	echo '<html><head><meta http-equiv="REFRESH" content="0; url=implementacion_consulta.php?cod_doc='. $cod_doc .'&rev='. $rev .'"></head></html>';
	//echo '<html><head><meta http-equiv="REFRESH" content="0; url=cod_asignados.php"></head></html>';
	
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	
}// guardar_implementacion



$guardar_solicitud_modificacion=$_POST['guardar_solicitud_modificacion'];
isset($guardar_solicitud_modificacion);
if($guardar_solicitud_modificacion == 'guardar_solicitud_modificacion'){
	$cod_doc=$_POST['cod_doc_h'];
	$rev=$_POST['rev_h'];
	$num_registro_unidad=$_POST['num_registro_unidad'];
	$num_registro_anio=$_POST['num_registro_anio'];
	$descripcion=$_POST['descripcion'];
	
	include ("conexion.php");
	// Guardando datos en la tabla implementacion_doc
	$sql = "SELECT * FROM solicitudes_mod WHERE cod_doc='$cod_doc' AND rev='$rev'";
	$q=mysql_query($sql,$conexion);
	$cont=mysql_num_rows($q);
	if($cont==0){
	
		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Asigna el correlativo para el Número de Registro para la Devolución de Documentos

	// Devolución
	$formulario = 'MODIFICACION'; // Almacena el nombre del tipo de formulario
		
	// CONEXION A LA BD
	include ('conexion.php');
	// Generando el correlativo del código
	$sql = "SELECT * FROM nro_codigo_formularios WHERE formulario='$formulario' AND anio='$num_registro_anio'";	// Hace la pregunta
	$registros = mysql_query($sql,$conexion); 							// Realiza la consulta a la BD
	$cantidad_de_registros = mysql_num_rows($registros);				// Contador de registros
	
	if($cantidad_de_registros==0){	// Inserta un nuevo registro
		$cantidad_de_registros++;
		
		$sql = "INSERT INTO nro_codigo_formularios (formulario, anio, nro_codigo_formularios) VALUE ('$formulario','$num_registro_anio','$cantidad_de_registros')";
		$accion=mysql_query($sql,$conexion);
		
	
		$contar = strlen ($cantidad_de_registros);
				switch($contar){
					case 0: {$cantidad_de_registros = "00" . $cantidad_de_registros;}
					break;
					case 1: {$cantidad_de_registros = "00" . $cantidad_de_registros;}
					break;
					case 2: {$cantidad_de_registros = "0" . $cantidad_de_registros;}
					break;
					
				}
			
				
		$nro_registro= $num_registro_unidad . "_" . $num_registro_anio . "_" . $cantidad_de_registros; 	// Ej: DO_2012_001
	
	}else{															// Actualiza un registro existente
				while ($fila = mysql_fetch_array($registros)){
				$tipo_doc_bd=$fila['nro_codigo_formularios'];
				}
				
				$tipo_doc_bd++;
				
				
				
				$sql="UPDATE nro_codigo_formularios SET nro_codigo_formularios='$tipo_doc_bd' WHERE formulario='$formulario' AND anio='$num_registro_anio'";
				$accion=mysql_query($sql,$conexion);
				
				
				$contar = strlen ($tipo_doc_bd);
				switch($contar){
					case 0: {$tipo_doc_bd = "00" . $tipo_doc_bd;}
					break;
					case 1: {$tipo_doc_bd = "00" . $tipo_doc_bd;}
					break;
					case 2: {$tipo_doc_bd = "0" . $tipo_doc_bd;}
					break;
					
				}
		$nro_registro= $num_registro_unidad . "_" . $num_registro_anio . "_" . $tipo_doc_bd; 	// Ej: DO_2012_002
	}
	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	
		
	// Almacenando la solicitud
	$sql = "INSERT INTO solicitudes_mod (cod_doc, rev, nro_registro, descrip_mod) VALUE ('$cod_doc', '$rev', '$nro_registro', '$descripcion')";
	$accion=mysql_query($sql,$conexion);
	
	// Cambiando el estatus en la tabla inf_codigo
	$sql="UPDATE inf_codigo SET estatus='999' WHERE cod_doc='$cod_doc' AND rev='$rev'";	
	$ingreso=mysql_query($sql,$conexion);
	
	echo '<html><head><meta http-equiv="REFRESH" content="0; url=solicitud_modificacion_consulta.php?cod_doc='. $cod_doc .'&rev='. $rev .'"></head></html>';
	//echo '<html><head><meta http-equiv="REFRESH" content="0; url=cod_asignados.php"></head></html>';
	}

	
	
} // fin guardar_solicitud_modificacion
$guardar_revision=$_POST['guardar_revision'];
isset($guardar_revision);
if($guardar_revision == 'guardar_revision'){
	
	/*
	echo "<pre>";
	print_r($_POST);
	echo "</pre>"; 
	*/
	
	// VARIABLES
	$cod_doc=$_POST['cod_doc_h']; 			
	$tipo_doc=$_POST['tipo_doc_h'];
	$sigla_doc=$_POST['sigla_doc_h']; 		
	$unidad_adscripcion=$_POST['unidad_adscripcion_h'];						
	$unidad_pertenece=$_POST['unidad_pertenece_h']; 
	$rev=$_POST['rev_h']; 
	$titulo_doc=$_POST['titulo_doc']; 
	$fecha_emision=$_POST['fecha_emision']; 
	$condicion=$_POST['condicion_h']; 
	$memo_unidad=$_POST['unidades_referencia']; 
	$memo_correlativo=$_POST['unidades_numero']; 
	$memo_fecha=$_POST['unidades_anio']; 		
	$fecha_recep=$_POST['fecha_recepcion']; 
	$rec_archivo=$_POST['fisico_digital']; 
	$observaciones=$_POST['observaciones']; 	
	$usuario_solic=$_POST['usuario_solic']; 	
	$fecha_ing= date('Y-m-d');
	$revision_anterior = $rev -1;
	
	include('conexion.php');
	// Guardando datos en la tabla inf_codigo
	$sql = "SELECT * FROM inf_codigo WHERE cod_doc='$cod_doc' AND rev='$rev'";
	$q=mysql_query($sql,$conexion);
	$cont=mysql_num_rows($q);
	if($cont==0){
		
		$sql = "INSERT INTO inf_codigo (cod_doc, tipo_doc, sigla_doc, rev, usuario_solic, titulo_doc, fecha_ing, estatus) VALUE ('$cod_doc','$tipo_doc','$sigla_doc','$rev','$usuario_solic','$titulo_doc','$fecha_ing', '1')";
		$accion=mysql_query($sql,$conexion);
		
		// Actualiza el estatus de la revisión anterior en la tabla inf_codigo
		$sql="UPDATE inf_codigo SET estatus='333' WHERE cod_doc='$cod_doc' AND rev='$revision_anterior'";	
		$ingreso=mysql_query($sql,$conexion);
		
		// Guardando datos en la tabla rec_doc
		$sql = "INSERT INTO rec_doc (cod_doc, fecha_emision, condicion, memo_unidad, memo_correlativo, memo_fecha, fecha_recep, rec_archivo, observaciones, usuario_ing, fecha_ing, rev) VALUE ('$cod_doc','$fecha_emision', '$condicion', '$memo_unidad' , '$memo_correlativo', '$memo_fecha', '$fecha_recep', '$rec_archivo', '$observaciones', '". $users[0] ."', '$fecha_ing', '$rev')";
			$ingreso=mysql_query($sql,$conexion);
		
		echo '<html><head><meta http-equiv="REFRESH" content="0; url=buscar_evaluacion.php"></head></html>';
		}
		
}//<><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><>
// Modificar Contraseña de Usuario
$guardar_modif_cuenta=$_POST['guardar_modif_cuenta'];
isset($guardar_modif_cuenta);
if($guardar_modif_cuenta == 'guardar_modif_cuenta'){
	
	$usuario=$_POST['usuario_h'];
	$actual=$_POST['actual'];
	$actual = md5($actual);
	$nueva=$_POST['nueva'];
	$nueva_repite=$_POST['nueva_repite'];
	include("conexion.php");
	$sql = "SELECT contrasenia FROM usuario WHERE usuario='$usuario' AND contrasenia='$actual'";
	$seleccion=mysql_query($sql,$conexion);
	$cont=mysql_num_rows($seleccion);
	
	
	if($cont!=0){
	
		// Validando variables $nueva y $nueva_repite
		if(($nueva=="" && $nueva_repite=="") && ($nueva!=$nueva_repite)){
				?><script>alert("El Campo 'Nueva Contraseña' y 'Repite Nueva Contraseña deben ser iguales");</script><?	
				echo '<html><head><meta http-equiv="REFRESH" content="0; url=configuracion_cuenta.php"></head></html>';
			}else{
					// Actualiza la contraseña
					$nueva = md5($nueva);
					$sql="UPDATE usuario SET contrasenia='$nueva' WHERE usuario='$usuario'";	
					$ingreso=mysql_query($sql,$conexion);	
					mysql_close();
					?><script>alert("La Contraseña fue cambiada satisfactoriamente - Ingrese Nuevamente al Sistema con la Nueva Contraseña");</script><?	
					echo '<html><head><meta http-equiv="REFRESH" content="0; url=cerrar_sesion.php"></head></html>';		
				}
		
		
		}else{
			?><script>alert("La Contraseña Actual NO es Correcta");</script><?
			echo '<html><head><meta http-equiv="REFRESH" content="0; url=configuracion_cuenta.php"></head></html>';
			}
	
	
	}
	//<><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><>
// Agregar Usuario
$agregar_usuario=$_POST['agregar_usuario'];
isset($agregar_usuario);
if($agregar_usuario == 'agregar_usuario'){
	$usuario = $_POST['usuario'];
	$cedula = $_POST['cedula'];
	$nombre = $_POST['nombre'];
	$apellido = $_POST['apellido'];
	$cod_unidad = $_POST['unidad'];
	$privilegio = $_POST['privilegio'];
	$nombre_usuario = $nombre . " " . $apellido;
	$contrasenia = md5($cedula);
	$correo = $_POST['correo'];
	/*
	Obteniendo la denominación de la unidad
	*/
	include('conexion.php');
	
	$sql = "SELECT denominacion FROM unidades WHERE sigla_unid='$cod_unidad'";
	$seleccion = mysql_query($sql,$conexion);
		while ($row = mysql_fetch_array($seleccion)){
			$unidad = $row[0];
			}
			
	/*	
	echo "<pre>";
	print_r($_POST);
	echo "</pre>"; 
	*/
	
	$sql = "SELECT usuario,cedula FROM usuario WHERE usuario='$usuario' OR cedula='$cedula'";
	$seleccion=mysql_query($sql,$conexion);
	$cont=mysql_num_rows($seleccion);
	if($cont==0){
		$sql = "INSERT INTO usuario (usuario, contrasenia, nombre_usuario, cedula, correo, cod_unidad, unidad, privilegio) VALUES ('$usuario', '$contrasenia', '$nombre_usuario', '$cedula', '$correo', '$cod_unidad', '$unidad', '$privilegio')";
		$seleccion=mysql_query($sql,$conexion);
			?><script>alert("Usuario agregado exitosamente");</script><?
			echo '<html><head><meta http-equiv="REFRESH" content="0; url=agregar_usuario.php"></head></html>';
		}else{
			?><script>alert("Ya existe un usuario con el nombre de usuario y/o contraseña");</script><?
			echo '<html><head><meta http-equiv="REFRESH" content="0; url=agregar_usuario.php"></head></html>';
			}

}
//<><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><>

//<><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><>
// Modificar Usuario
$modif_cuenta_usuario=$_POST['modif_cuenta_usuario'];
isset($modif_cuenta_usuario);
if($modif_cuenta_usuario == 'modif_cuenta_usuario'){
	$usuario = $_POST['usuario'];
	$cedula = $_POST['cedula'];
	$nombre_usuario = $_POST['nombre'];
	$cod_unidad = $_POST['unidad'];
	$privilegio = $_POST['privilegio'];
	$id = $_POST['id'];
	/*
	Obteniendo la denominación de la unidad
	*/
	include('conexion.php');
	
	$sql = "SELECT denominacion FROM unidades WHERE sigla_unid='$cod_unidad'";
	$seleccion = mysql_query($sql,$conexion);
		while ($row = mysql_fetch_array($seleccion)){
			$unidad = $row[0];
			}
			
	/*	
	echo "<pre>";
	print_r($_POST);
	echo "</pre>"; 
	*/
	
	
		$sql = "UPDATE usuario SET usuario='$usuario', nombre_usuario='$nombre_usuario', cedula='$cedula', cod_unidad='$cod_unidad', unidad='$unidad', privilegio='$privilegio' WHERE id='$id'";
		$seleccion=mysql_query($sql,$conexion);
			?><script>alert("Usuario actualizado exitosamente");</script><?
			echo '<html><head><meta http-equiv="REFRESH" content="0; url=buscar_usuario_modif.php"></head></html>';
}
//<><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><>

//<><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><>
// Eliminar Usuario
$eliminar_cuenta_usuario=$_POST['eliminar_cuenta_usuario'];
isset($eliminar_cuenta_usuario);
if($eliminar_cuenta_usuario == 'eliminar_cuenta_usuario'){
	$usuario = $_POST['usuario'];
	/* Obteniendo la denominación de la unidad */
	include('conexion.php');
	$sql = "UPDATE usuario SET privilegio='desactivado' WHERE usuario='$usuario'";
	$seleccion = mysql_query($sql,$conexion);
	?><script>alert("Usuario eliminado exitosamente");</script><?
	echo '<html><head><meta http-equiv="REFRESH" content="0; url=buscar_usuario_eliminar.php"></head></html>';
}
//<><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><>


//<><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><>
// Reniciar Contrasenia de Usuario
$reinicio_contrasenia_usuario=$_POST['reinicio_contrasenia_usuario'];
isset($reinicio_contrasenia_usuario);
if($reinicio_contrasenia_usuario == 'reinicio_contrasenia_usuario'){
	$id = $_POST['id'];
	$contrasenia = '123456';
	$contrasenia = md5($contrasenia);
		include('conexion.php');
		$sql = "UPDATE usuario SET contrasenia='$contrasenia' WHERE id='$id'";
		$seleccion=mysql_query($sql,$conexion);
			?><script>alert("Reinicio Exitoso");</script><?
			echo '<html><head><meta http-equiv="REFRESH" content="0; url=buscar_usuario_reinicio.php"></head></html>';
}
//<><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><>



	//<><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><>
// Agregar Unidad
$agregar_unidad=$_POST['agregar_unidad'];
isset($agregar_unidad);
if($agregar_unidad == 'agregar_unidad'){
	$denominacion = $_POST['unidad'];
		$denominacion = strtolower($denominacion) ; // Transforma la denominacion en minúsculas. 
		$denominacion = ucwords($denominacion); // Pasa a mayúsculas solo la primera letra de cada palabra .
	$sigla_unid = $_POST['sigla_unid'];
		$sigla_unid = strtoupper($sigla_unid); // Transforma las siglas en mayúsculas. Ej: AA
	$sigla_doc = $_POST['sigla_doc'];
		$sigla_doc = $sigla_doc . $sigla_unid; // Una las siglas de la unidad con la unidad que depende. EJ: GPAA
	/*
	Obteniendo la denominación de la unidad
	*/
	include('conexion.php');
	
	/*	
	echo "<pre>";
	print_r($_POST);
	echo "</pre>"; 
	*/
	
	$sql = "SELECT * FROM unidades WHERE denominacion='$denominacion' OR sigla_unid='$sigla_unid'";
	$seleccion=mysql_query($sql,$conexion);
	$cont=mysql_num_rows($seleccion);
	if($cont==0){
		$sql = "INSERT INTO unidades (sigla_unid, denominacion, sigla_doc) VALUES ('$sigla_unid', '$denominacion', '$sigla_doc')";
		$seleccion=mysql_query($sql,$conexion);
			?><script>alert("Unidad agregada exitosamente");</script><?
			echo '<html><head><meta http-equiv="REFRESH" content="0; url=agregar_unidad.php"></head></html>';
		}else{
			?><script>alert("Ya existe una Unidad registrada con ese Nombre y/o Siglas");</script><?
			echo '<html><head><meta http-equiv="REFRESH" content="0; url=agregar_unidad.php"></head></html>';
			}
	

}
//<><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><>

//<><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><>
// Modificar Unidad
$modif_cuenta_unidad=$_POST['modif_cuenta_unidad'];
isset($modif_cuenta_unidad);
if($modif_cuenta_unidad == 'modif_cuenta_unidad'){
	$denominacion = $_POST['unidad'];
		$denominacion = strtolower($denominacion) ; // Transforma la denominacion en minúsculas. 
		$denominacion = ucwords($denominacion); // Pasa a mayúsculas solo la primera letra de cada palabra .
	$sigla_unid = $_POST['sigla_unid'];
		$sigla_unid = strtoupper($sigla_unid); // Transforma las siglas en mayúsculas. Ej: AA
	$sigla_doc = $_POST['sigla_doc'];
	$id = $_POST['id'];
	/*	
	echo "<pre>";
	print_r($_POST);
	echo "</pre>"; 
	*/
	
	
	include('conexion.php');
	
	$sql = "SELECT * FROM unidades WHERE id!='$id' AND (denominacion='$denominacion' OR sigla_unid='$sigla_unid')";
	$seleccion = mysql_query($sql,$conexion);
	$cont=mysql_num_rows($seleccion);
	if($cont==0){
	
		// Valida que la unida y su dependencia sean iguales a PE
		if(($sigla_unid==="PE") && ($sigla_doc==="PE")){
				// Else solo en caso de que sea PE
				$sql = "UPDATE unidades SET denominacion='$denominacion', sigla_unid='$sigla_unid', sigla_doc='$sigla_doc' WHERE id='$id'";
				$seleccion=mysql_query($sql,$conexion);
				?><script>alert("Usuario actualizado exitosamente");</script><?
				echo '<html><head><meta http-equiv="REFRESH" content="0; url=buscar_unidad_modif.php"></head></html>';
				
			
		}else {
				// Valida la unidad y su dependencia
				switch ($sigla_doc){
					// Si son iguales
					case $sigla_unid :
					?><script>alert("La Unidad y la unidad a la que depende deben ser diferentes, modificación No exitosa");</script><?
					echo '<html><head><meta http-equiv="REFRESH" content="0; url=buscar_unidad_modif.php"></head></html>';
					break;
					// Si son Diferentes
					default:
					$sigla_doc = $sigla_doc . $sigla_unid; // Una las siglas de la unidad con la unidad que depende. EJ: GPAA
					//echo '<br>' . $sigla_doc;
					$sql = "UPDATE unidades SET denominacion='$denominacion', sigla_unid='$sigla_unid', sigla_doc='$sigla_doc' WHERE id='$id'";
					$seleccion=mysql_query($sql,$conexion);
					?><script>alert("Usuario actualizado exitosamente");</script><?
					echo '<html><head><meta http-equiv="REFRESH" content="0; url=buscar_unidad_modif.php"></head></html>';
					}
		}
	}else{
		?><script>alert("Ya existe una Unidad registrada con ese Nombre y/o Siglas");</script><?
		echo '<html><head><meta http-equiv="REFRESH" content="0; url=buscar_unidad_modif.php"></head></html>';
		}
	
	
}
//<><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><>

//<><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><>
// Eliminar Unidad
$eliminar_cuenta_unidad=$_POST['eliminar_cuenta_unidad'];
isset($eliminar_cuenta_unidad);
if($eliminar_cuenta_unidad == 'eliminar_cuenta_unidad'){
	$sigla_unid = $_POST['sigla_unid'];
	/* Obteniendo la denominación de la unidad */
	include('conexion.php');
	$sql = "DELETE FROM unidades WHERE sigla_unid='$sigla_unid'";
	$seleccion = mysql_query($sql,$conexion);
	?><script>alert("Usuario eliminado exitosamente");</script><?
	echo '<html><head><meta http-equiv="REFRESH" content="0; url=buscar_unidad_eliminar.php"></head></html>';
}
//<><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><>

	//<><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><>
// Agregar Tipo de Documento
$agregar_tipodoc=$_POST['agregar_tipodoc'];
isset($agregar_tipodoc);
if($agregar_tipodoc == 'agregar_tipodoc'){
	$nombre = $_POST['nombre'];
		$nombre = strtolower($nombre) ; // Transforma el nombre en minúsculas. 
		$nombre = ucwords($nombre); // Pasa a mayúsculas solo la primera letra de cada palabra .
	$sigla_doc = $_POST['sigla_doc'];
		$sigla_doc = strtoupper($sigla_doc); // Transforma las siglas en mayúsculas. Ej: AA
	include('conexion.php');
	/*	
	echo "<pre>";
	print_r($_POST);
	echo "</pre>"; 
	*/
	
	$sql = "SELECT * FROM cat_tipodoc WHERE sigla_doc='$sigla_doc' OR nombre='$nombre'";
	$seleccion=mysql_query($sql,$conexion);
	$cont=mysql_num_rows($seleccion);
	if($cont==0){
		$sql = "INSERT INTO cat_tipodoc (sigla_doc, nombre) VALUES ('$sigla_doc', '$nombre')";
		$seleccion=mysql_query($sql,$conexion);
			?><script>alert("Tipo de Documento agregado exitosamente");</script><?
			echo '<html><head><meta http-equiv="REFRESH" content="0; url=agregar_tipodoc.php"></head></html>';
		}else{
			?><script>alert("Ya existe un Tipo de Documento registrado con ese Nombre y/o Siglas");</script><?
			echo '<html><head><meta http-equiv="REFRESH" content="0; url=agregar_tipodoc.php"></head></html>';
			}
	

}
//<><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><>

//<><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><>
// Modificar Tipo de Documento
$modif_tipodoc=$_POST['modif_tipodoc'];
isset($modif_tipodoc);
if($modif_tipodoc == 'modif_tipodoc'){
	$nombre = $_POST['nombre'];
		$nombre = strtolower($nombre) ; // Transforma la denominacion en minúsculas. 
		$nombre = ucwords($nombre); // Pasa a mayúsculas solo la primera letra de cada palabra .
	$sigla_doc = $_POST['sigla_doc'];
		$sigla_doc = strtoupper($sigla_doc); // Transforma las siglas en mayúsculas. Ej: AA
	$id = $_POST['id'];
	/*	
	echo "<pre>";
	print_r($_POST);
	echo "</pre>"; 
	*/
	include('conexion.php');
		// Verificando que no existe un registro igual
		$sql = "SELECT * FROM cat_tipodoc WHERE id!='$id' AND (nombre='$nombre' OR sigla_doc='$sigla_doc')";
		$seleccion = mysql_query($sql,$conexion);
		$cont = mysql_num_rows($seleccion);
		if($cont==0){
		// Actualiza un Tipo de Documento
		$sql = "UPDATE cat_tipodoc SET sigla_doc='$sigla_doc', nombre='$nombre' WHERE id='$id'";
		$seleccion=mysql_query($sql,$conexion);
		?><script>alert("Tipo de Documento actualizado exitosamente");</script><?
		echo '<html><head><meta http-equiv="REFRESH" content="0; url=buscar_tipodoc_modif.php"></head></html>';
		}else{
			?><script>alert("Ya existe un Tipo de Documento registrado con ese Nombre y/o Siglas");</script><?
			echo '<html><head><meta http-equiv="REFRESH" content="0; url=buscar_tipodoc_modif.php"></head></html>';
			}
}
//<><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><>

//<><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><>
// Eliminar Tipo de Documento
$eliminar_tipodoc=$_POST['eliminar_tipodoc'];
isset($eliminar_tipodoc);
if($eliminar_tipodoc == 'eliminar_tipodoc'){
	$id = $_POST['id'];
	/* Obteniendo la denominación de la unidad */
	include('conexion.php');
	$sql = "DELETE FROM cat_tipodoc WHERE id='$id'";
	$seleccion = mysql_query($sql,$conexion);
	?><script>alert("Tipo de Documento eliminado exitosamente");</script><?
	echo '<html><head><meta http-equiv="REFRESH" content="0; url=buscar_tipodoc_eliminar.php"></head></html>';
}
//<><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><>


//<><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><>
// Modificar Criterio
$modif_criterio=$_POST['modif_criterio'];
isset($modif_criterio);
if($modif_criterio == 'modif_criterio'){
	$titulo = $_POST['titulo'];
	$detalles = $_POST['detalles'];
	$id = $_POST['id'];
	/*	
	echo "<pre>";
	print_r($_POST);
	echo "</pre>"; 
	*/
	include('conexion.php');
		// Verificando que no existe un registro igual
		$sql = "SELECT * FROM cat_crit_evaluacion WHERE id!='$id' AND (titulo='$titulo' OR detalles='$detalles')";
		$seleccion = mysql_query($sql,$conexion);
		$cont = mysql_num_rows($seleccion);
		if($cont==0){
		// Actualiza un Tipo de Documento
		$sql = "UPDATE cat_crit_evaluacion SET titulo='$titulo', detalles='$detalles' WHERE id='$id'";
		$seleccion=mysql_query($sql,$conexion);
		?><script>alert("Criterio actualizado exitosamente");</script><?
		echo '<html><head><meta http-equiv="REFRESH" content="0; url=buscar_criterio_modif.php"></head></html>';
		}else{
			?><script>alert("Ya existe un Criterio registrado con ese Título y/o Detalles");</script><?
			echo '<html><head><meta http-equiv="REFRESH" content="0; url=buscar_criterio_modif.php"></head></html>';
			}
}
//<><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><>

?>



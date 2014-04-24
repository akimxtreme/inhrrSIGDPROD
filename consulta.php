<?php session_start(); ?>
<?php 
// Variables de sesión
$usuario =$_SESSION['usuario'];
$nombre_usuario =$_SESSION['nombre_usuario'];
$privilegio = $_SESSION['privilegio'];
$ultimoAcceso =$_SESSION['ultimoAcceso'];
	if($privilegio==777 || $privilegio==1 || $privilegio==2){
		include_once('inactividad.php');
		inactivo($ultimoAcceso);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/plantilla.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="icon" href="imagenes/planta_vacunas.png"/>
<!-- InstanceBeginEditable name="doctitle" -->
<title>Bienvenido al Sistema de Gestión de Documentos - Planta Productora de Vacunas</title>
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
// Tomando las siglas de la unidad del usuario
include("conexion.php");
$sql = "SELECT cod_unidad FROM usuario WHERE usuario='$usuario'";
$seleccion=mysql_query($sql,$conexion);
				while ($row = mysql_fetch_array($seleccion)){
						$unidad_usuario=$row[0];
				}
				

configuracion ($nombre_usuario,$privilegio);
	
inf_codigo("inf_codigo","");

echo '<div class="ordenar">';
if($privilegio==777 || $privilegio==2){
	// Menú de búsqueda por tipo de documento
	menu_tipo_documento("Módulos del Sistema","modulos_sistema");
	echo '<h1 class="tituto_tipo_documento">Documentos Controlados</h1>';	
	}else{
		echo '<h1 class="tituto_tipo_documento" style="width:98%;">Documentos Controlados</h1>';	

		}
echo '</div>';

$lista_maestra ="'lm'";
$titulo_lm = "'lista_maestra'";
$documentos_anteriores ="'da'";
$titulo_da = "'documentos_anteriores'";
$valor = "'consulta.php'";
echo '<div class="ordenar">';
		echo '<div class="ordenar_2">';
				echo '<div class="menu">';
					echo '<h1 onclick="javascript:location.href='. $valor .';">CONSULTA DE DOCUMENTOS POR CAMPO &raquo;</h1>';
				echo '</div>';
				
				echo '<div class="menu">';
					echo '<h1 onclick="consulta('. $lista_maestra .','. $titulo_lm .');">VER LISTA MAESTRA &raquo;</h1>';
				echo '</div>';
				if($privilegio==777 || $privilegio==2){
				echo '<div class="menu">';
					echo '<h1 onclick="consulta('. $documentos_anteriores .','. $titulo_da .');">VER DOCUMENTOS ANTERIORES CONTROLADOS &raquo;</h1>';
				echo '</div>';				
				}
				
				echo '<div class="menu">';
			echo '<h1>TIPO DE DOCUMENTOS<br>CONTROLADOS</h1>';
				include("conexion.php");
				$sql="SELECT DISTINCT tipo_doc FROM inf_codigo WHERE estatus='777' OR estatus='999' OR estatus='333'";
				$seleccion=mysql_query($sql,$conexion);
				while ($row = mysql_fetch_array($seleccion)){
						$tipo_doc=$row[0];
						//
						
						$sql2="SELECT nombre FROM cat_tipodoc WHERE sigla_doc='$tipo_doc'";
						$seleccion2=mysql_query($sql2,$conexion);
						while ($row2 = mysql_fetch_array($seleccion2)){
							$nombre=$row2[0];
							
							echo '<div>';
							echo '<strong>'. $tipo_doc .'</strong>';
							echo '<a href="consulta.php?consulta='. $tipo_doc .'&titulo=tipo_documento" title="">'. $nombre .' &raquo;</a>';
							echo '</div>';
						}
						
						
				}
	
			echo '</div>';
			
			echo '<div class="menu">';
			echo '<h1>UNIDADES CON DOCUMENTOS<br>CONTROLADOS</h1>';
				include("conexion.php");
				$sql="SELECT DISTINCT sigla_doc FROM inf_codigo WHERE estatus='777' OR estatus='999' OR estatus='333'";
				$seleccion=mysql_query($sql,$conexion);
				while ($row = mysql_fetch_array($seleccion)){
						$sigla_doc=$row[0];
						//
						
						$sql2="SELECT sigla_unid, denominacion FROM unidades WHERE sigla_doc='$sigla_doc'";
						$seleccion2=mysql_query($sql2,$conexion);
						while ($row2 = mysql_fetch_array($seleccion2)){
							$sigla_unid=$row2[0];
							$denominacion=$row2[1];
							
							
							echo '<div>';
							echo '<strong>'. $sigla_unid .'</strong>';
							echo '<a href="consulta.php?consulta='. $sigla_unid .'&titulo=unidades" title="">'. $denominacion .' &raquo;</a>';
							echo '</div>';
						}
						
						
				}
	
			echo '</div>';
			if($privilegio==777 || $privilegio==2){
			echo '<div class="menu">';
			echo '<h1>VIGENCIA DE PROCEDIMIENTOS DE OPERACIÓN NORMALIZADOS</h1>';
						echo '<div>';
							echo '<strong>PON</strong>';
							echo '<a href="consulta.php?consulta=tecnico&titulo=procedimiento" title="PON - Tipo de Procedimiento Técnico">Técnico &raquo;</a>';
							echo '</div>';
							echo '<div>';
							echo '<strong>PON</strong>';
							echo '<a href="consulta.php?consulta=administrativo&titulo=procedimiento" title="PON - Tipo de Procedimiento Administrativo">Administrativo &raquo;</a>';
							echo '</div>';
	
			echo '</div>';
			}
				
			
			
				
		echo '</div>';

	echo '<div class="ordenar_3">';
		
	
$consulta = $_GET['consulta'];
isset($acceder);
if($consulta==""){
// CONSULTA GENERAL
// <><><><><><><><><><><><> Formulario de Solicitud de Códigos <><><><><><><><><><><><><><><><>
formulario_inicio ("Consulta de Documentos por Campo","formulario","consulta_global","","GET","","","","","");
	text ("Código del Documento","formulario","cod_doc","cod_doc","000_0000_000","12","","","","","","Ejemplo: PON_PEAC_001");
	text ("Revisión","formulario","rev","rev","","2","","","2","","","Ejemplo: 3");
	select ("Unidad","formulario","sigla_doc","sigla_doc","","unidades","formulario","","Ejemplo: ACCC - (Control de Calidad)");
	select ("Tipo de Documento","formulario","tipo_doc","pon_asociado(this);","","cat_tipodoc","formulario","","Ejemplo: DOC - (Documentos Generales)");
	textarea ("Título del documento","formulario_textarea","titulo_doc","titulo_doc","","","","","formulario_textarea","","obligatorio","Ejemplo: Control de la Documentación de la Planta Productora de Vacunas");
	paginas_calendario();
	fecha ("Desde","formulario","desde","desde","","","","","");
	fecha ("Hasta","formulario","hasta","hasta","","","","","");
	hidden('titulo','form');
	boton ("Consultar","formulario","consulta","formulario","","formulario_boton");
formulario_cierre ();
// <><><><><><><><><><><><><><><><>><><><><><><><><><><><><><><><>><><><><><><><><><><><><><><>

echo '
<table class="formulario_global">
<tr class="formulario">
<th class="formulario_2" style=" text-shadow: 0px 0px 2px #000000; width:95.3%">DOCUMENTOS CONTROLADOS</th>
</tr>
<tr class="formulario">
<th class="formulario" id="fecha">Código</th>
<th class="formulario" id="titulo_documento">Título del Documento</th>
<th class="formulario" id="nro_revision">Revisión</th>
<!--<th class="formulario" id="estado">Estado</th>-->
<th class="formulario" id="fecha">Fecha</th>
<th class="formulario" id="condicion">Condición</th>
<th class="formulario" id="archivo">Archivo</th>
</tr>
';

include ('conexion.php');
$sql="SELECT cod_doc, rev, titulo_doc FROM inf_codigo WHERE estatus='777' OR estatus='999' OR estatus='333'";
				$seleccion=mysql_query($sql,$conexion);
				while ($row = mysql_fetch_array($seleccion)){
						$cod_doc=$row[0];
						$rev=$row[1];
						$titulo_documento=$row[2];
				echo '	
						<tr class="formulario">
						<td class="fecha" style="font-weight:bold;text-align:right;">'. $cod_doc .'</td>
						<td class="titulo_documento">'. $titulo_documento .'</td>
						<td class="nro_revision">'. $rev .'</td>
						
						';	
					
					$sql2="SELECT fecha FROM implementacion_doc WHERE cod_doc='$cod_doc' AND rev='$rev'";
					$seleccion2=mysql_query($sql2,$conexion);	
					while ($row = mysql_fetch_array($seleccion2)){
							$fecha=$row[0];
					echo '<td class="fecha">'. $fecha .'</td>';
					
						$sql3="SELECT condicion FROM rec_doc WHERE cod_doc='$cod_doc' AND rev='$rev'";
						$seleccion3=mysql_query($sql3,$conexion);	
						while ($row = mysql_fetch_array($seleccion3)){
							$condicion=$row[0];
							if($condicion=="Confidencial"){
								echo '<td class="condicion"><img class="condicion" src="imagenes/privado.png" title="Documento Confidencial" /></td>';
								}else{
									echo '<td class="condicion"><img class="condicion" src="imagenes/publico.png" title="Acceso Público" /></td>';
									}
							$sql4="SELECT tipo_adjunto, ruta_adjunto, cod_doc FROM evaluacion_doc WHERE cod_doc='$cod_doc' AND rev='$rev'";
							$seleccion4=mysql_query($sql4,$conexion);	
							//echo $unidad_usuario;
							while ($row = mysql_fetch_array($seleccion4)){
								$tipo_adjunto=$row[0];
								$ruta_adjunto=$row[1];
								$compara=$row[2];
								if($condicion=="Confidencial"){
										$sql5 = "SELECT sigla_unid FROM unidades_confidencial WHERE cod_doc='$cod_doc' AND sigla_unid='$unidad_usuario'";
										$seleccion5=mysql_query($sql5,$conexion);	
										$cont=mysql_num_rows($seleccion5);
										
										if(($cont!=0) || ($privilegio==777) || ($privilegio==2)){
											echo '<td class="archivo"><a href="'. $ruta_adjunto . $tipo_adjunto . '" title="'. $cod_doc .'" target="_blank"><img class="archivo" src="imagenes/archivo.png" title="'. $cod_doc .' Revisión ('.$rev.')" /></a></td>';
											echo '</tr>';
										}else{
											echo '<td class="archivo"><a href="#"><img class="archivo" src="imagenes/protegido.png" title="'. $cod_doc .' Revisión ('.$rev.')" /></a></td>';
											echo '</tr>';
											
											}
									}else{
										echo '<td class="archivo"><a href="'. $ruta_adjunto . $tipo_adjunto . '" title="'. $cod_doc .'" target="_blank"><img class="archivo" src="imagenes/archivo.png" title="'. $cod_doc .' Revisión ('.$rev.')" /></a></td>';
										echo '</tr>';
									} 
							} // sql4
						} // sql3
					} // sql2
				} // sql


	echo '</div>';
		
			
			
echo '</div></table>';

}else{
	$titulo = $_GET['titulo'];
	switch($titulo){
			// Lista Maestra
			case 'lista_maestra':
				
				// CONSULTA LISTA MAESTRA
echo '
<table class="formulario_global">
<tr class="formulario">
<th class="formulario_2" style=" text-shadow: 0px 0px 2px #000000; width:95.3%">LISTA MAESTRA</th>
</tr>
<tr class="formulario">
<th class="formulario" id="fecha">Código</th>
<th class="formulario" id="titulo_documento">Título del Documento</th>
<th class="formulario" id="nro_revision">Revisión</th>
<!--<th class="formulario" id="estado">Estado</th>-->
<th class="formulario" id="fecha">Fecha</th>
<th class="formulario" id="condicion">Condición</th>
<th class="formulario" id="archivo">Archivo</th>
</tr>
';

include ('conexion.php');
$sql="SELECT cod_doc, rev, titulo_doc FROM inf_codigo WHERE estatus='777' OR estatus='999' OR estatus='333'";
				$seleccion=mysql_query($sql,$conexion);
				while ($row = mysql_fetch_array($seleccion)){
						$cod_doc=$row[0];
						$rev=$row[1];
						$titulo_documento=$row[2];
				echo '	
						<tr class="formulario">
						<td class="fecha" style="font-weight:bold;text-align:right;">'. $cod_doc .'</td>
						<td class="titulo_documento">'. $titulo_documento .'</td>
						<td class="nro_revision">'. $rev .'</td>
						
						';	
					
					$sql2="SELECT fecha FROM implementacion_doc WHERE cod_doc='$cod_doc' AND rev='$rev'";
					$seleccion2=mysql_query($sql2,$conexion);	
					while ($row = mysql_fetch_array($seleccion2)){
							$fecha=$row[0];
					echo '<td class="fecha">'. $fecha .'</td>';
					
						$sql3="SELECT condicion FROM rec_doc WHERE cod_doc='$cod_doc' AND rev='$rev'";
						$seleccion3=mysql_query($sql3,$conexion);	
						while ($row = mysql_fetch_array($seleccion3)){
							$condicion=$row[0];
							if($condicion=="Confidencial"){
								echo '<td class="condicion"><img class="condicion" src="imagenes/privado.png" title="Documento Confidencial" /></td>';
								}else{
									echo '<td class="condicion"><img class="condicion" src="imagenes/publico.png" title="Acceso Público" /></td>';
									}
							$sql4="SELECT tipo_adjunto, ruta_adjunto FROM evaluacion_doc WHERE cod_doc='$cod_doc' AND rev='$rev'";
							$seleccion4=mysql_query($sql4,$conexion);	
							while ($row = mysql_fetch_array($seleccion4)){
								$tipo_adjunto=$row[0];
								$ruta_adjunto=$row[1];
								if($condicion=="Confidencial"){
										$sql5 = "SELECT sigla_unid FROM unidades_confidencial WHERE cod_doc='$cod_doc' AND sigla_unid='$unidad_usuario'";
										$seleccion5=mysql_query($sql5,$conexion);	
										$cont=mysql_num_rows($seleccion5);
										if(($cont!=0) || ($privilegio==777) || ($privilegio==2)){
											echo '<td class="archivo"><a href="'. $ruta_adjunto . $tipo_adjunto . '" title="'. $cod_doc .'" target="_blank"><img class="archivo" src="imagenes/archivo.png" title="'. $cod_doc .' Revisión ('.$rev.')" /></a></td>';
											echo '</tr>';
										}else{
											echo '<td class="archivo"><a href="#"><img class="archivo" src="imagenes/protegido.png" title="'. $cod_doc .' Revisión ('.$rev.')" /></a></td>';
											echo '</tr>';
											}
									}else{
										echo '<td class="archivo"><a href="'. $ruta_adjunto . $tipo_adjunto . '" title="'. $cod_doc .'" target="_blank"><img class="archivo" src="imagenes/archivo.png" title="'. $cod_doc .' Revisión ('.$rev.')" /></a></td>';
										echo '</tr>';
									} 
								
							} // sql4
						} // sql3
					} // sql2
				} // sql


	echo '</div>';
		
			
			
echo '</div></table>';
				
				
				
				
			break;
			
			case 'documentos_anteriores':
			/*
			
			// Titulo de la tabla 
			echo '<table class="formulario_global">';
			echo '<tr class="formulario">';
			echo '<th class="formulario_2" style=" text-shadow: 0px 0px 2px #000000; width:99%">DOCUMENTOS ANTERIORES CONTROLADOS</th>';
			echo '</tr>';
			
			include ('conexion.php');
			// Consulta las siglas de la unidad sin redundancia
			$sql = "SELECT DISTINCT sigla_doc FROM inf_codigo WHERE estatus='111'";
			$seleccion=mysql_query($sql,$conexion);
			while ($row = mysql_fetch_array($seleccion)){
					$sigla_doc=$row[0];
					
				// Consulta la denominacion de la unidad sin redundancia
				$sql1 = "SELECT denominacion FROM unidades WHERE sigla_doc='$sigla_doc'";
				$seleccion1=mysql_query($sql1,$conexion);
				while ($row = mysql_fetch_array($seleccion1)){
					$denominacion=$row[0];
					echo '<tr class="formulario">';
					echo '<th class="formulario" style=" padding:9px 0px 9px 9px; text-align:left; text-shadow: 0px 0px 2px #000000; width:97.7%">Unidad: '. $denominacion .'</th>';
					echo '</tr>';
					
					// Consulta los codigos de un documento sin redundancia
					$sql2 = "SELECT DISTINCT cod_doc FROM inf_codigo";
					$seleccion2=mysql_query($sql2,$conexion);
					while ($row = mysql_fetch_array($seleccion2)){
						$cod_doc=$row[0];
						echo '<tr class="formulario">';
						echo '<th class="formulario" style=" padding:9px 0px 9px 9px; text-align:left; text-shadow: 0px 0px 2px #000000; width:97.7%">Código del Documento: '. $cod_doc .'</th>';
						echo '</tr>';
						echo '<tr class="formulario">';
						echo '<th class="formulario" id="numero">nº</th>';
						echo '<th class="formulario" id="titulo_documento" style="width:54.6%;">Titulo</th>';
						echo '<th class="formulario" id="nro_revision">Revisión</th>';
						echo '<th class="formulario" id="fecha">Fecha</th>';
						echo '<th class="formulario" id="condicion">Condición</th>';
						echo '<th class="formulario" id="archivo">Archivo</th>';
						echo '</tr>';
						
						// Consulta la catidad de Documentos por código
						$sql3 = "SELECT COUNT(cod_doc) FROM inf_codigo WHERE cod_doc='$cod_doc'";
						$seleccion3=mysql_query($sql3,$conexion);
						while ($row = mysql_fetch_array($seleccion3)){
							$count=$row[0];
														
							// Consulta rev, titulo_doc, fecha_ing de la tabla inf_codigo por tipo de revision
							echo '<tr class="formulario">';
							
							for($i=0;$i<=$count;$i++){
								$j = $i + 1;
								$sql4 = 'SELECT rev, titulo_doc, fecha_ing FROM inf_codigo WHERE cod_doc="'.$cod_doc.'" AND rev="'.$i.'"';
								$seleccion4=mysql_query($sql4,$conexion);
								while ($row = mysql_fetch_array($seleccion4)){
									$rev=$row[0];
									$titulo_doc=$row[1];
									$fecha_ing=$row[2];
									echo '<td class="numero">'. $j .'</td>';
									echo '<td class="titulo_documento" style="width:54.6%;">'. $titulo_doc .'</td>';
									echo '<td class="nro_revision">'. $rev .'</td>';
									echo '<td class="fecha">'. $fecha_ing .'</td>';
									
									// Consulta condicion de la tabla rec_doc por tipo de revision
									$sql5 = 'SELECT condicion FROM rec_doc WHERE cod_doc="'.$cod_doc.'" AND rev="'.$i.'"';
									$seleccion5=mysql_query($sql5,$conexion);
									while ($row = mysql_fetch_array($seleccion5)){
										$condicion=$row[0];
										if($condicion=="Confidencial"){
											echo '<td class="condicion"><img class="condicion" src="imagenes/privado.png" title="Documento Confidencial" /></td>';											
											}else{
												echo '<td class="condicion"><img class="condicion" src="imagenes/publico.png" title="Documento Confidencial" /></td>';						
												}
										// Consulta ruta_adjunto, tipo_adjunto de la tabla evaluacion_doc por tipo de revision
										$sql6 = 'SELECT ruta_adjunto, tipo_adjunto FROM evaluacion_doc WHERE cod_doc="'.$cod_doc.'" AND rev="'.$i.'"';
										$seleccion6=mysql_query($sql6,$conexion);
										while ($row = mysql_fetch_array($seleccion6)){
											$ruta_adjunto=$row[0];
											$tipo_adjunto=$row[1];
											echo '<td class="archivo"><a href="'. $ruta_adjunto . $tipo_adjunto . '" title="'. $cod_doc .'" target="_blank"><img class="archivo" src="imagenes/archivo.png" title="'. $cod_doc .' Revisión ('.$i.')" /></a></td>';
									echo '</tr>';
											
										} // fin Consulta ruta_adjunto, tipo_adjunto de la tabla evaluacion_doc por tipo de revision
									} // fin Consulta condicion de la tabla rec_doc por tipo de revision						
								} // fin Consulta la catidad de Documentos por código 
							} // fin del for
							 echo '</tr>';					
						} // fin Consulta la catidad de Documentos por código 
					} // fin Consulta los codigos de un documento sin redundancia
				} // fin denominacion de la unidad sin redundancia
			} // fin siglas de la unidad sin redundancia
			
			echo '</table>';
			*/
			// Maquetación de la Tabla
			echo '<table class="formulario_global">';
			echo '<tr class="formulario">';
			echo '<th class="formulario_2" style=" text-shadow: 0px 0px 2px #000000; width:99.4%">DOCUMENTOS ANTERIORES CONTROLADOS</th>';
			echo '</tr>';
			/*
			echo '<tr class="formulario">';
			echo '<th class="formulario" id="fecha">Código</th>';
			echo '<th class="formulario" id="titulo_documento" style="width:44.4%;">Título del Documento</th>';
			echo '<th class="formulario" id="nro_revision">Revisión</th>';
			echo '<th class="formulario" id="fecha">Fecha</th>';
			echo '<th class="formulario" id="condicion">Condición</th>';
			echo '<th class="formulario" id="archivo">Archivo</th>';
			echo '</tr>';
			*/			
			include('conexion.php');
			
			/*********************************************************************/
			// Paso I (inicio)
			// Consulta las Unidades con Documentos 111
			// Obtiene las siglas con su dependiente Ej: ACCC donde (CC es el Dueño del Documento Controlado)
			$sql = "SELECT DISTINCT sigla_doc FROM inf_codigo WHERE estatus='111' ";
			$seleccion = mysql_query($sql,$conexion);
			$unidades_111 = mysql_num_rows($seleccion);
			while($row = mysql_fetch_array($seleccion)){
				$sigla_doc = $row[0];
				// Imprime las siglas 
				// echo $sigla_doc . "<br>";
				/*********************************************************************/
				// Paso II (inicio)
				// Consulta la Denominación de la Unidad
				// Ej: Si la sigla es CC entonces muestra "Control de Calidad"
				$sql1 = "SELECT denominacion FROM unidades WHERE sigla_doc='$sigla_doc'";
				$seleccion1 = mysql_query($sql1,$conexion);
				while($row = mysql_fetch_array($seleccion1)){
					$denominacion = $row[0];
					// Imprime la Denominación de la unidad
					echo '<tr class="formulario">';
					echo '<th class="formulario_2" style=" text-shadow: 0px 0px 2px #000000; width:99.4%">'. $denominacion .'</th>';
					echo '</tr>';
					/*********************************************************************/
					// Paso III (inicio)
					// Consulta el Código con estatus 111 de la unidad
					$sql2 = "SELECT DISTINCT cod_doc FROM inf_codigo WHERE estatus AND sigla_doc='$sigla_doc' AND estatus='111'";
					$seleccion2 = mysql_query($sql2,$conexion);
					while($row = mysql_fetch_array($seleccion2)){
						$codigo = $row[0];
						// Imprime El Codigo del Documento sin redundancia
						echo '<tr class="formulario">';
						echo '<th class="formulario" style=" text-shadow: 0px 0px 2px #000000; width:99.4%">'. $codigo .'</th>';
						echo '</tr>';
						
						echo '<tr class="formulario">';
						echo '<th class="formulario" id="fecha">Código</th>';
						echo '<th class="formulario" id="titulo_documento" style="width:44.1%;">Título del Documento</th>';
						echo '<th class="formulario" id="nro_revision">Revisión</th>';
						echo '<th class="formulario" id="fecha">Fecha</th>';
						echo '<th class="formulario" id="condicion">Condición</th>';
						echo '<th class="formulario" id="archivo">Archivo</th>';
						echo '</tr>';
						/*********************************************************************/
						// Paso IV (inicio)
						// Consulta el Código, Título, Revisión y Fecha con estatus 111 de la unidad
						$sql3 = "SELECT cod_doc, titulo_doc, rev, fecha_ing FROM inf_codigo WHERE estatus='111' AND cod_doc='$codigo' ";
						$seleccion3 = mysql_query($sql3,$conexion);
						while($row = mysql_fetch_array($seleccion3)){
							$cod_doc = $row[0];
							$titulo_doc = $row[1];
							$rev = $row[2];
							$fecha_ing = $row[3];
							// Imprime: Código, Título, Revisión y Fecha
							echo '<tr class="formulario">';
							echo '<td class="fecha" style="font-weight:bold;text-align:right;">'. $cod_doc .'</td>';
							echo '<td class="titulo_documento" style="width:44.1%;" title="'. $titulo_doc .'">'. $titulo_doc .'</td>';
							echo '<td class="nro_revision">'. $rev .'</td>';
							echo '<td class="fecha">'. $fecha_ing .'</td>';
							//echo "<br>Código: ($cod_doc)  Título ($titulo_doc) Revisión ($rev) Fecha ($fecha_ing)<br>";
							/*
							echo "<br>Código:  $cod_doc <br>";
							echo "<br>Título:  $titulo_doc <br>";
							echo "<br>Revisión:  $rev <br>";
							echo "<br>Fecha:  $fecha_ing <br>";
							*/
							/*********************************************************************/
							// Paso V (inicio)
							$sql4 = "SELECT condicion FROM rec_doc WHERE cod_doc='$codigo' AND rev=$rev";
							$seleccion4 = mysql_query($sql4,$conexion);
							while($row = mysql_fetch_array($seleccion4)){
								$condicion = $row[0];
								// Imprime la Condición 
								if($condicion=="Confidencial"){
								echo '<td class="condicion"><img class="condicion" src="imagenes/privado.png" title="Documento Confidencial" /></td>';
								}else{
									echo '<td class="condicion"><img class="condicion" src="imagenes/publico.png" title="Acceso Público" /></td>';
									}
								//echo "<br>Condición:  $condicion <br>";
								/*********************************************************************/
								// Paso VI (inicio)
								$sql5 = "SELECT ruta_adjunto, tipo_adjunto FROM evaluacion_doc WHERE cod_doc='$codigo' AND rev=$rev";
								$seleccion5 = mysql_query($sql5, $conexion);
								while($row = mysql_fetch_array($seleccion5)){
									$ruta_adjunto = $row[0];
									$tipo_adjunto = $row[1];
									// Imprime la ruta y el nombre del adjunto controlado
									if($condicion=="Confidencial"){
										$sql6 = "SELECT sigla_unid FROM unidades_confidencial WHERE cod_doc='$cod_doc' AND sigla_unid='$unidad_usuario'";
										$seleccion6=mysql_query($sql6,$conexion);	
										$cont=mysql_num_rows($seleccion6);
										if(($cont!=0) || ($privilegio==777) || ($privilegio==2)){
											echo '<td class="archivo"><a href="'. $ruta_adjunto . $tipo_adjunto . '" title="'. $cod_doc .'" target="_blank"><img class="archivo" src="imagenes/archivo.png" title="'. $cod_doc .' Revisión ('.$rev.')" /></a></td>';
											echo '</tr>';
										}else{
											echo '<td class="archivo"><a href="#"><img class="archivo" src="imagenes/protegido.png" title="'. $cod_doc .' Revisión ('.$rev.')" /></a></td>';
											echo '</tr>';
											}
									}else{
										echo '<td class="archivo"><a href="'. $ruta_adjunto . $tipo_adjunto . '" title="'. $cod_doc .'" target="_blank"><img class="archivo" src="imagenes/archivo.png" title="'. $cod_doc .' Revisión ('.$rev.')" /></a></td>';
										echo '</tr>';
									} 						
									}// Paso VI (fin)
								/*********************************************************************/
								}// Paso V (fin)
							/*********************************************************************/
							}// Paso IV (fin)					
						/*********************************************************************/
						}// Paso III (fin)
					/*********************************************************************/
					}// Paso II (fin)
				/*********************************************************************/				
			}// Paso I (fin)			
			/*********************************************************************/
			
			
			/*********************************************************************/
			// toma todos los documentos Reemplazados por una revision anterior
			$sql="SELECT cod_doc FROM inf_codigo WHERE estatus='111'";
			$seleccion=mysql_query($sql,$conexion);
			$cont=mysql_num_rows($seleccion);
				/*while ($row = mysql_fetch_array($seleccion)){
					$cod_doc= $row[0];
					
					echo $cod_doc;
					echo '<br>';
				}*/
			/*********************************************************************/
					/*
					echo "<br>Documentos con Estatus 111 (Documentos Reemplazados Definitivamente por una Revisión)<br>";
					echo "Unidades con Documentos 111: $unidades_111<br>";
					echo "Cantidad de Documentos 111: $cont<br>";
					*/
			mysql_close();
			echo '</table>';
			break;
			
			case 'tipo_documento':
				// CONSULTA POR TIPO DE DOCUMENTO
				
				include ('conexion.php');
				$sql0="SELECT nombre FROM cat_tipodoc WHERE sigla_doc='$consulta'";
				$seleccion0=mysql_query($sql0,$conexion);
				while ($row = mysql_fetch_array($seleccion0)){
						$denominacion=$row[0];
				}
echo '
<table class="formulario_global">
<tr class="formulario">
<th class="formulario_2" style=" text-shadow: 0px 0px 2px #000000; width:95.3%">'. $denominacion . ' - (' . $consulta .')</th>
</tr>
<tr class="formulario">
<th class="formulario" id="fecha">Código</th>
<th class="formulario" id="titulo_documento">Título del Documento</th>
<th class="formulario" id="nro_revision">Revisión</th>
<!--<th class="formulario" id="estado">Estado</th>-->
<th class="formulario" id="fecha">Fecha</th>
<th class="formulario" id="condicion">Condición</th>
<th class="formulario" id="archivo">Archivo</th>
</tr>
';

include ('conexion.php');
$sql="SELECT cod_doc, rev, titulo_doc FROM inf_codigo WHERE (estatus='777' OR estatus='999' OR estatus='333') AND tipo_doc='$consulta'";
				$seleccion=mysql_query($sql,$conexion);
				while ($row = mysql_fetch_array($seleccion)){
						$cod_doc=$row[0];
						$rev=$row[1];
						$titulo_documento=$row[2];
				echo '	
						<tr class="formulario">
						<td class="fecha" style="font-weight:bold;text-align:right;">'. $cod_doc .'</td>
						<td class="titulo_documento">'. $titulo_documento .'</td>
						<td class="nro_revision">'. $rev .'</td>
						
						';	
					
					$sql2="SELECT fecha FROM implementacion_doc WHERE cod_doc='$cod_doc' AND rev='$rev'";
					$seleccion2=mysql_query($sql2,$conexion);	
					while ($row = mysql_fetch_array($seleccion2)){
							$fecha=$row[0];
					echo '<td class="fecha">'. $fecha .'</td>';
					
						$sql3="SELECT condicion FROM rec_doc WHERE cod_doc='$cod_doc' AND rev='$rev'";
						$seleccion3=mysql_query($sql3,$conexion);	
						while ($row = mysql_fetch_array($seleccion3)){
							$condicion=$row[0];
							if($condicion=="Confidencial"){
								echo '<td class="condicion"><img class="condicion" src="imagenes/privado.png" title="Documento Confidencial" /></td>';
								}else{
									echo '<td class="condicion"><img class="condicion" src="imagenes/publico.png" title="Acceso Público" /></td>';
									}
							$sql4="SELECT tipo_adjunto, ruta_adjunto FROM evaluacion_doc WHERE cod_doc='$cod_doc' AND rev='$rev'";
							$seleccion4=mysql_query($sql4,$conexion);	
							while ($row = mysql_fetch_array($seleccion4)){
								$tipo_adjunto=$row[0];
								$ruta_adjunto=$row[1];
								if($condicion=="Confidencial"){
										$sql5 = "SELECT sigla_unid FROM unidades_confidencial WHERE cod_doc='$cod_doc' AND sigla_unid='$unidad_usuario'";
										$seleccion5=mysql_query($sql5,$conexion);	
										$cont=mysql_num_rows($seleccion5);
										if(($cont!=0) || ($privilegio==777) || ($privilegio==2)){
											echo '<td class="archivo"><a href="'. $ruta_adjunto . $tipo_adjunto . '" title="'. $cod_doc .'" target="_blank"><img class="archivo" src="imagenes/archivo.png" title="'. $cod_doc .' Revisión ('.$rev.')" /></a></td>';
											echo '</tr>';
										}else{
											echo '<td class="archivo"><a href="#"><img class="archivo" src="imagenes/protegido.png" title="'. $cod_doc .' Revisión ('.$rev.')" /></a></td>';
											echo '</tr>';
											}
									}else{
										echo '<td class="archivo"><a href="'. $ruta_adjunto . $tipo_adjunto . '" title="'. $cod_doc .'" target="_blank"><img class="archivo" src="imagenes/archivo.png" title="'. $cod_doc .' Revisión ('.$rev.')" /></a></td>';
										echo '</tr>';
									} 
								
							} // sql4
						} // sql3
					} // sql2
				} // sql


	echo '</div>';
		
			
			
echo '</div></table>';
				
			break;
			
			case 'unidades':
				// CONSULTA POR TIPO DE DOCUMENTO
				
				include ('conexion.php');
				$sql0="SELECT denominacion FROM unidades WHERE  sigla_unid='$consulta'";
				$seleccion0=mysql_query($sql0,$conexion);
				while ($row = mysql_fetch_array($seleccion0)){
						$denominacion=$row[0];
				}
echo '
<table class="formulario_global">
<tr class="formulario">
<th class="formulario_2" style=" text-shadow: 0px 0px 2px #000000; width:95.3%">'. $denominacion . ' - (' . $consulta .')</th>
</tr>
<tr class="formulario">
<th class="formulario" id="fecha">Código</th>
<th class="formulario" id="titulo_documento">Título del Documento</th>
<th class="formulario" id="nro_revision">Revisión</th>
<!--<th class="formulario" id="estado">Estado</th>-->
<th class="formulario" id="fecha">Fecha</th>
<th class="formulario" id="condicion">Condición</th>
<th class="formulario" id="archivo">Archivo</th>
</tr>
';


				$sqlx="SELECT sigla_doc FROM unidades WHERE sigla_unid='$consulta'";
				$seleccionx=mysql_query($sqlx,$conexion);
				while ($row = mysql_fetch_array($seleccionx)){
					$sigla_doc=$row[0];
					}


$sql="SELECT cod_doc, rev, titulo_doc FROM inf_codigo WHERE (estatus='777' OR estatus='999' OR estatus='333') AND sigla_doc='$sigla_doc'";
				$seleccion=mysql_query($sql,$conexion);
				while ($row = mysql_fetch_array($seleccion)){
						$cod_doc=$row[0];
						$rev=$row[1];
						$titulo_documento=$row[2];
				echo '	
						<tr class="formulario">
						<td class="fecha" style="font-weight:bold;text-align:right;">'. $cod_doc .'</td>
						<td class="titulo_documento">'. $titulo_documento .'</td>
						<td class="nro_revision">'. $rev .'</td>
						
						';	
					
					$sql2="SELECT fecha FROM implementacion_doc WHERE cod_doc='$cod_doc' AND rev='$rev'";
					$seleccion2=mysql_query($sql2,$conexion);	
					while ($row = mysql_fetch_array($seleccion2)){
							$fecha=$row[0];
					echo '<td class="fecha">'. $fecha .'</td>';
					
						$sql3="SELECT condicion FROM rec_doc WHERE cod_doc='$cod_doc' AND rev='$rev'";
						$seleccion3=mysql_query($sql3,$conexion);	
						while ($row = mysql_fetch_array($seleccion3)){
							$condicion=$row[0];
							if($condicion=="Confidencial"){
								echo '<td class="condicion"><img class="condicion" src="imagenes/privado.png" title="Documento Confidencial" /></td>';
								}else{
									echo '<td class="condicion"><img class="condicion" src="imagenes/publico.png" title="Acceso Público" /></td>';
									}
							$sql4="SELECT tipo_adjunto, ruta_adjunto FROM evaluacion_doc WHERE cod_doc='$cod_doc' AND rev='$rev'";
							$seleccion4=mysql_query($sql4,$conexion);	
							while ($row = mysql_fetch_array($seleccion4)){
								$tipo_adjunto=$row[0];
								$ruta_adjunto=$row[1];
								if($condicion=="Confidencial"){
										$sql5 = "SELECT sigla_unid FROM unidades_confidencial WHERE cod_doc='$cod_doc' AND sigla_unid='$unidad_usuario'";
										$seleccion5=mysql_query($sql5,$conexion);	
										$cont=mysql_num_rows($seleccion5);
										if(($cont!=0) || ($privilegio==777) || ($privilegio==2)){
											echo '<td class="archivo"><a href="'. $ruta_adjunto . $tipo_adjunto . '" title="'. $cod_doc .'" target="_blank"><img class="archivo" src="imagenes/archivo.png" title="'. $cod_doc .' Revisión ('.$rev.')" /></a></td>';
											echo '</tr>';
										}else{
											echo '<td class="archivo"><a href="#"><img class="archivo" src="imagenes/protegido.png" title="'. $cod_doc .' Revisión ('.$rev.')" /></a></td>';
											echo '</tr>';
											}
									}else{
										echo '<td class="archivo"><a href="'. $ruta_adjunto . $tipo_adjunto . '" title="'. $cod_doc .'" target="_blank"><img class="archivo" src="imagenes/archivo.png" title="'. $cod_doc .' Revisión ('.$rev.')" /></a></td>';
										echo '</tr>';
									} 
								
							} // sql4
						} // sql3
					} // sql2
				} // sql


	echo '</div>';
		
			
			
echo '</div></table>';
			break;
			
			
			case 'procedimiento':
				// Variable que tiene contiene los atributos CSS background y color, para los documentos vencidos
			$background = "background: #cf0404; /* Old browsers */

/* IE9 SVG, needs conditional override of 'filter' to 'none' */

background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CiAgPGxpbmVhckdyYWRpZW50IGlkPSJncmFkLXVjZ2ctZ2VuZXJhdGVkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjAlIiB5MT0iMCUiIHgyPSIwJSIgeTI9IjEwMCUiPgogICAgPHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iI2NmMDQwNCIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0b3AtY29sb3I9IiNmZjMwMTkiIHN0b3Atb3BhY2l0eT0iMSIvPgogIDwvbGluZWFyR3JhZGllbnQ+CiAgPHJlY3QgeD0iMCIgeT0iMCIgd2lkdGg9IjEiIGhlaWdodD0iMSIgZmlsbD0idXJsKCNncmFkLXVjZ2ctZ2VuZXJhdGVkKSIgLz4KPC9zdmc+);

background: -moz-linear-gradient(top,  #cf0404 0%, #ff3019 100%); /* FF3.6+ */

background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#cf0404), color-stop(100%,#ff3019)); /* Chrome,Safari4+ */

background: -webkit-linear-gradient(top,  #cf0404 0%,#ff3019 100%); /* Chrome10+,Safari5.1+ */

background: -o-linear-gradient(top,  #cf0404 0%,#ff3019 100%); /* Opera 11.10+ */

background: -ms-linear-gradient(top,  #cf0404 0%,#ff3019 100%); /* IE10+ */

background: linear-gradient(to bottom,  #cf0404 0%,#ff3019 100%); /* W3C */

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#cf0404', endColorstr='#ff3019',GradientType=0 ); /* IE6-8 */
color: #FFFFFF;
";	
	// Variable que tiene contiene los atributos CSS background y color, para los documentos por vencer
			$background2 = "background: #ffd65e; /* Old browsers */

/* IE9 SVG, needs conditional override of 'filter' to 'none' */

background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CiAgPGxpbmVhckdyYWRpZW50IGlkPSJncmFkLXVjZ2ctZ2VuZXJhdGVkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjAlIiB5MT0iMCUiIHgyPSIwJSIgeTI9IjEwMCUiPgogICAgPHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iI2ZmZDY1ZSIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0b3AtY29sb3I9IiNmZWJmMDQiIHN0b3Atb3BhY2l0eT0iMSIvPgogIDwvbGluZWFyR3JhZGllbnQ+CiAgPHJlY3QgeD0iMCIgeT0iMCIgd2lkdGg9IjEiIGhlaWdodD0iMSIgZmlsbD0idXJsKCNncmFkLXVjZ2ctZ2VuZXJhdGVkKSIgLz4KPC9zdmc+);

background: -moz-linear-gradient(top,  #ffd65e 0%, #febf04 100%); /* FF3.6+ */

background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ffd65e), color-stop(100%,#febf04)); /* Chrome,Safari4+ */

background: -webkit-linear-gradient(top,  #ffd65e 0%,#febf04 100%); /* Chrome10+,Safari5.1+ */

background: -o-linear-gradient(top,  #ffd65e 0%,#febf04 100%); /* Opera 11.10+ */

background: -ms-linear-gradient(top,  #ffd65e 0%,#febf04 100%); /* IE10+ */

background: linear-gradient(to bottom,  #ffd65e 0%,#febf04 100%); /* W3C */

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffd65e', endColorstr='#febf04',GradientType=0 ); /* IE6-8 */
";

				if($consulta=="tecnico"){
					$tipo = 2;
					$meses = 24;
					$denominacion = "Técnicos";
					$dias = 710; // 2 años - 20 dias
					}else{
						$tipo = 1;
						$meses = 60;
						$denominacion = "Administrativos";
						$dias = 1805; // 5 años - 20 dias.
						}
				echo '
<table class="formulario_global">
<tr class="formulario">
<th class="formulario_2" style=" text-shadow: 0px 0px 2px #000000; width:99%">Vigencia de Procedimientos '. $denominacion .' de Operación Normalizados - (PON '. $denominacion .')</th>
</tr>
<tr class="formulario">
<th class="formulario" id="fecha">Código</th>
<th class="formulario" id="titulo_documento" style=" text-shadow: 0px 0px 2px #000000; width:45%">Título del Documento</th>
<th class="formulario" id="nro_revision">Revisión</th>
<!--<th class="formulario" id="estado">Estado</th>-->
<th class="formulario" id="fecha">Fecha</th>
<th class="formulario" id="fecha">Estatus</th>
</tr>
';
				
		  include('conexion.php');		
		  // Consulta para documetos vencidos	
		  $sql="SELECT 
					   inf_codigo.cod_doc, 
					   inf_codigo.rev, 
					   inf_codigo.estatus, 
					   rec_doc.fecha_emision,
					   pon_asoc_tipo_procedimiento.cod_tipo_procedimiento,
					   inf_codigo.titulo_doc,
					   DATE_ADD(rec_doc.fecha_emision, INTERVAL $meses MONTH)
				FROM inf_codigo 
				INNER JOIN rec_doc
				INNER JOIN pon_asoc_tipo_procedimiento
				ON 
				   (inf_codigo.cod_doc=rec_doc.cod_doc AND inf_codigo.cod_doc=pon_asoc_tipo_procedimiento.cod_doc)
				   AND 
				   inf_codigo.tipo_doc='PON'
				   AND 
				   inf_codigo.rev=rec_doc.rev 
				   AND
				   (pon_asoc_tipo_procedimiento.cod_tipo_procedimiento=$tipo)
				   AND
				   (inf_codigo.estatus='777' OR inf_codigo.estatus='999' OR inf_codigo.estatus='333')
				   AND 
				   DATE_ADD(rec_doc.fecha_emision, INTERVAL $meses MONTH)<=CURDATE();
			";
			
			
			// Consulta para documetos por vencer vencidos	
		  $sql2="SELECT 
					   inf_codigo.cod_doc, 
					   inf_codigo.rev, 
					   inf_codigo.estatus, 
					   rec_doc.fecha_emision,
					   pon_asoc_tipo_procedimiento.cod_tipo_procedimiento,
					   inf_codigo.titulo_doc
				FROM inf_codigo 
				INNER JOIN rec_doc
				INNER JOIN pon_asoc_tipo_procedimiento
				ON 
				   (inf_codigo.cod_doc=rec_doc.cod_doc AND inf_codigo.cod_doc=pon_asoc_tipo_procedimiento.cod_doc)
				   AND 
				   inf_codigo.tipo_doc='PON'
				   AND 
				   inf_codigo.rev=rec_doc.rev 
				   AND
				   (pon_asoc_tipo_procedimiento.cod_tipo_procedimiento=$tipo)
				   AND
				   (inf_codigo.estatus='777' OR inf_codigo.estatus='999' OR inf_codigo.estatus='333')
				   AND 
				   (DATE_ADD(rec_doc.fecha_emision, INTERVAL $meses MONTH) 
				   		BETWEEN 
						DATE_ADD(CURDATE(),INTERVAL 1 DAY) AND DATE_ADD(CURDATE(),INTERVAL 20 DAY)
				   );
			";
				$seleccion=mysql_query($sql,$conexion);
				while ($row = mysql_fetch_array($seleccion)){
						$cod_doc=$row[0];
						$rev=$row[1];
						$estatus=$row[2];
						$fecha_emision=$row[3];
						$cod_tipo_procedimiento=$row[4];
						$titulo_documento=$row[5];
						
						/*
						echo "Código del Documento: $cod_doc <br>Revisión: $rev <br> Estatus: $estatus <br> Fecha de Emisión: $fecha_emision <br> Tipo de Procedimiento: $cod_tipo_procedimiento <br><br>";
						*/
						echo '
						<tr class="formulario" >
						<td class="fecha" style="font-weight:bold;text-align:right;">'. $cod_doc .'</td>
						<td class="titulo_documento" style="width:45%">'. $titulo_documento .'</td>
						<td class="nro_revision">'. $rev .'</td>
						<td class="fecha">'. $fecha_emision .'</td>
						<td class="fecha" style="'. $background .'">Vencido</td>
						</tr>
						';
						
					
				}
				
				$seleccion2=mysql_query($sql2,$conexion);
				while ($row = mysql_fetch_array($seleccion2)){
						$cod_doc=$row[0];
						$rev=$row[1];
						$estatus=$row[2];
						$fecha_emision=$row[3];
						$cod_tipo_procedimiento=$row[4];
						$titulo_documento=$row[5];
						/*
						echo "Código del Documento: $cod_doc <br>Revisión: $rev <br> Estatus: $estatus <br> Fecha de Emisión: $fecha_emision <br> Tipo de Procedimiento: $cod_tipo_procedimiento <br><br>";
						*/
						echo '
						<tr class="formulario" >
						<td class="fecha" style="font-weight:bold;text-align:right;">'. $cod_doc .'</td>
						<td class="titulo_documento" style="width:45%">'. $titulo_documento .' </td>
						<td class="nro_revision">'. $rev .'</td>
						<td class="fecha">'. $fecha_emision .'</td>
						<td class="fecha" style="'. $background2 .'">Por Vencer</td>
						</tr>
						';
						
					
				}
				
				echo '</table>';

				//mysql_close();
				
			
			
				
			break;
			default:
				//echo 'FORMULARIO';
			$codigo = $_GET['cod_doc'];
			$revision = $_GET['rev'];
			$siglas_documento = $_GET['sigla_doc'];
			$tipo_doc = $_GET['tipo_doc'];
			$titulo_documento = $_GET['titulo_doc'];
			$desde = $_GET['desde'];
			$hasta = $_GET['hasta'];
			if($revision==""){
				$revision='1000000';
				}
			/*
			echo '<br>' . $codigo . '<br>';
			echo '<br>' . $revision . '<br>';
			echo '<br>' . $siglas_documento . '<br>';
			echo '<br>' . $tipo_documento . '<br>';
			echo '<br>' . $titulo_documento . '<br>';
			echo '<br>' . $desde . '<br>';
			echo '<br>' . $hasta . '<br>';
			*/		
				

			
			// CONSULTA GENERAL
echo '
<table class="formulario_global">
<tr class="formulario">
<th class="formulario_2" style=" text-shadow: 0px 0px 2px #000000; width:95.3%">DOCUMENTOS CONTROLADOS</th>
</tr>
<tr class="formulario">
<th class="formulario" id="fecha">Código</th>
<th class="formulario" id="titulo_documento">Título del Documento</th>
<th class="formulario" id="nro_revision">Revisión</th>
<!--<th class="formulario" id="estado">Estado</th>-->
<th class="formulario" id="fecha">Fecha</th>
<th class="formulario" id="condicion">Condición</th>
<th class="formulario" id="archivo">Archivo</th>
</tr>
';

include ('conexion.php');
$sql="SELECT cod_doc, rev, titulo_doc FROM inf_codigo WHERE (cod_doc='$codigo' OR tipo_doc='$tipo_doc' OR sigla_doc='$siglas_documento' OR titulo_doc='$titulo_documento' OR rev='$revision') AND (estatus='333' OR estatus='999' OR estatus='777')";
				$seleccion=mysql_query($sql,$conexion);
				while ($row = mysql_fetch_array($seleccion)){
						$cod_doc=$row[0];
						$rev=$row[1];
						$titulo_documento=$row[2];
				echo '	
						<tr class="formulario">
						<td class="fecha" style="font-weight:bold;text-align:right;">'. $cod_doc .'</td>
						<td class="titulo_documento">'. $titulo_documento .'</td>
						<td class="nro_revision">'. $rev .'</td>
						
						';	
					
					$sql2="SELECT fecha_ing FROM inf_codigo WHERE cod_doc='$cod_doc' AND rev='$rev'";
					$seleccion2=mysql_query($sql2,$conexion);	
					while ($row = mysql_fetch_array($seleccion2)){
							$fecha=$row[0];
					echo '<td class="fecha">'. $fecha .'</td>';
					
						$sql3="SELECT condicion FROM rec_doc WHERE cod_doc='$cod_doc' AND rev='$rev'";
						$seleccion3=mysql_query($sql3,$conexion);	
						while ($row = mysql_fetch_array($seleccion3)){
							$condicion=$row[0];
							if($condicion=="Confidencial"){
								echo '<td class="condicion"><img class="condicion" src="imagenes/privado.png" title="Documento Confidencial" /></td>';
								}else{
									echo '<td class="condicion"><img class="condicion" src="imagenes/publico.png" title="Acceso Público" /></td>';
									}
							$sql4="SELECT tipo_adjunto, ruta_adjunto FROM evaluacion_doc WHERE cod_doc='$cod_doc' AND rev='$rev'";
							$seleccion4=mysql_query($sql4,$conexion);	
							while ($row = mysql_fetch_array($seleccion4)){
								$tipo_adjunto=$row[0];
								$ruta_adjunto=$row[1];
								if($condicion=="Confidencial"){
										$sql5 = "SELECT sigla_unid FROM unidades_confidencial WHERE cod_doc='$cod_doc' AND sigla_unid='$unidad_usuario'";
										$seleccion5=mysql_query($sql5,$conexion);	
										$cont=mysql_num_rows($seleccion5);
										if(($cont!=0) || ($privilegio==777) || ($privilegio==2)){
											echo '<td class="archivo"><a href="'. $ruta_adjunto . $tipo_adjunto . '" title="'. $cod_doc .'" target="_blank"><img class="archivo" src="imagenes/archivo.png" title="'. $cod_doc .' Revisión ('.$rev.')" /></a></td>';
											echo '</tr>';
										}else{
											echo '<td class="archivo"><a href="#"><img class="archivo" src="imagenes/protegido.png" title="'. $cod_doc .' Revisión ('.$rev.')" /></a></td>';
											echo '</tr>';
											}
									}else{
										echo '<td class="archivo"><a href="'. $ruta_adjunto . $tipo_adjunto . '" title="'. $cod_doc .'" target="_blank"><img class="archivo" src="imagenes/archivo.png" title="'. $cod_doc .' Revisión ('.$rev.')" /></a></td>';
										echo '</tr>';
									} 
								
							} // sql4
						} // sql3
					} // sql2
				} // sql


	echo '</div>';
		
			
			
echo '</div></table>';

	}
	//echo $consulta;
	}
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
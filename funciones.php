<?php
/*
	Fecha: 16-08-2012
	Autor: Ing. Domingo Ilarreta
	Correo: akimxtreme.dj@gmail.com

/*
Todas las funciones en PHP

 */
function consulta_rapida($tabla){
			include "conexion.php";
			
			$primer_caracter =  substr($tabla, 0, 1);
			$restante =  substr($tabla, 1, 15);
			// Selecciona de la tabla seccion los items disponibles   
				////////
				if($tabla=="buscar"){
						$sql="SELECT * FROM $tabla ORDER BY buscar_tipo";
						$seleccion=mysql_query($sql,$conexion);
						while ($row = mysql_fetch_array($seleccion)){
						$campo_1=$row["buscar_tipo"];
						$campo_2=$row["cod_tipo"];
						echo '<option class="formulario" value="'. $campo_2 .'">'. $campo_1 .'</option>';
						}
				}
				////////
				
				////////
				if($tabla=="buscar_usuario"){
						$sql="SELECT buscar_usuario, campo FROM $tabla ORDER BY buscar_usuario";
						$seleccion=mysql_query($sql,$conexion);
						while ($row = mysql_fetch_array($seleccion)){
						$campo_1=$row[0];
						$campo_2=$row[1];
						echo '<option class="formulario" value="'. $campo_2 .'">'. $campo_1 .'</option>';
						}
				}
				////////
				////////
				if($tabla=="buscar_unidad"){
						$sql="SELECT buscar_unidad, sigla_unid FROM $tabla ORDER BY buscar_unidad";
						$seleccion=mysql_query($sql,$conexion);
						while ($row = mysql_fetch_array($seleccion)){
						$campo_1=$row[0];
						$campo_2=$row[1];
						echo '<option class="formulario" value="'. $campo_2 .'">'. $campo_1 .'</option>';
						}
				}
				////////
				////////
				if($tabla=="buscar_tipodoc"){
						$sql="SELECT buscar_tipodoc, sigla_doc FROM $tabla ORDER BY buscar_tipodoc";
						$seleccion=mysql_query($sql,$conexion);
						while ($row = mysql_fetch_array($seleccion)){
						$campo_1=$row[0];
						$campo_2=$row[1];
						echo '<option class="formulario" value="'. $campo_2 .'">'. $campo_1 .'</option>';
						}
				}
				////////
				////////
				if($tabla=="buscar_crit_evaluacion"){
						$sql="SELECT buscar_crit_evaluacion, campo FROM $tabla ORDER BY buscar_crit_evaluacion";
						$seleccion=mysql_query($sql,$conexion);
						while ($row = mysql_fetch_array($seleccion)){
						$campo_1=$row[0];
						$campo_2=$row[1];
						echo '<option class="formulario" value="'. $campo_2 .'">'. $campo_1 .'</option>';
						}
				}
				////////
				
				if($primer_caracter==";"){
				$sql="SELECT * FROM tmp_unidades_confidencial WHERE cod_doc='$restante' ORDER BY id  DESC";
				$seleccion=mysql_query($sql,$conexion);
				$contador=1;
				while ($row = mysql_fetch_array($seleccion)){
						$campo_1=$row["denominacion"];
						$campo_2=$row["sigla_unid"];
						$campo_3=$row["sigla_doc"];
						echo '<option onclick="unidades_referencia(this.value);" class="formulario" value="'. $campo_2 .'">'. $contador++ .") " . "- " . $campo_3 ." - ". "(" . $campo_1 . ")".'</option>';
						}
				}
				////////
				if($tabla=="tmp_unidades_confidencial"){
				$sql="SELECT * FROM tmp_unidades_confidencial ORDER BY id  DESC";
				$seleccion=mysql_query($sql,$conexion);
				$contador=1;
				while ($row = mysql_fetch_array($seleccion)){
						$campo_1=$row["denominacion"];
						$campo_2=$row["sigla_unid"];
						$campo_3=$row["sigla_doc"];
						echo '<option onclick="unidades_referencia(this.value);" class="formulario" value="'. $campo_2 .'">'. $contador++ .") " . "- " . $campo_3 ." - ". "(" . $campo_1 . ")".'</option>';
						}
				}
				////////
				if($tabla=="menu"){
				$sql="SELECT * FROM cat_tipodoc ORDER BY sigla_doc";
				$seleccion=mysql_query($sql,$conexion);
				while ($row = mysql_fetch_array($seleccion)){
						$campo_1=$row["nombre"];
						$campo_2=$row["sigla_doc"];
						echo '<li class="menu_tipo_documento_sub"><a class="menu_tipo_documento_sub" href="index.php?consulta=\'' . $campo_2 .'\'" target="_parent" title="'. $campo_1 .'">'. "<strong>". $campo_2 . " </strong>" . $campo_1 .'</a></li>';
						}
				}
				////////
				if($tabla=="modulos_sistema"){
				$sql="SELECT modulos_sistema, href_modulos_sistema, id FROM modulos_sistema ORDER BY id";
				$seleccion=mysql_query($sql,$conexion);
				while ($row = mysql_fetch_array($seleccion)){
						$campo_1=$row[0];
						$campo_2=$row[1];
						$campo_3=$row[2];
							echo '<li class="menu_tipo_documento_sub"><a class="menu_tipo_documento_sub" href="'. $campo_2 .'" target="_parent" title="'. $campo_1 .'">'. $campo_1 .'</a></li>';
						}
				}
				////////
				if($tabla=="cat_tipodoc"){
						$sql="SELECT * FROM $tabla ORDER BY sigla_doc";
						$seleccion=mysql_query($sql,$conexion);
						while ($row = mysql_fetch_array($seleccion)){
						$campo_1=$row["nombre"];
						$campo_2=$row["sigla_doc"];
						echo '<option class="formulario" value="'. $campo_2 .'">'. $campo_2 ." - ". "(" . $campo_1 . ")".'</option>';
						}
				}
				////////
				if($tabla=="unidades"){
						$sql="SELECT * FROM $tabla ORDER BY sigla_doc";
						$seleccion=mysql_query($sql,$conexion);
						while ($row = mysql_fetch_array($seleccion)){
						$campo_1=$row["denominacion"];
						$campo_2=$row["sigla_doc"];
						echo '<option class="formulario" value="'. $campo_2 .'">'. $campo_2 ." - ". "(" . $campo_1 . ")".'</option>';
						}
				}
				////////
				if($tabla=="privilegio"){
						$sql="SELECT privilegio, detalles FROM $tabla ORDER BY detalles";
						$seleccion=mysql_query($sql,$conexion);
						while ($row = mysql_fetch_array($seleccion)){
						$campo_1=$row[0];
						$campo_2=$row[1];
						echo '<option class="formulario" value="'. $campo_1 .'">'. $campo_2 .'</option>';
						}
				}
				
				////////
				if($tabla=="PON"){
						$sql="SELECT DISTINCT cod_doc FROM inf_codigo WHERE tipo_doc='PON' AND rev=NULL ORDER BY cod_doc";
						$seleccion=mysql_query($sql,$conexion);
						while ($row = mysql_fetch_array($seleccion)){
						$campo_1=$row["cod_doc"];
						echo '<option class="formulario" value="'. $campo_1 .'">'. $campo_1 .'</option>';
						}
				}
				////////
				/**************************************************************************************************************/
				$actual = substr($tabla,0,6); // RESULTADO = actual
				if($actual=="actual"){
						$letra = substr($tabla,7,1); // Toma la letra u (unidad) ó p (privilegio)
						$usuario_modificar = substr(strrchr($tabla, "#"), 1);
						switch($letra){
							case "u":
								// Para la unidades
								// Selecciona la unidad en donde pertenece el usuario
							$sql="SELECT cod_unidad FROM usuario WHERE usuario='$usuario_modificar'";
							$seleccion=mysql_query($sql,$conexion);
							while ($row = mysql_fetch_array($seleccion)){
							$unidad_usuario=$row[0];
							
							}
							
							// Consulta todas las Unidades de la tabla
							$sql1 = "SELECT sigla_unid, denominacion FROM unidades";
							$seleccion1 = mysql_query($sql1,$conexion);
							while($row2 = mysql_fetch_array($seleccion1)){
								$sigla_unid=$row2[0];
								$denominacion=$row2[1];
								
								// Compara la unidades con la la unidad del usuario
								if($unidad_usuario===$sigla_unid){
									echo '<option class="formulario" selected="selected" value="'. $sigla_unid .'">'. $sigla_unid ." - ". "(" . $denominacion . ")".'</option>';
									}else{
									echo '<option class="formulario" value="'. $sigla_unid .'">'. $sigla_unid ." - ". "(" . $denominacion . ")".'</option>';
									}
								
								}
							break;
							case "o":
								// Para la unidades
								// Consulta todas las Unidades de la tabla
							$sql1 = "SELECT sigla_unid, denominacion FROM unidades";
							$seleccion1 = mysql_query($sql1,$conexion);
							while($row2 = mysql_fetch_array($seleccion1)){
								$sigla_unid=$row2[0];
								$denominacion=$row2[1];
								
								// Compara la unidades con la la unidad del usuario
								if($usuario_modificar===$sigla_unid){
									echo '<option class="formulario" selected="selected" value="'. $sigla_unid .'">'. $sigla_unid ." - ". "(" . $denominacion . ")".'</option>';
									}else{
									echo '<option class="formulario" value="'. $sigla_unid .'">'. $sigla_unid ." - ". "(" . $denominacion . ")".'</option>';
									}
								
								}
							
							break;
							case "p":
							// para los privilegios
							// Selecciona la unidad en donde pertenece el usuario
								$sql="SELECT privilegio FROM usuario WHERE usuario='$usuario_modificar'";
								$seleccion=mysql_query($sql,$conexion);
								while ($row = mysql_fetch_array($seleccion)){
								$privilegio_usuario=$row[0];
								}
							// Consulta todas las Unidades de la tabla
							$sql1 = "SELECT privilegio, detalles FROM privilegio";
							$seleccion1 = mysql_query($sql1,$conexion);
							while($row2 = mysql_fetch_array($seleccion1)){
								$privilegio=$row2[0];
								$detalles=$row2[1];
								
								// Compara la unidades con la la unidad del usuario
								if($privilegio_usuario===$privilegio){
									echo '<option class="formulario" selected="selected" value="'. $privilegio .'">'. $detalles .'</option>';
									}else{
									echo '<option class="formulario" value="'. $privilegio .'">'. $detalles .'</option>';
									}
							}
							break;
							}
				}
				/**************************************************************************************************************/
				
				////////
				
				////////
				if($tabla=="PON"){
						$sql="SELECT DISTINCT cod_doc FROM inf_codigo WHERE tipo_doc='PON' ORDER BY cod_doc";
						$seleccion=mysql_query($sql,$conexion);
						while ($row = mysql_fetch_array($seleccion)){
						$campo_1=$row["cod_doc"];
						echo '<option class="formulario" value="'. $campo_1 .'">'. $campo_1 .'</option>';
						}
				}
				////////
				
				$actual = substr($tabla,0,8); // RESULTADO = PON_ASOC
				
				if($actual=="PON_ASOC"){
						
						$form = (stristr($tabla, "FOR")); // RESULTADO = FOR_XXX_XXX
						$sql="SELECT DISTINCT pon_asoc FROM pon_asoc_for WHERE cod_doc='$form' ORDER BY cod_doc";
						$seleccion=mysql_query($sql,$conexion);
						while ($row = mysql_fetch_array($seleccion)){
						$campo_1=$row["pon_asoc"];
						echo '<option class="formulario" value="'. $campo_1 .'">'. $campo_1 .'</option>';
						}
				}
				
				
				////////
				if($tabla=="unidades_do"){
						$sql="SELECT * FROM unidades WHERE sigla_unid='DO'";
						$seleccion=mysql_query($sql,$conexion);
						while ($row = mysql_fetch_array($seleccion)){
						$campo_1=$row["denominacion"];
						$campo_2=$row["sigla_unid"];
						echo '<option class="formulario" selected="selected" value="'. $campo_2 .'">'. $campo_2 ." - ". "(" . $campo_1 . ")".'</option>';
						}
				}
				////////
				
				////////
				if($tabla=="unidades_copias"){
						$sql="SELECT * FROM unidades ORDER BY sigla_unid";
						$seleccion=mysql_query($sql,$conexion);
						while ($row = mysql_fetch_array($seleccion)){
						$campo_1=$row["denominacion"];
						$campo_2=$row["sigla_unid"];
						echo '<option class="formulario" value="'. $campo_2 .'"  title="'. $campo_2 ." - ". "(" . $campo_1 . ")".'">'. $campo_2 ." - ". "(" . $campo_1 . ")".'</option>';
						}
				}
				////////
				if($tabla=="unidades_memo"){
						$sql="SELECT * FROM unidades ORDER BY sigla_doc";
						$seleccion=mysql_query($sql,$conexion);
						while ($row = mysql_fetch_array($seleccion)){
						$campo_1=$row["denominacion"];
						$campo_2=$row["sigla_unid"];
						echo '<option class="formulario" value="'. $campo_2 .'">'. $campo_2 ." - ". "(" . $campo_1 . ")".'</option>';
						}
				}
				////////
				
				if($tabla=="tipo_procedimiento"){
						$sql="SELECT id, tipo_procedimiento FROM  tipo_procedimiento ORDER BY tipo_procedimiento";
						$seleccion=mysql_query($sql,$conexion);
						while ($row = mysql_fetch_array($seleccion)){
						$campo_1=$row[1];
						$campo_2=$row[0];
						echo '<option class="formulario" value="'. $campo_2 .'">'. $campo_1 .'</option>';
						}
				}
				////////
				if($tabla=="personal"){
						$sql="SELECT nombres,apellidos FROM $tabla ORDER BY nombres";
						$seleccion=mysql_query($sql,$conexion);
						while ($row = mysql_fetch_array($seleccion)){
						$campo_1=$row[0];
						$campo_2=$row[1];
						echo '<option class="formulario" value="'. $campo_1 . " " . $campo_2 .'">'. $campo_1 . " " . $campo_2 .'</option>';
						}
				}
				////////
				if($tabla=="unidades_anio"){
						for($i=2013;$i>=2009;$i--){
						echo '<option class="formulario" value="'. $i .'">'. $i .'</option>';
						}
				}
				
				
							
				
} // fin funcion consulta_rapida();

				
function inf_codigo($tabla,$tabla2){
				include "conexion.php"; 
				$sql="SELECT * FROM $tabla";
				$seleccion=mysql_query($sql,$conexion);
				////////
				
					while ($row = mysql_fetch_array($seleccion)){
						$campo_1=$row["cod_doc"];
						$campo_2=$row["tipo_doc"];
						$campo_3=$row["sigla_doc"];
						$campo_4=$row["rev"];
						$campo_5=$row["usuario_solic"];
						$campo_6=$row["titulo_doc"];
					}
										
}

// fin funcion inf_codigo();
?>

<?php
// <><><><>  Funtcion Global Para el Formulario de INICIO <><><><><><><><><><><><><><><><><><><><><><>
function formulario_inicio($titulo, $css,$name_id,$action,$method,$onsubmit,$enctype,$id_fieldset,$title_fieldset,$id_legend){
	/* formulario 10 variables:
			1)  $titulo = Titulo del Formulario   --- Ej: Ingreso al Sistema ---
			2)  $css = Clase de los Estilos CSS para las etiquetas <form>, <fieldset> y <legend>  --- Ej: formularios ---
			3)  $name_id = nombre y id para la etiqueta <form> 	--- Ej: formulario_de_ingreso ---
			4)  $action = Acción que se le da al Formulario  --- Ej: acciones.php
			5)  $method = Indica el Tipo de metodo que tendra el formulario  --- Ej: GET  ó  POST ---
			6)  $onsubmit = Para asignar la función de Validación en el Lenguaje de Eventos "Javascript"  --- Ej: validacion(this); no Hace falta color return ya que está agregado en la función. ---
			7)  $enctype = Se llena siempre y cuando el formulario cuenta con etiquetas de tipo <file> "Adjuntar Archivos"  --- Ej: multipart/form-data ---
			8)  $id_fieldset = Para asignar propiedades CSS únicas a la etiqueta <fieldset>  --- Ej: fielset_estilos ---
			9)  $tittle_fieldset = Para mostrar a traves del atributo título una frase  --- Ej: Formulario para registro de usuarios ---
			10) $id_legend = Para asignar propiedades CSS únicas a la etiqueta <fieldset>  --- Ej: legend_estilos ---
			
	*/
echo '<form class="'. $css .'" id="'. $name_id .'" name="'. $name_id .'" action="'. $action .'" method="'. $method .'" onsubmit="return '. $onsubmit .'" enctype="'. $enctype .'">';
echo '<fieldset class="'. $css .'" id="'. $id_fieldset .'" title="'. $title_fieldset .'">';
echo '<legend class="'. $css .'" id="'. $id_legend .'" title="'. $titulo .'">'. $titulo .'</legend>';
}// <><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><>

// <><><><>  Function Global Para el Formulario de CIERRE <><><><><><><><><><><><><><><><><><><><><><><><><><><><>
function formulario_cierre (){
	echo'<h3 class="campo_obligatorio"><strong class="campo_obligatorio">*</strong>Campo Obligatorio</h3>';
	echo '</fieldset>';
	echo '</form>';
	}// <><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><>

// <><><><>  Function Global Para las Etiquetas Type TEXT <><><><><><><><><><><><><><><><><><><><><><><><><><><><>
function text($titulo,$css,$name_id,$onblur,$value,$maxlength,$disabled,$readonly,$numero_letra,$id_div,$id_label, $ayuda){
	/* Etiqueta input type="TEXT" 11 variables:
			1)  $titulo = Titulo del campo en la Etiqueta <label>   --- Ej: Nombre ---
			2)  $css = Clase de los Estilos CSS para las etiquetas <div>, <label> e <input>  --- Ej: formularios ---
			3)  $name_id = nombre y id para la etiqueta <input> 	--- Ej: nombre_completo ---
			4)  $onblur = Atributo que trabaja en conjunto con la validación de ayuda que proporciona "Javascript", se coloca la función + el name ó id del campo  --- Ej: solo_numeros('nombre_completo');
			5)  $value = Para asignar el Valor del campo  --- Ejemplos: " " , "Domingo Ilarreta" ó $nombre (muestra una consulta de la BD) ---
			6)  $maxlength = Para asignar la cantidad de caracteres que puede ingresar en el campo  --- Ejemplos: "" ó "5" (Cinco "5" = Cantidad de Caracteres)---
			7)  $disabled = Atributo para desactivar el campo  --- Ej: disabled ---
			8)  $readonly = Atributo para mostrar los valores del atributo value en forma de consulta  --- Ej: readonly ---
			9)  $numero_letra = Variable que indica si el campo acepta:
													a) Todos los caracteres --- Ej: ($numero_letra ="") ---
													b) Letras --- Ej: ($numero_letra ="1") ---
													c) Números --- Ej: ($numero_letra ="2") ---
			10) $id_div = Para asignar propiedades CSS únicas a la etiqueta <div>  --- Ej: div_estilos ---
			11) $id_label = Para asignar propiedades CSS únicas a la etiqueta <label>  --- Ej: label_estilos ---
			
	*/
$js_name_id="'".$name_id."'";
if ($titulo!="") {echo '<div class="'. $css .'" id="'. $id_div .'">';}
if ($titulo!="") {
	echo '<label class="'. $css .'" id="'. $id_label .'" title=""><div title="Ayuda" class="signo_ayuda">?';
	if($ayuda!=""){echo '<div class="ayuda">'. $ayuda .'</div>';}
	echo '</div>'. $titulo .':</label>';
}
echo '<input class="'. $css .'" name="'. $name_id .'" id="'. $name_id .'" type="text" onblur="obligatorio('.$js_name_id.');'. $onblur .'" value="'. $value .'" maxlength="'. $maxlength .'" title="'. $numero_letra .'"'; if ($readonly!=""){echo ' readonly="readonly"';} if ($disabled!=""){echo ' disabled="disabled"';} if ($numero_letra=="2"){echo ' onkeypress="return solonumeros(event);"';} if ($numero_letra=="1"){echo ' onkeypress="return soloLetras(event);"';} echo '/>';
if ($titulo!="") {echo '<strong class="obligatorio">*</strong>';}
if ($titulo!="") {echo '</div>';}
}// <><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><>

// <><><><>  Function Global Para las Etiquetas Type PASSWORD <><><><><><><><><><><><><><><><><><><><><><><><><><><><>
function contrasenia($titulo,$css,$name_id,$onblur,$value,$maxlength,$disabled,$readonly,$numero_letra,$id_div,$id_label,$ayuda){
	/* Etiqueta input type="PASSWORD" 11 variables:
			1)  $titulo = Titulo del campo en la Etiqueta <label>   --- Ej: Nombre ---
			2)  $css = Clase de los Estilos CSS para las etiquetas <div>, <label> e <input>  --- Ej: formularios ---
			3)  $name_id = nombre y id para la etiqueta <input> 	--- Ej: nombre_completo ---
			4)  $onblur = Atributo que trabaja en conjunto con la validación de ayuda que proporciona "Javascript", se coloca la función + el name ó id del campo  --- Ej: solo_numeros('nombre_completo');
			5)  $value = Para asignar el Valor del campo  --- Ejemplos: " " , "Domingo Ilarreta" ó $nombre (muestra una consulta de la BD) ---
			6)  $maxlength = Para asignar la cantidad de caracteres que puede ingresar en el campo  --- Ejemplos: "" ó "5" (Cinco "5" = Cantidad de Caracteres)---
			7)  $disabled = Atributo para desactivar el campo  --- Ej: disabled ---
			8)  $readonly = Atributo para mostrar los valores del atributo value en forma de consulta  --- Ej: readonly ---
			9)  $numero_letra = Variable que indica si el campo acepta:
													a) Todos los caracteres --- Ej: ($numero_letra ="") ---
													b) Letras --- Ej: ($numero_letra ="1") ---
													c) Números --- Ej: ($numero_letra ="2") ---
			10) $id_div = Para asignar propiedades CSS únicas a la etiqueta <div>  --- Ej: div_estilos ---
			11) $id_label = Para asignar propiedades CSS únicas a la etiqueta <label>  --- Ej: label_estilos ---
			
	*/
	
$js_name_id="'".$name_id."'";
echo '<div class="'. $css .'" id="'. $id_div .'">';
if ($titulo!="") {
	echo '<label class="'. $css .'" id="'. $id_label .'" title=""><div title="Ayuda" class="signo_ayuda">?';
	if($ayuda!=""){echo '<div class="ayuda">'. $ayuda .'</div>';}
	echo '</div>'. $titulo .':</label>';
}
echo '<input  class="'. $css .'" name="'. $name_id .'" id="'. $name_id .'" type="password" onblur="obligatorio('.$js_name_id.');'. $onblur .'" value="'. $value .'" maxlength="'. $maxlength .'"  title="'. $numero_letra .'"'; if ($readonly!=""){echo ' readonly="readonly"';} if ($disabled!=""){echo ' disabled="disabled"';}echo '/>';
echo '<strong class="obligatorio">*</strong>';
echo '</div>';
}// <><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><>

// <><><><>  Function Global Para las Etiquetas Type FECHA <><><><><><><><><><><><><><><><><><><><><><><><><><><><>
function fecha($titulo,$css,$name_id,$onblur,$value,$disabled,$id_div,$id_label,$ayuda){
		/* Etiqueta input type="FECHA" 8 variables:
			1)  $titulo = Titulo del campo en la Etiqueta <label>   --- Ej: Nombre ---
			2)  $css = Clase de los Estilos CSS para las etiquetas <div>, <label> e <input>  --- Ej: formularios ---
			3)  $name_id = nombre y id para la etiqueta <input> 	--- Ej: fecha_nacimiento ---
			4)  $onblur = Atributo que trabaja en conjunto con la validación de ayuda que proporciona "Javascript", se coloca la función + el name ó id del campo  --- Ej: solo_numeros('fecha_nacimiento');
			5)  $value = Para asignar el Valor del campo  --- Ejemplos: " " , "31-10-1985" ó $fecha_nacimiento (muestra una consulta de la BD) ---
			6)  $disabled = Atributo para desactivar el campo  --- Ej: disabled ---
			7)  $id_div = Para asignar propiedades CSS únicas a la etiqueta <div>  --- Ej: div_estilos ---
			8)  $id_label = Para asignar propiedades CSS únicas a la etiqueta <label>  --- Ej: label_estilos ---
		*/
		// NOTA: Llamar solo una (1) vez a la function paginas_calendario(); aunque se utilice la función fecha(); varias veces en una misma página, para que pueda funcionar el script del calendario que estará dentro de la(s) etiqueta(s)
$js_name_id="'".$name_id."'";
if ($titulo!="") {echo '<div class="'. $css .'" id="'. $id_div .'">';}
if ($titulo!="") {
	echo '<label class="'. $css .'" id="'. $id_label .'" title=""><div title="Ayuda" class="signo_ayuda">?';
	if($ayuda!=""){echo '<div class="ayuda">'. $ayuda .'</div>';}
	echo '</div>'. $titulo .':</label>';
}
echo '<input class="'. $css .'" name="'. $name_id .'" id="'. $name_id .'" type="date" onblur="obligatorio('.$js_name_id.');'. $onblur .'" value="'. $value .'" readonly="readonly" id="'. $name_id .'"'; if ($disabled!=""){echo ' disabled="disabled"';}echo '/>';
		// Script que define y configura el calendario
		echo '<script type="text/javascript"> 
			Calendar.setup({ 
			inputField     :    "'. $name_id .'",     
			ifFormat     :     "%Y-%m-%d",     
			button     :    "'.$name_id.'"     
			}); 
			</script>';
		/*Guia codigo Superior:
			inputField     :    "fecha",     // id del campo de texto 
			ifFormat     :     "%d-%m-%Y",     // formato de la fecha que se escriba en el campo de texto 
			button     :    "lanzador"     // el id del botón que lanzará el calendario 
			}); 
		
		*/
if ($titulo!="") {echo '<strong class="obligatorio">*</strong>';}
if ($titulo!="") {echo '</div>';}
	}// <><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><>

// <><><><>  Páginas para correr el CALENDARIO de la function fecha(); <><><><><><><><><><><><><><><><><><><><><><><><><><><><>
function paginas_calendario(){
	// Páginas necesarias el diseño del calendario
	// NOTA: Llamar solo una (1) vez a la function paginas_calendario(); aunque se utilice la función fecha(); varias veces en una misma página, para que pueda funcionar el script del calendario que estará dentro de la(s) etiqueta(s)
	echo '<link href="css/calendario.css" type="text/css" rel="stylesheet">';
	echo '<script src="js/calendar.js" type="text/javascript"></script>';
	echo '<script src="js/calendar-es.js" type="text/javascript"></script>';
	echo '<script src="js/calendar-setup.js" type="text/javascript"></script>';
}// <><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><>

// <><><><>  Function Global Para las Etiquetas Type HIDDEN <><><><><><><><><><><><><><><><><><><><><><><><><><><><>
function hidden($name_id,$value){
	/* Etiqueta input type="HIDDEN" 2 variables:
			1)  $name_id = nombre y id para la etiqueta <input> 	--- Ej: name_hidden ---
			2)  $value = Para asignar el Valor del campo  --- Ejemplos: " " , $variable, "31-10-1985" ó $fecha_nacimiento (muestra una consulta de la BD) ---
	*/
	echo '<input name="'. $name_id .'" id="'. $name_id .'" value="'. $value .'" type="hidden" />';
}// <><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><>

// <><><><>  Function Global Para las Etiquetas TEXTAREA <><><><><><><><><><><><><><><><><><><><><><><><><><><><>
function textarea($titulo,$css,$name_id,$onblur,$value,$disabled,$readonly,$numero_letra,$id_div,$id_label,$condicion,$ayuda){
	/* Etiqueta TEXTAREA 10 variables:
			1)  $titulo = Titulo del campo en la Etiqueta <label>   --- Ej: Indique la Descripción ---
			2)  $css = Clase de los Estilos CSS para las etiquetas <div>, <label> y <textarea>  --- Ej: formularios ---
			3)  $name_id = nombre y id para la etiqueta <textarea> 	--- Ej: descripcion ---
			4)  $onblur = Atributo que trabaja en conjunto con la validación de ayuda que proporciona "Javascript", se coloca la función + el name ó id del campo  --- Ej: alerta('descripcion');
			5)  $value = Para asignar el Valor del campo  --- Ejemplos: " " , "Domingo Ilarreta" ó $descripcion (muestra una consulta de la BD) ---
			6)  $disabled = Atributo para desactivar el campo  --- Ej: disabled ---
			7)  $readonly = Atributo para mostrar los valores del atributo value en forma de consulta  --- Ej: readonly ---
			8)  $numero_letra = Variable que indica si el campo acepta:
													a) Todos los caracteres --- Ej: ($numero_letra ="") ---
													b) Letras --- Ej: ($numero_letra ="1") ---
													c) Números --- Ej: ($numero_letra ="2") ---
			9)  $id_div = Para asignar propiedades CSS únicas a la etiqueta <div>  --- Ej: div_estilos ---
			10) $id_label = Para asignar propiedades CSS únicas a la etiqueta <label>  --- Ej: label_estilos ---
			
	*/
$js_name_id="'".$name_id."'";
if($condicion==""){ $js_name_id="";}
echo '<div class="'. $css .'" id="'. $id_div .'">';
if ($titulo!="") {
	echo '<label class="'. $css .'" id="'. $id_label .'" title=""><div title="Ayuda" class="signo_ayuda">?';
	if($ayuda!=""){echo '<div class="ayuda">'. $ayuda .'</div>';}
	echo '</div>'. $titulo .':</label>';
}
echo '<textarea class="'. $css .'" name="'. $name_id .'" id="'. $name_id .'" onblur="obligatorio('.$js_name_id.');'. $onblur .'" title="'. $numero_letra .'" '; if ($readonly!=""){echo ' readonly="readonly"';} if ($disabled!=""){echo ' disabled="disabled"';} echo '>'. $value .'</textarea>';
if ($condicion!=""){echo '<strong class="obligatorio">*</strong>';}
echo '</div>';
}// <><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><>

// <><><><>  Function Global BOTONES .. Etiquetas <button> <><><><><><><><><><><><><><><><><><><><><><><><><><><><>
function boton($titulo,$css,$name_id,$value,$disabled,$id_div){
	/* Etiqueta input type="TEXT" 6 variables:
			1)  $titulo = Titulo del campo en la Etiqueta <label>   --- Ej: Enviar ---
			2)  $css = Clase de los Estilos CSS para las etiquetas <div>, <label> e <input>  --- Ej: formulario ---
			3)  $name_id = nombre y id para la etiqueta <input> 	--- Ej: enviar ---
			4)  $value = Para asignar el Valor del campo  --- Ejemplos: " " , "envia" ó $envia (muestra una consulta de la BD) ---
			5)  $disabled = Atributo para desactivar el campo  --- Ej: disabled ---
			6)  $id_div = Para asignar propiedades CSS únicas a la etiqueta <div>  --- Ej: div_estilos ---
	*/
echo '<div class="'. $css .'" id="'. $id_div .'">';
echo '<button class="'. $css .'" name="'. $name_id .'" id="'. $name_id .'" value="'. $value .'" type="submit" title="'. $titulo .'"'; if ($disabled!=""){echo ' disabled="disabled"';} echo'>'. $titulo .'</button>';
echo '</div>';
	}// <><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><>

function radio(){
/*	
echo '<div class="'. $css .'" id="'. $id_div .'">';
for($i=1;$i<=$cantidad;$i++){
	$name_id= $name_id . $i;
echo '';
echo '<input class="'. $css .'" name="'. $name_id .'" id="'. $name_id .'" type="radio" value="'. $css .'" checked="'. $css .'" title="'. $css .'"/>';
}
echo '</div>';
	*/
	}
?>



<?php
// function textarea($titulo,$css,$name_id,$onblur,$value,$disabled,$readonly,$numero_letra,$id_div,$id_label){

function select ($titulo,$css,$name_id,$onchange,$disabled,$bd_contenido_tabla,$id_div,$id_label,$ayuda){
	$js_name_id="'".$name_id."'";
	if ($titulo!=""){echo '<div class="'. $css .'" id="'. $id_div .'">';}
	if ($titulo!="") {
	echo '<label class="'. $css .'" id="'. $id_label .'" title=""><div title="Ayuda" class="signo_ayuda">?';
	if($ayuda!=""){echo '<div class="ayuda">'. $ayuda .'</div>';}
	echo '</div>'. $titulo .':</label>';
	}
	echo '<select class="'. $css .'" name="'. $name_id .'" id="'. $name_id .'" onchange="obligatorio('.$js_name_id.');'. $onchange .'"'; if ($disabled!=""){echo ' disabled="disabled"';} echo '>';
	echo '<option class="formulario" value="Seleccione...">Seleccione...</option>';
	if($bd_contenido_tabla!=""){consulta_rapida($bd_contenido_tabla);}
	echo '</select>';
	if ($titulo!=""){echo '<strong class="obligatorio">*</strong>';}
	if ($titulo!=""){echo '</div>';}
}


function select_multiple ($titulo,$css,$name_id,$onchange,$disabled,$bd_contenido_tabla,$id_div,$id_label,$ayuda){
	$js_name_id="'".$name_id."'";
	if ($titulo!=""){echo '<div class="'. $css .'" id="'. $id_div .'">';}
	if ($titulo!="") {
	echo '<label class="'. $css .'" id="'. $id_label .'" title=""><div title="Ayuda" class="signo_ayuda">?';
	if($ayuda!=""){echo '<div class="ayuda">'. $ayuda .'</div>';}
	echo '</div>'. $titulo .':</label>';
	}
	echo '<select class="'. $css .'" name="'. $name_id .'" id="'. $name_id .'" multiple="multiple" onchange="obligatorio('.$js_name_id.');'. $onchange .'"'; if ($disabled!=""){echo ' disabled="disabled"';} echo '>';
	//echo '<option class="" value="Seleccione...">GP - (Gerencia de Producción)</option>';
	if($bd_contenido_tabla!=""){consulta_rapida($bd_contenido_tabla);}
	echo '</select>';
	if ($titulo!=""){echo '<strong class="obligatorio">*</strong>';}
	if ($titulo!=""){echo '</div>';}
}



function radio_checkbox ($titulo, $css,$name,$id,$onclick,$value,$type,$ayuda){
	$js_name_id="'".$id."'";
	echo '<span class="'. $css .'">';
	if ($titulo!="") {
	echo '<label class="'. $css .'" title="">'. $titulo .':</label>';
	}
	echo '<input class="'. $css .'" type="'. $type .'" name="'. $name .'" id="'. $id .'" value="'. $value .'" onclick="obligatorio('.$js_name_id.');"  />';
	echo '</span>';
	}
function div_multiple_inicio($titulo,$css,$css_DivSub, $id_DivSub, $id_div,$id_label,$ayuda) {
	echo '<div class="'. $css .'" id="'. $id_div .'">';
	if ($titulo!="") {
	echo '<label class="'. $css .'" id="'. $id_label .'" title=""><div title="Ayuda" class="signo_ayuda">?';
	if($ayuda!=""){echo '<div class="ayuda">'. $ayuda .'</div>';}
	echo '</div>'. $titulo .':</label>';
	}
	echo '<div class="'. $css_DivSub .'" id="'. $id_DivSub .'">';
	}
function div_multiple_cierre() {
	echo '</div>';
    echo '<strong class="obligatorio">*</strong>';
	echo '</div>';
	}
	

?>
<?php
// <><><><>  Páginas para correr estilos para etiquetas file <><><><><><><><><><><><><><><><><><><><><><><><><><><><>
function paginas_file(){
	// Páginas necesarias el diseño del file
	// Inicio: Scripts para modificar la etiqueta input type='file'
	echo '<script type="text/javascript" src="js/enhance.js"></script>		
			<script type="text/javascript">';
				// Run capabilities test
	echo"enhance({
				loadScripts: [
						'js/jquery_file.min.js',
						'js/jQuery.fileinput.js',
						'js/example.js'
				],
				loadStyles: ['css/enhanced.css']	
				});   
		</script>";
	
}// <><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><>



// <><><><>  Function Global Para las Etiquetas input type="FILE" <><><><><><><><><><><><><><><><><><><><><><><><>
function input_file($titulo, $css, $name_id, $onselect, $id_div, $id_label,$ayuda){
	$js_name_id="'".$name_id."'";
	if ($titulo!=""){echo '<div class="'. $css .'" id="'. $id_div .'">';}
	if ($titulo!="") {
	echo '<label class="'. $css .'" id="'. $id_label .'" title=""><div title="Ayuda" class="signo_ayuda">?';
	if($ayuda!=""){echo '<div class="ayuda">'. $ayuda .'</div>';}
	echo '</div>'. $titulo .':</label>';
	}
	echo '<input  name="' . $name_id . '" id="'. $name_id .  '" type="file" onselect="obligatorio('.$js_name_id.');'. $onblur .'"/>';
	if ($titulo!=""){echo '<strong class="obligatorio">*</strong>';}
	if ($titulo!=""){echo '</div>';}
}// <><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><>
// <><><><>  Function Global Para las Etiquetas input type="FILE" <><><><><><><><><><><><><><><><><><><><><><><><>
function archivo($titulo, $css, $name_id, $onblur, $id_div, $id_label,$ayuda){
	$js_name_id="'".$name_id."'";
	if ($titulo!=""){echo '<div class="'. $css .'" id="'. $id_div .'">';}
	if ($titulo!="") {
	echo '<label class="'. $css .'" id="'. $id_label .'" title=""><div title="Ayuda" class="signo_ayuda">?';
	if($ayuda!=""){echo '<div class="ayuda">'. $ayuda .'</div>';}
	echo '</div>'. $titulo .':</label>';
	}
	echo '<input class="'. $css .'" size="42"  name="' . $name_id . '" id="'. $name_id .  '" type="file" onblur="obligatorio('.$js_name_id.');'. $onblur .'"/>';
	if ($titulo!=""){echo '<strong class="obligatorio">*</strong>';}
	if ($titulo!=""){echo '</div>';}
}// <><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><>
	

// Menu Tipo de Documentos

function menu_tipo_documento ($titulo,$menu){
	echo '<ul class="menu_tipo_documento">';
    echo '<li class="menu_tipo_documento">'. $titulo .'</li>';
    echo '<ul class="menu_tipo_documento_sub">';
	if($menu!=""){consulta_rapida($menu);}
          
    echo '</ul>';
	echo '</ul>';
	}
function pestania($titulo,$css,$onclick) {
	echo '<span class="'. $css .'" onclick="'. $onclick .'" title="'. $titulo .'">'. $titulo .'</span>';
	}
function subtitulos($titulo,$id){
	echo '<label class="subtitulos" id="'. $id .' title="">'. $titulo .'</label>';
	}
function img($onclick,$css,$name_id,$alt,$value){
	echo '<img class="'. $css .'" id="'. $name_id .'" title="Eliminar" alt="'. $alt .'" value="'. $value.'" onclick="'. $onclick .'" type="image" src=""/>';
	
	}
	
/* Configuracion del Usuario */
function configuracion ($nombre_usuario, $tipo_usuario){
	/*
	TIPOS DE USUARIO
		777: Administrador del Sistema
		  2: Operador del Sistema
		  1: Usuario de Consulta de Documentos Controlados
	*/
	switch($tipo_usuario){
			
			case 777:
				$tipo_usuario = "ADMINISTRADOR";
			break;
			case 2:
				$tipo_usuario = "OPERADOR";
			break;
			case 1:
				$tipo_usuario = "USUARIO CONSULTA";
			break;
			
		
		}
	echo '<div class="ordenar" id="nombre_usuario">';
	echo '<a class="nombre_usuario_2" href="configuracion_cuenta.php" title="Configuración de la Cuenta"><img src="imagenes/configuracion.png" title="" alt=""/></a>';
	echo '<h2 class="nombre_usuario" title="'. $tipo_usuario .'">'. $tipo_usuario .': ' . $nombre_usuario . '<h2>';
	
	echo '</div>';
	echo '<a class="nombre_usuario" href="cerrar_sesion.php" title="Cerrar Sesión de Administración">Cerrar sesión</a>';
	}
	
	
	
	// Menu Secciones
	function section(){
		echo '
			<div class="pestanias" id="pestanias">
    	<ul>
        	<li onclick="change_section(0);">Cuentas de Usuario</a></li>
        	<li onclick="change_section(1);">Unidades</li>
            <li onclick="change_section(2);">Tipos de Documentos</li>
            <li onclick="change_section(3);">Criterios</li>
                	
    	</ul>
        
        
        <div>
        	<span>
            	<h1>Cuentas de Usuario</h1>
                <ul>
                <li><a href="agregar_usuario.php">Agregar Usuario</a></li>
                <li><a href="buscar_usuario_modif.php">Modificar Usuario</a></li>
                <li><a href="buscar_usuario_consulta.php">Consultar Usuario</a></li>
                <li><a href="buscar_usuario_eliminar.php">Eliminar Usuario</a></li>
				<li><a href="buscar_usuario_reinicio.php">Reiniciar Contraseña</a></li>
                </ul>
            </span>
            
            <span>
            	<h1>Unidades</h1>
				<ul>
                <li><a href="agregar_unidad.php">Agregar Unidad</a></li>
                <li><a href="buscar_unidad_modif.php">Modificar Unidad</a></li>
                <li><a href="buscar_unidad_consulta.php">Consultar Unidad</a></li>
                <li><a href="buscar_unidad_eliminar.php">Eliminar Unidad</a></li>
                </ul>
            </span>
            
            <span>
            	<h1>Tipos de Documentos</h1>
				<ul>
                <li><a href="agregar_tipodoc.php">Agregar Tipo de Documento</a></li>
                <li><a href="buscar_tipodoc_modif.php">Modificar Tipo de Documento</a></li>
                <li><a href="buscar_tipodoc_consulta.php">Consultar Tipo de Documento</a></li>
                <li><a href="buscar_tipodoc_eliminar.php">Eliminar Tipo de Documento</a></li>
                </ul>
            </span>
            
            <span>
            	<h1>Criterios</h1>
				<ul>
                <li><a href="buscar_criterio_modif.php">Modificar Criterio</a></li>
                <li><a href="buscar_criterio_consulta.php">Consultar Criterio</a></li>
                </ul>
            </span>
          
        </div>
        

        
    </div>
			 ';
		}
	
	
?>
<?php
session_start(); 
function inactivo ($ultimoAcceso){
	$ahora = date("Y-n-j H:i:s");
	$tiempo_transcurrido = (strtotime($ahora)-strtotime($ultimoAcceso));
	//comparamos el tiempo transcurrido
	if($tiempo_transcurrido >= 300) {
	//si pasaron 5 minutos o más
	echo '<html><head><meta http-equiv="REFRESH" content="0; url=cerrar_sesion.php"></head></html>';
	//sino, actualizo la fecha de la sesión
	}else {
	$_SESSION["ultimoAcceso"] = $ahora;
	} 
}	
   
?>
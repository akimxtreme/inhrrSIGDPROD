<?php
include "conexion.php";
include "funciones.php";
$u = $_GET['u'];


$sql="SELECT * FROM inf_codigo WHERE cod_doc = '$u'";
$seleccion=mysql_query($sql,$conexion);
$cantidad_de_registros = mysql_num_rows($seleccion);
mysql_close($conexion);
	if($cantidad_de_registros > 0){
		echo '<h1 class="verde">PON: '. $u .' existente &radic;</h1>';
		hidden('pon_unidad_h',"valido");
	}else {echo '<h1 class="rojo">PON: '. $u .' No existe X</h1>';hidden('pon_unidad_h',"");}
			
			
		
		
		
		
	
	
		





?>
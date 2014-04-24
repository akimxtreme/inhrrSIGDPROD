<?php
include "conexion.php";
include "funciones.php";

$u = $_GET['u'];
$cod = $_GET['cod'];
$cod_doc = ";" . $cod;
$pon_asoc = "PON_ASOC-" . $cod;
if($u==""){
	select_multiple ("","multiple","pon_asoc","","",$pon_asoc,"","","");
	img("borrar_pon(this.value);","boton_confidencial","boton_multiple","X","");
	}else {if($u=="undefined"){
		select_multiple ("","multiple","pon_asoc","","",$pon_asoc,"","","");
		img("borrar_pon(this.value);","boton_confidencial","boton_multiple","X","");
		}else {
			//$sql="TRUNCATE TABLE tmp_unidades_confidencial";
			$sql="DELETE FROM pon_asoc_for WHERE cod_doc ='$cod' AND pon_asoc='$u'";
			$seleccion=mysql_query($sql,$conexion);
			select_multiple ("","multiple","pon_asoc","","",$pon_asoc,"","","");
			img("borrar_pon(this.value);","boton_confidencial","boton_multiple","X","");
			}
		
		}




?>
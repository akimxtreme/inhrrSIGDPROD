<?php
include "conexion.php";
include "funciones.php";

$u = $_GET['u'];
$cod = $_GET['cod'];
$cod_doc = ";" . $cod;

if($u==""){
	select_multiple ("","multiple","unidades_confidencial","","",$cod_doc,"","","");
	img("borrar_unidad(this.value);","boton_confidencial","boton_multiple","X","");
	}else {if($u=="undefined"){
		select_multiple ("","multiple","unidades_confidencial","","",$cod_doc,"","","");
		img("borrar_unidad(this.value);","boton_confidencial","boton_multiple","X","");
		}else {
			//$sql="TRUNCATE TABLE tmp_unidades_confidencial";
			$sql="DELETE FROM tmp_unidades_confidencial WHERE sigla_unid ='$u' AND cod_doc='$cod'";
			$seleccion=mysql_query($sql,$conexion);
			select_multiple ("","multiple","unidades_confidencial","","",$cod_doc,"","","");
			img("borrar_unidad(this.value);","boton_confidencial","boton_multiple","X","");
			}
		
		}




?>
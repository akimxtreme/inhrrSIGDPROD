<?php
include "conexion.php";
include "funciones.php";
$u = $_GET['u'];
$cod = $_GET['cod'];
$pon_asoc = "PON_ASOC-" . $cod;
if($u!="Seleccione..."){
$sql="SELECT pon_asoc FROM pon_asoc_for WHERE cod_doc='$cod' AND pon_asoc='$u'";
$seleccion=mysql_query($sql,$conexion);
$cont=mysql_num_rows($seleccion);
	if($cont==0){
		$sql = "INSERT INTO pon_asoc_for (cod_doc,pon_asoc) VALUE ('$cod','$u')";
		$accion=mysql_query($sql,$conexion);
		select_multiple ("","multiple","pon_asoc","","",$pon_asoc,"","","");
		img("borrar_pon(this.value);","boton_confidencial","boton_multiple","X","");
		}else{
			select_multiple ("","multiple","pon_asoc","","",$pon_asoc,"","","");
			img("borrar_pon(this.value);","boton_confidencial","boton_multiple","X","");
			}
		
}else {
	select_multiple ("","multiple","unidades_confidencial","","",$pon_asoc,"","","");
	img("borrar_unidad(this.value);","boton_confidencial","boton_multiple","X","");
}


		
		
		
	
	
		





?>
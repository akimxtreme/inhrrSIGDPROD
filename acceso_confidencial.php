<?php
include "conexion.php";
include "funciones.php";
$u = $_GET['u'];
$cod = $_GET['cod'];
$cod_doc = ";" . $cod;

if($u!="Seleccione..."){
$sql="SELECT * FROM unidades WHERE sigla_doc ='$u'";
$seleccion=mysql_query($sql,$conexion);
while ($row = mysql_fetch_array($seleccion)){
						$sigla_doc=$row["sigla_doc"];
						$sigla_unid=$row["sigla_unid"];
						$denominacion=$row["denominacion"];
						}

$sql="SELECT * FROM tmp_unidades_confidencial WHERE sigla_doc = '$u' AND cod_doc='$cod'";
$seleccion=mysql_query($sql,$conexion);
$cantidad_de_registros = mysql_num_rows($seleccion);
if($cantidad_de_registros > 0){
		select_multiple ("","multiple","unidades_confidencial","","",$cod_doc,"","","");
		img("borrar_unidad(this.value);","boton_confidencial","boton_multiple","X","");
	}else{
		$sql = "INSERT INTO tmp_unidades_confidencial (sigla_unid,denominacion,sigla_doc,cod_doc) VALUE ('$sigla_unid','$denominacion','$sigla_doc','$cod')";
		$accion=mysql_query($sql,$conexion);

		
		select_multiple ("","multiple","unidades_confidencial","","",$cod_doc,"","","");
		img("borrar_unidad(this.value);","boton_confidencial","boton_multiple","X","");
		
		}


	
			
}else {
	select_multiple ("","multiple","unidades_confidencial","","",$cod_doc,"","","");
	img("borrar_unidad(this.value);","boton_confidencial","boton_multiple","X","");
}


		
		
		
	
	
		





?>
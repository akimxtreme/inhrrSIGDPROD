<?php

// Variables

$servidor='127.0.0.1';
$user='root';
$pass='';
/*
$user='root';
$pass='2006';
*/
//mysql_connect: Abre una conexión a un servidor MySQL
$conexion=mysql_connect($servidor,$user,$pass) or die ("NO SE PUEDE CONECTAR");

//mysql_select_db:Selecciona un base de datos MySQL
mysql_select_db('sigdprod',$conexion);
@mysql_query("SET NAMES 'utf8'");


?>

<?php
/*
//mysql_connect: Abre una conexión a un servidor MySQL
$conexion=mysql_connect('172.16.0.37','root','2006') or die ("NO SE PUEDE CONECTAR");

//mysql_select_db:Selecciona un base de datos MySQL
mysql_select_db('sigdprod',$conexion);
@mysql_query("SET NAMES 'utf8'");
*/
?>
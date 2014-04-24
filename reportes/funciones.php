<?php

	Function ConectarBD(){
		return mysql_connect("localhost","root","2006");
	}
	Function EjecuteExec($con,$sSQL){
		mysql_select_db("sigdprod",$con);
		return mysql_query($sSQL,$con);
	}
	Function ObtenerFila($Curso){
		return mysql_fetch_row($Curso);
	}
	Function NumFila($Curso){
		return mysql_num_rows($Curso);
	}
	Function ObResultado($Curso,$Campo,$Fila){
		return mysql_result($Curso,$Fila,$Campo);
	}
	Function InvertirFecha($d_txtFecnac){
		$d_txtFecnac = explode("/",$d_txtFecnac);
		krsort($d_txtFecnac);
		$d_txtFecnac = implode($d_txtFecnac,"-");
		return $d_txtFecnac;
	}
	Function ArreglarFecha($d_txtFecnac){
		$d_txtFecnac = explode("-",$d_txtFecnac);
		krsort($d_txtFecnac);
		$d_txtFecnac = implode($d_txtFecnac,"/");
		return $d_txtFecnac;
	}
	Function TraerCedula(){
		$cedula = $_POST['cedula'];
		$cedula = (int)$cedula;
		return $cedula;
	}
	Function Ejecute($con,$sSQL){
		mysql_select_db("sigdprod",$con);
		return mysql_query($sSQL,$con);
	}
	Function Ejecute2($con,$sSQL){
		mysql_select_db("sigdprod",$con);
		return mysql_query($sSQL,$con);
	}
	Function Titulo(){
		$pdf->setFont('Arial','B',10);
		$pdf->SetDrawColor(0,0,0);
	 	$pdf->SetTextColor(0,0,0);
		$pdf->SetLineWidth(0);
	}			
	Function Texto(){			
		$pdf->setFont('Arial','I',10);
		$pdf->SetDrawColor(0,0,0);
	 	$pdf->SetTextColor(0,0,0);
		$pdf->SetLineWidth(0);	
	}	

?>
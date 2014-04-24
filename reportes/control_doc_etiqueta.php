<?php
include('funciones.php');
require('fpdf.php');

class PDF extends FPDF
{
//Cabecera de p�gina
function Header()
{
	//Logo
	//$this->Image('LogoINH45x57.jpg',20,10);
	//Arial bold 12
	$this->SetFont('Arial','B',10);
	//Movernos a la derecha
	$this->Cell(55);
	//Emblema INHRR
	$this->Cell(80,5,utf8_decode('Control de la Documentacion de la Planta Productora de Vacunas'),0,1,'C');
	$this->Cell(55);
		
	//Salto de L�nea
	$this->Ln(12);
	//Arial bold 12
	$this->SetFont('Arial','B',12);
	//Movernos a la derecha
	$this->Cell(55);
	//T�tulo
	$this->Cell(80,10,'Emision de Etiqueta',0,1,'C');
	$this->SetFont('Arial','',8);
	}

//Pie de p�gina
function Footer()
{
	global $fecha;
	//Posici�n: a 2,1 cm del final
	$this->SetY(-21);
	//Arial italic 8
	$this->SetFont('Arial','B',7);	
	$this->cell(0,4,'FOR_PEAC_003',0,1,'L');
	//Posici�n: a 1,8 cm del final
	$this->SetY(-18);
	//Arial italic 8
	$this->SetFont('Arial','B',7);
	$this->cell(0,4,'Fecha:13/05/2011',0,1,'L');
	//Posici�n: a 1,5 cm del final
	$this->SetY(-15);
	//Arial italic 8
	$this->SetFont('Arial','B',7);
	//N�mero de p�gina
	$this->Cell(20,4,utf8_decode('Revisión 1'),0,0,'L');
	//$this->Cell(140,4,'Page '.$this->PageNo().'/{nb}',0,0,'C');

}
}

//Creaci�n del objeto de la clase heredada
$pdf=new PDF('P','mm','LETTER');
$pdf->SetMargins(20,20,10);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);

//BUSCA TODA LA INFORMACION
$conn = ConectarBD();
$sql1 = "select fecha_emision,condicion,memo_unidad,memo_correlativo,memo_fecha,rec_archivo,cod_doc,observaciones from rec_doc cod_doc ='".$_GET['cod_doc']."' AND rev='".$_GET['rev']."'";

$Resultado1 = Ejecute($conn,$sql1) or die($sql1);
if (NumFila($Resultado1) > 0){
	$Fila1 = ObtenerFila($Resultado1);
	$fecha_emision = $Fila1[0];
	$condicion = $Fila1[1];
	$memo_unidad = $Fila1[2];
	$memo_correlativo = $Fila1[3];
	$memo_fecha = $Fila1[4];
	$rec_archivo = $Fila1[5];
	$cod_doc= $Fila1[6];
	$observaciones= $Fila1[7];
		

	//$dirhab = strtolower($dirhab);
	//$dirhab = ucwords($dirhab);
	//$diremple = trim($diremple);
	//$diremple = strtolower($diremple);
	//$diremple = ucwords($diremple);
	//$fecnac=ArreglarFecha($fecnac);
}

$sql2 = "select titulo_doc,rev,sigla_doc from inf_codigo where cod_doc='$cod_doc'";
$Resultado2 = Ejecute($conn,$sql2) or die($sql2);
if (NumFila($Resultado2) > 0){
	$Fila2 = ObtenerFila($Resultado2);
	$titulo_doc = $Fila2[0];
	$titulo_doc = ucwords($titulo_doc);
	$rev = $Fila2[1];
	$sigla_doc = $Fila2[2];
}
//FECHA DEL REPORTE
$fecha = date('d/m/Y');

//Mostrando los datos en el reporte				

$pdf->Rect(15, 75, 80, 60, 'D');
//FILA 1 CELDA 1 ENCABEZADO TABLA
$pdf->setXY(15,75);
$pdf->setFont('Arial','B',7);
$pdf->SetLineWidth(.1);
$pdf->Cell(80,8,utf8_decode('                         República Bolivariana de Venezuela                    '),0,'T',1,'C',1);
$pdf->setXY(15,80);
$pdf->Cell(80,8,utf8_decode('                            Planta Productora de Vacunas                     '),0,'T',2,'C',1);
$pdf->setXY(15,90);
$pdf->setFont('Arial','B',9);
$pdf->Cell(80,8,utf8_decode('                         Expediente Documental                           '),0,'T',2,'C',1);
$pdf->setXY(15,100);
$pdf->setFont('Arial','B',7);
$pdf->Cell(35,7,'1) Nro. de Registro:',0,0,'L');
$pdf->Cell(20,7,'2) PON asociado: PON_ACDO_004',0,1,'L');
$pdf->Cell(15,7,'3) Codigo: '.$cod_doc,0,1,'L');
$pdf->Cell(15,7,'4) Titulo: '.$titulo_doc,0,1,'L');
$pdf->Cell(15,7,'5) Unidad: '.$sigla_doc,0,1,'L');
$pdf->Rect(15,145, 80, 15, 'D');
$pdf->setXY(15,145);
$pdf->Cell(15,7,'Codigo: '.$cod_doc,0,1,'L');
$pdf->Cell(15,7,'Titulo '.$titulo_doc,0,1,'L');

//SALTO DE LINEA
$pdf->Ln();
$pdf->Output($cod_doc.'_etiqueta.pdf',I);

?>
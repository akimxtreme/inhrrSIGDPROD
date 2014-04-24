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
	$this->Cell(130,5,utf8_decode('República Bolivariana de Venezuela'),0,1,'C');
	$this->Cell(55);
	$this->Cell(130,5,'Planta Productora de Vacunas"',0,1,'C');
	
	//Salto de L�nea
	$this->Ln(12);
	//Arial bold 12
	$this->SetFont('Arial','B',12);
	//Movernos a la derecha
	$this->Cell(55);
	//T�tulo
	$this->Cell(130,10,'Distribucion de Documento(s) Controlado(s) de la Planta Productora de Vacunas',0,1,'C');
	$this->SetFont('Arial','B',10);
	$this->Cell(50,20,'1) Nro. de Registro:',0,0,'L');
	$this->Cell(130,20,'',0,0,'L');
	$this->Cell(50,20,'2) PON asociado: PON_PEAC_023',0,1,'L');
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
$pdf=new PDF('L','mm','LETTER');
$pdf->SetMargins(20,20,10);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);

//BUSCA TODA LA INFORMACION
$conn = ConectarBD();
$sql1 = "select fecha_emision,condicion,memo_unidad,memo_correlativo,memo_fecha,rec_archivo,cod_doc,observaciones from rec_doc where cod_doc ='".$_GET['cod_doc']."' AND rev='".$_GET['rev']."'";

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

//FILA 1 CELDA 1 ENCABEZADO TABLA
$pdf->setXY(20,70);
$pdf->setFont('Arial','B',7);
$pdf->SetLineWidth(.1);
$pdf->Cell(25,8,utf8_decode('(3). Código'),1,'T',2,'C',1);
$pdf->Cell(160,8,'(4). Titulo',1,'T',2,'C',1);
$pdf->Cell(26,8,utf8_decode('(5). Nro. de Revisión'),1,'F',2,'C',0);
$pdf->Cell(30,8,utf8_decode('(6). Fecha de Emisión'),1,'F',2,'C',0);


//FILA 2 CELDA 1 CONTENIDO DE LA CONSULTA

$pdf->setXY(20,78);
$pdf->setFont('Arial','B',7);
$pdf->SetLineWidth(.1);
$pdf->Cell(25,10,$cod_doc,1,'T',2,'C',2);
$pdf->Cell(160,10,$titulo_doc,1,'T',1,'C',1);
$pdf->Cell(26,10,$rev,1,'F',1,'C',0);
$pdf->Cell(30,10,$fecha_emision,1,'F',1,'C',0);


//distribucion

$pdf->setXY(20,95);
$pdf->setFont('Arial','B',7);
$pdf->SetLineWidth(.1);
$pdf->Cell(25,8,utf8_decode('(7). Nro. de C/C'),1,'T',2,'C',1);
$pdf->Cell(25,8,'(8). Siglas',1,'T',2,'C',1);
$pdf->Cell(102,8,utf8_decode('(9). Nombre del Area'),1,'F',2,'C',0);
$pdf->Cell(30,8,utf8_decode('(10). Recibe'),1,'F',2,'C',0);
$pdf->Cell(30,8,utf8_decode('(11). Firma'),1,'F',2,'C',0);
$pdf->Cell(30,8,utf8_decode('(12). Fecha'),1,'F',2,'C',0);
$y=103;
$sql3 = "select unidad,codigo from codigo_unid_distribucion_doc where cod_doc='$cod_doc' and rev='$rev'";
$Resultado3 = Ejecute($conn,$sql3) or die($sql3);
if(mysql_num_rows($Resultado3)>0){
$filasDevueltas = mysql_num_rows($Resultado3);
	while($campo1 = mysql_fetch_object($Resultado3)){
	$unidad= $campo1->unidad;
	$codigo=$campo1->codigo;
		for($c = 0, $total = count($filasDevueltas); $c < $total; ++$c){
		$pdf->setXY(20,$y);
		$pdf->setFont('Arial','B',7);
		$pdf->SetLineWidth(.1);
			$contar = strlen ($codigo);
				switch($contar){
					case 0: {$codigo = "00" . $codigo;}
					break;
					case 1: {$codigo = "00" . $codigo;}
					break;
					case 2: {$codigo = "0" . $codigo;}
					break;
				}
		$pdf->Cell(25,8,$codigo,1,'T',2,'C',1);
		$pdf->Cell(25,8,$unidad,1,'T',2,'C',1);
				$sql4 = "select denominacion from unidades where sigla_unid='$unidad'";
				$Resultado4 = Ejecute($conn,$sql4) or die($sql4);
				if (NumFila($Resultado4) > 0){
					$Fila4 = ObtenerFila($Resultado4);
					$nombre_unidad = $Fila4[0];
					$nombre_unidad = ucwords($nombre_unidad);
				}
		$pdf->Cell(102,8,$nombre_unidad,1,'F',2,'C',0);
		$pdf->Cell(30,8,'',1,'F',2,'C',0);
		$pdf->Cell(30,8,'',1,'F',2,'C',0);
		$pdf->Cell(30,8,'',1,'F',2,'C',1);
		if($y>=183){
			$y=70;
			$pdf->AddPage();
			$pdf->setXY(20,$y);
			$pdf->setFont('Arial','B',7);
			$pdf->SetLineWidth(.1);
			$pdf->Cell(25,8,utf8_decode('(7). Nro. de C/C'),1,'T',2,'C',1);
			$pdf->Cell(25,8,'(8). Siglas',1,'T',2,'C',1);
			$pdf->Cell(102,8,utf8_decode('(9). Nombre del Area'),1,'F',2,'C',0);
			$pdf->Cell(30,8,utf8_decode('(10). Recibe'),1,'F',2,'C',0);
			$pdf->Cell(30,8,utf8_decode('(11). Firma'),1,'F',2,'C',0);
			$pdf->Cell(30,8,utf8_decode('(12). Fecha'),1,'F',2,'C',0);
			$y=$y+8;			
		}else{
			$y=$y+8;
		}
	}
	}
$total=$c;
if($y>=183){
	$y=70;
	$pdf->AddPage();
}else{
	$y=$y+8;
}
}
//fila 3 
$pdf->setXY(20,$y);
$pdf->setFont('Arial','B',7);
$pdf->SetDrawColor(0,50,0);
$pdf->SetTextColor(0,0,0);
$pdf->SetLineWidth(.1);
$pdf->MultiCell(246,20,'(12).Observaciones: '.$observaciones,1,'T',0,'C',0);
$y=$y+30;

//fila 4
$pdf->setXY(80,$y);
$pdf->setFont('Arial','B',7);
$pdf->SetDrawColor(0,50,0);
$pdf->SetTextColor(0,0,0);
$pdf->SetLineWidth(.1);
$pdf->MultiCell(70,8,'(13).Elaborado por:',1,'T',0,'C',0);

//fila 5
$pdf->setXY(150,$y);
$pdf->setFont('Arial','B',7);
$pdf->SetDrawColor(0,50,0);
$pdf->SetTextColor(0,0,0);
$pdf->SetLineWidth(.1);
$pdf->MultiCell(70,8,'(14).Responsable de Documentacion:',1,'T',0,'C',1);
$y=$y+8;
//fila 6 nombre

$pdf->setXY(150,$y);
$pdf->setFont('Arial','B',7);
$pdf->SetDrawColor(0,50,0);
$pdf->SetTextColor(0,0,0);
$pdf->SetLineWidth(.1);
$pdf->MultiCell(30,8,'Nombre:',1,'T',0,'C',0);


$pdf->setXY(180,$y);
$pdf->setFont('Arial','B',7);
$pdf->SetDrawColor(0,50,0);
$pdf->SetTextColor(0,0,0);
$pdf->SetLineWidth(.1);
$pdf->MultiCell(40,8,'',1,'T',0,'C',0);

$pdf->setXY(80,$y);
$pdf->setFont('Arial','B',7);
$pdf->SetDrawColor(0,50,0);
$pdf->SetTextColor(0,0,0);
$pdf->SetLineWidth(.1);
$pdf->MultiCell(30,8,'Nombre:',1,'T',0,'C',0);

$pdf->setXY(110,$y);
$pdf->setFont('Arial','B',7);
$pdf->SetDrawColor(0,50,0);
$pdf->SetTextColor(0,0,0);
$pdf->SetLineWidth(.1);
$pdf->MultiCell(40,8,'',1,'T',0,'C',0);
$y=$y+8;

//fila7 firma 

$pdf->setXY(80,$y);
$pdf->setFont('Arial','B',7);
$pdf->SetDrawColor(0,50,0);
$pdf->SetTextColor(0,0,0);
$pdf->SetLineWidth(.1);
$pdf->MultiCell(30,8,'Firma:',1,'T',0,'C',0);

$pdf->setXY(110,$y);
$pdf->setFont('Arial','B',7);
$pdf->SetDrawColor(0,50,0);
$pdf->SetTextColor(0,0,0);
$pdf->SetLineWidth(.1);
$pdf->MultiCell(40,8,'',1,'T',0,'C',0);

$pdf->setXY(150,$y);
$pdf->setFont('Arial','B',7);
$pdf->SetDrawColor(0,50,0);
$pdf->SetTextColor(0,0,0);
$pdf->SetLineWidth(.1);
$pdf->MultiCell(30,8,'Firma:',1,'T',0,'C',0);

$pdf->setXY(180,$y);
$pdf->setFont('Arial','B',7);
$pdf->SetDrawColor(0,50,0);
$pdf->SetTextColor(0,0,0);
$pdf->SetLineWidth(.1);
$pdf->MultiCell(40,8,'',1,'T',0,'C',0);
$y=$y+8;

//fila8 fecha 

$pdf->setXY(80,$y);
$pdf->setFont('Arial','B',7);
$pdf->SetDrawColor(0,50,0);
$pdf->SetTextColor(0,0,0);
$pdf->SetLineWidth(.1);
$pdf->MultiCell(30,8,'Fecha:',1,'T',0,'C',0);

$pdf->setXY(110,$y);
$pdf->setFont('Arial','B',7);
$pdf->SetDrawColor(0,50,0);
$pdf->SetTextColor(0,0,0);
$pdf->SetLineWidth(.1);
$pdf->MultiCell(40,8,'',1,'T',0,'C',0);

$pdf->setXY(150,$y);
$pdf->setFont('Arial','B',7);
$pdf->SetDrawColor(0,50,0);
$pdf->SetTextColor(0,0,0);
$pdf->SetLineWidth(.1);
$pdf->MultiCell(30,8,'Firma:',1,'T',0,'C',0);

$pdf->setXY(180,$y);
$pdf->setFont('Arial','B',7);
$pdf->SetDrawColor(0,50,0);
$pdf->SetTextColor(0,0,0);
$pdf->SetLineWidth(.1);
$pdf->MultiCell(40,8,'',1,'T',0,'C',0);
//SALTO DE LINEA
$pdf->Ln();
$pdf->Output($cod_doc.'_distribucion.pdf',D);
?>
<?php
include('funciones.php');
require('fpdf.php');
require('WriteHTML.php');

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
	$this->Cell(130,10,'Devolucion de la Documentacion de la Planta Productora de Vacunas',0,1,'C');
	$this->SetFont('Arial','B',10);
	$this->Cell(50,20,'1) Nro. de Registro:',0,0,'L');
	$this->Cell(130,20,'',0,0,'L');
	$this->Cell(50,20,'2) PON asociado: PON_PEAC_023',0,1,'L');
}
}

//Pie de p�gina
function Footer()
{
	global $fecha;
	//Posici�n: a 2,1 cm del final
	$this->SetY(-21);
	//Arial italic 8
	$this->SetFont('Arial','B',7);	
	$this->cell(0,4,'FOR_PEAC_002',0,1,'L');
	//Posici�n: a 1,8 cm del final
	$this->SetY(-18);
	//Arial italic 8
	$this->SetFont('Arial','B',7);
	$this->cell(0,4,'Fecha:16/04/2012',0,1,'L');
	//Posici�n: a 1,5 cm del final
	$this->SetY(-15);
	//Arial italic 8
	$this->SetFont('Arial','B',7);
	//N�mero de p�gina
	$this->Cell(20,4,utf8_decode('Revisión 2'),0,0,'L');
	//$this->Cell(140,4,'Page '.$this->PageNo().'/{nb}',0,0,'C');

}

//Creaci�n del objeto de la clase heredada
//$pdf=new PDF('L','mm','LETTER');
$pdf=new PDF_HTML('L','mm','LETTER');
$pdf->SetMargins(10,10,10,10);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);

//BUSCA TODA LA INFORMACION
$conn = ConectarBD();
$sql1 = "select fecha_recep,memo,nro_copia,observaciones,cod_doc,rev from devolucion_doc where cod_doc ='".$_GET['cod_doc']."' AND rev='".$_GET['rev']."'";

$Resultado1 = Ejecute($conn,$sql1) or die($sql1);
if (NumFila($Resultado1) > 0){
	$Fila1 = ObtenerFila($Resultado1);
	$fecha_recep = $Fila1[0];
	$memo = $Fila1[1];
	$nro_copia = $Fila1[2];
	$observaciones = $Fila1[3];
	$cod_doc = $Fila1[4];
	$rev = $Fila1[5];
}
$sql2 = "select titulo_doc,rev,sigla_doc from inf_codigo where cod_doc='$cod_doc' and rev='$rev'";
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



$pdf->SetFont('Arial','B',9);
//Movernos a la derecha
$pdf->Cell(55);
	//T�tulo
$pdf->Cell(130,5,utf8_decode('República Bolivariana de Venezuela'),0,1,'C');
$pdf->Cell(55);
$pdf->Cell(130,5,'Planta Productora de Vacunas',0,1,'C');
$pdf->Cell(240,10,'Devolucion de la Documentacion de la Planta Productora de Vacunas',0,1,'C');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(50,8,'1) Nro. de Registro:',0,0,'L');
$pdf->Cell(130,8,'',0,0,'L');
$pdf->Cell(50,8,'2) PON asociado: PON_PEAC_023',0,1,'L');


//FILA 1 CELDA 1 ENCABEZADO TABLA
$pdf->setXY(10,40);
$pdf->setFont('Arial','B',7);
$pdf->SetLineWidth(.1);
$pdf->Cell(50,8,utf8_decode('(3). Código: '.$cod_doc),1,'T',2,'C',0);
$pdf->Cell(210,8,'(4). Titulo: '.$titulo_doc,1,'T',2,'C',1);
$pdf->setXY(10,48);
$pdf->Cell(65,8,utf8_decode('(5). Nro. de Revisión: '.$rev),1,'F',2,'C',1);
$pdf->Cell(65,8,utf8_decode('(6). Fecha de Recepción: '.$fecha_recep),1,'F',2,'C',1);
$pdf->Cell(65,8,'(7). Nro. de Copias: '.$nro_copia,1,'T',2,'C',1);
$pdf->Cell(65,8,'(8). Tipo de Documento:   X  Fisico',1,'T',2,'C',1);
$pdf->setXY(10,56);
$pdf->Rect(10,56, 260, 80, 'D');
$pdf->Cell(240,8,utf8_decode('(9). Motivo de la Devolución:   '),0,'T',2,'C',1);
//FILA 2 CELDA 1 CONTENIDO DE Los motivos
$sql3 = "SELECT crit1,crit2,crit3,crit4,crit5,crit6,crit7,crit8 FROM evaluacion_doc WHERE cod_doc='$cod_doc' and rev='$rev'";
$Resultado3 = Ejecute($conn,$sql3) or die($sql3);
if(mysql_num_rows($Resultado3)>0){
$filasDevueltas3 = mysql_num_rows($Resultado3);
	while($row = mysql_fetch_array($Resultado3)){
			$campos = array(
						$row[0], // crit1
						$row[1], // crit2
						$row[2], // crit3
						$row[3], // crit4
						$row[4], // crit5
						$row[5], // crit6
						$row[6], // crit7
						$row[7]  // crit8
							);
			
	}
	/*if($y>=183){
				$y=70;
				$pdf->AddPage();
				$pdf->setXY(20,$y);
		+		$pdf->Cell(240,8,'hjhkjhkjhjkh',1,'T',2,'C',1);
				$y=$y+8;			
			}else{
				$y=$y+8;
			}*/
			for($i=0;$i<=7;$i++){
					// Valida los criterios no cumplidos
					if($campos[$i]=='no'){
						/*$valor;
						$inc;
						$valorX = 20; // Margen X del cuadro detalles (Criterios)
						$valorY = 94; // Margen Y del cuadro detalles (Criterios) *Valor Inicial*
						$ancho = 240; // Valor que indica el ancho del cuadro detalles (Criterios)
						$alto; // Valor que indica la altura del cuadro detalles (Criterios) *Valor Inicial*
						$k = $i + 1;
						$valorY = $valorY + $valor;
						$alto = $alto + $valor;*/
						$k = $i + 1;
						$sql4 = "SELECT detalles FROM cat_crit_evaluacion WHERE id='$k'";
						$Resultado4 = Ejecute($conn,$sql4) or die($sql4);
						$filasDevueltas4 = mysql_num_rows($Resultado4);
								while($row = mysql_fetch_array($Resultado4)){
										$detalles = array(
													$row[0], // detalles
														);
										$contar = strlen ($detalles[0]); // Cuenta la cantidad de caracteres de los detalles
										$datos=$datos.'- Criterio '. $k.': '.$detalles[0].'<br>';
										$pdf->setXY(10,64);  // identifica la posicion X y Y del cuadro de texto
										$pdf->setFont('Arial','B',6);
										$pdf->WriteHTML($datos);
										//$pdf->Rect(20,80, 80, 15, 'D');
										//$pdf->MultiCell(240,5,$datos,0,'T',2,'C',1);
								}
						
						}
			
				
			}
			
}

//fila 3 
$pdf->setXY(10,136);
$pdf->setFont('Arial','B',7);
$pdf->SetDrawColor(0,50,0);
$pdf->SetTextColor(0,0,0);
$pdf->SetLineWidth(.1);
$pdf->MultiCell(260,10,'(10).Observaciones: '.$observaciones,1,'T',0,'C',0);


//fila 4
$pdf->setXY(40,148);
$pdf->setFont('Arial','B',7);
$pdf->SetDrawColor(0,50,0);
$pdf->SetTextColor(0,0,0);
$pdf->SetLineWidth(.1);
$pdf->MultiCell(70,8,'(11).Elaborado por:',1,'T',0,'C',0);

//fila 5
$pdf->setXY(110,148);
$pdf->setFont('Arial','B',7);
$pdf->SetDrawColor(0,50,0);
$pdf->SetTextColor(0,0,0);
$pdf->SetLineWidth(.1);
$pdf->MultiCell(70,8,'(12).Responsable de Documentacion:',1,'T',0,'C',1);

//fila 5
$pdf->setXY(180,148);
$pdf->setFont('Arial','B',7);
$pdf->SetDrawColor(0,50,0);
$pdf->SetTextColor(0,0,0);
$pdf->SetLineWidth(.1);
$pdf->MultiCell(70,8,'(13).Recibido por:',1,'T',0,'C',1);
$y=$y+8;
//fila 6 nombre

$pdf->setXY(40,156);
$pdf->setFont('Arial','B',7);
$pdf->SetDrawColor(0,50,0);
$pdf->SetTextColor(0,0,0);
$pdf->SetLineWidth(.1);
$pdf->MultiCell(70,8,'Nombre:',1,'T',0,'C',0);


$pdf->setXY(110,156);
$pdf->setFont('Arial','B',7);
$pdf->SetDrawColor(0,50,0);
$pdf->SetTextColor(0,0,0);
$pdf->SetLineWidth(.1);
$pdf->MultiCell(70,8,'Nombre:',1,'T',0,'C',0);

$pdf->setXY(180,156);
$pdf->setFont('Arial','B',7);
$pdf->SetDrawColor(0,50,0);
$pdf->SetTextColor(0,0,0);
$pdf->SetLineWidth(.1);
$pdf->MultiCell(70,8,'Nombre:',1,'T',0,'C',0);

//fila7 firma 

$pdf->setXY(40,164);
$pdf->setFont('Arial','B',7);
$pdf->SetDrawColor(0,50,0);
$pdf->SetTextColor(0,0,0);
$pdf->SetLineWidth(.1);
$pdf->MultiCell(70,8,'Firma:',1,'T',0,'C',0);

$pdf->setXY(110,164);
$pdf->setFont('Arial','B',7);
$pdf->SetDrawColor(0,50,0);
$pdf->SetTextColor(0,0,0);
$pdf->SetLineWidth(.1);
$pdf->MultiCell(70,8,'Firma:',1,'T',0,'C',0);

$pdf->setXY(180,164);
$pdf->setFont('Arial','B',7);
$pdf->SetDrawColor(0,50,0);
$pdf->SetTextColor(0,0,0);
$pdf->SetLineWidth(.1);
$pdf->MultiCell(70,8,'Firma:',1,'T',0,'C',0);


$pdf->setXY(40,172);
$pdf->setFont('Arial','B',7);
$pdf->SetDrawColor(0,50,0);
$pdf->SetTextColor(0,0,0);
$pdf->SetLineWidth(.1);
$pdf->MultiCell(70,8,'Fecha:',1,'T',0,'C',0);

$pdf->setXY(110,172);
$pdf->setFont('Arial','B',7);
$pdf->SetDrawColor(0,50,0);
$pdf->SetTextColor(0,0,0);
$pdf->SetLineWidth(.1);
$pdf->MultiCell(70,8,'Fecha:',1,'T',0,'C',0);

$pdf->setXY(180,172);
$pdf->setFont('Arial','B',7);
$pdf->SetDrawColor(0,50,0);
$pdf->SetTextColor(0,0,0);
$pdf->SetLineWidth(.1);
$pdf->MultiCell(70,8,'Fecha:',1,'T',0,'C',0);
//SALTO DE LINEA

$pdf->setXY(10,183);
$pdf->SetFont('Arial','B',6);	
$pdf->Cell(0,4,'FOR_PEAC_002',0,1,'L');
	//Posici�n: a 1,8 cm del final
	//Arial italic 8
	$pdf->SetFont('Arial','B',7);
	$pdf->cell(0,4,'Fecha:16/04/2012',0,1,'L');
	//Posici�n: a 1,5 cm del final
	
	//Arial italic 8
	$pdf->SetFont('Arial','B',7);
	//N�mero de p�gina
	$pdf->Cell(20,4,utf8_decode('Revisión 2'),0,0,'L');
$pdf->Ln();
$pdf->Output($cod_doc.'_devolucion.pdf',D);
?>
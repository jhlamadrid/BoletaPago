<?php



// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);




// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


// set some language-dependent strings (optional)
/*if (@file_exists(dirname(__FILE__).'/lang/spa.php')) {
	require_once(dirname(__FILE__).'/lang/spa.php');
	$pdf->setLanguageArray($l);
}*/

// ---------------------------------------------------------

// set font


// add a page
$pdf->AddPage('P', 'A5');
$pdf->SetAutoPageBreak(false, 0);
$pdf->Image('images/RECIBO_copia12.png', 5, 5, 136, 195, '', '', '', false, 300, '', false, false, 0);
$pdf->Image('images/grafico_barras.jpg', 86, 33, 52, 29, '', '', '', false, 300, '', false, false, 0);
$pdf->SetXY(70,7); 
$pdf->SetFont('helveticaB', '', 5);
$pdf->Write(0, 'RUTA :', '', 0, 'L', true, 0, false, false, 0);
$pdf->SetXY(72,10); 
$pdf->SetFont('helveticaB', '', 5);
$pdf->Write(0, '5010-54634', '', 0, 'L', true, 0, false, false, 0);
//PARA EL RECIBO 
$pdf->SetXY(84,7); 
$pdf->SetFont('helvetica', '', 9);
$pdf->Write(0, 'RECIBO : ', '', 0, 'L', true, 0, false, false, 0);
$pdf->SetXY(100,7); 
$pdf->SetFont('helveticaB', '', 9);
$pdf->Write(0, '106-14849081-65 ', '', 0, 'L', true, 0, false, false, 0);
//CODIGO CABECERA
$pdf->SetXY(84,12); 
$pdf->SetFont('helvetica', '', 9);
$pdf->Write(0, 'CODIGO : ', '', 0, 'L', true, 0, false, false, 0);
$pdf->SetXY(100,12); 
$pdf->SetFont('helveticaB', '', 9);
$pdf->Write(0, '09055502750 ', '', 0, 'L', true, 0, false, false, 0);
//FECHA DE FACTURACION 
$pdf->SetXY(84,19); 
$pdf->SetFont('helvetica', '', 8);
$pdf->Write(0, 'FACTURACION DE : ', '', 0, 'L', true, 0, false, false, 0);
$pdf->SetXY(113,19); 
$pdf->SetFont('helveticaB', '', 9);
$pdf->Write(0, 'DICIEMBRE', '', 0, 'L', true, 0, false, false, 0);
//FECHA DE EMISION 
$pdf->SetXY(84,23); 
$pdf->SetFont('helvetica', '', 8);
$pdf->Write(0, 'FECHA DE EMISION : ', '', 0, 'L', true, 0, false, false, 0);
$pdf->SetXY(113,23); 
$pdf->SetFont('helveticaB', '', 9);
$pdf->Write(0, '03/04/2017', '', 0, 'L', true, 0, false, false, 0);
// CICLO DE FACTURACION 
$pdf->SetXY(86,30.5); 
$pdf->SetFont('helvetica', '', 5);
$pdf->Write(0, 'CICLO : ', '', 0, 'L', true, 0, false, false, 0);
$pdf->SetXY(95,30.5); 
$pdf->SetFont('helveticaB', '', 5);
$pdf->Write(0, '5', '', 0, 'L', true, 0, false, false, 0);
//DETALLE DE LA CABECERA 
$pdf->SetXY(7,25); 
$pdf->SetFont('helveticaB', '', 8);
$pdf->Write(0, 'ESSALUD CAP III METROPOLITANO', '', 0, 'L', true, 0, false, false, 0);
$pdf->SetXY(7,28.5); 
$pdf->SetFont('helveticaB', '', 8);
$pdf->Write(0, 'CA FRANCISCO ADRIANZEN 326', '', 0, 'L', true, 0, false, false, 0);
$pdf->SetXY(7,31.5); 
$pdf->SetFont('helveticaB', '', 8);
$pdf->Write(0, 'URBA SANTA MARIA V ', '', 0, 'L', true, 0, false, false, 0);
//REFERENCIA 
$pdf->SetXY(7,35); 
$pdf->SetFont('helvetica', '', 7);
$pdf->Write(0, 'REFERENCIA :', '', 0, 'L', true, 0, false, false, 0);
/*$pdf->SetXY(27,35); 
$pdf->SetFont('helveticaB', '', 8);
$pdf->Write(0, '', '', 0, 'L', true, 0, false, false, 0);*/
//RUC
$pdf->SetXY(7,38); 
$pdf->SetFont('helvetica', '', 7);
$pdf->Write(0, 'R.U.C.:', '', 0, 'L', true, 0, false, false, 0);
$pdf->SetXY(20,38); 
$pdf->SetFont('helveticaB', '', 7);
$pdf->Write(0, '20131257750', '', 0, 'L', true, 0, false, false, 0);
//HORARIO 
$pdf->SetXY(7,41); 
$pdf->SetFont('helvetica', '', 7);
$pdf->Write(0, 'Horario :', '', 0, 'L', true, 0, false, false, 0);
$pdf->SetXY(20,41); 
$pdf->SetFont('helveticaB', '', 7);
$pdf->Write(0, '03:00:00 Hrs - 23:55:00 Hrs', '', 0, 'L', true, 0, false, false, 0);
// FRECUENCIA , HORAS , DIA SEMANA
$pdf->SetXY(7,45); 
$pdf->SetFont('helvetica', '', 7);
$pdf->Write(0, 'Frecuencia :', '', 0, 'L', true, 0, false, false, 0);
$pdf->SetXY(22,45); 
$pdf->SetFont('helveticaB', '', 7);
$pdf->Write(0, 'Diario', '', 0, 'L', true, 0, false, false, 0);
$pdf->SetXY(31,45); 
$pdf->SetFont('helvetica', '', 7);
$pdf->Write(0, 'Horas:', '', 0, 'L', true, 0, false, false, 0);
$pdf->SetXY(40,45); 
$pdf->SetFont('helveticaB', '', 7);
$pdf->Write(0, '20.92', '', 0, 'L', true, 0, false, false, 0);
$pdf->SetXY(48,45); 
$pdf->SetFont('helvetica', '', 7);
$pdf->Write(0, 'Dias/Semanas :', '', 0, 'L', true, 0, false, false, 0);
$pdf->SetXY(68,45); 
$pdf->SetFont('helveticaB', '', 7);
$pdf->Write(0, '7.00', '', 0, 'L', true, 0, false, false, 0);
// MEDIDOR , TARIFA , TS
$pdf->SetXY(7,49); 
$pdf->SetFont('helvetica', '', 7);
$pdf->Write(0, 'MEDIDOR :', '', 0, 'L', true, 0, false, false, 0);
$pdf->SetXY(22,49); 
$pdf->SetFont('helveticaB', '', 7);
$pdf->Write(0, '2972010459', '', 0, 'L', true, 0, false, false, 0);
$pdf->SetXY(37,49); 
$pdf->SetFont('helvetica', '', 7);
$pdf->Write(0, 'TARIFA :', '', 0, 'L', true, 0, false, false, 0); 
$pdf->SetXY(48,49); 
$pdf->SetFont('helveticaB', '', 7);
$pdf->Write(0, 'E01', '', 0, 'L', true, 0, false, false, 0);
$pdf->SetXY(55,49); 
$pdf->SetFont('helvetica', '', 7);
$pdf->Write(0, 'T/S : ', '', 0, 'L', true, 0, false, false, 0);
$pdf->SetXY(61,49); 
$pdf->SetFont('helveticaB', '', 7);
$pdf->Write(0, '7.00 ', '', 0, 'L', true, 0, false, false, 0);
//LECTURA ACTUAL , LECTURA ANTERIOR 
$pdf->SetXY(7,53); 
$pdf->SetFont('helvetica', '', 7);
$pdf->Write(0, 'LECTURA ACTUAL: ', '', 0, 'L', true, 0, false, false, 0);
$pdf->SetXY(34,53); 
$pdf->SetFont('helveticaB', '', 7);
$pdf->Write(0, '3897 - 28/03/2017 ', '', 0, 'L', true, 0, false, false, 0);
$pdf->SetXY(7,56.5); 
$pdf->SetFont('helvetica', '', 7);
$pdf->Write(0, 'LECTURA ANTERIOR: ', '', 0, 'L', true, 0, false, false, 0);
$pdf->SetXY(34,56.5); 
$pdf->SetFont('helveticaB', '', 7);
$pdf->Write(0, '3854 - 26/02/2017 ', '', 0, 'L', true, 0, false, false, 0);
// CONSUMO M3
$pdf->SetXY(7,60); 
$pdf->SetFont('helvetica', '', 7);
$pdf->Write(0, 'CONSUMO M3 :', '', 0, 'L', true, 0, false, false, 0);
$pdf->SetXY(27,60); 
$pdf->SetFont('helveticaB', '', 7);
$pdf->Write(0, '00000043', '', 0, 'L', true, 0, false, false, 0);
//CUERPO 
$pdf->SetXY(7,70); 
$pdf->SetFont('helvetica', '', 7);
$tbl = <<<EOD
<table border="1" cellpadding="2" cellspacing="2">
 <tr>
  <td width="15" align="center">1</td>
  <td width="185" > SERVICIO DE AGUA  </td>
  <td width="60" align="center">10</td>
  <td width="60" align="center">20</td>
  <td width="60" align="center">30</td>
  <td width="70" align="right">153.33</td>
 </tr>
</table>
EOD;
$pdf->writeHTMLCell(148,  0, 7, 70,$tbl, 0, 1, 0, true, 'L',  true);
$tbl = <<<EOD
<table border="1" cellpadding="2" cellspacing="2">
 <tr>
  <td width="15" align="center">2</td>
  <td width="185" > SERVICIO DE ALCANTARILLADO  </td>
  <td width="60" align="center">10</td>
  <td width="60" align="center">20</td>
  <td width="60" align="center">30</td>
  <td width="70" align="right">153.33</td>
 </tr>
</table>
EOD;
$pdf->writeHTMLCell(148,  0, 7, 73.5,$tbl, 0, 1, 0, true, 'L',  true);
$tbl = <<<EOD
<table border="1" cellpadding="2" cellspacing="2">
 <tr>
  <td width="15" align="center">3</td>
  <td width="185"> CARGO FIJO </td>
  <td width="60" align="center">10</td>
  <td width="60" align="center">20</td>
  <td width="60" align="center">30</td>
  <td width="70" align="right">153.33</td>
 </tr>
</table>
EOD;
$pdf->writeHTMLCell(148,  0, 7, 77,$tbl, 0, 1, 0, true, 'L',  true);
$tbl = <<<EOD
<table border="1" cellpadding="2" cellspacing="2">
 <tr>
  <td width="387.5" align="right" > SUBTOTAL : </td>
  <td width="70" align="right">10</td>
 </tr>
</table>
EOD;
$pdf->writeHTMLCell(148,  0, 7, 81,$tbl, 0, 1, 0, true, 'L',  true);
$dato = 43.95 ;
$tbl = <<<EOD
<table border="1" cellpadding="2" cellspacing="2">
 <tr>  
  <td width="387.5" align="right" > I.G.V.( 18% ) : </td>
  <td width="70" align="right">$dato</td>
 </tr>
</table>
EOD;
$pdf->writeHTMLCell(148,  0, 7, 84,$tbl, 0, 1, 0, true, 'L',  true);
$tbl = <<<EOD
<table border="1" cellpadding="2" cellspacing="2">
 <tr>  
  <td width="387.5" align="right" > SALDO AL MES ANTERIOR : </td>
  <td width="70" align="right">-0.01</td>
 </tr>
</table>
EOD;
$pdf->writeHTMLCell(148,  0, 7, 87.5,$tbl, 0, 1, 0, true, 'L',  true);
$tbl = <<<EOD
<table border="1" cellpadding="2" cellspacing="2">
 <tr>  
  <td width="387.5" align="right" > REDONDEO MES ACTUAL : </td>
  <td width="70" align="right">-0.02</td>
 </tr>
</table>
EOD;
$pdf->writeHTMLCell(148,  0, 7, 90.5,$tbl, 0, 1, 0, true, 'L',  true);
$tbl = <<<EOD
<table border="1" cellpadding="2" cellspacing="2">
 <tr>  
  <td width="387.5" align="left" > Deuda anterior (Ignorar , si está al día)  (1 Mes)" </td>
  <td width="70" align="right">288.10</td>
 </tr>
</table>
EOD;
$pdf->writeHTMLCell(148,  0, 7, 94,$tbl, 0, 1, 0, true, 'L',  true);

$pdf->writeHTMLCell(36,  0,5 , 136,"<p><strong>SEGUNDO ORIGINAL</strong></p>", 0, 1, 0, true, 'L',  true);
$pdf->writeHTMLCell(97,  0, 5, 140.2,"<p>Son: DOSCIENTOS OCHENTIOCHO Y 10/100 SOLES DOSCIENTOS  Y 10/100 SOLES</p>", 0, 1, 0, true, 'L',  true);
//TOTAL A PAGAR
$pdf->SetXY(94,143); 
$pdf->SetFont('helveticaB', '', 8);
$pdf->Write(0, 'TOTAL A PAGAR :', '', 0, 'L', true, 0, false, false, 0);
$pdf->SetFont('helvetica', '', 8);
$pdf->writeHTMLCell(20,  0, 120, 143,"<p>S/ 5,288.10</p>", 0, 1, 0, true, 'R',  true);
//CODIGO DE BARRA E IMAGEN DE CARITA
$pdf->Image('images/codi_barra.png', 4, 151.5, 86, 11, '', '', '', false, 300, '', false, false, 0);
$pdf->Image('images/Alegre.png', 90, 149.5, 11, 11, '', '', '', false, 300, '', false, false, 0);
//FECHA DE VENCIMIENTO Y DE CORTE 
$pdf->SetXY(102,152); 
$pdf->SetFont('helveticaB', '', 8);
$pdf->Write(0, 'F. VEN. :', '', 0, 'L', true, 0, false, false, 0);
$pdf->writeHTMLCell(20,  0, 114, 152,"<p>17/04/2017</p>", 0, 1, 0, true, 'R',  true);
$pdf->SetXY(102,155.5); 
$pdf->SetFont('helveticaB', '', 8);
$pdf->Write(0, 'F. CORTE :', '', 0, 'L', true, 0, false, false, 0);
$pdf->writeHTMLCell(20,  0, 114, 155.5,"<p>17/04/2017</p>", 0, 1, 0, true, 'R',  true);
// PARTE DE LA BASE  ******
//ruta
$pdf->SetXY(7,170); 
$pdf->SetFont('helvetica', '', 6);
$pdf->Write(0, 'Ruta: ', '', 0, 'L', true, 0, false, false, 0);
$pdf->SetXY(14,170); 
$pdf->SetFont('helveticaB', '', 6);
$pdf->Write(0, '5010 - 54634', '', 0, 'L', true, 0, false, false, 0);
//recibo y codigo 
$pdf->SetFont('helvetica', '', 7 );
$pdf->writeHTMLCell(36,  0, 50, 167,"<p>RECIBO : <strong>106-14849081-65</strong></p>", 0, 1, 0, true, 'L',  true);
$pdf->writeHTMLCell(36,  0, 50, 170,"<p>CODIGO : <strong>09055502750</strong></p>", 0, 1, 0, true, 'L',  true);
$pdf->writeHTMLCell(50,  0, 95, 167,"<p>FACTURACIÓN DE : <strong>NOVIEMBRE-17</strong></p>", 0, 1, 0, true, 'L',  true);
$pdf->writeHTMLCell(50,  0, 95, 170,"<p>TOTAL :</p>", 0, 1, 0, true, 'L',  true);
$pdf->writeHTMLCell(50,  0, 118, 170,"<p><strong>S/ 5,288.10</strong></p>", 0, 1, 0, true, 'L',  true);
//MENSAJE DE LA BASE
$pdf->SetXY(57,175); 
$pdf->SetFont('helveticaB', '', 7);
$pdf->Write(0, 'Estimado Cliente :', '', 0, 'L', true, 0, false, false, 0);
$pdf->SetFont('helveticaB', '', 8);
$pdf->writeHTMLCell(133,  0, 7, 178,"<p>Los cobros por los servicios que tu empresa brinda, están sustentados en un comprobante de
pago (Boleta de Venta, Factura o recibo de servicios) y se realizan solamente en oficinas y
centros autorizados.Si algún trabajador visita su predio en nombre de SEDALIB S.A., tiene que
identificarse y estar uniformado. En Caso contrario ¡Denúncielo!SEDALIB LES DESEA
FELICES FIESTAS PATRIAS.</p>", 0, 1, 0, true, 'C',  true);
//MENSAJE ULTIMO DESPUES DE LA BASE 
$pdf->SetXY(112,201); 
$pdf->SetFont('helveticaB', '', 7);
$pdf->Write(0, 'A0228-124101', '', 0, 'L', true, 0, false, false, 0);
// output the HTML content
//$pdf->writeHTML($html, true, 0, true, 0);

// reset pointer to the last page
//$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_021.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

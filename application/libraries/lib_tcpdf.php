<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class lib_tcpdf {
   
 
    function cargar() {
        include_once APPPATH.'third_party/tcpdf/tcpdf.php';
        //include_once APPPATH.'third_party/dompdf/include/dompdf.cls.php';

        /*$dompdf = new DOMPDF();
        $dompdf->load_html('hola');
        $dompdf->set_paper('letter', 'landscape'); 
        $dompdf->render();
        $dompdf->stream("hello_world.pdf");*/
        return new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    }

    
    public function cargo_plantilla($pdf,$dato_general,$dato_detalle){
      //TIPO DOCUMENTO 
      $doc_identificacion = "";
      if(trim($dato_general[0]['CLIRUC']) != ""){
        $doc_identificacion = trim($dato_general[0]['CLIRUC']);
      }else{
        if(trim($dato_general[0]['CLIELECT']) != ""){
          $doc_identificacion = "D.N.I. ".trim($dato_general[0]['CLIELECT']) ;
        }
      }
      $pdf->Image( base_url().'frontend/recibo/RECIBO_copia11.png', 5, 5, 136, 195, '', '', '', false, 300, '', false, false, 0);
      //CONSUMO 
      if(trim($dato_general[0]['TIPIMP']) != "P" && trim($dato_general[0]['TIPIMP'])!= "A"){
        if ($dato_general[0]['CONSUMO'] != 0 ) {
          $consumo = str_pad($dato_general[0]['CONSUMO'],8, "0", STR_PAD_LEFT); 
        }else{
          $consumo="";
        } 
      }else{
        $consumo = 0 ;
      }
      $consumo = $consumo ." ". trim($dato_general[0]['DESCRIREG']);
      //ruta cabecera 
      $pdf->SetXY(70,7); 
      $pdf->SetFont('helveticaB', '', 5);
      $pdf->Write(0, 'RUTA :', '', 0, 'L', true, 0, false, false, 0);
      $pdf->SetXY(72,10); 
      $pdf->SetFont('helveticaB', '', 5);
      $pdf->Write(0, $dato_general[0]['CARGARD']." "."-"." ".$dato_general[0]['ORDENRD'], '', 0, 'L', true, 0, false, false, 0);
      // RECIBO , CODIGO --> CABECERA 
      $pdf->SetXY(85,7); 
      $pdf->SetFont('helvetica', '', 9);
      $pdf->Write(0, 'RECIBO : ', '', 0, 'L', true, 0, false, false, 0);
      /* VERIFICO LAS FECHAS */
      $fecha_emi=$dato_general[0]['FACEMIFEC'];
      $fecha_comparo = '01/02/2020';
      $fecha_e = strtotime($fecha_emi);
      $fecha_c = strtotime($fecha_comparo);
      $electro = '';
      if ($fecha_e >= $fecha_c) {
        $electro = 'S';
      }
      $pdf->SetXY(101,7); 
      $pdf->SetFont('helveticaB', '', 9);
      $pdf->Write(0, $electro.$dato_general[0]['FACSERNRO']."-".$dato_general[0]['FACNRO']."-".$dato_general[0]['FACCHEDIG'], '', 0, 'L', true, 0, false, false, 0);
      //CODIGO CABECERA
      $pdf->SetXY(85,12); 
      $pdf->SetFont('helvetica', '', 9);
      $pdf->Write(0, 'CODIGO : ', '', 0, 'L', true, 0, false, false, 0);
      $pdf->SetXY(101,12); 
      $pdf->SetFont('helveticaB', '', 9);
      $pdf->Write(0, $dato_general[0]['CLICODFAX'], '', 0, 'L', true, 0, false, false, 0);
      //FECHA DE FACTURACION 
      $pdf->SetXY(84,19); 
      $pdf->SetFont('helvetica', '', 8);
      $pdf->Write(0, 'FACTURACION DE : ', '', 0, 'L', true, 0, false, false, 0);
      $pdf->SetXY(113,19); 
      $pdf->SetFont('helveticaB', '', 9);
      $pdf->writeHTMLCell(36,  0, 113, 19,strtoupper($dato_general[0]['DESMES']), 0, 1, 0, true, 'L',  true);
      //$pdf->Write(0, strtoupper($dato_general[0]['DESMES']), '', 0, 'L', true, 0, false, false, 0);
      //FECHA DE EMISION 
      $pdf->SetXY(84,23); 
      $pdf->SetFont('helvetica', '', 8);
      $pdf->Write(0, 'FECHA DE EMISION : ', '', 0, 'L', true, 0, false, false, 0);
      $pdf->SetXY(113,23); 
      $pdf->SetFont('helveticaB', '', 9);
      $pdf->Write(0, $dato_general[0]['FACEMIFEC'], '', 0, 'L', true, 0, false, false, 0);
      //CICLO
      $pdf->SetXY(86,30.5); 
      $pdf->SetFont('helvetica', '', 5.5);
      $pdf->Write(0, 'CICLO : ', '', 0, 'L', true, 0, false, false, 0);
      $pdf->SetXY(95,30.5); 
      $pdf->SetFont('helveticaB', '', 5.5);
      $pdf->Write(0, $dato_general[0]['FCICLO'], '', 0, 'L', true, 0, false, false, 0);
      //DETALLE DE LA CABECERA 
      $pdf->SetXY(7,25); 
      $pdf->SetFont('helveticaB', '', 8);
      $pdf->Write(0,trim($dato_general[0]['CLINOMBRE']), '', 0, 'L', true, 0, false, false, 0);
      $pdf->SetXY(7,28.5); 
      $pdf->SetFont('helveticaB', '', 8);
      $pdf->Write(0,trim($dato_general[0]['DESCALLE'])." ".$dato_general[0]['NUMERO'], '', 0, 'L', true, 0, false, false, 0);
      $pdf->SetXY(7,31.5); 
      $pdf->SetFont('helveticaB', '', 8);
      $pdf->Write(0,$dato_general[0]['DESURBA'], '', 0, 'L', true, 0, false, false, 0);
      //REFERENCIA 
      $pdf->SetXY(7,35); 
      $pdf->SetFont('helvetica', '', 7);
      $pdf->Write(0, 'Ref.:', '', 0, 'L', true, 0, false, false, 0);
      //RUC
      $pdf->SetXY(7,38); 
      $pdf->SetFont('helvetica', '', 7);
      $pdf->Write(0, 'R.U.C.:', '', 0, 'L', true, 0, false, false, 0);
      $pdf->SetXY(20,38); 
      $pdf->SetFont('helveticaB', '', 7);
      $pdf->Write(0, $doc_identificacion, '', 0, 'L', true, 0, false, false, 0);
      //HORARIO 
      $pdf->SetXY(7,41); 
      $pdf->SetFont('helvetica', '', 7);
      $pdf->Write(0, 'Horario :', '', 0, 'L', true, 0, false, false, 0);
      $pdf->SetXY(20,41); 
      $pdf->SetFont('helveticaB', '', 7);
      $pdf->Write(0, $dato_general[0]['HORARIO'], '', 0, 'L', true, 0, false, false, 0);
      // FRECUENCIA , HORAS , DIA SEMANA
      $pdf->SetXY(7,45); 
      $pdf->SetFont('helvetica', '', 7);
      $pdf->Write(0, 'Frecuencia :', '', 0, 'L', true, 0, false, false, 0);
      $pdf->SetXY(22,45); 
      $pdf->SetFont('helveticaB', '', 7);
      $pdf->Write(0, trim($dato_general[0]['DESFH']), '', 0, 'L', true, 0, false, false, 0);
      $pdf->SetXY(31,45); 
      $pdf->SetFont('helvetica', '', 7);
      $pdf->Write(0, 'Horas:', '', 0, 'L', true, 0, false, false, 0);
      $pdf->SetXY(40,45); 
      $pdf->SetFont('helveticaB', '', 7);
      $pdf->Write(0, number_format(floatval($dato_general[0]['HORABS']) , 2, '.', ''), '', 0, 'L', true, 0, false, false, 0);
      $pdf->SetXY(48,45); 
      $pdf->SetFont('helvetica', '', 7);
      $pdf->Write(0, 'Dias/Semanas :', '', 0, 'L', true, 0, false, false, 0);
      $pdf->SetXY(68,45); 
      $pdf->SetFont('helveticaB', '', 7);
      $pdf->Write(0, number_format(floatval($dato_general[0]['DXSEM']) , 2, '.', ''), '', 0, 'L', true, 0, false, false, 0);
      //MEDIDOR, LECTURAR , CONSUMO
      if(trim($dato_general[0]['FMEDIDOR']) != ""){
        $lect_actual = "";
        $lect_anterior = "" ;
        if ($dato_general[0]['LECACT'] !=0) {
          $lect_actual = $dato_general[0]['LECACT']." - ".$dato_general[0]['FECACT'];
        }
        if ($dato_general[0]['LECANT'] !=0) {
          $lect_anterior = $dato_general[0]['LECANT']." - ".$dato_general[0]['FECANT'];
        }
        $pdf->Image('assets/recibo/grafico_barras.jpg', 86, 33, 52, 29, '', '', '', false, 300, '', false, false, 0);
        $pdf->SetXY(7,49); 
        $pdf->SetFont('helvetica', '', 7);
        $pdf->Write(0, 'MEDIDOR :', '', 0, 'L', true, 0, false, false, 0);
        $pdf->SetXY(22,49); 
        $pdf->SetFont('helveticaB', '', 7);
        $pdf->Write(0, trim($dato_general[0]['FMEDIDOR']), '', 0, 'L', true, 0, false, false, 0);
        //LECTURA ACTUAL , LECTURA ANTERIOR 
        $pdf->SetXY(7,53); 
        $pdf->SetFont('helvetica', '', 7);
        $pdf->Write(0, 'LECTURA ACTUAL: ', '', 0, 'L', true, 0, false, false, 0);
        $pdf->SetXY(34,53); 
        $pdf->SetFont('helveticaB', '', 7);
        $pdf->Write(0,$lect_actual, '', 0, 'L', true, 0, false, false, 0);
        $pdf->SetXY(7,56.5); 
        $pdf->SetFont('helvetica', '', 7);
        $pdf->Write(0, 'LECTURA ANTERIOR: ', '', 0, 'L', true, 0, false, false, 0);
        $pdf->SetXY(34,56.5); 
        $pdf->SetFont('helveticaB', '', 7);
        $pdf->Write(0, $lect_anterior, '', 0, 'L', true, 0, false, false, 0);
        // CONSUMO M3
        $pdf->SetXY(7,60); 
        $pdf->SetFont('helvetica', '', 7);
        $pdf->Write(0, 'CONSUMO M3 :', '', 0, 'L', true, 0, false, false, 0);
        $pdf->SetXY(27,60); 
        $pdf->SetFont('helveticaB', '', 7);
        $pdf->Write(0, $consumo, '', 0, 'L', true, 0, false, false, 0);
      }else{
        // CONSUMO M3
        $pdf->SetXY(7,53); 
        $pdf->SetFont('helvetica', '', 7);
        $pdf->Write(0, trim($dato_general[0]['DESCRIREG']), '', 0, 'L', true, 0, false, false, 0); 
      }

      // TARIFA Y OBSERVACION DE LECTURA 
      if($dato_general[0]['OBSLEC'] != 0){
        $pdf->SetXY(65,49); 
        $pdf->SetFont('helvetica', '', 7);
        $pdf->Write(0, 'O/L:', '', 0, 'L', true, 0, false, false, 0);
        $pdf->SetXY(70,49); 
        $pdf->SetFont('helveticaB', '', 7);
        $pdf->Write(0, $dato_general[0]['OBSLEC'], '', 0, 'L', true, 0, false, false, 0);
      }
      if ( ($dato_general[0]['FGRUCOD']== 0 && $dato_general[0]['FGRUSUB'] == 0 ) || strlen(trim($dato_general[0]['CLICODFAX'])) == 11) {
        $pdf->SetXY(39,49); 
        $pdf->SetFont('helvetica', '', 7);
        $pdf->Write(0, 'TARIFA :', '', 0, 'L', true, 0, false, false, 0); 
        $pdf->SetXY(50,49); 
        $pdf->SetFont('helveticaB', '', 7);
        $pdf->Write(0, $dato_general[0]['FACTARIFA'], '', 0, 'L', true, 0, false, false, 0);
        $pdf->SetXY(57,49); 
        $pdf->SetFont('helvetica', '', 7);
        $pdf->Write(0, 'T/S : ', '', 0, 'L', true, 0, false, false, 0);
        $pdf->SetXY(63,49); 
        $pdf->SetFont('helveticaB', '', 7);
        $pdf->Write(0, $dato_general[0]['FSETIPCOD'] , '', 0, 'L', true, 0, false, false, 0);
      }
      // ************************
      // **** CUERPO DEL RECIBO *
      //*************************
      $altura =70; 
      $pdf->SetFont('helvetica', '', 6);
      $i=0;
      while($i<sizeof($dato_detalle)){
        $rang1=" ";
        $rang2=" ";
        $rang3=" ";
        if ( $dato_general[0]['FGRUSUB'] == 0 ){
          if($dato_detalle[$i]['IMPPRIRANG'] != "0"){
            $rang1=number_format(floatval($dato_detalle[$i]['IMPPRIRANG']) , 2, '.', '');
          }
          if($dato_detalle[$i]['IMPSEGRANG'] != "0"){
            $rang2=number_format(floatval($dato_detalle[$i]['IMPSEGRANG']) , 2, '.', '');
          }
          if($dato_detalle[$i]['IMPTERRANG'] != "0"){
            $rang3=number_format(floatval($dato_detalle[$i]['IMPTERRANG']) , 2, '.', '');
          }
        }
        $item = $dato_detalle[$i]['FACLINRO'];
        $detalle = trim($dato_detalle[$i]['DESCONCEP']);
        $letra = strlen(trim($detalle));
        $monto = number_format(number_format(floatval($dato_detalle[$i]['FACPRECI']), 2, '.', '') , 2);
         $tbl = <<<EOD
<table border="1" cellpadding="2" cellspacing="2">
 <tr>
  <td width="15" align="center">$item</td>
  <td width="185" > $detalle</td>
  <td width="60" align="center">$rang1</td>
  <td width="60" align="center">$rang2</td>
  <td width="60" align="center">$rang3</td>
  <td width="70" align="right">$monto</td>
 </tr>
</table>
EOD;
        $pdf->writeHTMLCell(148,  0, 7, $altura,$tbl, 0, 1, 0, true, 'L',  true);
        if ($letra > 44) {
          $altura = $altura + 6 ;
        }else{
          $altura = $altura + 3 ;
        }
        $i++;
      }
      $pdf->SetFont('helveticaBI', '', 7.5);
      $detalle_subtotal =$dato_general[0]['SUBTOT_ANT'] - $dato_general[0]['REDONANT'] ;
      $subtotal = number_format(number_format(floatval($detalle_subtotal), 2, '.', '') , 2);
      $igv = number_format(floatval($dato_general[0]['FACIGV']), 2, '.', '');
      $tbl = <<<EOD
<table border="1" cellpadding="2" cellspacing="2">
 <tr>
  <td width="387.5" align="right" > SUBTOTAL : </td>
  <td width="70" align="right">$subtotal</td>
 </tr>
</table>
EOD;
    $pdf->writeHTMLCell(148,  0, 7, $altura,$tbl, 0, 1, 0, true, 'L',  true);
    $altura = $altura + 3.5 ;
    $tbl = <<<EOD
<table border="1" cellpadding="2" cellspacing="2">
 <tr>  
  <td width="387.5" align="right" > I.G.V.( 18% ) : </td>
  <td width="70" align="right">$igv</td>
 </tr>
</table>
EOD;
    $pdf->writeHTMLCell(148,  0, 7, $altura,$tbl, 0, 1, 0, true, 'L',  true);
    $altura = $altura + 3.5 ;
    $saldo_anterior = number_format(number_format(floatval($dato_general[0]['REDONANT']), 2, '.', '') , 2);
    $tbl = <<<EOD
<table border="1" cellpadding="2" cellspacing="2">
 <tr>  
  <td width="387.5" align="right" > SALDO REDONDEO AL MES ANTERIOR: </td>
  <td width="70" align="right">$saldo_anterior</td>
 </tr>
</table>
EOD;

    $pdf->writeHTMLCell(148,  0, 7, $altura,$tbl, 0, 1, 0, true, 'L',  true);
    $altura = $altura + 3.5 ;
    $redondeo = number_format(number_format(floatval($dato_general[0]['REDONACT']), 2, '.', '') , 2) ;
    $tbl = <<<EOD
<table border="1" cellpadding="2" cellspacing="2">
 <tr>  
  <td width="387.5" align="right" > REDONDEO MES ACTUAL : </td>
  <td width="70" align="right">$redondeo </td>
 </tr>
</table>
EOD;
    $pdf->writeHTMLCell(148,  0, 7, $altura,$tbl, 0, 1, 0, true, 'L',  true);
    $altura = $altura + 3.5 ;
    $mes_periodo =strtoupper ($dato_general[0]['DESMES'])." ".substr($dato_general[0]['PERIODO'], 0, 4); 
    $total_pagar = number_format(number_format($dato_general[0]['FACTOTAL'], 2, '.', '') , 2) ;
    $tbl = <<<EOD
<table border="1" cellpadding="2" cellspacing="2">
 <tr>  
  <td width="387.5" align="left" > TOTAL RECIBO $mes_periodo  </td>
  <td width="70" align="right">$total_pagar</td>
 </tr>
</table>
EOD;
    $pdf->writeHTMLCell(148,  0, 7, $altura,$tbl, 0, 1, 0, true, 'L',  true);
    if ($dato_general[0]['FACSALDO'] > 0) {
      $altura = $altura + 3.5 ;
      $deuda_anterior = number_format(number_format($dato_general[0]['FACSALDO'], 2, '.', ''), 2);
      $tbl = <<<EOD
<table border="1" cellpadding="2" cellspacing="2">
 <tr>  
  <td width="387.5" align="left" > Deuda anterior (Ignorar , si está al día) </td>
  <td width="70" align="right">$deuda_anterior</td>
 </tr>
</table>
EOD;
      $pdf->writeHTMLCell(148,  0, 7, $altura,$tbl, 0, 1, 0, true, 'L',  true);
    }
    $pdf->SetFont('helvetica', '', 7);
    $pdf->writeHTMLCell(36,  0,5 , 136,"<p><strong>SEGUNDO ORIGINAL</strong></p>", 0, 1, 0, true, 'L',  true);
    $desImporte = trim($dato_general[0]['DESIMPORTE'])." SOLES" ;
    $pdf->writeHTMLCell(97,  0, 5, 140.2,"<p>SON:".$desImporte."</p>", 0, 1, 0, true, 'L',  true);
    //CODIGO DE BARRA E IMAGEN DE CARITA ,FECHAS
    $pdf->SetXY(102,152); 
    $pdf->SetFont('helveticaB', '', 8);
    $pdf->Write(0, 'F. VENC. :', '', 0, 'L', true, 0, false, false, 0);
    $pdf->writeHTMLCell(20,  0, 114, 152,"<p>".trim($dato_general[0]['FACVENFEC'])."</p>", 0, 1, 0, true, 'R',  true);
    if($dato_general[0]['FACSALDO']>0 || $dato_general[0]['MENSCORTES'] == 1){
      $pdf->SetXY(102,155.5); 
      $pdf->SetFont('helveticaB', '', 8);
      $pdf->Write(0, 'F. CORTE :', '', 0, 'L', true, 0, false, false, 0);
      $pdf->writeHTMLCell(20,  0, 114, 155.5,"<p>".trim($dato_general[0]['FACCICCOR'])."</p>", 0, 1, 0, true, 'R',  true);
    }
    $pdf->Image('assets/recibo/codi_barra.png', 4, 151.5, 86, 11, '', '', '', false, 300, '', false, false, 0);
    if(floatval($dato_general[0]['FACSALDO'])>0){
      $pdf->Image(base_url() .'frontend/recibo/Triste.png', 90, 149.5, 11, 11, '', '', '', false, 300, '', false, false, 0);
    }else{
      $pdf->Image(base_url() .'frontend/recibo/Alegre.png', 90, 149.5, 11, 11, '', '', '', false, 300, '', false, false, 0);
    }
    $dato=ltrim(rtrim(str_replace ( 'Estimado Cliente:' ,'',utf8_encode($dato_general[0]['MENSAJE']->load() ) )));
    if($dato_general[0]['PORDESEXC']>0){
      if(trim($dato) != ""){
          $pdf->SetFont('helvetica', '', 7);
          $pdf->writeHTMLCell(30,  0, 5, 143,"<p><strong>Estimado Cliente:</strong></p>", 0, 1, 0, true, 'L',  true);
          $pdf->SetFont('helvetica', '', 5.5);
          $pdf->writeHTMLCell(62.5,  0, 5, 145.5,"<p>".utf8_decode($dato)."</p>", 0, 1, 0, true, 'L',  true);
          $pdf->writeHTMLCell(50,  0, 63, 143,"<table cellpadding='1' cellspacing='1' border='1'><tr><td>Consumo Real: ".$dato_general[0]['CONREALMED']." m3 </td></tr><tr><td>Consumo Facturado: ".$dato_general[0]['VOLFAC']." m3</td></tr><tr><td>R.S. N° 10-2008-SUNASS-CD</td></tr></table>", 0, 1, 0, true, 'L',  true);
          

      }
    }else{
      if(trim($dato) != ""){
          $pdf->SetFont('helvetica', '', 7);
          $pdf->writeHTMLCell(30,  0, 5, 143,"<p><strong>Estimado Cliente:</strong></p>", 0, 1, 0, true, 'L',  true);
          $pdf->SetFont('helvetica', '', 5);
          $pdf->writeHTMLCell(80,  0, 5, 145.5,"<p>".utf8_decode($dato)."</p>", 0, 1, 0, true, 'L',  true);
      }
    }
    //TOTAL A PAGAR
    $pdf->SetXY(94,145.5); 
    $pdf->SetFont('helveticaB', '', 8);
    $pdf->Write(0, 'TOTAL A PAGAR :', '', 0, 'L', true, 0, false, false, 0);
    $pdf->SetFont('helvetica', '', 8);
    $pdf->writeHTMLCell(20,  0, 120, 145.5,"<p>S/ ".number_format(number_format(floatval(($dato_general[0]['FACTOTAL']+$dato_general[0]['FACSALDO'] ) ), 2, '.', ''), 2)."</p>", 0, 1, 0, true, 'R',  true);
    if ($dato_general[0]['MENSCORTES'] ==1) {
      $pdf->SetFont('helvetica', '', 4);
      $pdf->writeHTMLCell(50,  0, 90, 142.5,"<p>EL INCUMPLIMIENTO DE PAGO DE UNA CUOTA DE CONVENIO O CREDITO OBLIGA A LA SUSPENCION AUTOMATICA DEL SERVICIO</p>", 0, 1, 0, true, 'L',  true);
    }
    if($dato_general[0]['FACSALDO']>0){
      $pdf->SetFont('helvetica', '', 6);
      $pdf->writeHTMLCell(50,  0, 99, 149,"<p>(no incluye Intereses ni Gastos)</p>", 0, 1, 0, true, 'L',  true);
    }
    
    // PARTE DE LA BASE  ******
    //ruta
    $pdf->SetXY(7,170); 
    $pdf->SetFont('helvetica', '', 6);
    $pdf->Write(0, 'Ruta: ', '', 0, 'L', true, 0, false, false, 0);
    $pdf->SetXY(14,170); 
    $pdf->SetFont('helveticaB', '', 6);
    $pdf->Write(0, $dato_general[0]['CARGARD']."  "."-"." ".$dato_general[0]['ORDENRD'], '', 0, 'L', true, 0, false, false, 0);
    //recibo y codigo 
     $pdf->SetFont('helvetica', '', 7.5 );
    $pdf->writeHTMLCell(56,  0, 40, 167,"<p>RECIBO : <strong>".$dato_general[0]['FACSERNRO']."-".$dato_general[0]['FACNRO']."-".$dato_general[0]['FACCHEDIG']."</strong></p>", 0, 1, 0, true, 'L',  true);
    $pdf->writeHTMLCell(56,  0, 40, 170,"<p>SUMINISTRO : <strong>".$dato_general[0]['CLICODFAX']."</strong></p>", 0, 1, 0, true, 'L',  true);
    $pdf->writeHTMLCell(60,  0, 85, 167,"<p>FACTURACIÓN DE : <strong>".strtoupper ($dato_general[0]['DESMES'])."-".substr($dato_general[0]['PERIODO'], 2, 2)."</strong></p>", 0, 1, 0, true, 'L',  true);
    $pdf->writeHTMLCell(60,  0, 85, 170,"<p>TOTAL :</p>", 0, 1, 0, true, 'L',  true);
    $pdf->writeHTMLCell(60,  0, 108, 170,"<p><strong>S/ ".number_format(number_format(floatval($dato_general[0]['FACTOTAL']+$dato_general[0]['FACSALDO'] ), 2, '.', '') , 2)."</strong></p>", 0, 1, 0, true, 'L',  true);
    //MENSAJE DE LA BASE
    $pdf->SetXY(57,175); 
    $pdf->SetFont('helveticaB', '', 8);
    if($dato_general[0]['MENSAJE2'] != null){
        $mensaje_base =trim(utf8_decode( utf8_encode($dato_general[0]['MENSAJE2']->load() ) )) ; 
        $posicion = stripos($mensaje_base , ':');
        if($posicion===false){
          $pdf->SetFont('helveticaB', '', 8);
          $pdf->writeHTMLCell(133,  0, 7, 178,"<p>".$mensaje_base ."</p>", 0, 1, 0, true, 'C',  true);
        }else{
           if($posicion<25){
              $cabecera_mensaje = substr($mensaje_base, 0,($posicion+1));
              $cuerpo_mensaje = substr($mensaje_base,($posicion+1), strlen($mensaje_base));
              $pdf->SetXY(57,175); 
              $pdf->SetFont('helveticaB', '', 7);
              $pdf->Write(0, $cabecera_mensaje , '', 0, 'L', true, 0, false, false, 0);
              $pdf->SetFont('helveticaB', '', 8);
              $pdf->writeHTMLCell(133,  0, 7, 178,"<p>".$cuerpo_mensaje ."</p>", 0, 1, 0, true, 'C',  true);
           }
          
        }
        
    }else{
      $pdf->writeHTMLCell(133,  0, 7, 178,"<p></p>", 0, 1, 0, true, 'C',  true);
    }
    
    return $pdf ;
    }

    public function cargo_plantilla_mail($pdf,$dato_general,$dato_detalle, $nombre_codi_barra, $nombre_grafi_barra){
      //TIPO DOCUMENTO 
      $doc_identificacion = "";
      if(trim($dato_general[0]['CLIRUC']) != ""){
        $doc_identificacion = trim($dato_general[0]['CLIRUC']);
      }else{
        if(trim($dato_general[0]['CLIELECT']) != ""){
          $doc_identificacion = "D.N.I. ".trim($dato_general[0]['CLIELECT']) ;
        }
      }
      $pdf->Image( base_url().'frontend/recibo/RECIBO_copia15.png', 5, 5, 136, 195, '', '', '', false, 300, '', false, false, 0);
      //CONSUMO 
      if(trim($dato_general[0]['TIPIMP']) != "P" && trim($dato_general[0]['TIPIMP'])!= "A"){
        if ($dato_general[0]['CONSUMO'] != 0 ) {
          $consumo = str_pad($dato_general[0]['CONSUMO'],8, "0", STR_PAD_LEFT); 
        }else{
          $consumo="";
        } 
      }else{
        $consumo = 0 ;
      }
      $consumo = $consumo ." ". trim($dato_general[0]['DESCRIREG']);
      //ruta cabecera 
      $pdf->SetXY(70,7); 
      $pdf->SetFont('helveticaB', '', 5);
      $pdf->Write(0, 'RUTA :', '', 0, 'L', true, 0, false, false, 0);
      $pdf->SetXY(72,10); 
      $pdf->SetFont('helveticaB', '', 5);
      $pdf->Write(0, $dato_general[0]['CARGARD']." "."-"." ".$dato_general[0]['ORDENRD'], '', 0, 'L', true, 0, false, false, 0);
      // RECIBO , CODIGO --> CABECERA 
      $pdf->SetXY(85,7); 
      $pdf->SetFont('helvetica', '', 9);
      $pdf->Write(0, 'RECIBO : ', '', 0, 'L', true, 0, false, false, 0);
      $pdf->writeHTMLCell(50,  9,101,7,"<p><strong>".$dato_general[0]['FACSERNRO']."-".$dato_general[0]['FACNRO']."-".$dato_general[0]['FACCHEDIG']."</strong></p>", 0, 1, 0, true, 'L',  true);
      //CODIGO CABECERA
      $pdf->SetXY(85,12); 
      $pdf->SetFont('helvetica', '', 9);
      $pdf->Write(0, 'CODIGO : ', '', 0, 'L', true, 0, false, false, 0);
      $pdf->writeHTMLCell(50,  9,101,12,"<p><strong>".$dato_general[0]['CLICODFAX']."</strong></p>", 0, 1, 0, true, 'L',  true);
      //FECHA DE FACTURACION 
      $pdf->SetXY(84,19); 
      $pdf->SetFont('helvetica', '', 8);
      $pdf->Write(0, 'FACTURACION DE : ', '', 0, 'L', true, 0, false, false, 0);
      $pdf->SetXY(113,19); 
      $pdf->SetFont('helveticaB', '', 9);
      $pdf->writeHTMLCell(36,  0, 113, 19,strtoupper($dato_general[0]['DESMES']), 0, 1, 0, true, 'L',  true);
      //FECHA DE EMISION 
      $pdf->SetXY(84,23); 
      $pdf->SetFont('helvetica', '', 8);
      $pdf->Write(0, 'FECHA DE EMISION : ', '', 0, 'L', true, 0, false, false, 0);
      $pdf->SetXY(113,23); 
      $pdf->SetFont('helveticaB', '', 9);
      $pdf->Write(0, $dato_general[0]['FACEMIFEC'], '', 0, 'L', true, 0, false, false, 0);
      //CICLO
      $pdf->SetXY(86,30.5); 
      $pdf->SetFont('helvetica', '', 5.5);
      $pdf->Write(0, 'CICLO : ', '', 0, 'L', true, 0, false, false, 0);
      $pdf->SetXY(95,30.5); 
      $pdf->SetFont('helveticaB', '', 5.5);
      $pdf->Write(0, $dato_general[0]['FCICLO'], '', 0, 'L', true, 0, false, false, 0);
      //DETALLE DE LA CABECERA 
      $pdf->SetXY(7,25); 
      $pdf->SetFont('helveticaB', '', 8);
      $pdf->Write(0,trim($dato_general[0]['CLINOMBRE']), '', 0, 'L', true, 0, false, false, 0);
      $pdf->SetXY(7,28.5); 
      $pdf->SetFont('helveticaB', '', 8);
      $pdf->Write(0,trim($dato_general[0]['DESCALLE'])." ".$dato_general[0]['NUMERO'], '', 0, 'L', true, 0, false, false, 0);
      $pdf->SetXY(7,31.5); 
      $pdf->SetFont('helveticaB', '', 8);
      $pdf->Write(0,trim($dato_general[0]['DESURBA']), '', 0, 'L', true, 0, false, false, 0);
      //REFERENCIA 
      $pdf->SetXY(7,35); 
      $pdf->SetFont('helvetica', '', 7);
      $pdf->Write(0, 'Ref. :', '', 0, 'L', true, 0, false, false, 0);
      //RUC
      $pdf->SetXY(7,38); 
      $pdf->SetFont('helvetica', '', 7);
      $pdf->Write(0, 'R.U.C.:', '', 0, 'L', true, 0, false, false, 0);
      $pdf->SetXY(20,38); 
      $pdf->SetFont('helveticaB', '', 7);
      $pdf->Write(0, $doc_identificacion, '', 0, 'L', true, 0, false, false, 0);
      //HORARIO 
      $pdf->SetXY(7,41); 
      $pdf->SetFont('helvetica', '', 7);
      $pdf->Write(0, 'Horario :', '', 0, 'L', true, 0, false, false, 0);
      $pdf->SetXY(17,41); 
      $pdf->SetFont('helveticaB', '', 7);
      $pdf->Write(0, $dato_general[0]['HORARIO'], '', 0, 'L', true, 0, false, false, 0);
      // FRECUENCIA , HORAS , DIA SEMANA
      $pdf->SetXY(7,45); 
      $pdf->SetFont('helvetica', '', 7);
      $pdf->Write(0, 'Frecuencia :', '', 0, 'L', true, 0, false, false, 0);
      $pdf->SetXY(22,45); 
      $pdf->SetFont('helveticaB', '', 7);
      $pdf->Write(0, trim($dato_general[0]['DESFH']), '', 0, 'L', true, 0, false, false, 0);
      $pdf->SetXY(31,45); 
      $pdf->SetFont('helvetica', '', 7);
      $pdf->Write(0, 'Horas:', '', 0, 'L', true, 0, false, false, 0);
      $pdf->SetXY(40,45); 
      $pdf->SetFont('helveticaB', '', 7);
      $pdf->Write(0, number_format(floatval($dato_general[0]['HORABS']) , 2, '.', ''), '', 0, 'L', true, 0, false, false, 0);
      $pdf->SetXY(48,45); 
      $pdf->SetFont('helvetica', '', 7);
      $pdf->Write(0, 'Dias/Semanas :', '', 0, 'L', true, 0, false, false, 0);
      $pdf->SetXY(68,45); 
      $pdf->SetFont('helveticaB', '', 7);
      $pdf->Write(0, number_format(floatval($dato_general[0]['DXSEM']) , 2, '.', ''), '', 0, 'L', true, 0, false, false, 0);
      //MEDIDOR, LECTURAR , CONSUMO
      if(trim($dato_general[0]['FMEDIDOR']) != ""){
        $lect_actual = "";
        $lect_anterior = "" ;
        if ($dato_general[0]['LECACT'] !=0) {
          $lect_actual = $dato_general[0]['LECACT']." - ".$dato_general[0]['FECACT'];
        }
        if ($dato_general[0]['LECANT'] !=0) {
          $lect_anterior = $dato_general[0]['LECANT']." - ".$dato_general[0]['FECANT'];
        }
        $pdf->Image('assets/recibo_mail/'.$nombre_grafi_barra.'.jpg', 86, 33, 52, 29, '', '', '', false, 300, '', false, false, 0);
        $pdf->SetXY(7,49); 
        $pdf->SetFont('helvetica', '', 7);
        $pdf->Write(0, 'MEDIDOR :', '', 0, 'L', true, 0, false, false, 0);
        $pdf->SetXY(22,49); 
        $pdf->SetFont('helveticaB', '', 7);
        $pdf->Write(0, trim($dato_general[0]['FMEDIDOR']), '', 0, 'L', true, 0, false, false, 0);
        //LECTURA ACTUAL , LECTURA ANTERIOR 
        $pdf->SetXY(7,53); 
        $pdf->SetFont('helvetica', '', 7);
        $pdf->Write(0, 'LECTURA ACTUAL: ', '', 0, 'L', true, 0, false, false, 0);
        $pdf->SetXY(34,53); 
        $pdf->SetFont('helveticaB', '', 7);
        $pdf->Write(0,$lect_actual, '', 0, 'L', true, 0, false, false, 0);
        $pdf->SetXY(7,56.5); 
        $pdf->SetFont('helvetica', '', 7);
        $pdf->Write(0, 'LECTURA ANTERIOR: ', '', 0, 'L', true, 0, false, false, 0);
        $pdf->SetXY(34,56.5); 
        $pdf->SetFont('helveticaB', '', 7);
        $pdf->Write(0, $lect_anterior, '', 0, 'L', true, 0, false, false, 0);
        // CONSUMO M3
        $pdf->SetXY(7,60); 
        $pdf->SetFont('helvetica', '', 7);
        $pdf->Write(0, 'CONSUMO M3 :', '', 0, 'L', true, 0, false, false, 0);
        $pdf->SetXY(27,60); 
        $pdf->SetFont('helveticaB', '', 7);
        $pdf->Write(0, $consumo, '', 0, 'L', true, 0, false, false, 0);
      }else{
        // CONSUMO M3
        $pdf->SetXY(7,53); 
        $pdf->SetFont('helvetica', '', 7);
        $pdf->Write(0, trim($dato_general[0]['DESCRIREG']), '', 0, 'L', true, 0, false, false, 0);
        
      }

      // TARIFA Y OBSERVACION DE LECTURA 
      if($dato_general[0]['OBSLEC'] != 0){
        $pdf->SetXY(65,49); 
        $pdf->SetFont('helvetica', '', 7);
        $pdf->Write(0, 'O/L:', '', 0, 'L', true, 0, false, false, 0);
        $pdf->SetXY(70,49); 
        $pdf->SetFont('helveticaB', '', 7);
        $pdf->Write(0, $dato_general[0]['OBSLEC'], '', 0, 'L', true, 0, false, false, 0);
      }
      if ( ($dato_general[0]['FGRUCOD']== 0 && $dato_general[0]['FGRUSUB'] == 0 ) || strlen(trim($dato_general[0]['CLICODFAX'])) == 11) {
        $pdf->SetXY(39,49); 
        $pdf->SetFont('helvetica', '', 7);
        $pdf->Write(0, 'TARIFA :', '', 0, 'L', true, 0, false, false, 0); 
        $pdf->SetXY(50,49); 
        $pdf->SetFont('helveticaB', '', 7);
        $pdf->Write(0, $dato_general[0]['FACTARIFA'], '', 0, 'L', true, 0, false, false, 0);
        $pdf->SetXY(57,49); 
        $pdf->SetFont('helvetica', '', 7);
        $pdf->Write(0, 'T/S : ', '', 0, 'L', true, 0, false, false, 0);
        $pdf->SetXY(63,49); 
        $pdf->SetFont('helveticaB', '', 7);
        $pdf->Write(0, $dato_general[0]['FSETIPCOD'] , '', 0, 'L', true, 0, false, false, 0);
      }
      // ************************
      // **** CUERPO DEL RECIBO *
      //*************************
      $altura =70; 
      $pdf->SetFont('helvetica', '', 7);
      $i=0;
      while($i<sizeof($dato_detalle)){
        $rang1=" ";
        $rang2=" ";
        $rang3=" ";
        if ( $dato_general[0]['FGRUSUB'] == 0 ){
          if($dato_detalle[$i]['IMPPRIRANG'] != "0"){
            $rang1=number_format(floatval($dato_detalle[$i]['IMPPRIRANG']) , 2, '.', '');
          }
          if($dato_detalle[$i]['IMPSEGRANG'] != "0"){
            $rang2=number_format(floatval($dato_detalle[$i]['IMPSEGRANG']) , 2, '.', '');
          }
          if($dato_detalle[$i]['IMPTERRANG'] != "0"){
            $rang3=number_format(floatval($dato_detalle[$i]['IMPTERRANG']) , 2, '.', '');
          }
        }
        $item = $dato_detalle[$i]['FACLINRO'];
        $detalle = trim($dato_detalle[$i]['DESCONCEP']);
        $letra = strlen($detalle);
        $monto = number_format(number_format(floatval($dato_detalle[$i]['FACPRECI']), 2, '.', '') , 2);
         $tbl = <<<EOD
<table border="1" cellpadding="2" cellspacing="2">
 <tr>
  <td width="15" align="center">$item</td>
  <td width="185" > $detalle</td>
  <td width="60" align="center">$rang1</td>
  <td width="60" align="center">$rang2</td>
  <td width="60" align="center">$rang3</td>
  <td width="70" align="right">$monto</td>
 </tr>
</table>
EOD;
        $pdf->writeHTMLCell(148,  0, 7, $altura,$tbl, 0, 1, 0, true, 'L',  true);
        if ($letra > 39) {
          $altura = $altura + 6 ;
        }else{
          $altura = $altura + 3 ;
        }
        $i++;
      }
      $pdf->SetFont('helveticaBI', '', 7.5);
      $detalle_subtotal =$dato_general[0]['SUBTOT_ANT'] - $dato_general[0]['REDONANT'] ;
      $subtotal = number_format(number_format(floatval($detalle_subtotal), 2, '.', '') , 2);
      $igv = number_format(floatval($dato_general[0]['FACIGV']), 2, '.', '');
      $tbl = <<<EOD
<table border="1" cellpadding="2" cellspacing="2">
 <tr>
  <td width="387.5" align="right" > SUBTOTAL : </td>
  <td width="70" align="right">$subtotal</td>
 </tr>
</table>
EOD;
    $pdf->writeHTMLCell(148,  0, 7, $altura,$tbl, 0, 1, 0, true, 'L',  true);
    $altura = $altura + 3.5 ;
    $tbl = <<<EOD
<table border="1" cellpadding="2" cellspacing="2">
 <tr>  
  <td width="387.5" align="right" > I.G.V.( 18% ) : </td>
  <td width="70" align="right">$igv</td>
 </tr>
</table>
EOD;
    $pdf->writeHTMLCell(148,  0, 7, $altura,$tbl, 0, 1, 0, true, 'L',  true);
    $altura = $altura + 3.5 ;
    $saldo_anterior = number_format(number_format(floatval($dato_general[0]['REDONANT']), 2, '.', '') , 2);
    $tbl = <<<EOD
<table border="1" cellpadding="2" cellspacing="2">
 <tr>  
  <td width="387.5" align="right" > SALDO REDONDEO AL MES ANTERIOR: </td>
  <td width="70" align="right">$saldo_anterior</td>
 </tr>
</table>
EOD;

    $pdf->writeHTMLCell(148,  0, 7, $altura,$tbl, 0, 1, 0, true, 'L',  true);
    $altura = $altura + 3.5 ;
    $redondeo = number_format(number_format(floatval($dato_general[0]['REDONACT']), 2, '.', '') , 2) ;
    $tbl = <<<EOD
<table border="1" cellpadding="2" cellspacing="2">
 <tr>  
  <td width="387.5" align="right" > REDONDEO MES ACTUAL : </td>
  <td width="70" align="right">$redondeo </td>
 </tr>
</table>
EOD;
    $pdf->writeHTMLCell(148,  0, 7, $altura,$tbl, 0, 1, 0, true, 'L',  true);
    $altura = $altura + 3.5 ;
    $mes_periodo =strtoupper ($dato_general[0]['DESMES'])." ".substr($dato_general[0]['PERIODO'], 0, 4); 
    $total_pagar = number_format(number_format($dato_general[0]['FACTOTAL'], 2, '.', '') , 2) ;
    $tbl = <<<EOD
<table border="1" cellpadding="2" cellspacing="2">
 <tr>  
  <td width="387.5" align="left" > TOTAL RECIBO $mes_periodo  </td>
  <td width="70" align="right">$total_pagar</td>
 </tr>
</table>
EOD;
    $pdf->writeHTMLCell(148,  0, 7, $altura,$tbl, 0, 1, 0, true, 'L',  true);
    if ($dato_general[0]['FACSALDO'] > 0) {
      $altura = $altura + 3.5 ;
      $deuda_anterior = number_format(number_format($dato_general[0]['FACSALDO'], 2, '.', ''), 2);
      $tbl = <<<EOD
<table border="1" cellpadding="2" cellspacing="2">
 <tr>  
  <td width="387.5" align="left" > Deuda anterior (Ignorar , si está al día) </td>
  <td width="70" align="right">$deuda_anterior</td>
 </tr>
</table>
EOD;
      $pdf->writeHTMLCell(148,  0, 7, $altura,$tbl, 0, 1, 0, true, 'L',  true);
    }
    $pdf->SetFont('helvetica', '', 7);
    $desImporte = trim($dato_general[0]['DESIMPORTE'])." SOLES" ;
    $pdf->writeHTMLCell(97,  0, 5, 140.2,"<p>SON:".$desImporte."</p>", 0, 1, 0, true, 'L',  true);
    //CODIGO DE BARRA E IMAGEN DE CARITA ,FECHAS
    
    $pdf->Image('assets/recibo_mail/'.$nombre_codi_barra.'.png', 4, 151.5, 86, 9.5, '', '', '', false, 300, '', false, false, 0);
    if(floatval($dato_general[0]['FACSALDO'])>0){
      $pdf->Image(base_url() .'frontend/recibo/Triste.png', 90, 149.5, 11, 11, '', '', '', false, 300, '', false, false, 0);
    }else{
      $pdf->Image(base_url() .'frontend/recibo/Alegre.png', 90, 149.5, 11, 11, '', '', '', false, 300, '', false, false, 0);
    }
    $dato=ltrim(rtrim(str_replace ( 'Estimado Cliente:' ,'',utf8_encode($dato_general[0]['MENSAJE']->load() ) )));
    if($dato_general[0]['PORDESEXC']>0){
      if(trim($dato) != ""){
          $pdf->SetFont('helvetica', '', 7);
          $pdf->writeHTMLCell(30,  0, 5, 143,"<p><strong>Estimado Cliente:</strong></p>", 0, 1, 0, true, 'L',  true);
          $pdf->SetFont('helvetica', '', 5.5);
          $pdf->writeHTMLCell(62.5,  0, 5, 145.5,"<p>".utf8_decode($dato)."</p>", 0, 1, 0, true, 'L',  true);
          $pdf->writeHTMLCell(50,  0, 63, 143,"<table cellpadding='1' cellspacing='1' border='1'><tr><td>Consumo Real: ".$dato_general[0]['CONREALMED']." m3 </td></tr><tr><td>Consumo Facturado: ".$dato_general[0]['VOLFAC']." m3</td></tr><tr><td>R.S. N° 10-2008-SUNASS-CD</td></tr></table>", 0, 1, 0, true, 'L',  true);
          

      }
    }else{
      if(trim($dato) != ""){
          $pdf->SetFont('helvetica', '', 7);
          $pdf->writeHTMLCell(30,  0, 5, 143,"<p><strong>Estimado Cliente:</strong></p>", 0, 1, 0, true, 'L',  true);
          $pdf->SetFont('helvetica', '', 5);
          $pdf->writeHTMLCell(80,  0, 5, 145.5,"<p>".utf8_decode($dato)."</p>", 0, 1, 0, true, 'L',  true);
      }
    }
    
    if ($dato_general[0]['MENSCORTES'] ==1) {
      //TOTAL A PAGAR
      $pdf->SetXY(94,144.5); 
      $pdf->SetFont('helveticaB', '', 8);
      $pdf->Write(0, 'TOTAL A PAGAR :', '', 0, 'L', true, 0, false, false, 0);
      $pdf->SetFont('helvetica', '', 8);
      $pdf->writeHTMLCell(20,  0, 120, 144.5,"<p>S/ ".number_format(number_format(floatval(($dato_general[0]['FACTOTAL']+$dato_general[0]['FACSALDO'] ) ), 2, '.', ''), 2)."</p>", 0, 1, 0, true, 'R',  true);
      $pdf->SetFont('helvetica', '', 4);
      $pdf->writeHTMLCell(50,  0, 90, 141,"<p>EL INCUMPLIMIENTO DE PAGO DE UNA CUOTA DE CONVENIO O CREDITO OBLIGA A LA SUSPENCION AUTOMATICA DEL SERVICIO</p>", 0, 1, 0, true, 'L',  true);
      if($dato_general[0]['FACSALDO']>0){
          $pdf->SetFont('helvetica', '', 6);
          $pdf->writeHTMLCell(50,  0, 99, 149,"<p>(no incluye Intereses ni Gastos)</p>", 0, 1, 0, true, 'L',  true);
          // fechas 
          $pdf->SetXY(106,152); 
          $pdf->SetFont('helveticaB', '', 8);
          $pdf->Write(0, 'F. VENC.:', '', 0, 'L', true, 0, false, false, 0);
          $pdf->writeHTMLCell(20,  0, 116, 152,"<p>".trim($dato_general[0]['FACVENFEC'])."</p>", 0, 1, 0, true, 'R',  true);
          if($dato_general[0]['FACSALDO']>0 || $dato_general[0]['MENSCORTES'] == 1){
            $pdf->SetXY(106,155.5); 
            $pdf->SetFont('helveticaB', '', 8);
            $pdf->Write(0, 'F. CORTE :', '', 0, 'L', true, 0, false, false, 0);
            $pdf->writeHTMLCell(20,  0, 118, 155.5,"<p>".trim($dato_general[0]['FACCICCOR'])."</p>", 0, 1, 0, true, 'R',  true);
          }
      }else{
        // fechas 
          $pdf->SetXY(106,148); 
          $pdf->SetFont('helveticaB', '', 8);
          $pdf->Write(0, 'F. VENC.:', '', 0, 'L', true, 0, false, false, 0);
          $pdf->writeHTMLCell(20,  0, 116, 148,"<p>".trim($dato_general[0]['FACVENFEC'])."</p>", 0, 1, 0, true, 'R',  true);
          if($dato_general[0]['FACSALDO']>0 || $dato_general[0]['MENSCORTES'] == 1){
            $pdf->SetXY(106,151); 
            $pdf->SetFont('helveticaB', '', 8);
            $pdf->Write(0, 'F. CORTE :', '', 0, 'L', true, 0, false, false, 0);
            $pdf->writeHTMLCell(20,  0, 118, 151,"<p>".trim($dato_general[0]['FACCICCOR'])."</p>", 0, 1, 0, true, 'R',  true);
          }
      }
    }
    else{
       //TOTAL A PAGAR
      $pdf->SetXY(94,142); 
      $pdf->SetFont('helveticaB', '', 8);
      $pdf->Write(0, 'TOTAL A PAGAR :', '', 0, 'L', true, 0, false, false, 0);
      $pdf->SetFont('helvetica', '', 8);
      $pdf->writeHTMLCell(20,  0, 120, 142,"<p>S/ ".number_format(number_format(floatval(($dato_general[0]['FACTOTAL']+$dato_general[0]['FACSALDO'] ) ), 2, '.', ''), 2)."</p>", 0, 1, 0, true, 'R',  true);
      $pdf->SetFont('helvetica', '', 4);
      if($dato_general[0]['FACSALDO']>0){
        $pdf->SetFont('helvetica', '', 6);
        $pdf->writeHTMLCell(50,  0, 99, 145,"<p>(no incluye Intereses ni Gastos)</p>", 0, 1, 0, true, 'L',  true);
        // fechas 
        $pdf->SetXY(106,148); 
        $pdf->SetFont('helveticaB', '', 8);
        $pdf->Write(0, 'F. VENC.:', '', 0, 'L', true, 0, false, false, 0);
        $pdf->writeHTMLCell(20,  0, 116, 148,"<p>".trim($dato_general[0]['FACVENFEC'])."</p>", 0, 1, 0, true, 'R',  true);
        if($dato_general[0]['FACSALDO']>0 || $dato_general[0]['MENSCORTES'] == 1){
          $pdf->SetXY(106,152); 
          $pdf->SetFont('helveticaB', '', 8);
          $pdf->Write(0, 'F. CORTE :', '', 0, 'L', true, 0, false, false, 0);
          $pdf->writeHTMLCell(20,  0, 118, 152,"<p>".trim($dato_general[0]['FACCICCOR'])."</p>", 0, 1, 0, true, 'R',  true);
        }
      }else{
        // fechas 
        $pdf->SetXY(106,146); 
        $pdf->SetFont('helveticaB', '', 8);
        $pdf->Write(0, 'F. VENC.:', '', 0, 'L', true, 0, false, false, 0);
        $pdf->writeHTMLCell(20,  0, 116, 146,"<p>".trim($dato_general[0]['FACVENFEC'])."</p>", 0, 1, 0, true, 'R',  true);
        if($dato_general[0]['FACSALDO']>0 || $dato_general[0]['MENSCORTES'] == 1){
          $pdf->SetXY(106,150); 
          $pdf->SetFont('helveticaB', '', 8);
          $pdf->Write(0, 'F. CORTE :', '', 0, 'L', true, 0, false, false, 0);
          $pdf->writeHTMLCell(20,  0, 118, 150,"<p>".trim($dato_general[0]['FACCICCOR'])."</p>", 0, 1, 0, true, 'R',  true);
        }
      }
    }
    
    // PARTE DE LA BASE  ******
    //ruta
    $pdf->SetXY(7,170); 
    $pdf->SetFont('helvetica', '', 6);
    $pdf->Write(0, 'Ruta: ', '', 0, 'L', true, 0, false, false, 0);
    $pdf->SetXY(14,170); 
    $pdf->SetFont('helveticaB', '', 6);
    $pdf->Write(0, $dato_general[0]['CARGARD']."  "."-"." ".$dato_general[0]['ORDENRD'], '', 0, 'L', true, 0, false, false, 0);
    //recibo y codigo 
     $pdf->SetFont('helvetica', '', 7.5 );
    $pdf->writeHTMLCell(56,  0, 40, 167,"<p>RECIBO : <strong>".$dato_general[0]['FACSERNRO']."-".$dato_general[0]['FACNRO']."-".$dato_general[0]['FACCHEDIG']."</strong></p>", 0, 1, 0, true, 'L',  true);
    $pdf->writeHTMLCell(56,  0, 40, 170,"<p>SUMINISTRO : <strong>".$dato_general[0]['CLICODFAX']."</strong></p>", 0, 1, 0, true, 'L',  true);
    $pdf->writeHTMLCell(60,  0, 85, 167,"<p>FACTURACIÓN DE : <strong>".strtoupper ($dato_general[0]['DESMES'])."-".substr($dato_general[0]['PERIODO'], 2, 2)."</strong></p>", 0, 1, 0, true, 'L',  true);
    $pdf->writeHTMLCell(60,  0, 85, 170,"<p>TOTAL :</p>", 0, 1, 0, true, 'L',  true);
    $pdf->writeHTMLCell(60,  0, 108, 170,"<p><strong>S/ ".number_format(number_format(floatval($dato_general[0]['FACTOTAL']+$dato_general[0]['FACSALDO'] ), 2, '.', '') , 2)."</strong></p>", 0, 1, 0, true, 'L',  true);
    //MENSAJE DE LA BASE
    $pdf->SetXY(57,175); 
    $pdf->SetFont('helveticaB', '', 8);
    if($dato_general[0]['MENSAJE2'] != null){
        $mensaje_base =trim(utf8_decode( utf8_encode($dato_general[0]['MENSAJE2']->load() ) )) ; 
        $posicion = stripos($mensaje_base , ':');
        if($posicion===false){
          $pdf->SetFont('helveticaB', '', 8);
          $pdf->writeHTMLCell(133,  0, 7, 178,"<p>".$mensaje_base ."</p>", 0, 1, 0, true, 'C',  true);
        }else{
           if($posicion<25){
              $cabecera_mensaje = substr($mensaje_base, 0,($posicion+1));
              $cuerpo_mensaje = substr($mensaje_base,($posicion+1), strlen($mensaje_base));
              $pdf->SetXY(57,175); 
              $pdf->SetFont('helveticaB', '', 7);
              $pdf->Write(0, $cabecera_mensaje , '', 0, 'L', true, 0, false, false, 0);
              $pdf->SetFont('helveticaB', '', 8);
              $pdf->writeHTMLCell(133,  0, 7, 178,"<p>".$cuerpo_mensaje ."</p>", 0, 1, 0, true, 'C',  true);
           }
          
        }
        
    }else{
      $pdf->writeHTMLCell(133,  0, 7, 178,"<p></p>", 0, 1, 0, true, 'C',  true);
    }

    return $pdf ;
    }

    public function plantilla_acta($pdf, $suministro, $direccion, $nombre, $DNI, $total_deuda, $inicial, $nro_cuota, $fech_vencimiento, $oficina, $agencia, $nro_credito,$tipo,$fech,$tabla, $nombre_catastral){

      //$fecha  = explode("/", $fech_vencimiento);
      $style = array('width' => 0.20, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
      $pdf->SetXY(10 ,6); 
      $pdf->SetFont('helvetica', '', 6);
      $pdf->Write(0, 'SEDALIB S.A.', '', 0, 'L', true, 0, false, false, 0);
      $pdf->writeHTMLCell(60,  0,170 , 6,"<p>Impreso el ".date("d/m/Y H:i:s")."</p>", 0, 1, 0, true, 'L',  true);
      $pdf->SetXY(40 ,12); 
      $pdf->SetFont('helveticaB', '', 9);
      $pdf->Write(0, 'CONTRATO DE RECONOCIMIENTO DE DEUDA Y FACILIDADES DE PAGO N° '.$oficina.'-'.$agencia.'-'.$nro_credito, '', 0, 'L', true, 0, false, false, 0);
      $pdf->Line(11, 22,200, 22, $style);
      $pdf->SetFont('helveticaB', '', 8);
      $pdf->writeHTMLCell(60,  0,15 , 25,"<p>Suministro: ".$suministro."</p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(90,  0,15 , 29,"<p>Nombre: ".$nombre_catastral."</p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(90,  0,110 , 29,"<p>Dirección: ".$direccion."</p>", 0, 1, 0, true, 'L',  true);
      $pdf->Line(11, 37,200, 37, $style);
      $pdf->Line(11, 22,11, 37, $style);
      $pdf->Line(200, 22,200, 37, $style);
      $pdf->SetFont('helvetica', '', 8.5);
      if(count($tabla)==2){
        $pdf->writeHTMLCell(175,  0,15 , 40,'<p style="text-align:justify;">Conste por el presente documento de Reconocimiento de deuda y facilidades pago que celebran de una parte la E.P.S. Empresa de Servicios de Agua Potable y Alcantarillado de la Libertad Sociedad Anónima Identificada con R.U.C. Nro. 20131911310 con domicilio en la Av. Federico Villareal Nro. 1300 , Urbanización Semirústica El Bosque, a quien en adelante se le denominará SEDALIB S.A.; y en otra parte el señor(a) '.$tabla[1]['Nombre'].' , identificado con D.N.I. Nro. '.$tabla[1]['DNI'].' en su condición de titular del predio ubicado en '.$direccion.' a quien en adelante se le denominará EL DEUDOR, bajo la siguientes condiciones y terminos siguientes : </p>', 0, 1, 0, true, 'L',  true);
      }else{
        $pdf->writeHTMLCell(175,  0,15 , 40,'<p style="text-align:justify;">Conste por el presente documento de Reconocimiento de deuda y facilidades pago que celebran de una parte la E.P.S. Empresa de Servicios de Agua Potable y Alcantarillado de la Libertad Sociedad Anónima Identificada con R.U.C. Nro. 20131911310 con domicilio en la Av. Federico Villareal Nro. 1300 , Urbanización Semirústica El Bosque, a quien en adelante se le denominará SEDALIB S.A.; y en otra parte el señor(a) '.$nombre.' , identificado con D.N.I. Nro. '.$DNI.' en su condición de titular del predio ubicado en '.$direccion.' a quien en adelante se le denominará EL DEUDOR, bajo la siguientes condiciones y terminos siguientes : </p>', 0, 1, 0, true, 'L',  true);
      }
      
      $pdf->SetXY(15 ,70); 
      $pdf->Write(0, 'PRIMERA: ', '', 0, 'L', true, 0, false, false, 0);
      $pdf->writeHTMLCell(175,  0,15 , 74,'<p style="text-align:justify;">EL DEUDOR reconoce y asume la deuda total de S/ '.$total_deuda.' Soles contraído a la fecha a favor de SEDALIB S.A., correspondiente al suministro con Código Nro. '.$suministro.' por servicios de Agua Potable y Alcantarillado, generados por los recibos impagos, más los intereses correspondientes de acuerdo a la Tasa TAM, de coformidad con el Art. 13 Inc. E) del Reglamento de Prestación de Servicios de SEDALIB S.A., aprobado mediante Resolución de Intendencia Nro. 010-97-SUNASS-INF.</p>', 0, 1, 0, true, 'L',  true);
      $pdf->SetXY(15 ,93); 
      $pdf->Write(0, 'SEGUNDA: ', '', 0, 'L', true, 0, false, false, 0);
      $pdf->writeHTMLCell(175,  0,15 , 97,'<p style="text-align:justify;">EL DEUDOR conviene con SEDALIB S.A. que la forma de pago será de la siguiente manera: </p>', 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(175,  0,15 , 102,'<p style="text-align:justify;">a) Una inicial en efectivo de S/ '.$inicial.' Soles  </p>', 0, 1, 0, true, 'L',  true);
      $fecha = explode("/", $fech_vencimiento);
      if(count($fecha)>=2){
        $pdf->writeHTMLCell(175,  0,15 , 107,'<p style="text-align:justify;">b) El saldo  en '.$nro_cuota.' cuotas fijas , a partir de la facturación de '.$fecha[2].$fecha[1].'</p>', 0, 1, 0, true, 'L',  true);
      }else{
        
        $pdf->writeHTMLCell(175,  0,15 , 107,'<p style="text-align:justify;">b) El saldo  en '.$nro_cuota.' cuotas fijas , a partir de la facturación de '.$fecha[0].'</p>', 0, 1, 0, true, 'L',  true);
      }
      
      /*if(isset($fecha)){
        if(!(is_array ($fech_vencimiento))){
          
          $pdf->writeHTMLCell(175,  0,15 , 107,'<p style="text-align:justify;">b) El saldo 1 en '.$nro_cuota.' cuotas fijas , a partir de la facturación de '.$fech_vencimiento.'</p>', 0, 1, 0, true, 'L',  true);
        }else{
          $fecha  = explode("/", $fech_vencimiento);
          $pdf->writeHTMLCell(175,  0,15 , 107,'<p style="text-align:justify;">b) El saldo 2 en '.$nro_cuota.' cuotas fijas , a partir de la facturación de '.$fecha[2].$fecha[1].'</p>', 0, 1, 0, true, 'L',  true);
        }
       
      }*/
      
      $pdf->SetXY(15 ,113); 
      $pdf->Write(0, 'TERCERA: ', '', 0, 'L', true, 0, false, false, 0);
      $pdf->writeHTMLCell(175,  0,15 , 117,'<p style="text-align:justify;">EL DEUDOR acepta cumplir fielmente el cronograma de pagos adjunto y que en el caso de retraso en el pago de dos cuotas a su cargo quedarán vencidas y plenamente exigibles todas las demás cuotas procediendo SEDALIB S.A. a iniciar la cobranza judicial por la totalidad de la deuda , la misma que tiene mérito ejecutivo de conformidad con el Art. 24 de la Ley 26338, Ley General de Saneamiento ,concordante con el Art. 693, inc 5to, del Código Procesal Civil. </p>', 0, 1, 0, true, 'L',  true);
      $pdf->SetXY(15 ,135); 
      $pdf->Write(0, 'CUARTA: ', '', 0, 'L', true, 0, false, false, 0);
      $pdf->writeHTMLCell(175,  0,15 , 139,'<p style="text-align:justify;"><strong>En caso que el DEUDOR incumpliera en el pago se procederá a ejecutar las acciones coercitivas de suspeción del servicio y levantamiento de las conexiones de ser necesario, en este caso el DEUDOR quedará constituido en mora en forma automática y deberá asumir respecto al integro de la deuda los intereses moratorios y compensatorios máximos permitidos por el Banco Central de Reserva del Perú hasta la fecha de pago efectivo, así como todos los gastos administrativos que se generen por la cobranza respectiva. </strong></p>', 0, 1, 0, true, 'L',  true);
      $pdf->SetXY(15 ,160); 
      $pdf->Write(0, 'QUINTA: ', '', 0, 'L', true, 0, false, false, 0);
      $pdf->writeHTMLCell(175,  0,15 , 165,'<p style="text-align:justify;">EL DEUDOR declara que sobre el importe de S/ '.$total_deuda.' Soles no tiene observación alguna que formular renunciando a cualquier reclamo posterior a la suscripción del presente convenio</p>', 0, 1, 0, true, 'L',  true);
      $pdf->SetXY(15 ,175); 
      $pdf->Write(0, 'SEXTA: ', '', 0, 'L', true, 0, false, false, 0);
      $pdf->writeHTMLCell(175,  0,15 , 179,'<p style="text-align:justify;">Con la firma del presente convenio, ambas partes aceptan su contenido y se ratifican en todas y cada una de las condiciones, declarando que no existe, error, dolo, simulación o vicio que lo invalide.</p>', 0, 1, 0, true, 'L',  true);
      $pdf->SetXY(15 ,190); 
      $pdf->Write(0, 'SETIMA: ', '', 0, 'L', true, 0, false, false, 0);
      $pdf->writeHTMLCell(175,  0,15 , 194,'<p style="text-align:justify;">Para los efectos derivados del presente contrato las partes renuncian al fuero de su domicilio y se somenten a la Jurisdicción de los Jueces y Tribunales de la ciudad de Trujillo, fijando como sus domicilios los indicados en la Introducción del presente documento.</p>', 0, 1, 0, true, 'L',  true);
      if($tipo == 1){
        $pdf->writeHTMLCell(175,  0,15 , 209,'<p style="text-align:justify;">En señal de conformidad, las partes firman el presente contrato, en la ciudad de Trujillo, a la fecha '.date("d/m/Y").'</p>', 0, 1, 0, true, 'L',  true);
      }else{
        $pdf->writeHTMLCell(175,  0,15 , 209,'<p style="text-align:justify;">En señal de conformidad, las partes firman el presente contrato, en la ciudad de Trujillo, a la fecha '.$fech[0].'</p>', 0, 1, 0, true, 'L',  true);
      }
      $pdf->Line(15, 250,70, 250, $style);
      $pdf->SetXY(30 ,251); 
      $pdf->Write(0, 'POR SEDALIB S.A.', '', 0, 'L', true, 0, false, false, 0);
      $pdf->Line(80, 250,145, 250, $style);
      $pdf->SetXY(80 ,251); 
      $pdf->SetFont('helvetica', '', 7);
      $pdf->Write(0, 'NOMBRE DEL DEUDOR:', '', 0, 'L', true, 0, false, false, 0);
      $pdf->SetXY(80 ,254);
      $pdf->Write(0, 'D.N.I.:', '', 0, 'L', true, 0, false, false, 0);
      $pdf->Line(155, 220,180, 220, $style);
      $pdf->Line(155, 220,155, 245, $style);
      $pdf->Line(155, 245,180, 245, $style);
      $pdf->Line(180, 220,180, 245, $style);
      $pdf->SetXY(160 ,247);
      $pdf->Write(0, 'Huella Digital', '', 0, 'L', true, 0, false, false, 0);
      $pdf->SetXY(15 ,285);
      $pdf->Write(0, 'DIGITADOR(A): '.$_SESSION['user_nom'], '', 0, 'L', true, 0, false, false, 0);
      return $pdf;
    }
    public function plantilla_caja($pdf, $distancia, $nombre, $direccion, $deuda_total, $inicial, $nro_cuota, $saldo, $oficina, $agencia, $num_credit, $num_amortiza, $suministro, $tipo, $fecha_sum, $nombre_catastral ){
      $style = array('width' => 0.20, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
      $pdf->SetFont('helvetica', '', 6.5);
      $pdf->writeHTMLCell(60,  0,170 , (5 + $distancia),"<p> ".date("d/m/Y H:i:s")."</p>", 0, 1, 0, true, 'L',  true);
      $pdf->SetFont('helveticaB', '', 11);
      $pdf->writeHTMLCell(150, 0,30 , (13 + $distancia),"<p>Empresa de Servicio de Agua Potable y Alcantarillado de la Libertad S.A.</p>", 0, 1, 0, true, 'L',  true);
      $pdf->SetFont('helvetica', '', 10);
      $pdf->writeHTMLCell(150, 0,70 , (18 + $distancia),"<p>SEDALIB S.A. RUC 20131911310</p>", 0, 1, 0, true, 'L',  true);
      $pdf->SetFont('helveticaB', '', 14);
      $pdf->writeHTMLCell(100, 0,15 , (27 + $distancia),"<p>RECIBO DE CAJA DE ".$oficina.$agencia."-".$num_amortiza." </p>", 0, 1, 0, true, 'L',  true);
      $pdf->Line(15, (37 + $distancia),190, (37 + $distancia), $style);
      $pdf->Line(15, (80 + $distancia),190, (80 + $distancia), $style);
      $pdf->Line(15, (37 + $distancia),15, (80 + $distancia), $style);
      $pdf->Line(190, (37 + $distancia),190, (80 + $distancia), $style);
      $pdf->SetFont('helvetica', '', 8);
      $pdf->writeHTMLCell(100, 0,18 , (40 + $distancia),"<p> CLIENTE : ".$suministro." - ".$nombre_catastral."</p>", 0, 1, 0, true, 'L',  true);
      if($tipo == 1){
        $pdf->writeHTMLCell(100, 0,148 , (40 + $distancia),"<p> FECHA : ".date("d/m/Y")."</p>", 0, 1, 0, true, 'L',  true);
      }else{
        $pdf->writeHTMLCell(100, 0,148 , (40 + $distancia),"<p> FECHA : ".$fecha_sum."</p>", 0, 1, 0, true, 'L',  true);
      }
      
      $pdf->writeHTMLCell(170, 0,18 , (48 + $distancia),"<p> DIRECCIÓN :".$direccion."</p>", 0, 1, 0, true, 'L',  true);
      $pdf->SetFont('helveticaB', '', 10);
      $pdf->writeHTMLCell(160, 0,18 , (52 + $distancia),"<p>Por medio del presente documento el usuario amortiza la cantidad de  S/  ".$inicial." Como parte de inicial del Credito N° ".$num_credit." generado por una deuda con la empresa de  S/ ".$deuda_total.", quedando un saldo de S/ ".$saldo." pagadero en ".$nro_cuota." cuotas. </p>", 0, 1, 0, true, 'L',  true);
      $pdf->SetFont('helvetica', '', 10);
      $pdf->writeHTMLCell(60, 0,130 , (72 + $distancia),"<p>TOTAL S/. ".$inicial."</p>", 0, 1, 0, true, 'L',  true);
      $pdf->Line(13, (92 + $distancia),70, (92 + $distancia), $style);
      $pdf->writeHTMLCell(60, 0,23 , (94 + $distancia),"<p>NOMBRE DE CLIENTE</p>", 0, 1, 0, true, 'L',  true);
      $pdf->Line(130, (92 + $distancia),190, (92 + $distancia), $style);
      $pdf->writeHTMLCell(60, 0,145 , (94 + $distancia),"<p>POR SEDALIB S.A.</p>", 0, 1, 0, true, 'L',  true);
      $pdf->SetFont('helveticaB', '', 10);
      $pdf->writeHTMLCell(60, 0,15 , (105 + $distancia),"<p>COPIA</p>", 0, 1, 0, true, 'L',  true);
      $pdf->SetFont('helvetica', '', 8);
      $pdf->Line(15, (110 + $distancia),70, (110 + $distancia), $style);
      $pdf->Line(15, (117 + $distancia),70, (117 +  $distancia), $style);
      $pdf->Line(15, (110 + $distancia),15, (117 + $distancia), $style);
      $pdf->Line(70, (110 + $distancia),70, (117 + $distancia), $style);
      $pdf->writeHTMLCell(60, 0,15 , (112 + $distancia),"<p>FORMATO: Duplicado de Recibo de Caja</p>", 0, 1, 0, true, 'L',  true);
      $pdf->SetXY(15 ,(125 + $distancia) );
      $pdf->Write(0, 'DIGITADOR(A): '.$_SESSION['user_nom'], '', 0, 'L', true, 0, false, false, 0);
      return $pdf;
    }
    private function  cabecera_cronograma ($style, $pdf, $suministro,$direccion ,$nombre, $deuda_total, $inicial, $nro_letra, $oficina, $agencia, $Letras, $saldo, $fecha, $interes, $credito,$tipo){
      $pdf->SetFont('helveticaB', '',7);
      $pdf->writeHTMLCell(150, 0,10 , 6 ,"<p>SEDALIB S.A.</p>", 0, 1, 0, true, 'L',  true);
      $pdf->SetFont('helveticaB', '',10);
      $pdf->writeHTMLCell(150, 0,80 , 12 ,"<p>CRONOGRAMA DE PAGOS </p>", 0, 1, 0, true, 'L',  true);
      $pdf->SetFont('helvetica', '',6.5);
      if($tipo==1){
        $pdf->writeHTMLCell(160, 0,150 , 6 ,"<p>Impreso el ".date("d/m/Y H:i:s")."</p>", 0, 1, 0, true, 'L',  true);
      }
      $pdf->SetFont('helveticaB', '',9);
      $pdf->writeHTMLCell(150, 0,80 , 17 ,"<p>Convenio Nro. ".$oficina."-".$agencia."- ".$credito[0]['MAXIMO']." </p>", 0, 1, 0, true, 'L',  true);
      $tbl = '<table cellspacing="0" cellpadding="1" border="1">
              <tr>
                  <td height="15" width="130">Suministro : '.$suministro.' </td>
                  <td height="15" width="250">Nombre : '.$nombre.'</td>
                  <td height="15" width="290">Dirección: '.$direccion.' </td>
              </tr>
            </table>';
      $pdf->SetFont('helvetica', '',7.5);

      $pdf->SetXY(10 ,25);
      $pdf->writeHTML($tbl, true, false, false, false, '');
      $pdf->Line(10, 33 ,199, 33 , $style);
      $pdf->writeHTMLCell(70, 0,15 , 36 ,"<p>Nro. Cuotas : ".$nro_letra." </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 0,15 , 40 ,"<p>Fecha del Credito : ".date("d/m/Y")." </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 0,75 , 36 ,"<p>Deuda Total : ".$deuda_total." </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 0,75 , 40 ,"<p>Monto Inicial : ".$inicial."</p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 0,75 , 44 ,"<p>Capital a Financiar : ".$saldo."</p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 0,140 , 36 ,"<p>Concepto </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 0,140 , 40 ,"<p>Tasa Intereses : ".$interes."</p>", 0, 1, 0, true, 'L',  true);
      $pdf->Line(10, 50 ,199, 50 , $style);
      $pdf->Line(10, 33 ,10, 50 , $style);
      $pdf->Line(199, 33 ,199, 50 , $style);
      $pdf->Line(10, 53 ,199, 53 , $style);
      return $pdf; 
    }

    public function plantilla_cronograma($pdf, $suministro, $direccion, $nombre, $deuda_total, $inicial, $nro_letra, $oficina, $agencia, $Letras , $saldo, $fecha, $interes,$num_cred,$tipo, $nombre_catastral){
      $style = array('width' => 0.20, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
      $pdf = $this -> cabecera_cronograma($style,$pdf, $suministro,$direccion, $nombre_catastral, $deuda_total, $inicial, $nro_letra, $oficina, $agencia, $Letras, $saldo, $fecha, $interes, $num_cred ,$tipo);
      $tbl = '
          <table cellspacing="0" cellpadding="1" border="0">
            <tr>
                <td height="20" width="80" align="center" border="1">Cuota</td>
                <td height="20" width="80" align="center" border="1">Saldo</td>
                <td height="20" width="100" align="center" border="1">Interes compensatorio</td>
                <td height="20" width="100" align="center" border="1">Amortización del Capital</td>
                <td height="20" width="90" align="center" border="1">Importe de la Cuota</td>
                <td height="20" width="90" align="center" border="1">Mes de Facturación</td>
            </tr>
          ';
      $i = 0;
      $cuerpo = '';
      $contador = 0 ;
      $distancia  = 60 ;
      $sum_int_comp = 0;
      $sum_amo_cap = 0;
      $sum_imp_cuota = 0 ;
      while ($i < count($Letras)) {
        if ($contador==35) {
          $cab_tbl = $tbl.$cuerpo.'</table>';
          $pdf->SetFont('helvetica', '',7.5);
          $pdf->SetXY(27 ,57);
          $pdf->writeHTML($cab_tbl, true, false, false, false, '');
          $pdf->SetXY(15 ,290);
          $pdf->Write(0, 'DIGITADOR(A): '.$_SESSION['user_nom'], '', 0, 'L', true, 0, false, false, 0);
          $pdf->AddPage('P', 'A4');
          $pdf = $this -> cabecera_cronograma($style,$pdf, $suministro,$direccion , $nombre_catastral, $deuda_total, $inicial, $nro_letra, $oficina, $agencia, $Letras, $saldo, $fecha , $interes, $num_cred,$tipo);
          $cuerpo = '';
          $contador = 0 ;
          $distancia = 60 ;
        }
        $fecha  = explode("/", $Letras[$i]['Vencimiento']);
        $cuerpo = $cuerpo.'
            <tr>
                <td height="20" width="80" align="center">'.$Letras[$i]['Cuota'].'</td>
                <td height="20" width="80" align="center">'.$Letras[$i]['Saldo'].'</td>
                <td height="20" width="100" align="center">'.$Letras[$i]['Int_comp'].'</td>
                <td height="20" width="100" align="center">'.$Letras[$i]['Amo_cap'].'</td>
                <td height="20" width="90" align="center">'.$Letras[$i]['Imp_cuota'].'</td>
                <td height="20" width="90" align="center">'.$fecha[2].'-'.$fecha[1].'</td>
            </tr>';
        $sum_int_comp = $sum_int_comp + (float)$Letras[$i]['Int_comp'];
        $sum_amo_cap = $sum_amo_cap +  (float)$Letras[$i]['Amo_cap'];
        $sum_imp_cuota = $sum_imp_cuota + (float)$Letras[$i]['Imp_cuota'] ;
        $distancia = $distancia + 6 ;  
        $contador++;         
        $i++;
      }

      $cuerpo = $cuerpo.'
            <tr>
                <td height="20" width="160" align="center" colspan="2" border="1">Montos Finales del convenio</td>
                <td height="20" width="100" align="center" border="1">'.$sum_int_comp.'</td>
                <td height="20" width="100" align="center" border="1">'.$sum_amo_cap.'</td>
                <td height="20" width="90" align="center" border="1">'.$sum_imp_cuota.'</td>
                <td height="20" width="90" align="center" border="1"></td>
            </tr>';
      $cab_tbl = $tbl.$cuerpo.'</table>';
      $pdf->SetFont('helvetica', '',7.5);
      $pdf->SetXY(27 ,57);
      $pdf->writeHTML($cab_tbl, true, false, false, false, '');
      $pdf->SetFont('helveticaB', '',8);
      $distancia = $distancia + 6 ;  
      if( $contador >=33 && $contador <=35){
        $distancia = $distancia - 10;
        $pdf->writeHTMLCell(70, 0,10 , ($distancia + 5),"<p>NOTA: </p>", 0, 1, 0, true, 'L',  true);
        $pdf->SetFont('helvetica', '',7.5);
        $pdf->writeHTMLCell(170, 0,10 , ($distancia + 8),"<p>El Monto por Interes compensatorio no incluye IGV, el cual sera incluido en la facturación respectiva (Ver 'Periodo de Vencimiento') </p>", 0, 1, 0, true, 'L',  true);
        $pdf->Line(10, ($distancia + 20) ,60, ($distancia + 20), $style);
        $pdf->writeHTMLCell(170, 0,13 , ($distancia + 22),"<p>Cliente</p>", 0, 1, 0, true, 'L',  true);
        $pdf->writeHTMLCell(170, 0,13 , ($distancia + 25),"<p>D.N.I.</p>", 0, 1, 0, true, 'L',  true);
        $pdf->SetXY(15 ,290);
        $pdf->Write(0, 'DIGITADOR(A): '.$_SESSION['user_nom'], '', 0, 'L', true, 0, false, false, 0);
      }else{
        $pdf->writeHTMLCell(70, 0,10 , ($distancia + 5),"<p>NOTA: </p>", 0, 1, 0, true, 'L',  true);
        $pdf->SetFont('helvetica', '',7.5);
        $pdf->writeHTMLCell(170, 0,10 , ($distancia + 8),"<p>El Monto por Interes compensatorio no incluye IGV, el cual sera incluido en la facturación respectiva (Ver 'Periodo de Vencimiento') </p>", 0, 1, 0, true, 'L',  true);
        $pdf->Line(10, ($distancia + 25) ,60, ($distancia + 25), $style);
        $pdf->writeHTMLCell(170, 0,13 , ($distancia + 27),"<p>Cliente</p>", 0, 1, 0, true, 'L',  true);
        $pdf->writeHTMLCell(170, 0,13 , ($distancia + 30),"<p>D.N.I.</p>", 0, 1, 0, true, 'L',  true);
        
      }
      
      
      return $pdf; 
    }

    private function  cabecera_proforma ($style, $pdf, $suministro,$direccion ,$nombre, $deuda_total, $inicial, $nro_letra, $oficina, $agencia, $Letras, $saldo, $fecha, $interes){
      $pdf->SetFont('helveticaB', '',7);
      $pdf->writeHTMLCell(150, 0,10 , 6 ,"<p>SEDALIB S.A.</p>", 0, 1, 0, true, 'L',  true);
      $pdf->SetFont('helveticaB', '',10);
      $pdf->writeHTMLCell(150, 0,80 , 12 ,"<p>PROFORMA DE PAGOS </p>", 0, 1, 0, true, 'L',  true);
      $pdf->SetFont('helvetica', '',6.5);
      $pdf->writeHTMLCell(160, 0,150 , 6 ,"<p>Impreso el ".date("d/m/Y H:i:s")."</p>", 0, 1, 0, true, 'L',  true);
      
      $pdf->SetFont('helveticaB', '',9);
      $pdf->writeHTMLCell(150, 0,80 , 17 ,"<p>OFICINA :".$oficina." - AGENCIA : ".$agencia." </p>", 0, 1, 0, true, 'L',  true);
      $tbl = '<table cellspacing="0" cellpadding="1" border="1">
              <tr>
                  <td height="15" width="130">Suministro : '.$suministro.' </td>
                  <td height="15" width="250">Nombre : '.$nombre.'</td>
                  <td height="15" width="290">Dirección: '.$direccion.' </td>
              </tr>
            </table>';
      $pdf->SetFont('helvetica', '',7.5);

      $pdf->SetXY(10 ,25);
      $pdf->writeHTML($tbl, true, false, false, false, '');
      $pdf->Line(10, 33 ,199, 33 , $style);
      $pdf->writeHTMLCell(70, 0,15 , 36 ,"<p>Nro. Cuotas : ".$nro_letra." </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 0,15 , 40 ,"<p>Fecha del Credito : ".date("d/m/Y")." </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 0,75 , 36 ,"<p>Deuda Total : ".$deuda_total." </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 0,75 , 40 ,"<p>Monto Inicial : ".$inicial."</p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 0,75 , 44 ,"<p>Capital a Financiar : ".$saldo."</p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 0,140 , 36 ,"<p>Concepto </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 0,140 , 40 ,"<p>Tasa Intereses : ".$interes."</p>", 0, 1, 0, true, 'L',  true);
      $pdf->Line(10, 50 ,199, 50 , $style);
      $pdf->Line(10, 33 ,10, 50 , $style);
      $pdf->Line(199, 33 ,199, 50 , $style);
      $pdf->Line(10, 53 ,199, 53 , $style);
      return $pdf; 
    }
    public function proforma_cronograma($pdf, $suministro, $direccion, $nombre, $deuda_total, $inicial, $nro_letra, $oficina, $agencia, $Letras , $saldo, $fecha, $interes){
      $style = array('width' => 0.20, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
      $pdf = $this -> cabecera_proforma($style,$pdf, $suministro,$direccion, $nombre, $deuda_total, $inicial, $nro_letra, $oficina, $agencia, $Letras, $saldo, $fecha, $interes);
      $tbl = '
          <table cellspacing="0" cellpadding="1" border="0">
            <tr>
                <td height="20" width="80" align="center" border="1">Cuota</td>
                <td height="20" width="80" align="center" border="1">Saldo</td>
                <td height="20" width="100" align="center" border="1">Interes compensatorio</td>
                <td height="20" width="100" align="center" border="1">Amortización del Capital</td>
                <td height="20" width="90" align="center" border="1">Importe de la Cuota</td>
                <td height="20" width="90" align="center" border="1">Mes de Facturación</td>
            </tr>
          ';
      $i = 0;
      $cuerpo = '';
      $contador = 0 ;
      $distancia  = 60 ;
      $sum_int_comp = 0;
      $sum_amo_cap = 0;
      $sum_imp_cuota = 0 ;
      while ($i < count($Letras)) {
        if ($contador==35) {
          $cab_tbl = $tbl.$cuerpo.'</table>';
          $pdf->SetFont('helvetica', '',7.5);
          $pdf->SetXY(27 ,57);
          $pdf->writeHTML($cab_tbl, true, false, false, false, '');
          $pdf->AddPage('P', 'A4');
          $pdf = $this -> cabecera_proforma($style,$pdf, $suministro,$direccion , $nombre, $deuda_total, $inicial, $nro_letra, $oficina, $agencia, $Letras, $saldo, $fecha , $interes);
          $cuerpo = '';
          $contador = 0 ;
          $distancia = 60 ;
        }
        $fecha  = explode("/", $Letras[$i]['Vencimiento']);
        $cuerpo = $cuerpo.'
            <tr>
                <td height="20" width="80" align="center">'.$Letras[$i]['Cuota'].'</td>
                <td height="20" width="80" align="center">'.$Letras[$i]['Saldo'].'</td>
                <td height="20" width="100" align="center">'.$Letras[$i]['Int_comp'].'</td>
                <td height="20" width="100" align="center">'.$Letras[$i]['Amo_cap'].'</td>
                <td height="20" width="90" align="center">'.$Letras[$i]['Imp_cuota'].'</td>
                <td height="20" width="90" align="center">'.$fecha[2].'-'.$fecha[1].'</td>
            </tr>';
        $sum_int_comp = $sum_int_comp + (float)$Letras[$i]['Int_comp'];
        $sum_amo_cap = $sum_amo_cap +  (float)$Letras[$i]['Amo_cap'];
        $sum_imp_cuota = $sum_imp_cuota + (float)$Letras[$i]['Imp_cuota'] ;
        $distancia = $distancia + 6 ;  
        $contador++;         
        $i++;
      }

      $cuerpo = $cuerpo.'
            <tr>
                <td height="20" width="160" align="center" colspan="2" border="1">Montos Finales del convenio</td>
                <td height="20" width="100" align="center" border="1">'.$sum_int_comp.'</td>
                <td height="20" width="100" align="center" border="1">'.$sum_amo_cap.'</td>
                <td height="20" width="90" align="center" border="1">'.$sum_imp_cuota.'</td>
                <td height="20" width="90" align="center" border="1"></td>
            </tr>';
      $cab_tbl = $tbl.$cuerpo.'</table>';
      $pdf->SetFont('helvetica', '',7.5);
      $pdf->SetXY(27 ,57);
      $pdf->writeHTML($cab_tbl, true, false, false, false, '');
      $pdf->SetFont('helveticaB', '',8);
      $distancia = $distancia + 6 ;  
      if( $contador >=33 && $contador <=35){
        $distancia = $distancia - 10;
        $pdf->writeHTMLCell(70, 0,10 , ($distancia + 5),"<p>NOTA: </p>", 0, 1, 0, true, 'L',  true);
        $pdf->SetFont('helvetica', '',7.5);
        $pdf->writeHTMLCell(170, 0,10 , ($distancia + 8),"<p>El Monto por Interes compensatorio no incluye IGV, el cual sera incluido en la facturación respectiva (Ver 'Periodo de Vencimiento') </p>", 0, 1, 0, true, 'L',  true);
        $pdf->Line(10, ($distancia + 20) ,60, ($distancia + 20), $style);
        $pdf->writeHTMLCell(170, 0,13 , ($distancia + 22),"<p>Cliente</p>", 0, 1, 0, true, 'L',  true);
        $pdf->writeHTMLCell(170, 0,13 , ($distancia + 25),"<p>D.N.I.</p>", 0, 1, 0, true, 'L',  true);
      }else{
        $pdf->writeHTMLCell(70, 0,10 , ($distancia + 5),"<p>NOTA: </p>", 0, 1, 0, true, 'L',  true);
        $pdf->SetFont('helvetica', '',7.5);
        $pdf->writeHTMLCell(170, 0,10 , ($distancia + 8),"<p>El Monto por Interes compensatorio no incluye IGV, el cual sera incluido en la facturación respectiva (Ver 'Periodo de Vencimiento') </p>", 0, 1, 0, true, 'L',  true);
        $pdf->Line(10, ($distancia + 25) ,60, ($distancia + 25), $style);
        $pdf->writeHTMLCell(170, 0,13 , ($distancia + 27),"<p>Cliente</p>", 0, 1, 0, true, 'L',  true);
        $pdf->writeHTMLCell(170, 0,13 , ($distancia + 30),"<p>D.N.I.</p>", 0, 1, 0, true, 'L',  true);
      }
      
      
      return $pdf; 
    }

    public function cabecera_Colateral_cronograma($style, $pdf, $suministro, $nombre, $direccion, $monto, $nro_cuotas, $monto_inicial, $capi_financiar, $concepto, $tasa_interes, $oficina, $agencia, $n_credito){
      $pdf->SetFont('helveticaB', '',7);
      $pdf->writeHTMLCell(150, 0,10 , 6 ,"<p>SEDALIB S.A.</p>", 0, 1, 0, true, 'L',  true);
      $pdf->SetFont('helveticaB', '',10);
      $pdf->writeHTMLCell(120, 0,50 , 12 ,"<p>CRONOGRAMA DE PAGOS - CREDITOS POR SERVICIO  </p>", 0, 1, 0, true, 'L',  true);
      $pdf->SetFont('helvetica', '',6.5);
      $pdf->writeHTMLCell(160, 0,150 , 6 ,"<p>Impreso el ".date("d/m/Y H:i:s")."</p>", 0, 1, 0, true, 'L',  true);
      $pdf->SetFont('helveticaB', '',9);
      $pdf->writeHTMLCell(150, 0,80 , 17 ,"<p>Convenio Nro. ".$oficina."-".$agencia."- ".$n_credito." </p>", 0, 1, 0, true, 'L',  true);
      $tbl = '<table cellspacing="0" cellpadding="1" border="1">
              <tr>
                  <td height="15" width="130">Suministro : '.$suministro.' </td>
                  <td height="15" width="250">Nombre : '.$nombre.'</td>
                  <td height="15" width="290">Dirección: '.$direccion.' </td>
              </tr>
            </table>';
      $pdf->SetFont('helvetica', '',7.5);

      $pdf->SetXY(10 ,25);
      $pdf->writeHTML($tbl, true, false, false, false, '');
      $pdf->Line(10, 33 ,199, 33 , $style);
      $pdf->writeHTMLCell(70, 0,15 , 36 ,"<p>Nro. Cuotas : ".$nro_cuotas." </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 0,15 , 40 ,"<p>Fecha del Credito : ".date("d/m/Y")." </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 0,75 , 36 ,"<p>Deuda Total : ". $monto." </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 0,75 , 40 ,"<p>Monto Inicial : "."0.00"."</p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 0,75 , 44 ,"<p>Capital a Financiar : ".$capi_financiar."</p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 0,140 , 36 ,"<p>Concepto : ".$concepto."</p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 0,140 , 40 ,"<p>Tasa Intereses : ".(float)$tasa_interes."000</p>", 0, 1, 0, true, 'L',  true);
      $pdf->Line(10, 50 ,199, 50 , $style);
      $pdf->Line(10, 33 ,10, 50 , $style);
      $pdf->Line(199, 33 ,199, 50 , $style);
      $pdf->Line(10, 53 ,199, 53 , $style);
      return $pdf; 
    }

    public function colateral_cronograma($pdf, $suministro, $nombre, $direccion, $monto, $nro_cuotas, $monto_inicial, $capi_financiar, $concepto, $tasa_interes, $tabla, $oficina, $agencia, $n_credito){
      $style = array('width' => 0.20, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
      $pdf = $this -> cabecera_Colateral_cronograma($style,$pdf, $suministro, $nombre, $direccion, $monto, $nro_cuotas, $monto_inicial, $capi_financiar, $concepto, $tasa_interes, $oficina, $agencia, $n_credito );
      $tbl = '
          <table cellspacing="0" cellpadding="1" border="0">
            <tr>
                <td height="20" width="80" align="center"  border = "1">Cuota</td>
                <td height="20" width="80" align="center"  border = "1" >Saldo</td>
                <td height="20" width="100" align="center"  border = "1">Interes compensatorio</td>
                <td height="20" width="100" align="center"  border = "1">Amortización del Capital</td>
                <td height="20" width="90" align="center"  border = "1">Importe de la Cuota</td>
                <td height="20" width="90" align="center"  border = "1">Mes de Facturación</td>
            </tr>
          ';
      $i = 0;
      $cuerpo = '';
      $contador = 0 ;
      $distancia  = 60 ;
      $sum_int_comp = 0;
      $sum_amo_cap = 0;
      $sum_imp_cuota = 0 ;
      while ($i < count($tabla) ) {
        if ($contador==35) {
          $cab_tbl = $tbl.$cuerpo.'</table>';
          $pdf->SetFont('helvetica', '',7.5);
          $pdf->SetXY(27 ,57);
          $pdf->writeHTML($cab_tbl, true, false, false, false, '');
          $pdf->AddPage('P', 'A4');
          $pdf = $this -> cabecera_Colateral_cronograma($style,$pdf, $suministro, $nombre, $direccion, $monto, $nro_cuotas, $monto_inicial, $capi_financiar, $concepto, $tasa_interes, $oficina, $agencia, $n_credito);
          $cuerpo = '';
          $contador = 0 ;
          $distancia = 60 ;
        }
        //$fecha  = explode("/", $Letras[$i]['Vencimiento']);
        $cuerpo = $cuerpo.'
            <tr>
                <td height="20" width="80" align="center">'.$tabla[$i][0].'</td>
                <td height="20" width="80" align="center">'.number_format(floatval($tabla[$i][1]), 2, '.', '').'</td>
                <td height="20" width="100" align="center">'.number_format(floatval($tabla[$i][2]), 2, '.', '').'</td>
                <td height="20" width="100" align="center">'.number_format(floatval($tabla[$i][3]), 2, '.', '').'</td>
                <td height="20" width="90" align="center">'.number_format(floatval($tabla[$i][4]), 2, '.', '').'</td>
                <td height="20" width="90" align="center">'.$tabla[$i][5].'</td>
            </tr>';
        $sum_int_comp = $sum_int_comp + (float)$tabla[$i][2];
        $sum_amo_cap = $sum_amo_cap +  (float)$tabla[$i][3];
        $sum_imp_cuota = $sum_imp_cuota + (float)$tabla[$i][4] ;
        $distancia = $distancia + 6 ;  
        $contador++;         
        $i++;
      }

      $cuerpo = $cuerpo.'
            <tr>
                <td height="20" width="160" align="center" colspan="2"  border = "1" >Montos Finales del convenio</td>
                <td height="20" width="100" align="center"  border = "1">'.number_format(floatval($sum_int_comp), 2, '.', '').'</td>
                <td height="20" width="100" align="center"  border = "1">'.number_format(floatval($sum_amo_cap), 2, '.', '').'</td>
                <td height="20" width="90" align="center"  border = "1">'.number_format(floatval($sum_imp_cuota), 2, '.', '').'</td>
                <td height="20" width="90" align="center"  border = "1"></td>
            </tr>';
      $cab_tbl = $tbl.$cuerpo.'</table>';
      $pdf->SetFont('helvetica', '',7.5);
      $pdf->SetXY(27 ,57);
      $pdf->writeHTML($cab_tbl, true, false, false, false, '');
      $pdf->SetFont('helveticaB', '',8);
      $distancia = $distancia + 6 ;  
      if( $contador >=33 && $contador <=35){
        $distancia = $distancia - 10;
        $pdf->SetFont('helvetica', '',7.5);
        $pdf->Line(10, ($distancia + 20) ,60, ($distancia + 20), $style);
        $pdf->writeHTMLCell(170, 0,13 , ($distancia + 22),"<p>Cliente</p>", 0, 1, 0, true, 'L',  true);
        $pdf->writeHTMLCell(170, 0,13 , ($distancia + 25),"<p>D.N.I.</p>", 0, 1, 0, true, 'L',  true);
      }else{
        $pdf->SetFont('helvetica', '',7.5);
        $pdf->Line(10, ($distancia + 25) ,60, ($distancia + 25), $style);
        $pdf->writeHTMLCell(170, 0,13 , ($distancia + 27),"<p>Cliente</p>", 0, 1, 0, true, 'L',  true);
        $pdf->writeHTMLCell(170, 0,13 , ($distancia + 30),"<p>D.N.I.</p>", 0, 1, 0, true, 'L',  true);
      }
       
      return $pdf;
    }

    private function  Repor_cabe_cronograma ($style, $pdf, $suministro,$direccion ,$nombre, $deuda_total, $inicial, $nro_letra, $oficina, $agencia, $Letras, $saldo, $fecha, $interes, $credito,$fech_gen){
      $pdf->SetFont('helveticaB', '',7);
      $pdf->writeHTMLCell(150, 0,10 , 6 ,"<p>SEDALIB S.A.</p>", 0, 1, 0, true, 'L',  true);
      $pdf->SetFont('helveticaB', '',10);
      $pdf->writeHTMLCell(150, 0,80 , 12 ,"<p>CRONOGRAMA DE PAGOS </p>", 0, 1, 0, true, 'L',  true);
      $pdf->SetFont('helvetica', '',6.5);
      $pdf->writeHTMLCell(160, 0,150 , 6 ,"<p>Impreso el ".date("d/m/Y H:i:s")."</p>", 0, 1, 0, true, 'L',  true);
      $pdf->SetFont('helveticaB', '',9);
      $pdf->writeHTMLCell(150, 0,80 , 17 ,"<p>Convenio Nro. ".$oficina."-".$agencia."- ".$credito." </p>", 0, 1, 0, true, 'L',  true);
      $tbl = '<table cellspacing="0" cellpadding="1" border="1">
              <tr>
                  <td height="15" width="130">Suministro : '.$suministro.' </td>
                  <td height="15" width="250">Nombre : '.$nombre.'</td>
                  <td height="15" width="290">Dirección: '.$direccion.' </td>
              </tr>
            </table>';
      $pdf->SetFont('helvetica', '',7.5);
      $pdf->SetXY(10 ,25);
      $pdf->writeHTML($tbl, true, false, false, false, '');
      $pdf->Line(10, 33 ,199, 33 , $style);
      $pdf->writeHTMLCell(70, 0,15 , 36 ,"<p>Nro. Cuotas : ".$nro_letra." </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 0,15 , 40 ,"<p>Fecha del Credito : ".$fech_gen." </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 0,75 , 36 ,"<p>Deuda Total : ".number_format(floatval($deuda_total), 2, '.', '')." </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 0,75 , 40 ,"<p>Monto Inicial : ".number_format(floatval($inicial), 2, '.', '')."</p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 0,75 , 44 ,"<p>Capital a Financiar : ".number_format(floatval($saldo), 2, '.', '')."</p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 0,140 , 36 ,"<p>Concepto </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 0,140 , 40 ,"<p>Tasa Intereses : ".(float)$interes."000</p>", 0, 1, 0, true, 'L',  true);
      $pdf->Line(10, 50 ,199, 50 , $style);
      $pdf->Line(10, 33 ,10, 50 , $style);
      $pdf->Line(199, 33 ,199, 50 , $style);
      $pdf->Line(10, 53 ,199, 53 , $style);
      return $pdf; 
    }

    public function Report_planti_cronograma($pdf, $suministro, $direccion, $nombre, $deuda_total, $inicial, $nro_letra, $oficina, $agencia, $Letras , $saldo, $fecha, $interes, $CuotaFija, $num_cred,$fech_gen, $nombre_catastral){
      $style = array('width' => 0.20, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
      $pdf = $this -> Repor_cabe_cronograma($style,$pdf, $suministro,$direccion,$nombre_catastral, $deuda_total, $inicial, $nro_letra, $oficina, $agencia, $Letras, $saldo, $fecha, $interes, $num_cred,$fech_gen);
      $tbl = '
          <table cellspacing="0" cellpadding="1" border="0">
            <tr>
                <td height="20" width="80" align="center" border = "1">Cuota</td>
                <td height="20" width="80" align="center" border = "1">Saldo</td>
                <td height="20" width="100" align="center" border = "1">Interes compensatorio</td>
                <td height="20" width="100" align="center" border = "1">Amortización del Capital</td>
                <td height="20" width="90" align="center" border = "1">Importe de la Cuota</td>
                <td height="20" width="90" align="center" border = "1">Mes de Facturación</td>
            </tr>
          ';
      $i = 0;
      $cuerpo = '';
      $contador = 0 ;
      $distancia  = 60 ;
      $sum_int_comp = 0;
      $sum_amo_cap = 0;
      $sum_imp_cuota = 0 ;
      while ($i < count($Letras)) {
        if ($contador==35) {
          $cab_tbl = $tbl.$cuerpo.'</table>';
          $pdf->SetFont('helvetica', '',7.5);
          $pdf->SetXY(27 ,57);
          $pdf->writeHTML($cab_tbl, true, false, false, false, '');
          $pdf->AddPage('P', 'A4');
          $pdf = $this -> Repor_cabe_cronograma($style,$pdf, $suministro,$direccion , $nombre_catastral , $deuda_total, $inicial, $nro_letra, $oficina, $agencia, $Letras, $saldo, $fecha , $interes, $num_cred,$fech_gen);
          $cuerpo = '';
          $contador = 0 ;
          $distancia = 60 ;
        }
        $fecha  = explode("/", $Letras[$i]['LTVENCIM']);
        $Inte_Compen =  floatval($Letras[$i]['LTINTER']) + floatval($Letras[$i]['LTCUOTA']);
        $cuerpo = $cuerpo.'
            <tr>
                <td height="20" width="80" align="center">'.$Letras[$i]['LTNUM'].'</td>
                <td height="20" width="80" align="center">'.number_format(floatval($Letras[$i]['LTSALDO']), 2, '.', '').'</td>
                <td height="20" width="100" align="center">'.number_format(floatval($Letras[$i]['LTINTER']), 2, '.', '').'</td>
                <td height="20" width="100" align="center">'.number_format(floatval($Letras[$i]['LTCUOTA']), 2, '.', '').'</td>
                <td height="20" width="90" align="center">'.number_format(floatval($Inte_Compen), 2, '.', '').'</td>
                <td height="20" width="90" align="center">'.$fecha[2].'-'.$fecha[1].'</td>
            </tr>';
        $sum_int_comp = $sum_int_comp + (float)$Letras[$i]['LTINTER'];
        $sum_amo_cap = $sum_amo_cap +  (float)$Letras[$i]['LTCUOTA'];
        $sum_imp_cuota = $sum_imp_cuota + (float)$Inte_Compen;
        $distancia = $distancia + 6 ;  
        $contador++;         
        $i++;
      }

      $cuerpo = $cuerpo.'
            <tr>
                <td height="20" width="160" align="center" colspan="2" border = "1">Montos Finales del convenio</td>
                <td height="20" width="100" align="center" border = "1">'.number_format(floatval($sum_int_comp), 2, '.', '').'</td>
                <td height="20" width="100" align="center" border = "1">'.number_format(floatval($sum_amo_cap), 2, '.', '').'</td>
                <td height="20" width="90" align="center" border = "1">'.number_format(floatval($sum_imp_cuota), 2, '.', '').'</td>
                <td height="20" width="90" align="center" border = "1"></td>
            </tr>';
      $cab_tbl = $tbl.$cuerpo.'</table>';
      $pdf->SetFont('helvetica', '',7.5);
      $pdf->SetXY(27 ,57);
      $pdf->writeHTML($cab_tbl, true, false, false, false, '');
      $pdf->SetFont('helveticaB', '',8);
      $distancia = $distancia + 6 ;  
      if( $contador >=33 && $contador <=35){
        $distancia = $distancia - 10;
        $pdf->writeHTMLCell(70, 0,10 , ($distancia + 5),"<p>NOTA: </p>", 0, 1, 0, true, 'L',  true);
        $pdf->SetFont('helvetica', '',7.5);
        $pdf->writeHTMLCell(170, 0,10 , ($distancia + 8),"<p>El Monto por Interes compensatorio no incluye IGV, el cual sera incluido en la facturación respectiva (Ver 'Periodo de Vencimiento') </p>", 0, 1, 0, true, 'L',  true);
        $pdf->Line(10, ($distancia + 20) ,60, ($distancia + 20), $style);
        $pdf->writeHTMLCell(170, 0,13 , ($distancia + 22),"<p>Cliente</p>", 0, 1, 0, true, 'L',  true);
        $pdf->writeHTMLCell(170, 0,13 , ($distancia + 25),"<p>D.N.I.</p>", 0, 1, 0, true, 'L',  true);
      }else{
        $pdf->writeHTMLCell(70, 0,10 , ($distancia + 5),"<p>NOTA: </p>", 0, 1, 0, true, 'L',  true);
        $pdf->SetFont('helvetica', '',7.5);
        $pdf->writeHTMLCell(170, 0,10 , ($distancia + 8),"<p>El Monto por Interes compensatorio no incluye IGV, el cual sera incluido en la facturación respectiva (Ver 'Periodo de Vencimiento') </p>", 0, 1, 0, true, 'L',  true);
        $pdf->Line(10, ($distancia + 25) ,60, ($distancia + 25), $style);
        $pdf->writeHTMLCell(170, 0,13 , ($distancia + 27),"<p>Cliente</p>", 0, 1, 0, true, 'L',  true);
        $pdf->writeHTMLCell(170, 0,13 , ($distancia + 30),"<p>D.N.I.</p>", 0, 1, 0, true, 'L',  true);
      }
      
      
      return $pdf; 
    }

    private function  cabecera_recibo($style,$pdf,$sum_recibo , $direccion_cliente ,$nombre_cliente, $tabla , $fi_deuda_total, $Cal_inicial, $Cal_nro_cuota, $Cal_vencimiento, $oficina, $agencia, $num_cred){

      $pdf->SetFont('helveticaB', '',11.5);
      $pdf->writeHTMLCell(150, 0,30 , 18 ,"<p>Detalle de Recibos de Constituyen el Convenio de Financiamiento de Deuda</p>", 0, 1, 0, true, 'L',  true);
      $pdf->SetFont('helvetica', '',6.5);
      $pdf->writeHTMLCell(70, 0,150 , 8 ,"<p>Impreso el : ".date('d/m/Y  h:i:s A')."</p>", 0, 1, 0, true, 'L',  true);
      $pdf->SetFont('helvetica', '',7.5);
      $pdf->writeHTMLCell(50, 0,150 , 11 ,"<p>Pag.Nro.".$pdf->getAliasNumPage()."</p>", 0, 1, 0, true, 'L',  true);
      $pdf->SetFont('helveticaB', '',11.5);
      $pdf->writeHTMLCell(150, 0,70 , 24 ,"<p>CREDITO NUMERO ".$oficina." - ".$agencia." - ".$num_cred[0]["MAXIMO"]." </p>", 0, 1, 0, true, 'L',  true);
      $pdf->Line(17, 37 ,190, 37 , $style);
      $pdf->Line(17, 62 ,190, 62 , $style);
      $pdf->Line(17, 37 ,17, 62 , $style);
      $pdf->Line(190, 37 ,190, 62, $style);
      $pdf->SetFont('helveticaB', '',9);
      $pdf->writeHTMLCell(100, 0,20 , 40 ,"<p>Suministro: ".$sum_recibo."</p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(100, 0,20 , 45 ,"<p>Nombre: ".$nombre_cliente."</p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(170, 0,20 , 50 ,"<p>Dirección: ".$direccion_cliente."</p>", 0, 1, 0, true, 'L',  true);
      $pdf->SetFont('helvetica', '',8);
      $pdf->writeHTMLCell(100, 0,17 , 68 ,"<p>Convenio de financiamiento de Deuda establecido el dia ".date('d/m/Y ')."</p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(150, 0,17 , 72 ,"<p>Regularizando una Deuda Total de S/ ".$fi_deuda_total.", antes del calculo de intereses de Financiamiento</p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(150, 0,17 , 76 ,"<p>Se dio la suma de S/ ".$Cal_inicial." como Pago Inicial, pactandose el pago del salgo en ".$Cal_nro_cuota." cuotas. </p>", 0, 1, 0, true, 'L',  true);

      return $pdf;
    }

    public function plantilla_recibos($pdf,$sum_recibo , $direccion_cliente ,$nombre_cliente, $tabla , $fi_deuda_total, $Cal_inicial, $Cal_nro_cuota, $Cal_vencimiento, $oficina, $agencia, $num_cred, $int_mora, $gast_cobra, $nombre_catastral ){
      $style = array('width' => 0.20, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
      $pdf = $this -> cabecera_recibo($style,$pdf,$sum_recibo , $direccion_cliente ,$nombre_catastral, $tabla , $fi_deuda_total, $Cal_inicial, $Cal_nro_cuota, $Cal_vencimiento, $oficina, $agencia, $num_cred);
      
      $can_tbl = '
          <table cellspacing="0" cellpadding="1" border="0">
            <tr>
                <td height="20" width="100" align="center" border = "1">Emision</td>
                <td height="20" width="50" align="center" border = "1">Serie</td>
                <td height="20" width="70" align="center" border = "1">Nro</td>
                <td height="20" width="190" align="center" border = "1">Descripcion</td>
                <td height="20" width="100" align="center" border = "1">Monto</td>
                <td height="20" width="100" align="center" border = "1">Descuento</td>
            </tr>
          ';
      $tama = count($tabla);
      $distancia = 87;
      if (count($tabla)>0) {
          $tabla[$tama]['Emision'] = date('d/m/Y');
          $tabla[$tama]['Serie'] = 0;
          $tabla[$tama]['Numero'] = 900;
          $tabla[$tama]['Descri'] = "INTERESES MORATORIOS" ;
          $tabla[$tama]['Total'] = number_format(floatval($int_mora), 2, '.', ''); 
          $tabla[$tama]['Not_cre'] = 0;
          $tabla[$tama+1]['Emision'] = date('d/m/Y');
          $tabla[$tama+1]['Serie'] = 0;
          $tabla[$tama+1]['Numero'] = 902;
          $tabla[$tama+1]['Descri'] = "GASTOS DE COBRANZA";
          $tabla[$tama+1]['Total'] = number_format(floatval($gast_cobra ), 2, '.', ''); 
          $tabla[$tama+1]['Not_cre'] = 0 ;
          $i = 0;
          $cuerpo_tbl = '';
          $tbl = '';
          $contador = 0;
          $distancia = 87 ; 
          $suma_monto = 0;
          $suma_monto_cap = 0;
          $suma_cred = 0;
          while ($i < count($tabla)) {
            if ($contador == 39) {
              $cuerpo_tbl = $can_tbl.$tbl.'</table>';
              $pdf->SetXY(17 ,85);
              $pdf->writeHTML($cuerpo_tbl, true, false, false, false, '');
              $pdf->SetXY(15 ,285);
              $pdf->Write(0, 'DIGITADOR(A): '.$_SESSION['user_nom'], '', 0, 'L', true, 0, false, false, 0);
              $pdf->AddPage('P', 'A4');
              $pdf = $this -> cabecera_recibo($style,$pdf,$sum_recibo , $direccion_cliente ,$nombre_catastral, $tabla , $fi_deuda_total, $Cal_inicial, $Cal_nro_cuota, $Cal_vencimiento, $oficina, $agencia, $num_cred);
              $tbl = '';
              $contador = 0 ;
              $distancia = 87;
            }
            $not_cre= $tabla[$i]['Not_cre'] != 0 ? $tabla[$i]['Not_cre'] : '';
            $descri = isset($tabla[$i]['Descri']) ? $tabla[$i]['Descri'] :'RECIBO';
            $tbl = $tbl. '
                <tr>
                    <td height="16" width="100" align="center" >'.$tabla[$i]['Emision'].'</td>
                    <td height="16" width="50" align="center" >'.$tabla[$i]['Serie'].'</td>
                    <td height="16" width="70" align="center" >'.$tabla[$i]['Numero'].'</td>
                    <td height="16" width="190" align="center" >'.$descri.'</td>
                    <td height="16" width="100" align="center" align="right">'.number_format(floatval($tabla[$i]['Total']), 2, '.', '').'</td>
                    <td height="16" width="100" align="center" align="right" >'.$not_cre  .'</td>
                </tr>
            ';
            if($descri == 'RECIBO'){
              $suma_monto_cap = $suma_monto_cap + $tabla[$i]['Total'] ;
            }
            $suma_monto =  $suma_monto + $tabla[$i]['Total'];
            $suma_cred = $tabla[$i]['Not_cre'] + $suma_cred ; 
            $distancia = $distancia +4.5;
            $contador++;
            $i++;
          }
          $cuerpo_tbl = $can_tbl.$tbl.'
                <tr>
                    <td height="20" width="220" align="center" border = "1" rowspan="2" >TOTAL DEUDA CAPITAL = '.number_format(floatval($suma_monto_cap ), 2, '.', '').'</td>
                    <td height="20" width="290" align="center" border = "1" align="right">TOTAL DEUDA = '.number_format(floatval($suma_monto ), 2, '.', '').'</td>
                    <td height="20" width="100" align="center" border = "1" align="right" >'.$suma_cred.'</td>
                </tr>
          </table>';
          $pdf->SetXY(17 ,85);
          $pdf->writeHTML($cuerpo_tbl, true, false, false, false, '');
      }  
      $pdf->Line(17, ($distancia+22) ,70,($distancia+22) , $style);
      $pdf->Line(120, ($distancia+22) ,180,($distancia+22) , $style);
      $pdf->writeHTMLCell(60, 0,30 , ($distancia+23) ,"<p>POR SEDALIB S.A.</p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(60, 0,135 , ($distancia+23) ,"<p>POR EL CLIENTE</p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(60, 0,135 , ($distancia+26) ,"<p>D.N.I.</p>", 0, 1, 0, true, 'L',  true);
      if($contador<39){
        $pdf->SetXY(15 ,285);
        $pdf->Write(0, 'DIGITADOR(A): '.$_SESSION['user_nom'], '', 0, 'L', true, 0, false, false, 0);
      }
      return $pdf;
    }

    private function  Repo_cabecera_recibo($style,$pdf,$sum_recibo , $direccion_cliente ,$nombre_cliente, $tabla , $fi_deuda_total, $Cal_inicial, $Cal_nro_cuota, $Cal_vencimiento, $oficina, $agencia, $num_cred){
        $pdf->SetFont('helveticaB', '',11.5);
        $pdf->writeHTMLCell(150, 0,30 , 18 ,"<p>Detalle de Recibos de Constituyen el Convenio de Financiamiento de Deuda</p>", 0, 1, 0, true, 'L',  true);
        $pdf->SetFont('helvetica', '',6.5);
        $pdf->writeHTMLCell(70, 0,150 , 8 ,"<p>Impreso el : ".date('d/m/Y  h:i:s A')."</p>", 0, 1, 0, true, 'L',  true);
        $pdf->SetFont('helvetica', '',7.5);
        $pdf->writeHTMLCell(50, 0,150 , 11 ,"<p>Pag.Nro.".$pdf->getAliasNumPage()."</p>", 0, 1, 0, true, 'L',  true);
        $pdf->SetFont('helveticaB', '',11.5);
        $pdf->writeHTMLCell(150, 0,70 , 24 ,"<p>CREDITO NUMERO ".$oficina." - ".$agencia." - ".$num_cred." </p>", 0, 1, 0, true, 'L',  true);
        $pdf->Line(17, 37 ,190, 37 , $style);
        $pdf->Line(17, 62 ,190, 62 , $style);
        $pdf->Line(17, 37 ,17, 62 , $style);
        $pdf->Line(190, 37 ,190, 62, $style);
        $pdf->SetFont('helveticaB', '',9);
        $pdf->writeHTMLCell(100, 0,20 , 40 ,"<p>Suministro: ".$sum_recibo."</p>", 0, 1, 0, true, 'L',  true);
        $pdf->writeHTMLCell(100, 0,20 , 45 ,"<p>Nombre: ".$nombre_cliente."</p>", 0, 1, 0, true, 'L',  true);
        $pdf->writeHTMLCell(170, 0,20 , 50 ,"<p>Dirección: ".$direccion_cliente."</p>", 0, 1, 0, true, 'L',  true);
        $pdf->SetFont('helvetica', '',8);
        $pdf->writeHTMLCell(100, 0,17 , 68 ,"<p>Convenio de financiamiento de Deuda establecido el dia ".date('d/m/Y ')."</p>", 0, 1, 0, true, 'L',  true);
        $pdf->writeHTMLCell(150, 0,17 , 72 ,"<p>Regularizando una Deuda Total de S/. ".$fi_deuda_total.", antes del calculo de intereses de Financiamiento</p>", 0, 1, 0, true, 'L',  true);
        $pdf->writeHTMLCell(150, 0,17 , 76 ,"<p>Se dio la suma de S/. ".$Cal_inicial." como Pago Inicial, pactandose el pago del salgo en ".$Cal_nro_cuota." cuotas. </p>", 0, 1, 0, true, 'L',  true);

        return $pdf;
    }

    public function Repo_plantilla_recibos($pdf, $sum_recibo, $direccion_cliente, $nombre_cliente, $tabla, $fi_deuda_total, $Cal_inicial, $Cal_nro_cuota, $Cal_vencimiento, $oficina, $agencia, $num_cred, $int_mora, $gast_cobra, $nombre_catastral){
      $style = array('width' => 0.20, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
      $pdf = $this -> Repo_cabecera_recibo($style,$pdf,$sum_recibo , $direccion_cliente ,$nombre_catastral, $tabla , $fi_deuda_total, $Cal_inicial, $Cal_nro_cuota, $Cal_vencimiento, $oficina, $agencia, $num_cred);
      
      $can_tbl = '
          <table cellspacing="0" cellpadding="1" border="0">
            <tr>
                <td height="20" width="100" align="center" border = "1">Emision</td>
                <td height="20" width="50" align="center" border = "1">Serie</td>
                <td height="20" width="70" align="center" border = "1">Nro</td>
                <td height="20" width="190" align="center" border = "1">Descripcion</td>
                <td height="20" width="100" align="center" border = "1">Monto</td>
                <td height="20" width="100" align="center" border = "1">Descuento</td>
            </tr>
          ';
      $tama = count($tabla);
      $distancia = 87;
      if (count($tabla)>0) {
          $tabla[$tama]['FACEMIFEC'] = $Cal_vencimiento;
          $tabla[$tama]['FACSERNRO'] = 0;
          $tabla[$tama]['FACNRO'] = 900;
          $tabla[$tama]['Descri'] = "INTERESES MORATORIOS" ;
          $tabla[$tama]['FACTOTAL'] =number_format(floatval($int_mora), 2, '.', '') ; 
          $tabla[$tama]['NCA'] = 0;
          $tabla[$tama+1]['FACEMIFEC'] = $Cal_vencimiento;
          $tabla[$tama+1]['FACSERNRO'] = 0;
          $tabla[$tama+1]['FACNRO'] = 902;
          $tabla[$tama+1]['Descri'] = "GASTOS DE COBRANZA";
          $tabla[$tama+1]['FACTOTAL'] = number_format(floatval($gast_cobra), 2, '.', '')  ; 
          $tabla[$tama+1]['NCA'] = 0 ;
          $i = 0;
          $cuerpo_tbl = '';
          $tbl = '';
          $contador = 0;
          $distancia = 87 ; 
          $suma_monto = 0;
          $suma_monto_cap = 0;
          $suma_cred = 0;
          while ($i < count($tabla)) {
            if ($contador == 39) {
              $cuerpo_tbl = $can_tbl.$tbl.'</table>';
              $pdf->SetXY(17 ,85);
              $pdf->writeHTML($cuerpo_tbl, true, false, false, false, '');
              $pdf->AddPage('P', 'A4');
              $pdf = $this -> Repo_cabecera_recibo($style,$pdf,$sum_recibo , $direccion_cliente ,$nombre_catastral, $tabla , $fi_deuda_total, $Cal_inicial, $Cal_nro_cuota, $Cal_vencimiento, $oficina, $agencia, $num_cred);
              $tbl = '';
              $contador = 0 ;
              $distancia = 87;
            }
            
            $not_cre= $tabla[$i]['NCA'] != 0 ? $tabla[$i]['NCA'] : '';
            $descri = isset($tabla[$i]['Descri']) ? $tabla[$i]['Descri'] :'RECIBO';
            $tbl = $tbl. '
                <tr>
                    <td height="16" width="100" align="center" >'.$tabla[$i]['FACEMIFEC'].'</td>
                    <td height="16" width="50" align="center" >'.$tabla[$i]['FACSERNRO'].'</td>
                    <td height="16" width="70" align="center" >'.$tabla[$i]['FACNRO'].'</td>
                    <td height="16" width="190" align="center" >'.$descri.'</td>
                    <td height="16" width="100" align="center" align="right">'.number_format(floatval($tabla[$i]['FACTOTAL']), 2, '.', '').'</td>
                    <td height="16" width="100" align="center" align="right" >'.$not_cre  .'</td>
                </tr>
            ';
            if($descri == 'RECIBO'){
              $suma_monto_cap = $suma_monto_cap + $tabla[$i]['FACTOTAL'] ;
            }
            $suma_monto =  $suma_monto + $tabla[$i]['FACTOTAL'];
            $suma_cred = $tabla[$i]['NCA'] + $suma_cred ; 
            $distancia = $distancia +4.5;
            $contador++;
            $i++;
          }
          $cuerpo_tbl = $can_tbl.$tbl.'
                <tr>
                    <td height="20" width="220" align="center" border = "1" rowspan="2" >TOTAL DEUDA CAPITAL = '.$suma_monto_cap.'</td>
                    <td height="20" width="290" align="center" border = "1" align="right">TOTAL DEUDA = '.$suma_monto.'</td>
                    <td height="20" width="100" align="center" border = "1" align="right" >'.$suma_cred.'</td>
                </tr>
          </table>';
          $pdf->SetXY(17 ,85);
          $pdf->writeHTML($cuerpo_tbl, true, false, false, false, '');
      }  
      $pdf->Line(17, ($distancia+22) ,70,($distancia+22) , $style);
      $pdf->Line(120, ($distancia+22) ,180,($distancia+22) , $style);
      $pdf->writeHTMLCell(60, 0,30 , ($distancia+23) ,"<p>POR SEDALIB S.A.</p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(60, 0,135 , ($distancia+23) ,"<p>POR EL CLIENTE</p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(60, 0,135 , ($distancia+26) ,"<p>D.N.I.</p>", 0, 1, 0, true, 'L',  true);
      return $pdf;
    }
    
    public function plantilla_reporte_atipico($pdf,$num_atipicos,$titulo, $nombre, $suministro, $direccion){
      $pdf->SetFont('helveticaB', '',11.5);
      $i = 0;
      while ($i< count($num_atipicos)) {
        $num_atipicos[$i] = str_replace(' ', '%20', $num_atipicos[$i]);
       $pdf->Image( base_url()."img/logo4.jpg", 5, 5, 45, 15, '', '', '', false, 300, '', false, false, 0);
        $pdf->SetFont('helveticaB', '',13);
        $pdf->writeHTMLCell(150, 5, 50, 20 ,"<p>".$titulo."</p>", 0, 1, 0, true, 'L',  true);
        $pdf->SetFont('helvetica', '',10);
        $pdf->writeHTMLCell(170, 5, 10, 27 ,"<p><strong>SUMINISTRO :</strong> ".$suministro."</p>", 0, 1, 0, true, 'L',  true);
        $pdf->writeHTMLCell(170, 5, 10, 32 ,"<p><strong>NOMBRE :</strong> ".$nombre."</p>", 0, 1, 0, true, 'L',  true);
        $pdf->writeHTMLCell(170, 5, 10, 37 ,"<p><strong>DIRECCIÓN :</strong> ".$direccion."</p>", 0, 1, 0, true, 'L',  true);
        $pdf->Image( $num_atipicos[$i], 10, 45, 190, 235, '', '', '', false, 300, '', false, false, 0);
        $pdf->writeHTMLCell(70, 5, 100, 285 ,"<p>PÁGINA ".($i+1)."</p>", 0, 1, 0, true, 'L',  true);
        $pdf->SetFont('helvetica', '',7);
        $pdf->writeHTMLCell(70, 5, 10, 285 ,"<p>Impreso el  ".date("Y-m-d H:i:s a")."</p>", 0, 1, 0, true, 'L',  true);
        if(($i+1) != count($num_atipicos) ){
          $pdf->AddPage('P', 'A4');
        }
        $i++;
      }
      return $pdf;
    }

    private function cabecera_repo_financiamiento($pdf, $style){
      $pdf->Image( base_url()."img/logo4.jpg", 5, 3, 50, 15, '', '', '', false, 300, '', false, false, 0);
      $pdf->SetFont('helveticaB', '',10);
      $pdf->writeHTMLCell(120, 0,120 , 12 ,"<p>REPORTE DE FINANCIAMIENTO </p>", 0, 1, 0, true, 'L',  true);
      $pdf->SetFont('helveticaB', '',6.5);
      $pdf->writeHTMLCell(160, 0,240 , 6 ,"<p>Impreso el ".date("d/m/Y H:i:s")."</p>", 0, 1, 0, true, 'L',  true);
      $pdf->SetFont('helveticaB', '',8);
      $pdf->writeHTMLCell(160, 0,240 , 10 ,"<p>Página ".$pdf->getAliasNumPage()." de ".$pdf->getAliasNbPages()."</p>", 0, 1, 0, true, 'L',  true);
      return $pdf;
    }
    public function plantilla_repo_financiamiento($pdf, $tabla){
      $style = array('width' => 0.20, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
      $pdf = $this -> cabecera_repo_financiamiento($pdf, $style);
      $tbl = '
          <table cellspacing="0" cellpadding="1" border="0">
            <tr>
                <td height="20" width="30" align="center" border = "1">N°</td>
                <td height="20" width="60" align="center" border = "1">FECHA</td>
                <td height="20" width="70" align="center" border = "1">CODIGO SUMINISTRO</td>
                <td height="20" width="240" align="center" border = "1">TITULAR</td>
                <td height="20" width="90" align="center" border = "1"> N° DE CONVENIO</td>
                <td height="20" width="70" align="center" border = "1">DEUDA TOTAL</td>
                <td height="20" width="60" align="center" border = "1">INICIAL</td>
                <td height="20" width="70" align="center" border = "1">SALDO</td>
                <td height="20" width="30" align="center" border = "1"> TIPO</td>
                <td height="20" width="50" align="center" border = "1" style="font-size:7px"> CONCEPTO</td>
                <td height="20" width="50" align="center" border = "1"> N° DE CUOTAS </td>
                <td height="20" width="30" align="center" border = "1" style="font-size:6px">ESTADO</td>
                <td height="20" width="160" align="center" border = "1"> EJECUTOR</td>
            </tr>
          ';
        $i = 0;
        $contador = 0;
        $cuerpo = '';
        $sum_deuda_total = 0;
        $sum_inicial = 0;
        $sum_saldo = 0;
        while ( $i < (int)$tabla['length'] ) {
          if ($contador==30) {
            $cab_tbl = $tbl.$cuerpo.'</table>';
            $pdf->SetFont('helvetica', '',6);
            $pdf->SetXY(7 ,20);
            $pdf->writeHTML($cab_tbl, true, false, false, false, '');
            $pdf->AddPage('L', 'A4');
            $pdf = $this -> cabecera_repo_financiamiento($pdf, $style);
            $cuerpo = '';
            $contador = 0 ;
          }
          $cuerpo = $cuerpo.'
            <tr>
                <td height="20" width="30" align="center" border = "1">'.$tabla[$i][0].'</td>
                <td height="20" width="60" align="center" border = "1">'.$tabla[$i][1].'</td>
                <td height="20" width="70" align="left" border = "1">'.$tabla[$i][2].'</td>
                <td height="20" width="240" align="left" border = "1">'.substr($tabla[$i][3], 0, 42).'</td>
                <td height="20" width="90" align="center" border = "1">'.$tabla[$i][4].'</td>
                <td height="20" width="70" align="right" border = "1">'.$tabla[$i][5].'</td>
                <td height="20" width="60" align="right" border = "1">'.$tabla[$i][6].'</td>
                <td height="20" width="70" align="right" border = "1">'.$tabla[$i][7].'</td>
                <td height="20" width="30" align="center" border = "1">'.$tabla[$i][8].'</td>
                <td height="20" width="50" align="center" border = "1">'.$tabla[$i][9].'</td>
                <td height="20" width="50" align="center" border = "1">'.$tabla[$i][10].'</td>
                <td height="20" width="30" align="center" border = "1">'.$tabla[$i][11].'</td>
                <td height="20" width="160" align="left" border = "1">'.$tabla[$i][12].'</td>
            </tr>';
          $sum_deuda_total =$sum_deuda_total +  (float)$tabla[$i][5];
          $sum_inicial = $sum_inicial +  (float)$tabla[$i][6];
          $sum_saldo = $sum_saldo + (float)$tabla[$i][7];
          $contador++;
          $i++;
        }

        if($contador<=30){
          $cab_tbl = $tbl.$cuerpo.'<tr>
          <td height="20" colspan="5" width="490" align="center" border = "1">TOTAL</td>
          <td height="20" width="70" align="right" border = "1">'.$sum_deuda_total.'</td>
          <td height="20" width="60" align="right" border = "1">'.$sum_inicial.'</td>
          <td height="20" width="70" align="right" border = "1">'.$sum_saldo.'</td>
          </tr> </table>';
          $pdf->SetFont('helvetica', '',6.5);
          $pdf->SetXY(7 ,20);
          $pdf->writeHTML($cab_tbl, true, false, false, false, '');
        }
      
      return $pdf;
    }

    public function plantilla_reporte_re_lectura($pdf,$respuesta,$periodo, $anio , $nom_perido, $datos){
      $style = array('width' => 0.20, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
      $date = new DateTime($datos[0]['RlecFchRgMov']);
      $pdf->Image( base_url()."img/logo4.jpg", 5, 5, 45, 12, '', '', '', false, 300, '', false, false, 0);
      $pdf->SetFont('helveticaB', '',9);
      $pdf->writeHTMLCell(170, 5, 140, 10 ,"<p>FECHA DE RELECTURA : ".$date->format('d-m-Y')."</p>", 0, 1, 0, true, 'L',  true);
      $pdf->SetFont('helveticaBI', '',8);
      $pdf->writeHTMLCell(70, 5, 5, 30 ,"CLIENTE SOLICITADO</p>", 0, 1, 0, true, 'L',  true);
      $pdf->SetFont('helveticaB', '',8);
      $pdf->writeHTMLCell(70, 5, 7, 35 ,"<p>SUMINISTRO : ".$datos[0]['RlecCodFc']."</p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(60, 5, 140, 35 ,"<p>CICLO : ".$datos[0]['RlecCicCod']."</p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(170, 5, 7, 40 ,"<p>NOMBRE : ".$datos[0]['RlecNom']."</p>", 0, 1, 0, true, 'L',  true);
      $pdf->Line(5, 34 ,204, 34 , $style);
      $pdf->Line(5, 34 ,5, 47 , $style);
      $pdf->Line(5, 47 ,204, 47 , $style);
      $pdf->Line(204, 47 ,204, 34, $style);
      $pdf->SetFont('helveticaB', '',13);
      $pdf->writeHTMLCell(170, 5, 30, 20 ,"<p>RELECTURA DE MEDIDORES DE AGUA-FACTURACIÓN ".$nom_perido." ".$anio."</p>", 0, 1, 0, true, 'L',  true);
      $pdf->SetFont('helvetica', '',5.5);
      $can_tbl = '
          <table cellspacing="0" cellpadding="1" border="1">
            <tr>
                <td height="20" width="70" align="center" >SUMINISTRO</td>
                <td height="20" width="200" align="center" >NOMBRE</td>
                <td height="20" width="160" align="center" >URBANIZACIÓN</td>
                <td height="20" width="100" align="center">CALLE</td>
                <td height="20" width="50" align="center" >NUMERO</td>
                <td height="20" width="50" align="center" >MEDIDOR</td>
                <td height="20" width="50" align="center" >LECTURA</td>
                <td height="20" width="30" align="center" >OBS</td>
            </tr>
          ';
      $i = 0;
      $tbl='';
      while(count($respuesta)>$i){
        if($datos[0]['RlecId'] != $respuesta[$i]['RlecId'] ){
            $tbl = $tbl .'<tr>
                  <td  width="70" align="center" >'.$respuesta[$i]['RlecCodFc'].'</td>
                  <td width="200" align="left" >'.$respuesta[$i]['RlecNom'].'</td>
                  <td  width="160" align="left" >'.$respuesta[$i]['RlecUrb'].'</td>
                  <td  width="100" align="left">'.$respuesta[$i]['RlecCal'].'</td>
                  <td  width="50" align="center" >'.$respuesta[$i]['RlecMun'].'</td>
                  <td  width="50" align="center" >'.$respuesta[$i]['RlecMed'].'</td>
                  <td  width="50" align="center" >'.$respuesta[$i]['RlecVal'].'</td>
                  <td  width="30" align="center" >'.$respuesta[$i]['observacion'].'</td>
                  
              </tr>';
        }else{
          $tbl = $tbl .'<tr>
                  <td  width="70" align="center" bgcolor="#FFFF00" >'.$respuesta[$i]['RlecCodFc'].'</td>
                  <td width="200" align="left" bgcolor="#FFFF00" >'.$respuesta[$i]['RlecNom'].'</td>
                  <td  width="160" align="left" bgcolor="#FFFF00" >'.$respuesta[$i]['RlecUrb'].'</td>
                  <td  width="100" align="left" bgcolor="#FFFF00">'.$respuesta[$i]['RlecCal'].'</td>
                  <td  width="50" align="center" bgcolor="#FFFF00" >'.$respuesta[$i]['RlecMun'].'</td>
                  <td  width="50" align="center" bgcolor="#FFFF00" >'.$respuesta[$i]['RlecMed'].'</td>
                  <td  width="50" align="center" bgcolor="#FFFF00" >'.$respuesta[$i]['RlecVal'].'</td>
                  <td  width="30" align="center" bgcolor="#FFFF00" >'.$respuesta[$i]['observacion'].'</td>
              </tr>';
        }
         
        $i++;
      }
      $tabla = $can_tbl.$tbl."</table>";
      $pdf->SetXY(5 ,50);
      $pdf->writeHTML($tabla, true, false, false, false, '');
      return $pdf;
    }


    public function cargo_plantilla_doble1($pdf,$dato_general, $dato_detalle, $distancia, $nombre_codi_barra, $nombre_grafi_barra, $fondo,$tipo_imagen, $cadena_aleatoria){
      //TIPO DOCUMENTO 
      $doc_identificacion = "";
      if(trim($dato_general['CLIRUC']) != ""){
        $doc_identificacion = trim($dato_general['CLIRUC']);
      }else{
        if(trim($dato_general['CLIELECT']) != ""){
          $doc_identificacion = "D.N.I. ".trim($dato_general['CLIELECT']);
        }
      }
      if($fondo == 1){
        $pdf->Image(base_url().'frontend/recibo/RECIBO_copia11.png', (5+ $distancia), 5, 136, 195, '', '', '', false, 300, '', false, false, 0);
      }
      
      //CONSUMO 
      if(trim($dato_general['TIPIMP']) != "P" && trim($dato_general['TIPIMP'])!= "A"){
        if ($dato_general['CONSUMO'] != 0 ) {
          $consumo = str_pad($dato_general['CONSUMO'],8, "0", STR_PAD_LEFT); 
        }else{
          $consumo="";
        } 
      }else{
        $consumo = 0 ;
      }
      $consumo = $consumo ." ". trim($dato_general['DESCRIREG']);
      //ruta cabecera 
      $pdf->SetXY((70+$distancia),7); 
      $pdf->SetFont('helveticaB', '', 5);
      $pdf->Write(0, 'RUTA :', '', 0, 'L', true, 0, false, false, 0);
      $pdf->SetXY((72 + $distancia),10); 
      $pdf->Write(0, $dato_general['CARGARD']." "."-"." ".$dato_general['ORDENRD'], '', 0, 'L', true, 0, false, false, 0);
      // RECIBO , CODIGO --> CABECERA 
      $pdf->SetXY((85+$distancia),7); 
      $pdf->SetFont('helvetica', '', 9);
      $pdf->Write(0, 'RECIBO : ', '', 0, 'L', true, 0, false, false, 0);
      $pdf->SetXY((85 +$distancia),12); 
      $pdf->Write(0, 'CODIGO : ', '', 0, 'L', true, 0, false, false, 0);
      $pdf->SetFont('helveticaB', '', 9);
      /* VERIFICO LAS FECHAS */
      $fecha_emi=$dato_general['FACEMIFEC'];
      $fecha_comparo = '01/02/2020';
      $fecha_e = strtotime($fecha_emi);
      $fecha_c = strtotime($fecha_comparo);
      $electro = '';
      if ($fecha_e >= $fecha_c) {
        $electro = 'S';
      }
      $pdf->SetXY((101+ $distancia),7);  
      $pdf->Write(0, $electro.$dato_general['FACSERNRO']."-".$dato_general['FACNRO']."-".$dato_general['FACCHEDIG'], '', 0, 'L', true, 0, false, false, 0);
      //CODIGO CABECERA
      
      $pdf->SetXY((101+ $distancia),12); 
      $pdf->Write(0, $dato_general['CLICODFAX'], '', 0, 'L', true, 0, false, false, 0);
      $pdf->SetXY((113+ $distancia),19); 
      $pdf->Write(0, trim(strtoupper($dato_general['DESMES'])), '', 0, 'L', true, 0, false, false, 0);
      $pdf->SetXY( (113 + $distancia),23); 
      $pdf->Write(0, $dato_general['FACEMIFEC'], '', 0, 'L', true, 0, false, false, 0);
      //FECHA DE FACTURACION 
      $pdf->SetXY((84+$distancia),19); 
      $pdf->SetFont('helvetica', '', 8);
      $pdf->Write(0, 'FACTURACION DE : ', '', 0, 'L', true, 0, false, false, 0);
      //FECHA DE EMISION 
      $pdf->SetXY((84 + $distancia),23); 
      $pdf->Write(0, 'FECHA DE EMISION : ', '', 0, 'L', true, 0, false, false, 0);
      //CICLO
      $pdf->SetXY( (86 + $distancia),30.5); 
      $pdf->SetFont('helvetica', '', 5.5);
      $pdf->Write(0, 'CICLO : ', '', 0, 'L', true, 0, false, false, 0);
      $pdf->SetXY( (95 + $distancia),30.5); 
      $pdf->SetFont('helveticaB', '', 5.5);
      $pdf->Write(0, $dato_general['FCICLO'], '', 0, 'L', true, 0, false, false, 0);
      //DETALLE DE LA CABECERA 
      $pdf->SetXY((7 + $distancia),25); 
      $pdf->SetFont('helveticaB', '', 8);
      $pdf->Write(0,trim($dato_general['CLINOMBRE']), '', 0, 'L', true, 0, false, false, 0);
      $pdf->SetXY((7 + $distancia),28.5); 
      $pdf->Write(0,trim($dato_general['DESCALLE'])." ".$dato_general['NUMERO'], '', 0, 'L', true, 0, false, false, 0);
      $pdf->SetXY( (7 + $distancia),31.5); 
      $pdf->Write(0, $dato_general['DESURBA'], '', 0, 'L', true, 0, false, false, 0);
      //REFERENCIA 
      $pdf->SetFont('helvetica', '', 7);
      $pdf->SetXY((7 + $distancia),35); 
      $pdf->Write(0, 'Ref :', '', 0, 'L', true, 0, false, false, 0);
      //RUC
      $pdf->SetXY((7 + $distancia),38);
      $pdf->Write(0, 'R.U.C.:', '', 0, 'L', true, 0, false, false, 0);
      $pdf->SetXY((7 + $distancia),41); 
      $pdf->Write(0, 'Horario :', '', 0, 'L', true, 0, false, false, 0);
      $pdf->SetXY((7 + $distancia),45); 
      $pdf->Write(0, 'Frecuencia :', '', 0, 'L', true, 0, false, false, 0);
      $pdf->SetXY( (31 + $distancia),45); 
      $pdf->Write(0, 'Horas:', '', 0, 'L', true, 0, false, false, 0);
      $pdf->SetXY((48 + $distancia),45); 
      $pdf->Write(0, 'Dias/Semanas :', '', 0, 'L', true, 0, false, false, 0);

      $pdf->SetFont('helveticaB', '', 7);
      $pdf->SetXY((20 + $distancia),38); 
      $pdf->Write(0, $doc_identificacion, '', 0, 'L', true, 0, false, false, 0);
      //HORARIO 
      $pdf->SetXY((20 + $distancia),41); 
      $pdf->Write(0, $dato_general['HORARIO'], '', 0, 'L', true, 0, false, false, 0);
      // FRECUENCIA , HORAS , DIA SEMANA
      $pdf->SetXY((22 + $distancia),45); 
      $pdf->Write(0, trim($dato_general['DESFH']), '', 0, 'L', true, 0, false, false, 0);
      $pdf->SetXY( (40 + $distancia),45);
      $pdf->Write(0, number_format(floatval($dato_general['HORABS']) , 2, '.', ''), '', 0, 'L', true, 0, false, false, 0);
      $pdf->SetXY((68 + $distancia),45); 
      $pdf->Write(0, number_format(floatval($dato_general['DXSEM']) , 2, '.', ''), '', 0, 'L', true, 0, false, false, 0);
      //MEDIDOR, LECTURAR , CONSUMO
      if(trim($dato_general['FMEDIDOR']) != ""){
        $lect_actual = "";
        $lect_anterior = "" ;
        if ($dato_general['LECACT'] !=0) {
          $lect_actual = $dato_general['LECACT']." - ".$dato_general['FECACT'];
        }
        if ($dato_general['LECANT'] !=0) {
          $lect_anterior = $dato_general['LECANT']." - ".$dato_general['FECANT'];
        }
        if($tipo_imagen ==1){
          $pdf->Image('@'.$nombre_grafi_barra, (86 + $distancia), 33, 52, 29, '', '', '', false, 300, '', false, false, 0);
        }else{
          $pdf->Image('assets/recibo/'.$nombre_grafi_barra.'.jpg', (86 + $distancia), 33, 52, 29, '', '', '', false, 300, '', false, false, 0);
        }
        $pdf->SetFont('helvetica', '', 7);
        $pdf->SetXY((7 + $distancia),49); 
        $pdf->Write(0, 'MEDIDOR :', '', 0, 'L', true, 0, false, false, 0);
        $pdf->SetXY((7 + $distancia),53); 
        $pdf->Write(0, 'LECTURA ACTUAL: ', '', 0, 'L', true, 0, false, false, 0);
        $pdf->SetXY((7 + $distancia),56.5); 
        $pdf->Write(0, 'LECTURA ANTERIOR: ', '', 0, 'L', true, 0, false, false, 0);
        $pdf->SetXY((7 + $distancia),60); 
        $pdf->Write(0, 'CONSUMO M3 :', '', 0, 'L', true, 0, false, false, 0);

        $pdf->SetFont('helveticaB', '', 7);
        $pdf->SetXY((22 + $distancia),49);
        $pdf->Write(0, trim($dato_general['FMEDIDOR']), '', 0, 'L', true, 0, false, false, 0);
        //LECTURA ACTUAL , LECTURA ANTERIOR 
        $pdf->SetXY((35 + $distancia),53); 
        if($dato_general['OBSLEC'] ==61){
          $pdf->Write(0,'--', '', 0, 'L', true, 0, false, false, 0);
          $pdf->SetXY((40 + $distancia),53);
          $pdf->Write(0,'-', '', 0, 'L', true, 0, false, false, 0);
          $pdf->SetXY((42 + $distancia),53);
          $pdf->Write(0,$dato_general['FECACT'], '', 0, 'L', true, 0, false, false, 0);
        }else{
          $pdf->Write(0,$lect_actual, '', 0, 'L', true, 0, false, false, 0);
        }
        $pdf->SetXY((34 + $distancia),56.5); 
        $pdf->Write(0, $lect_anterior, '', 0, 'L', true, 0, false, false, 0);
        // CONSUMO M3
        $pdf->SetXY((27 + $distancia),60); 
        $pdf->Write(0, $consumo, '', 0, 'L', true, 0, false, false, 0);
      }else{
        if($dato_general['CONSUMO'] != 0  &&  $dato_general['LECACT'] != 0 && $dato_general['LECANT'] != 0 ){
            $lect_actual = "";
            $lect_anterior = "" ;
            if ($dato_general['LECACT'] !=0) {
              $lect_actual = $dato_general['LECACT']." - ".$dato_general['FECACT'];
            }
            if ($dato_general['LECANT'] !=0) {
              $lect_anterior = $dato_general['LECANT']." - ".$dato_general['FECANT'];
            }
            if($tipo_imagen ==1){
              $pdf->Image('@'.$nombre_grafi_barra, (86 + $distancia), 33, 52, 29, '', '', '', false, 300, '', false, false, 0);
            }else{
              $pdf->Image('assets/recibo/'.$nombre_grafi_barra.'.jpg', (86 + $distancia), 33, 52, 29, '', '', '', false, 300, '', false, false, 0);
            }
            $pdf->SetFont('helvetica', '', 7);
            $pdf->SetXY((7 + $distancia),49); 
            $pdf->Write(0, 'MEDIDOR :', '', 0, 'L', true, 0, false, false, 0);
            $pdf->SetXY((7 + $distancia),53); 
            $pdf->Write(0, 'LECTURA ACTUAL: ', '', 0, 'L', true, 0, false, false, 0);
            $pdf->SetXY((7 + $distancia),56.5); 
            $pdf->Write(0, 'LECTURA ANTERIOR: ', '', 0, 'L', true, 0, false, false, 0);
            $pdf->SetXY((7 + $distancia),60); 
            $pdf->Write(0, 'CONSUMO M3 :', '', 0, 'L', true, 0, false, false, 0);

            $pdf->SetFont('helveticaB', '', 7);
            $pdf->SetXY((22 + $distancia),49);
            $pdf->Write(0, trim($dato_general['FMEDIDOR']), '', 0, 'L', true, 0, false, false, 0);
            //LECTURA ACTUAL , LECTURA ANTERIOR 
            $pdf->SetXY((34 + $distancia),54); 
            if($dato_general['OBSLEC'] ==61){
              $pdf->Write(0,'--', '', 0, 'L', true, 0, false, false, 0);
              $pdf->SetXY((40 + $distancia),53);
              $pdf->Write(0,'-', '', 0, 'L', true, 0, false, false, 0);
              $pdf->SetXY((42 + $distancia),53);
              $pdf->Write(0,$dato_general['FECACT'], '', 0, 'L', true, 0, false, false, 0);
            }else{
              $pdf->Write(0,$lect_actual, '', 0, 'L', true, 0, false, false, 0);
            }
            
            $pdf->SetXY((34 + $distancia),56.5); 
            $pdf->Write(0, $lect_anterior, '', 0, 'L', true, 0, false, false, 0);
            // CONSUMO M3
            $pdf->SetXY((27 + $distancia),60); 
            $pdf->Write(0, $consumo, '', 0, 'L', true, 0, false, false, 0);
        }else{
            // CONSUMO M3
            $pdf->SetXY((7 + $distancia),53); 
            $pdf->SetFont('helvetica', '', 7);
            $pdf->Write(0, trim($dato_general['DESCRIREG']), '', 0, 'L', true, 0, false, false, 0);
        }
        
        
      }

      // TARIFA Y OBSERVACION DE LECTURA 
      if($dato_general['OBSLEC'] != 0){
        $pdf->SetXY((65 + $distancia),49); 
        $pdf->SetFont('helvetica', '', 7);
        $pdf->Write(0, 'O/L:', '', 0, 'L', true, 0, false, false, 0);
        $pdf->SetXY((70 + $distancia),49); 
        $pdf->SetFont('helveticaB', '', 7);
        $pdf->Write(0, $dato_general['OBSLEC'], '', 0, 'L', true, 0, false, false, 0);
      }
      if ( ($dato_general['FGRUCOD']== 0 && $dato_general['FGRUSUB'] == 0 ) || strlen(trim($dato_general['CLICODFAX'])) == 11) {
        $pdf->SetFont('helvetica', '', 7);
        $pdf->SetXY((39 + $distancia),49); 
        $pdf->Write(0, 'TARIFA :', '', 0, 'L', true, 0, false, false, 0); 
        $pdf->SetXY((57 + $distancia),49); 
        $pdf->Write(0, 'T/S : ', '', 0, 'L', true, 0, false, false, 0);
        
        $pdf->SetFont('helveticaB', '', 7);
        $pdf->SetXY((50 + $distancia),49); 
        $pdf->Write(0, $dato_general['FACTARIFA'], '', 0, 'L', true, 0, false, false, 0);
        $pdf->SetXY( (63 + $distancia),49); 
        $pdf->Write(0, $dato_general['FSETIPCOD'] , '', 0, 'L', true, 0, false, false, 0);
      }
      // ************************
      // **** CUERPO DEL RECIBO *
      //*************************
      $altura =71; 
      $pdf->SetFont('helvetica', '', 6);
      $i=0;
      while($i<sizeof($dato_detalle)){
        $rang1=" ";
        $rang2=" ";
        $rang3=" ";
        if ($dato_general['FGRUCOD']== 0 && $dato_general['FGRUSUB'] == 0 ){
          if($dato_detalle[$i]['IMPPRIRANG'] != "0"){
            $rang1=number_format(str_replace(',', '.', $dato_detalle[$i]['IMPPRIRANG']) , 2, '.', '');
          }
          if($dato_detalle[$i]['IMPSEGRANG'] != "0"){
            $rang2=number_format(str_replace(',', '.', $dato_detalle[$i]['IMPSEGRANG']) , 2, '.', '');
          }
          if($dato_detalle[$i]['IMPTERRANG'] != "0"){
            $rang3=number_format(str_replace(',', '.', $dato_detalle[$i]['IMPTERRANG']) , 2, '.', '');
          }
        }
        $item = $dato_detalle[$i]['FACLINRO'];
        $detalle = trim($dato_detalle[$i]['DESCONCEP']);
        $letra = strlen($detalle);
        $monto = number_format(str_replace(',', '.', $dato_detalle[$i]['FACPRECI']), 2, '.', '');
        // writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
        $pdf->writeHTMLCell(10, 5, (8 + $distancia), $altura, $item, 0, 1, 0, true, 'L', true);
        $pdf->writeHTMLCell(50, 5, (13 + $distancia), $altura, $detalle, 0, 1, 0, true, 'L', true);
        $pdf->writeHTMLCell(15, 5, (68 + $distancia), $altura, $rang1, 0, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(15, 5, (85 + $distancia), $altura, $rang2, 0, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(15, 5, (103 + $distancia), $altura, $rang3, 0, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(22, 5, (118 + $distancia), $altura, $monto, 0, 1, 0, true, 'R', true);
        if ($letra > 45) {
          $altura = $altura + 6 ;
        }else{
          $altura = $altura + 3.5 ;
        }
        $i++;
      }
      $pdf->SetFont('helveticaB', '', 7.5);
      $detalle_subtotal = (float)str_replace(',', '.', $dato_general['SUBTOT_ANT']) -  (float)str_replace(',', '.', $dato_general['REDONANT']) ;
      $subtotal = number_format($detalle_subtotal, 2, '.', '');
      $igv = number_format(str_replace(',', '.', $dato_general['FACIGV']), 2, '.', ',');
     
      $pdf->writeHTMLCell(59, 5, (60 + $distancia), $altura, 'SUBTOTAL :', 0, 1, 0, true, 'R', true);
      $pdf->writeHTMLCell(22, 5, (118 + $distancia), $altura, $subtotal, 0, 1, 0, true, 'R', true);
      $altura = $altura + 3.5 ;
      $pdf->writeHTMLCell(59, 5, (60 + $distancia), $altura, 'I.G.V.( 18% ) :', 0, 1, 0, true, 'R', true);
      $pdf->writeHTMLCell(22, 5, (118 + $distancia), $altura, '<p>'.$igv.'</p>', 0, 1, 0, true, 'R', true);
      // mensaje para cuarentena
      if($dato_general['OBSLEC'] ==61){
        $pdf->SetFont('helvetica', '', 5.5);
        $pdf->writeHTMLCell(30,  0, (5 + $distancia), ($altura-1),"<p><strong>ESTIMADO USUARIO:</strong></p>", 0, 1, 0, true, 'L',  true);
        $pdf->SetFont('helvetica', '', 5);
        $pdf->writeHTMLCell(60,  0, (5 + $distancia),($altura+1.5),"<p>".trim($dato_general['DESPREM'])."</p>", 0, 1, 0, true, 'L',  true);
      }
      $pdf->SetFont('helveticaB', '', 7.5);
      $altura = $altura + 3.5 ;
      $saldo_anterior = number_format(str_replace(',', '.', $dato_general['REDONANT']), 2, '.', '');
      $pdf->writeHTMLCell(59, 5, (60 + $distancia), $altura, 'SALDO REDONDEO AL MES ANTERIOR :', 0, 1, 0, true, 'R', true);
      $pdf->writeHTMLCell(22, 5, (118 + $distancia), $altura, $saldo_anterior, 0, 1, 0, true, 'R', true);
      $altura = $altura + 3.5 ;
      $redondeo = number_format(str_replace(',', '.', $dato_general['REDONACT']), 2, '.', '');
      $pdf->writeHTMLCell(59, 5, (60 + $distancia), $altura, 'REDONDEO MES ACTUAL :', 0, 1, 0, true, 'R', true);
      $pdf->writeHTMLCell(22, 5, (118 + $distancia), $altura, $redondeo , 0, 1, 0, true, 'R', true);
      $altura = $altura + 3.5 ;
      $mes_periodo =strtoupper ($dato_general['DESMES'])." ".substr($dato_general['PERIODO'], 0, 4); 
      $total_pagar = number_format(str_replace(',', '.', $dato_general['FACTOTAL']), 2, '.', '') ;
      $pdf->writeHTMLCell(69, 5, (9 + $distancia), $altura, 'TOTAL RECIBO '.$mes_periodo , 0, 1, 0, true, 'L', true);
      $pdf->writeHTMLCell(22, 5, (118 + $distancia), $altura, $total_pagar , 0, 1, 0, true, 'R', true);
      $deuda_anterior = 0;
    if ($dato_general['FACSALDO'] > 0) {
      $altura = $altura + 3.5 ;
      $deuda_anterior = number_format(str_replace(',', '.', $dato_general['FACSALDO']), 2, '.', '') ;
      $pdf->writeHTMLCell(69, 5, (9 + $distancia), $altura, 'Deuda anterior (Ignorar , si está al día)', 0, 1, 0, true, 'L', true);
      $pdf->writeHTMLCell(22, 5, (118 + $distancia), $altura, $deuda_anterior , 0, 1, 0, true, 'R', true);
    }
    
    $pdf->SetFont('helveticaB', '', 7);
    $pdf->writeHTMLCell(36,  0,(5 + $distancia) , 136,"<p>SEGUNDO ORIGINAL</p>", 0, 1, 0, true, 'L',  true);
    $desImporte = trim($dato_general['DESIMPORTE'])." SOLES" ;
    $pdf->writeHTMLCell(97,  0, (5 + $distancia), 140.2,"<p>SON:".$desImporte."</p>", 0, 1, 0, true, 'L',  true);
    //CODIGO DE BARRA E IMAGEN DE CARITA ,FECHAS
    $pdf->SetXY((102 + $distancia),152); 
    $pdf->SetFont('helveticaB', '', 8);
    $pdf->Write(0, 'F. VENC. :', '', 0, 'L', true, 0, false, false, 0);
    $pdf->writeHTMLCell(20,  0, (114 + $distancia), 152,"<p>".trim($dato_general['FACVENFEC'])."</p>", 0, 1, 0, true, 'R',  true);
    if($dato_general['FACSALDO']>0 || $dato_general['MENSCORTES'] == 1){
      $pdf->SetXY((102+ $distancia),155.5); 
      $pdf->Write(0, 'F. CORTE :', '', 0, 'L', true, 0, false, false, 0);
      if($dato_general['FACCICCOR']==null){
        $pdf->writeHTMLCell(20,  0, (120 + $distancia), 155.5,"<p> / / </p>", 0, 1, 0, true, 'L',  true);
      }else{
        $pdf->writeHTMLCell(20,  0, (114 + $distancia), 155.5,"<p>".trim($dato_general['FACCICCOR'])."</p>", 0, 1, 0, true, 'R',  true);
      }
      
    }
    $pdf->setXY((4 + $distancia), 151.5);
    //$pdf->write1DBarcode($nombre_codi_barra, 'C128', '', '', 83, 10, 0.4, '', 'N');
    $pdf->Image('assets/recibo/'.$nombre_codi_barra.'.jpg', (4 + $distancia), 151.5, 86, 11, '', '', '', false, 300, '', false, false, 0);
    if(floatval($dato_general['FACSALDO'])>0){
      $pdf->Image(base_url() .'frontend/recibo/Triste.png', (90 +$distancia ), 149.5, 11, 11, '', '', '', false, 300, '', false, false, 0);
    }else{
      $pdf->Image(base_url() .'frontend/recibo/Alegre.png', (90 + $distancia), 149.5, 11, 11, '', '', '', false, 300, '', false, false, 0);
    }
    $dato=ltrim(rtrim(str_replace ( 'Estimado Cliente:' ,'',utf8_encode($dato_general['MENSAJE']->load() ) )));
    if($dato_general['PORDESEXC']>0){
      if(trim($dato) != ""){
          
          if($dato_general['OBSLEC'] !=61){
            $pdf->SetFont('helvetica', '', 7);
            $pdf->writeHTMLCell(30,  0, (5 + $distancia), 143,"<p><strong>Estimado Cliente:</strong></p>", 0, 1, 0, true, 'L',  true);
            $pdf->SetFont('helvetica', '', 5.5);
            $pdf->writeHTMLCell(62.5,  0, (5 + $distancia), 145.5,"<p>".utf8_decode($dato)."</p>", 0, 1, 0, true, 'L',  true);
          }
          $pdf->SetFont('helvetica', '', 5.2);
          $pdf->writeHTMLCell(50,  0, (63 + $distancia), 143,"<table cellpadding='1' cellspacing='1' border='1'><tr><td>Consumo Real: ".$dato_general['CONREALMED']." m3 </td></tr><tr><td>Consumo Facturado: ".$dato_general['VOLFAC']." m3</td></tr><tr><td>R.S. N° 10-2008-SUNASS-CD</td></tr></table>", 0, 1, 0, true, 'L',  true);
      }
    }else{
      if(trim($dato) != ""){
          if($dato_general['OBSLEC'] !=61){
            $pdf->SetFont('helveticaB', '', 7);
            $pdf->writeHTMLCell(30,  0, (5 + $distancia), 143,"<p>Estimado Cliente:</p>", 0, 1, 0, true, 'L',  true);
            $pdf->SetFont('helvetica', '', 5);
            $pdf->writeHTMLCell(80,  0, (5 + $distancia), 145.5,"<p>".utf8_decode($dato)."</p>", 0, 1, 0, true, 'L',  true);
          }
          
      }
    }
    //TOTAL A PAGAR
    $pdf->SetXY((94 + $distancia),145.5); 
    $pdf->SetFont('helveticaB', '', 8.3);
    $pdf->Write(0, 'TOTAL A PAGAR :', '', 0, 'L', true, 0, false, false, 0);
    $pdf->SetFont('helveticaB', '', 8.3);
    $pdf->writeHTMLCell(20,  0, (120 + $distancia), 145.5,"<p>S/ ".number_format(($total_pagar + $deuda_anterior), 2, '.', '')."</p>", 0, 1, 0, true, 'R',  true);
    if ($dato_general['MENSCORTES'] ==1) {
      $pdf->SetFont('helvetica', '', 4);
      $pdf->writeHTMLCell(50,  0, (90 + $distancia), 142.5,"<p>EL INCUMPLIMIENTO DE PAGO DE UNA CUOTA DE CONVENIO O CREDITO OBLIGA A LA SUSPENCION AUTOMATICA DEL SERVICIO</p>", 0, 1, 0, true, 'L',  true);
    }
    if($dato_general['FACSALDO']>0){
      $pdf->SetFont('helvetica', '', 6);
      $pdf->writeHTMLCell(50,  0, (99 + $distancia), 149,"<p>(no incluye Intereses ni Gastos)</p>", 0, 1, 0, true, 'L',  true);
    }
    // PARTE DE LA BASE  ******
    //ruta
    $pdf->SetXY((7 + $distancia),170); 
    $pdf->SetFont('helvetica', '', 6);
    $pdf->Write(0, 'Ruta: ', '', 0, 'L', true, 0, false, false, 0);
    $pdf->SetXY((14 + $distancia),170); 
    $pdf->SetFont('helveticaB', '', 6);
    $pdf->Write(0, $dato_general['CARGARD']."  "."-"." ".$dato_general['ORDENRD'], '', 0, 'L', true, 0, false, false, 0);
    //recibo y codigo 
    $pdf->SetFont('helveticaB', '', 7.5 );
    $pdf->writeHTMLCell(56,  0, (40 + $distancia), 167,"<p>RECIBO : ".$dato_general['FACSERNRO']."-".$dato_general['FACNRO']."-".$dato_general['FACCHEDIG']."</p>", 0, 1, 0, true, 'L',  true);
    $pdf->writeHTMLCell(56,  0, (40 + $distancia), 170,"<p>SUMINISTRO : ".$dato_general['CLICODFAX']."</p>", 0, 1, 0, true, 'L',  true);
    $pdf->writeHTMLCell(60,  0, (85 + $distancia), 167,"<p>FACTURACIÓN DE : ".strtoupper ($dato_general['DESMES'])."-".substr($dato_general['PERIODO'], 2, 2)."</p>", 0, 1, 0, true, 'L',  true);
    $pdf->writeHTMLCell(60,  0, (85 + $distancia), 170,"<p>TOTAL :</p>", 0, 1, 0, true, 'L',  true);
    $pdf->writeHTMLCell(60,  0, (108 + $distancia), 170,"<p>S/ ".number_format(($total_pagar + $deuda_anterior), 2, '.', '')."</p>", 0, 1, 0, true, 'L',  true);
    //MENSAJE DE LA BASE
    /*$mensaje_base =trim(utf8_decode( utf8_encode($dato_general['MENSAJE2']->load() ) )) ; 
    $posicion = stripos($mensaje_base , ':');
    $cabecera_mensaje = substr($mensaje_base, 0,($posicion+1));
    $cuerpo_mensaje = substr($mensaje_base,($posicion+1), strlen($mensaje_base));
    $pdf->SetXY((57 + $distancia),175); 
    $pdf->SetFont('helveticaB', '', 7);
    $pdf->Write(0, $cabecera_mensaje , '', 0, 'L', true, 0, false, false, 0);
    $pdf->SetFont('helveticaB', '', 8);
    $pdf->writeHTMLCell(133,  0, (7 + $distancia), 178,"<p>".$cuerpo_mensaje ."</p>", 0, 1, 0, true, 'C',  true);*/
    if($dato_general['MENSAJE2'] != null){
        $mensaje_base =trim(utf8_decode( utf8_encode($dato_general['MENSAJE2']->load() ) )) ; 
        $posicion = stripos($mensaje_base , ':');
        if($posicion===false){
          $pdf->SetFont('helveticaB', '', 8);
          $pdf->writeHTMLCell(133,  0, (7 + $distancia), 178,"<p>".$mensaje_base ."</p>", 0, 1, 0, true, 'C',  true);
        }else{
           if($posicion<25){
              $cabecera_mensaje = substr($mensaje_base, 0,($posicion+1));
              $cuerpo_mensaje = substr($mensaje_base,($posicion+1), strlen($mensaje_base));
              $pdf->SetXY( (57 + $distancia),175 );  
              $pdf->SetFont('helveticaB', '', 7);
              $pdf->Write(0, $cabecera_mensaje , '', 0, 'L', true, 0, false, false, 0);
              $pdf->SetFont('helveticaB', '', 8);
              $pdf->writeHTMLCell(133,  0,(7 + $distancia), 178,"<p>".$cuerpo_mensaje ."</p>", 0, 1, 0, true, 'C',  true);
           }
          
        }
        
    }else{
      $pdf->writeHTMLCell(133,  0, (7 + $distancia), 178,"<p></p>", 0, 1, 0, true, 'C',  true);
    }
    $pdf->SetFont('helvetica', '', 6.5);
    $pdf->writeHTMLCell(133,  0, (5 + $distancia), 197,"<p>".$cadena_aleatoria."</p>", 0, 1, 0, true, 'L',  true);
    unset($dato_general, $dato_detalle);
    return $pdf ;
    }

    public function plantilla_reporte_lectura($pdf,$respuesta,$periodo, $anio , $nom_perido, $datos){
      $style = array('width' => 0.20, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
      $date = new DateTime($datos[0]['LecFchRgMov']);
      $pdf->Image( base_url()."img/logo4.jpg", 5, 5, 45, 12, '', '', '', false, 300, '', false, false, 0);
      $pdf->SetFont('helveticaB', '',9);
      $pdf->writeHTMLCell(170, 5, 140, 10 ,"<p>FECHA DE LECTURA : ".$date->format('d-m-Y')."</p>", 0, 1, 0, true, 'L',  true);
      $pdf->SetFont('helveticaBI', '',8);
      $pdf->writeHTMLCell(70, 5, 5, 30 ,"CLIENTE SOLICITADO</p>", 0, 1, 0, true, 'L',  true);
      $pdf->SetFont('helveticaB', '',8);
      $pdf->writeHTMLCell(70, 5, 7, 35 ,"<p>SUMINISTRO : ".$datos[0]['LecCodFc']."</p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(60, 5, 140, 35 ,"<p>CICLO : ".$datos[0]['LecCicCod']."</p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(170, 5, 7, 40 ,"<p>NOMBRE : ".$datos[0]['LecNom']."</p>", 0, 1, 0, true, 'L',  true);
      $pdf->Line(5, 34 ,204, 34 , $style);
      $pdf->Line(5, 34 ,5, 47 , $style);
      $pdf->Line(5, 47 ,204, 47 , $style);
      $pdf->Line(204, 47 ,204, 34, $style);
      $pdf->SetFont('helveticaB', '',13);
      $pdf->writeHTMLCell(170, 5, 30, 20 ,"<p>LECTURA DE MEDIDORES DE AGUA - FACTURACIÓN ".$nom_perido." ".$anio."</p>", 0, 1, 0, true, 'L',  true);
      $pdf->SetFont('helvetica', '',5.5);
      $can_tbl = '
          <table cellspacing="0" cellpadding="1" border="1">
            <tr>
                <td height="20" width="70" align="center" >SUMINISTRO</td>
                <td height="20" width="200" align="center" >NOMBRE</td>
                <td height="20" width="160" align="center" >URBANIZACIÓN</td>
                <td height="20" width="100" align="center">CALLE</td>
                <td height="20" width="50" align="center" >NUMERO</td>
                <td height="20" width="50" align="center" >MEDIDOR</td>
                <td height="20" width="50" align="center" >LECTURA</td>
                <td height="20" width="30" align="center" >OBS</td>
            </tr>
          ';
      $i = 0;
      $tbl='';
      while(count($respuesta)>$i){
        if($datos[0]['LecId'] != $respuesta[$i]['LecId'] ){
            $tbl = $tbl .'<tr>
                  <td  width="70" align="center" >'.$respuesta[$i]['LecCodFc'].'</td>
                  <td width="200" align="left" >'.$respuesta[$i]['LecNom'].'</td>
                  <td  width="160" align="left" >'.$respuesta[$i]['LecUrb'].'</td>
                  <td  width="100" align="left">'.$respuesta[$i]['LecCal'].'</td>
                  <td  width="50" align="center" >'.$respuesta[$i]['LecMun'].'</td>
                  <td  width="50" align="center" >'.$respuesta[$i]['LecMed'].'</td>
                  <td  width="50" align="center" >'.$respuesta[$i]['LecVal'].'</td>
                  <td  width="30" align="center" >'.$respuesta[$i]['observacion'].'</td>
                  
              </tr>';
        }else{
          $tbl = $tbl .'<tr>
                  <td  width="70" align="center" bgcolor="#FFFF00" >'.$respuesta[$i]['LecCodFc'].'</td>
                  <td width="200" align="left" bgcolor="#FFFF00" >'.$respuesta[$i]['LecNom'].'</td>
                  <td  width="160" align="left" bgcolor="#FFFF00" >'.$respuesta[$i]['LecUrb'].'</td>
                  <td  width="100" align="left" bgcolor="#FFFF00">'.$respuesta[$i]['LecCal'].'</td>
                  <td  width="50" align="center" bgcolor="#FFFF00" >'.$respuesta[$i]['LecMun'].'</td>
                  <td  width="50" align="center" bgcolor="#FFFF00" >'.$respuesta[$i]['LecMed'].'</td>
                  <td  width="50" align="center" bgcolor="#FFFF00" >'.$respuesta[$i]['LecVal'].'</td>
                  <td  width="30" align="center" bgcolor="#FFFF00" >'.$respuesta[$i]['observacion'].'</td>
              </tr>';
        }
         
        $i++;
      }
      $tabla = $can_tbl.$tbl."</table>";
      $pdf->SetXY(5 ,50);
      $pdf->writeHTML($tabla, true, false, false, false, '');
      return $pdf;
    }


    function imprimir_reclamo($pdf, $reclamo, $reclamante, $direccion, $direccion_procesal, $descri_problema, $empresa, $conciliacion){
      $style = array('width' => 0.20, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
      $pdf->Image( base_url()."img/logo4.jpg", 5, 5, 45, 12, '', '', '', false, 300, '', false, false, 0);
      $pdf->SetFont('helveticaB', '',14);
      $pdf->writeHTMLCell(170, 5, 65, 10 ,"<p>FICHA DE REGISTRO DE RECLAMO</p>", 0, 1, 0, true, 'L',  true);
      
      // SUMINISTRO
      $pdf->Line(5, 20 , 40, 20 , $style);
      $pdf->Line(5, 20 ,5, 30 , $style);
      $pdf->Line(5, 30 ,40, 30 , $style);
      $pdf->Line(40, 30 ,40, 20, $style);
      $pdf->SetFont('helveticaB', '',8);
      $pdf->writeHTMLCell(70, 5, 11, 20 ,"<p>Nro. sumunistro</p>", 0, 1, 0, true, 'L',  true);
      $pdf->SetFont('helvetica', '',11);
      $pdf->writeHTMLCell(70, 5, 10, 24 ,"<p>".$reclamo['UUCOD']."</p>", 0, 1, 0, true, 'L',  true);
      // CODIGO DE RECLAMO
      $pdf->Line(120, 20 , 120, 30 , $style);
      $pdf->Line(120, 30 ,206, 30 , $style);
      $pdf->Line(206, 30 ,206, 20 , $style);
      $pdf->Line(206, 20 ,120, 20, $style);
      $pdf->SetFont('helveticaB', '',8);
      $pdf->writeHTMLCell(70, 5, 150, 20 ,"<p>Codigo reclamo</p>", 0, 1, 0, true, 'L',  true);
      $pdf->SetFont('helvetica', '',11);
      $pdf->writeHTMLCell(160, 5, 143, 22 ,"<p>".$reclamo['EMPCOD'].' - '.$reclamo['OFICOD'].' - '.$reclamo['ARECOD'].' - '.$reclamo['CTDCOD'].' - '.$reclamo['DOCCOD'].' - '.$reclamo['SERNRO'].'- <strong style="font-size:18px;">'.$reclamo['RECID']."</strong></p>", 0, 1, 0, true, 'L',  true);
      // NOMBRE APELLIDO SOLICITANTE
      $pdf->Line(5, 32 , 5, 47 , $style);
      $pdf->Line(5, 47 ,206, 47 , $style);
      $pdf->Line(206, 47 ,206, 32 , $style);
      $pdf->Line(206, 32 ,5, 32, $style);
      $pdf->Line(5, 37 ,206, 37 , $style);
      $pdf->Line(5, 42 ,206, 42 , $style);
      $pdf->Line(100, 32 ,100, 47, $style);
      $pdf->SetFont('helveticaB', '',8);
      $pdf->writeHTMLCell(70, 5, 11, 33 ,"<p>SOLICITANTE O REPRESENTANTE</p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 5, 105, 33 ,"<p>CLIENTE PROPIETARIO</p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 5, 35, 43 ,"<p>Apellidos y nombres</p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 5, 140, 43 ,"<p>Apellidos y nombres</p>", 0, 1, 0, true, 'L',  true);
      $pdf->SetFont('helvetica', '',9);
      $pdf->writeHTMLCell(150, 5, 6, 38 ,"<p>".trim($reclamante['PRENOM']).' '.trim($reclamante['PREAPEPAT']).' '.trim($reclamante['PREAPEMAT']) ."</p>", 0, 1, 0, true, 'L',  true);
      
      // DOCUMENTO CATASTRO
      $pdf->Line(5, 49 , 5, 59 , $style);
      $pdf->Line(5, 59 ,206, 59 , $style);
      $pdf->Line(206, 59 ,206, 49 , $style);
      $pdf->Line(206, 49 ,5, 49, $style);
      $pdf->Line(5, 54 ,206, 54 , $style);
      $pdf->Line(150, 49 ,150, 59 , $style);
      $pdf->Line(80, 54 ,80, 59 , $style);
      $pdf->Line(120, 54 ,120, 59 , $style);
      $pdf->SetFont('helveticaB', '',7);
      $pdf->writeHTMLCell(90, 5, 11, 50 ,"<p>NRO DE DOCUM. IDENTIDAD(DNI,LE,CI) DE RECLAMANTE:</p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 5, 11, 55 ,"<p>RAZÓN SOCIAL: </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 5, 82, 55 ,"<p>TARIFA: </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 5, 122, 55 ,"<p>CICLO: </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 5, 152, 55 ,"<p>MEDIDOR:</p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 5, 152, 50 ,"<p>TELEFONO:</p>", 0, 1, 0, true, 'L',  true);
      $pdf->SetFont('helvetica', '',8);
      $pdf->writeHTMLCell(90, 5, 86, 50 ,"<p>".trim($reclamante['PREDOCID'])."</p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 5, 50, 55 ,"<p>".(is_null($reclamante['PRERAZSOC'])? '': trim($reclamante['PRERAZSOC']) )." </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 5, 170, 50 ,"<p>".(is_null($reclamante['PRETEL'])? '': trim($reclamante['PRETEL']) )."</p>", 0, 1, 0, true, 'L',  true);
      // PREDIO 
      $pdf->Line(5, 61, 5, 86, $style);
      $pdf->Line(5, 86, 206, 86, $style);
      $pdf->Line(206, 86, 206, 61, $style);
      $pdf->Line(206, 61 ,5, 61, $style);
      $pdf->Line(5, 66, 206, 66, $style);
      $pdf->Line(5, 71, 206, 71, $style);
      $pdf->Line(5, 76, 206, 76, $style);
      $pdf->Line(5, 81, 206, 81, $style);
      $pdf->Line(80, 66 ,80, 86 , $style);
      $pdf->Line(125, 66 ,125, 76 , $style);
      $pdf->Line(170, 66 ,170, 76 , $style);
      $pdf->Line(150, 76 ,150, 86 , $style);
      $pdf->SetFont('helveticaB', '',7);
      $pdf->writeHTMLCell(70, 5, 11, 62 ,"<p>UBICACIÓN DEL PREDIO: </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 5, 30, 72 ,"<p>(Calle, Jirón, Avenida) </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 5, 100, 72 ,"<p>Nro </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 5, 145, 72 ,"<p>Mza </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 5, 185, 72 ,"<p>Lote </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 5, 30, 82 ,"<p>(Urbanización, barrio) </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 5, 110, 82 ,"<p>Provincia: </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 5, 175, 82 ,"<p>Distrito: </p>", 0, 1, 0, true, 'L',  true);
      $pdf->SetFont('helvetica', '',7);
      $pdf->writeHTMLCell(70, 5, 6, 67 ,"<p>".trim($direccion['MVIDES']) ."</p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 5, 6, 77 ,"<p>".trim($direccion['CGPDES'])."</p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 5, 90, 77 ,"<p>".(is_null($direccion['CPVDES'])? '': trim($direccion['CPVDES']) )."</p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 5, 155, 77 ,"<p>".(is_null($direccion['CDSDES'])? '': trim($direccion['CDSDES']) )." </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 5, 90, 67 ,"<p>".(is_null($reclamante['PRENROM'])? '': trim($reclamante['PRENROM']) )."</p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 5, 135, 67 ,"<p>".(is_null($reclamante['PREMZN'])? '': trim($reclamante['PREMZN']) )."</p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 5, 175, 67 ,"<p>".(is_null($reclamante['PRELOT'])? '': trim($reclamante['PRELOT']) )." </p>", 0, 1, 0, true, 'L',  true);
      // DOMICILIO PROCESAL 
      $pdf->Line(5, 88, 5, 132, $style);
      $pdf->Line(5, 132, 206, 132, $style);
      $pdf->Line(206, 132, 206, 88, $style);
      $pdf->Line(206, 88 ,5, 88, $style);
      $pdf->Line(5, 93, 206, 93, $style);
      $pdf->Line(5, 98, 206, 98, $style);
      $pdf->Line(5, 103, 206, 103, $style);
      $pdf->Line(5, 108, 206, 108, $style);
      $pdf->Line(5, 113, 206, 113, $style);
      $pdf->Line(5, 118, 206, 118, $style);
      $pdf->Line(5, 123, 206, 123, $style);
      $pdf->Line(80, 93 ,80, 123, $style);
      $pdf->Line(135, 93 ,135, 123, $style);
      $pdf->Line(175, 93 ,175, 103, $style);
      $pdf->SetFont('helveticaB', '',7);
      $pdf->writeHTMLCell(70, 5, 11, 89 ,"<p>DOMICILIO PROCESAL </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 5, 30, 99 ,"<p>(Calle, Jirón, Avenida) </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 5, 103, 99 ,"<p>Nro </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 5, 150, 99 ,"<p>Mza </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 5, 190, 99 ,"<p>Lote </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 5, 30, 109 ,"<p>(Urbanización, barrio) </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 5, 100, 109 ,"<p>Provincia </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 5, 165, 109 ,"<p>Distrito </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 5, 30, 119 ,"<p>Código Postal  </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 5, 100, 119 ,"<p>Telefono/Celular </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 5, 137, 119 ,"<p>Correo Electrónico(obligatorio para reclamos via web) </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(140, 5, 7, 124 ,"<p>Solicito que las notificaciones de los actos administrativos del presente procedimiento de reclamo se
      realicen en la direccion de correo electronico consignado, para lo cual brindo mi autorizacion expresa
      </p>", 0, 1, 0, true, 'L',  true);
      $pdf->SetFont('helvetica', '',7);
      $pdf->writeHTMLCell(70, 5, 6, 94 ,"<p>".trim($direccion_procesal['MVIDES']) ."</p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 5, 6, 104 ,"<p>".trim($direccion_procesal['CGPDES'])."</p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 5, 90, 104 ,"<p>".(is_null($direccion_procesal['CPVDES'])? '': trim($direccion_procesal['CPVDES']) )."</p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 5, 155, 104 ,"<p>".(is_null($direccion_procesal['CDSDES'])? '': trim($direccion_procesal['CDSDES']) )." </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 5, 98, 94 ,"<p>".(is_null($reclamante['PREDPNMUN'])? '': trim($reclamante['PREDPNMUN']) )."</p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 5, 140, 94 ,"<p>".(is_null($reclamante['PREDPMZN'])? '': trim($reclamante['PREDPMZN']) )."</p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 5, 180, 94 ,"<p>".(is_null($reclamante['PREDPLOTE'])? '': trim($reclamante['PREDPLOTE']) )." </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 5, 20, 114 ,"<p>".(is_null($reclamante['PREDPCODP'])? '': trim($reclamante['PREDPCODP']) )."</p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 5, 90, 114 ,"<p>".(is_null($reclamante['PREDPTELF'])? '': trim($reclamante['PREDPTELF']) )."</p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 5, 137, 114 ,"<p>".(is_null($reclamante['PREDPMAIL'])? '': trim($reclamante['PREDPMAIL']) )." </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(140, 5, 160, 126 ,"<p style ='font-size:19px;' > ".(($reclamo['ORECMAILSN'] == 'S')? 'SI ( X )  NO( )' : 'SI ()  NO( X )' )."</p>", 0, 1, 0, true, 'L',  true);
      // TIPO DE RECLAMO
      $pdf->Line(5, 134, 5, 198, $style);
      $pdf->Line(5, 198, 206, 198, $style);
      $pdf->Line(206, 198, 206, 134, $style);
      $pdf->Line(206, 134 ,5, 134, $style);
      $pdf->Line(5, 139, 206, 139, $style);
      $pdf->Line(5, 144, 206, 144, $style);
      $pdf->Line(5, 149, 206, 149, $style);
      $pdf->Line(5, 154, 206, 154, $style);
      $pdf->Line(5, 164, 206, 164, $style);
      $pdf->Line(5, 169, 206, 169, $style);
      $pdf->Line(5, 179, 206, 179, $style);
      $pdf->Line(5, 184, 206, 184, $style);
      $pdf->Line(65, 139, 65, 144, $style);
      $pdf->Line(115, 139, 115, 144, $style);
      $pdf->Line(45, 179, 45, 184, $style);
      $pdf->Line(80, 179, 80, 184, $style);
      $pdf->Line(135, 179, 135, 184, $style);
      $pdf->Line(100, 184 ,100, 198, $style);
      $pdf->SetFont('helveticaB', '',7);
      $pdf->writeHTMLCell(70, 5, 11, 135 ,"<p>TIPO DE RECLAMO (Indique la letra del tipo de reclamo): </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(140, 5, 11, 150 ,"<p>BREVE DESCRIPCION DEL RECLAMO (meses reclamados,montos,etc., en lo aplicable): </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(140, 5, 11, 165 ,"<p>FUNDAMENTO DEL RECLAMO:      </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(140, 5, 11, 180 ,"<p>SUCURSAL / ZONA:      </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(140, 5, 11, 185 ,"<p>ATENDIDO POR:  </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(140, 5, 105, 185 ,"<p>FIRMA: </p>", 0, 1, 0, true, 'L',  true);
      $pdf->SetFont('helvetica', '',7);
      $pdf->writeHTMLCell(70, 5, 6, 140 ,"<p>". $descri_problema[0]['CPID'].'-'.$descri_problema[0]['CPDESC']." </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 5, 65, 140 ,"<p>". $descri_problema[0]['TIPPROBID'].'-'.$descri_problema[0]['TIPPROBDESC']." </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 5, 115, 140 ,"<p>". $descri_problema[0]['SCATPROBDESC']." </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 5, 6, 145 ,"<p>". $descri_problema[0]['PROBDESC']." </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(200, 5, 6, 155 ,"<p>". $reclamo['RECDESC']." </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(200, 5, 6, 170 ,"<p>". $reclamo['RECFUNDA']." </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(200, 5, 47, 180 ,"<p>". $empresa." </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(200, 5, 83, 180 ,"<p>". $_SESSION['oficina']." </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(200, 5, 137, 180 ,"<p>". $_SESSION['area']." </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(200, 5, 11, 190 ,"<p>". $_SESSION['user_nom']." </p>", 0, 1, 0, true, 'L',  true);
      //$empresa
      // RELACION DE PRUEBAS 
      $pdf->Line(5, 200, 5, 210, $style);
      $pdf->Line(5, 210, 206, 210, $style);
      $pdf->Line(206, 210, 206, 200, $style);
      $pdf->Line(206, 200 ,5, 200, $style);
      $pdf->Line(5, 205, 206, 205, $style);
      $pdf->Line(100, 205 ,100, 210, $style);
      $pdf->SetFont('helveticaB', '',7);
      $pdf->writeHTMLCell(110, 5, 11, 201 ,"<p>RELACION DE PRUEBAS QUE SE PRESENTAN ADJUNTAS:      </p>", 0, 1, 0, true, 'L',  true);
      // CARTILLA INFORMATIVA 
      $pdf->Line(5, 212, 5, 226, $style);
      $pdf->Line(5, 226, 206, 226, $style);
      $pdf->Line(206, 226, 206, 212, $style);
      $pdf->Line(206, 212 ,5, 212, $style);
      $pdf->Line(5, 217, 206, 217, $style);
      $pdf->Line(85, 212, 85, 217, $style);
      $pdf->Line(115, 212, 115, 217, $style);
      $pdf->SetFont('helveticaB', '',7);
      $pdf->writeHTMLCell(110, 5, 11, 213 ,"<p>LA EPS ENTREGA CARTILLA INFORMATIVA:  </p>", 0, 1, 0, true, 'L',  true);
      if($reclamo['RECCARTILLA'] =='S'){
        $pdf->writeHTMLCell(110, 5, 86, 213 ,"<p>SI ( X ) </p>", 0, 1, 0, true, 'L',  true);
        $pdf->writeHTMLCell(110, 5, 120, 213 ,"<p>NO ( ) </p>", 0, 1, 0, true, 'L',  true);
      }else{
        $pdf->writeHTMLCell(110, 5, 86, 213 ,"<p>SI ( ) </p>", 0, 1, 0, true, 'L',  true);
        $pdf->writeHTMLCell(110, 5, 120, 213 ,"<p>NO ( X ) </p>", 0, 1, 0, true, 'L',  true);
      }
      
      $pdf->SetFont('helvetica', '',7);
      $pdf->writeHTMLCell(110, 5, 7, 218 ,"<p>DECLARACION DEL RECLAMANTE (aplicable a reclamos por consumo medido):  </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(170, 5, 7, 222 ,"<p>Solicito la realización de prueba de contrastación y acepto asumir su costo,si el resultado de la prueba indica que el medidor subregistra.  </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(170, 5, 170, 222 ,"<p style ='font-size:19px;' > ".(($reclamo['RECDECLA'] == 'S')? 'SI ( X )  NO( )' : 'SI ()  NO( X )' )."</p>", 0, 1, 0, true, 'L',  true);
      // FECHAS 
      $pdf->Line(5, 228, 5, 243, $style);
      $pdf->Line(5, 243, 206, 243, $style);
      $pdf->Line(206, 243, 206, 228, $style);
      $pdf->Line(206, 228, 5, 228, $style);
      $pdf->Line(5, 233, 206, 233, $style);
      $pdf->Line(5, 238, 130, 238, $style);
      $pdf->Line(130, 228, 130, 243, $style);
      $pdf->Line(80, 228, 80, 243, $style);
      $pdf->SetFont('helveticaB', '',7);
      $pdf->writeHTMLCell(110, 5, 11, 229 ,"<p>FECHA INSPECCION INTERNA Y EXTERNA:  </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(110, 5, 11, 234 ,"<p>FECHA CITACION A REUNION:  </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(110, 5, 11, 239 ,"<p>FECHA MAXIMA DE LA EMISION DE LA RESOLUCIÓN:      </p>", 0, 1, 0, true, 'L',  true);
      $pdf->SetFont('helveticaB', '',6);
      $pdf->writeHTMLCell(110, 5, 131, 229 ,"<p>HORA (RANGO DE 2 HORAS):     </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(110, 5, 131, 234 ,"<p>HORA:     </p>", 0, 1, 0, true, 'L',  true);
      $pdf->SetFont('helvetica', '',7);
      $pdf->writeHTMLCell(110, 5, 85, 234 ,"<p>".$conciliacion['CNCFCH']."</p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(110, 5, 85, 239 ,"<p>".$reclamo['RSLFCHMAXEMI']."</p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(110, 5, 140, 237 ,"<p>".$conciliacion['CNCHORINI']."</p>", 0, 1, 0, true, 'L',  true);
      // FIRMA Y HUELLA DIGITAL
      $pdf->Line(90, 245, 90, 264, $style);
      $pdf->Line(90, 264, 110, 264, $style);
      $pdf->Line(110, 264, 110, 245, $style);
      $pdf->Line(110, 245, 90, 245, $style);
      $pdf->Line(5, 264, 70, 264, $style);
      $pdf->SetFont('helveticaB', '',7);
      $pdf->writeHTMLCell(110, 5, 26, 265 ,"<p>Firma del Reclamante</p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(110, 5, 81, 265 ,"<p>Huella Digital * (Indice derecho)</p>", 0, 1, 0, true, 'L',  true);
      $pdf->SetFont('helvetica', '',7);
      $pdf->writeHTMLCell(110, 5, 7, 270 ,"<p>(*) En caso de no saber firmar o estar impedido bastará con la huella digital</p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(180, 5, 7, 273 ,"<p>(*) Puede realizar el seguimiento a su reclamo desde www.sedalib.com.pe, ingresando la 'clave web' impresa en la parte superior derecha de esta ficha</p>", 0, 1, 0, true, 'L',  true);
      return $pdf;
    }

    function imprimir_conciliacion($pdf,$conciliacion,$reclamo, $reclamante, $descri_problema){
      $style = array('width' => 0.20, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
      $pdf->Image( base_url()."img/logo4.jpg", 5, 5, 45, 12, '', '', '', false, 300, '', false, false, 0);
      $pdf->SetFont('helveticaB', '',14);
      $pdf->writeHTMLCell(170, 5, 65, 10 ,"<p>ACTA DE REUNIÓN DE NEGOCIACIÓN</p>", 0, 1, 0, true, 'L',  true);
       // CODIGO DE RECLAMO
       $pdf->Line(120, 20 , 120, 30 , $style);
       $pdf->Line(120, 30 ,206, 30 , $style);
       $pdf->Line(206, 30 ,206, 20 , $style);
       $pdf->Line(206, 20 ,120, 20, $style);
       $pdf->SetFont('helveticaB', '',8);
       $pdf->writeHTMLCell(70, 5, 150, 20 ,"<p>Nro. reclamo</p>", 0, 1, 0, true, 'L',  true);
       $pdf->SetFont('helvetica', '',8);
       $pdf->writeHTMLCell(160, 5, 143, 23 ,"<p>".$reclamo['EMPCOD'].' - '.$reclamo['OFICOD'].' - '.$reclamo['ARECOD'].' - '.$reclamo['CTDCOD'].' - '.$reclamo['DOCCOD'].' - '.$reclamo['SERNRO'].'- <strong style="font-size:18px;">'.$reclamo['RECID']."</strong></p>", 0, 1, 0, true, 'L',  true);
       // DATOS DEL REPRESENTANTE 
       $pdf->Line(5, 32 , 5, 52 , $style);
       $pdf->Line(5, 52 ,206, 52 , $style);
       $pdf->Line(206, 52 ,206, 32 , $style);
       $pdf->Line(206, 32 ,5, 32, $style);
       $pdf->Line(5, 37 ,206, 37 , $style);
       $pdf->Line(5, 42 ,206, 42 , $style);
       $pdf->Line(5, 47 ,206, 47 , $style);
       $pdf->Line(120, 37 ,120, 47, $style);
       $pdf->Line(165, 37 ,165, 47, $style);
       $pdf->SetFont('helveticaB', '',7);
       $pdf->writeHTMLCell(70, 5, 11, 33 ,"<p>NOMBRE DEL RECLAMANTE O SU REPRESENTANTE</p>", 0, 1, 0, true, 'L',  true);
       $pdf->writeHTMLCell(70, 5, 50, 43 ,"<p>Apellido y nombres</p>", 0, 1, 0, true, 'L',  true);
       $pdf->writeHTMLCell(70, 5, 140, 43 ,"<p>DNI</p>", 0, 1, 0, true, 'L',  true);
       $pdf->writeHTMLCell(70, 5, 175, 43 ,"<p>SUMINISTRO</p>", 0, 1, 0, true, 'L',  true);
       $pdf->writeHTMLCell(70, 5, 11, 48 ,"<p>RAZÓN SOCIAL</p>", 0, 1, 0, true, 'L',  true);
       $pdf->SetFont('helvetica', '',7);
       $pdf->writeHTMLCell(70, 5, 8, 38 ,"<p>".$conciliacion['CNCPDNOM']."</p>", 0, 1, 0, true, 'L',  true);
       $pdf->writeHTMLCell(70, 5, 125, 38 ,"<p>".$conciliacion['CNCPDDNI']."</p>", 0, 1, 0, true, 'L',  true);
       $pdf->writeHTMLCell(70, 5, 165, 38 ,"<p>".$reclamo['UUCOD']."</p>", 0, 1, 0, true, 'L',  true);
       $pdf->writeHTMLCell(70, 5,  35, 48 ,"<p>".(is_null($reclamante['PRERAZSOC'])? '': trim($reclamante['PRERAZSOC']) )." </p>", 0, 1, 0, true, 'L',  true);
       // DATOS DE LA EPS
       $pdf->Line(5, 54 , 5, 74 , $style);
       $pdf->Line(5, 74 ,206, 74 , $style);
       $pdf->Line(206, 74 ,206, 54 , $style);
       $pdf->Line(206, 54 ,5, 54, $style);
       $pdf->Line(5, 59 ,206, 59 , $style);
       $pdf->Line(5, 64 ,206, 64 , $style);
       $pdf->Line(5, 69 ,206, 69 , $style);
       $pdf->Line(150, 59 ,150, 69, $style);
       $pdf->SetFont('helveticaB', '',7);
       $pdf->writeHTMLCell(70, 5, 11, 55 ,"<p>NOMBRE DEL REPRESENTANTE DE LA EPS</p>", 0, 1, 0, true, 'L',  true);
       $pdf->writeHTMLCell(70, 5, 70, 65 ,"<p>Apellido y nombres</p>", 0, 1, 0, true, 'L',  true);
       $pdf->writeHTMLCell(70, 5, 175, 65 ,"<p>DNI</p>", 0, 1, 0, true, 'L',  true);
       $pdf->writeHTMLCell(120, 5, 11, 70 ,"<p>Facultado por: (Documento, cargo, etc., segun sea el caso):
       </p>", 0, 1, 0, true, 'L',  true);
       $pdf->SetFont('helvetica', '',7);
       $pdf->writeHTMLCell(70, 5, 20, 60 ,"<p>". $_SESSION['user_nom']."</p>", 0, 1, 0, true, 'L',  true);
       $pdf->writeHTMLCell(120, 5, 90, 70 ,"<p>". $conciliacion['CNCPDDOC']." </p>", 0, 1, 0, true, 'L',  true);
       // HORA PROGRAMADA
       $pdf->Line(5, 76 , 5, 86 , $style);
       $pdf->Line(5, 86 ,206, 86 , $style);
       $pdf->Line(206, 86 ,206, 76 , $style);
       $pdf->Line(206, 76 ,5, 76, $style);
       $pdf->Line(5, 81 ,206, 81 , $style);
       $pdf->Line(50, 76 ,50, 86, $style);
       $pdf->Line(100, 76 ,100, 86, $style);
       $pdf->Line(150, 76 ,150, 86, $style);
       $pdf->SetFont('helveticaB', '',7);
       $pdf->writeHTMLCell(70, 5, 11, 77 ,"<p>Hora Programada:</p>", 0, 1, 0, true, 'L',  true);
       $pdf->writeHTMLCell(70, 5, 11, 82 ,"<p>Hora de Inicio: </p>", 0, 1, 0, true, 'L',  true);
       $pdf->writeHTMLCell(70, 5, 105, 77 ,"<p>Fecha prog. concilia:</p>", 0, 1, 0, true, 'L',  true);
       $pdf->writeHTMLCell(70, 5, 105, 82 ,"<p>Hora de término:</p>", 0, 1, 0, true, 'L',  true);
       $pdf->SetFont('helvetica', '',7);
       $pdf->writeHTMLCell(70, 5, 50, 77 ,"<p>". $conciliacion['CNCHORINI']."</p>", 0, 1, 0, true, 'L',  true);
       $pdf->writeHTMLCell(70, 5, 50, 82 ,"<p>". $conciliacion['CNCHORINIREAL']." </p>", 0, 1, 0, true, 'L',  true);
       $pdf->writeHTMLCell(70, 5, 155, 77 ,"<p>". $conciliacion['CNCFCH']."</p>", 0, 1, 0, true, 'L',  true);
       $pdf->writeHTMLCell(70, 5, 155, 82 ,"<p>". $conciliacion['CNCHORFIN']."</p>", 0, 1, 0, true, 'L',  true);
       // MATERIA DE RECLAMO
       $pdf->Line(5, 88 , 5, 125 , $style);
       $pdf->Line(5, 125 ,206, 125 , $style);
       $pdf->Line(206, 125 ,206, 88 , $style);
       $pdf->Line(206, 88 ,5, 88, $style);
       $pdf->Line(5, 93 ,206, 93 , $style);
       $pdf->Line(5, 98 ,206, 98 , $style);
       $pdf->Line(50, 93 ,50, 125, $style);
       $pdf->Line(50, 109 ,206, 109 , $style);
       $pdf->Line(50, 114 ,206, 114 , $style);
       $pdf->SetFont('helveticaB', '',7);
       $pdf->writeHTMLCell(70, 5, 11, 89 ,"<p>Materia del Reclamo </p>", 0, 1, 0, true, 'L',  true);
       $pdf->writeHTMLCell(70, 5, 11, 94 ,"<p>Tipo de Reclamo</p>", 0, 1, 0, true, 'L',  true);

       $pdf->writeHTMLCell(70, 5, 52, 94 ,"<p>Descripción del reclamo </p>", 0, 1, 0, true, 'L',  true);
       $pdf->writeHTMLCell(70, 5, 52, 110 ,"<p>Fundamento del reclamo</p>", 0, 1, 0, true, 'L',  true);
       $pdf->SetFont('helvetica', '',7);
       $pdf->writeHTMLCell(70, 5, 8, 99 ,"<p>".$descri_problema[0]['TIPPROBDESC']."</p>", 0, 1, 0, true, 'L',  true);
       $pdf->writeHTMLCell(70, 5, 50, 99 ,"<p>".$reclamo['RECDESC']."</p>", 0, 1, 0, true, 'L',  true);
       $pdf->writeHTMLCell(70, 5, 50, 115 ,"<p>".$reclamo['RECFUNDA']."</p>", 0, 1, 0, true, 'L',  true);
       // PRUEBAS DE LA EPS
       $pdf->Line(5, 127 , 5, 155 , $style);
       $pdf->Line(5, 155 ,206, 155 , $style);
       $pdf->Line(206, 155 ,206, 127 , $style);
       $pdf->Line(206, 127 ,5, 127, $style);
       $pdf->Line(5, 132 ,206, 132 , $style);
       $pdf->SetFont('helveticaB', '',7);
       $pdf->writeHTMLCell(70, 5, 11, 128 ,"<p>PROPUESTA DE LA EPS</p>", 0, 1, 0, true, 'L',  true);
       $pdf->SetFont('helvetica', '',7);
       $pdf->writeHTMLCell(70, 5, 8, 133 ,"<p>". $conciliacion['CNCFOREPS']."</p>", 0, 1, 0, true, 'L',  true);
       // PROPUESTA DEL RECLAMANTE
       $pdf->Line(5, 157 , 5, 185 , $style);
       $pdf->Line(5, 185 ,206, 185 , $style);
       $pdf->Line(206, 185 ,206, 157 , $style);
       $pdf->Line(206, 157 ,5, 157, $style);
       $pdf->Line(5, 162 ,206, 162 , $style);
       $pdf->SetFont('helveticaB', '',7);
       $pdf->writeHTMLCell(70, 5, 11, 158 ,"<p>PROPUESTA DEL RECLAMANTE </p>", 0, 1, 0, true, 'L',  true);
       $pdf->SetFont('helvetica', '',7);
       $pdf->writeHTMLCell(70, 5, 8, 163 ,"<p>". $conciliacion['CNCFORREC']."</p>", 0, 1, 0, true, 'L',  true);
       // PUNTOS EN ACUERDO Y DESACUERDO
       $pdf->Line(5, 187 , 5, 210 , $style);
       $pdf->Line(5, 210 ,206, 210 , $style);
       $pdf->Line(206, 210 ,206, 187 , $style);
       $pdf->Line(206, 187 ,5, 187, $style);
       $pdf->Line(5, 192 ,206, 192 , $style);
       $pdf->Line(100, 187, 100, 210, $style);
       $pdf->SetFont('helveticaB', '',7);
       $pdf->writeHTMLCell(70, 5, 11, 188 ,"<p>PUNTOS DE ACUERDO </p>", 0, 1, 0, true, 'L',  true);
       $pdf->writeHTMLCell(70, 5, 105, 188 ,"<p>PUNTOS EN DESACUERDO </p>", 0, 1, 0, true, 'L',  true);
       $pdf->SetFont('helvetica', '',7);
       $pdf->writeHTMLCell(120, 5, 8, 193 ,"<p>". $conciliacion['CNCPTOSACU']."</p>", 0, 1, 0, true, 'L',  true);
       $pdf->writeHTMLCell(120, 5, 102, 193 ,"<p>". $conciliacion['CNCPTOSDES']."</p>", 0, 1, 0, true, 'L',  true);
       //  SUBSISTE EL RECLAMO 
       $pdf->Line(5, 212 , 5, 222 , $style);
       $pdf->Line(5, 222 ,206, 222 , $style);
       $pdf->Line(206, 222 ,206, 212 , $style);
       $pdf->Line(206, 212 ,5, 212, $style);
       $pdf->Line(5, 217 ,206, 217 , $style);
       $pdf->Line(50, 212 ,50, 217 , $style);
       $pdf->SetFont('helveticaB', '',7);
       $pdf->writeHTMLCell(70, 5, 11, 213 ,"<p>¿SUBSISTE EL RECLAMO? </p>", 0, 1, 0, true, 'L',  true);
       $pdf->writeHTMLCell(70, 5, 60, 213 ,"<p>".(($conciliacion['CNCSUBSIS'] == 'S')? 'SI' : 'NO' )." </p>", 0, 1, 0, true, 'L',  true);
       $pdf->writeHTMLCell(190, 5, 11, 218 ,"<p>Si el Reclamante marca la casilla 'NO' implica el desistimiento del reclamo, bajo condiciones expresadas en el presente documento. </p>", 0, 1, 0, true, 'L',  true);
       // OBSERVACIONES DEL RECLAMANTE O EPS
       $pdf->Line(5, 224 , 5, 245 , $style);
       $pdf->Line(5, 245 ,206, 245 , $style);
       $pdf->Line(206, 245 ,206, 224 , $style);
       $pdf->Line(206, 224 ,5, 224, $style);
       $pdf->Line(5, 229 ,206, 229 , $style);
       $pdf->SetFont('helveticaB', '',7);
       $pdf->writeHTMLCell(70, 5, 11, 225 ,"<p>OBSERVACIONES DEL RECLAMANTE O DE LA EPS</p>", 0, 1, 0, true, 'L',  true);
       $pdf->SetFont('helvetica', '',7);
       $pdf->writeHTMLCell(120, 5, 8, 230 ,"<p>".$conciliacion['CNCOBSREC']."</p>", 0, 1, 0, true, 'L',  true);
       // PARTE DE FIRMA DEL RECLAMANTE 
       $pdf->Line(80, 247 , 80, 277 , $style);
       $pdf->Line(80, 277 ,110, 277 , $style);
       $pdf->Line(110, 277 ,110, 247 , $style);
       $pdf->Line(110, 247 ,80, 247, $style);
       $pdf->Line(5, 277 ,60, 277 , $style);
       $pdf->Line(140, 277 ,195, 277 , $style);
       $pdf->SetFont('helveticaB', '',7);
       $pdf->writeHTMLCell(70, 5, 8, 278 ,"<p>Firma del Reclamante o su representante </p>", 0, 1, 0, true, 'L',  true);
       $pdf->writeHTMLCell(70, 5, 76, 278 ,"<p>Huella Digital (índice derecho)  </p>", 0, 1, 0, true, 'L',  true);
       $pdf->writeHTMLCell(70, 5, 147, 278 ,"<p>Firma del Representante de la EPS  </p>", 0, 1, 0, true, 'L',  true);
      return $pdf;
    }

    function imprimir_cargo($pdf){
      $style = array('width' => 0.20, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
      $pdf->Image( base_url()."img/logo4.jpg", 3, 3, 40, 10, '', '', '', false, 300, '', false, false, 0);
      $pdf->SetFont('helveticaB', '',12);
      $pdf->writeHTMLCell(170, 5, 42, 12 ,"<p>CONSTANCIA DE RECEPCIÓN</p>", 0, 1, 0, true, 'L',  true);
      //$pdf->Line(40, 17, 110, 17, $style);
      $pdf->SetFont('helvetica', '',8);
      $pdf->writeHTMLCell(90, 5, 103, 4 ,"<p>Fecha de Impresión :".date("d/m/Y")."</p>", 0, 1, 0, true, 'L',  true);
      $pdf->SetFont('helveticaB', '',9);
      $pdf->writeHTMLCell(70, 5, 5, 20 ,"<p> » AREA DE ENVÍO:  </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 5, 5, 26 ,"<p> » PERSONA DE ENVÍO: </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 5, 5, 32 ,"<p> » FECHA DE ENVÍO: </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 5, 80, 32 ,"<p> » HORA DE ENVÍO: </p>", 0, 1, 0, true, 'L',  true);
      $pdf->Line(5, 37, 143, 37, $style);
      $pdf->writeHTMLCell(70, 5, 5, 40 ,"<p> » AREA DE RECEPCIÓN: </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 5, 5, 46 ,"<p> » PERSONA QUE RECEPCIONÓ: </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 5, 5, 52 ,"<p> » FECHA DE RECEPCIÓN: </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 5, 80, 52 ,"<p> » HORA DE RECEPCIÓN: </p>", 0, 1, 0, true, 'L',  true);
      $pdf->Line(5, 57, 143, 57, $style);
      $pdf->writeHTMLCell(70, 5, 5, 60 ,"<p> » ASUNTO: </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 5, 5, 90 ,"<p> » OBSERVACIÓN: </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 5, 5, 120 ,"<p> » CONTENIDO: </p>", 0, 1, 0, true, 'L',  true);
      $pdf->SetFont('helvetica', '',7.5);
      $pdf->writeHTMLCell(130, 5, 38, 20 ,"<p> SUBGERENCIA DE INFORMATICA E INFORMACIÓN  </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 5, 43, 26 ,"<p> EMERSON ALEXANDER </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 5, 38, 32 ,"<p> 23 DE OCTUBRE DEL 2019 </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 5, 110, 32 ,"<p> 10:20:25 </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(130, 5, 45, 40 ,"<p> SUBGERENCIA DE INFORMATICA E INFORMACIÓN  </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 5, 56, 46 ,"<p> EMERSON ALEXANDER </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 5, 45, 52 ,"<p> 23 DE OCTUBRE DEL 2019 </p>", 0, 1, 0, true, 'L',  true);
      $pdf->writeHTMLCell(70, 5, 119, 52 ,"<p> 10:20:25 </p>", 0, 1, 0, true, 'L',  true);
      //$pdf->Image( base_url()."img/sedalito.png", 20, 40, 50, 100, '', '', '', false, 300, '', false, false, 0);
      return $pdf;
    }

}
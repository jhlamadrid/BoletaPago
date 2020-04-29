<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class tcp_not_atipico {
   
 
    function cargar() {
        include_once APPPATH.'third_party/tcpdf/tcpdf.php';
        //include_once APPPATH.'third_party/dompdf/include/dompdf.cls.php' 
        return new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    }

    //graficamos el recibo 
    public function cargo_plantilla($notifica, $nombre, $domicilio, $ciclo, $suministro, $periodo, $lectura, $consumo, $cadena,$fecha_lectura,$i, $fecha_sup, $hora_inicio,$hora_fin){
      $style = array('width' => 0.25, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
      //TIPO DOCUMENTO 
     $notifica->Image( base_url().'frontend/excel/img_notificacion.png', 4, 3, 40, 12, '', '', '', false, 300, '', false, false, 0);
       $notifica->SetXY(170,7); 
       $notifica->SetFont('helveticaB', '', 8);
       $notifica->Write(0, 'ORDEN :', '', 0, 'L', true, 0, false, false, 0);
       $notifica->SetXY(182,7); 
       $notifica->SetFont('helvetica', '', 8);
       $notifica->Write(0, $ciclo.'-'.$i, '', 0, 'L', true, 0, false, false, 0);
       $notifica->SetXY(67,15); 
       $notifica->SetFont('helveticaB', '', 11);
       $notifica->Write(0, 'NOTIFICACIÓN POR CONSUMO ATIPICO', '', 0, 'L', true, 0, false, false, 0);
       $notifica->SetXY(15,25); 
       $notifica->SetFont('helveticaB', '', 8);
       $notifica->Write(0, 'CLIENTE :', '', 0, 'L', true, 0, false, false, 0);
       $notifica->SetXY(35,25); 
       $notifica->SetFont('helvetica', '', 8);
       $notifica->Write(0, $nombre, '', 0, 'L', true, 0, false, false, 0);
       $notifica->SetXY(15,30); 
       $notifica->SetFont('helveticaB', '', 8);
       $notifica->Write(0, 'DOMICILIO :', '', 0, 'L', true, 0, false, false, 0);
       $notifica->SetXY(35,30); 
       $notifica->SetFont('helvetica', '', 8);
       $notifica->Write(0, $domicilio, '', 0, 'L', true, 0, false, false, 0);
       $notifica->SetXY(15,35); 
       $notifica->SetFont('helveticaB', '', 8);
       $notifica->Write(0, 'CICLO :', '', 0, 'L', true, 0, false, false, 0);
       $notifica->SetXY(35,35); 
       $notifica->SetFont('helvetica', '', 8);
       $notifica->Write(0, $ciclo, '', 0, 'L', true, 0, false, false, 0);
       $notifica->SetXY(125,25); 
       $notifica->SetFont('helveticaB', '', 8);
       $notifica->Write(0, 'CODIGO :', '', 0, 'L', true, 0, false, false, 0);
       $notifica->SetXY(140,25); 
       $notifica->SetFont('helvetica', '', 8);
       $notifica->Write(0, $suministro, '', 0, 'L', true, 0, false, false, 0);
       $notifica->SetXY(125,35); 
       $notifica->SetFont('helveticaB', '', 8);
       $notifica->Write(0, 'PERIODO :', '', 0, 'L', true, 0, false, false, 0);
       $notifica->SetXY(140,35); 
       $notifica->SetFont('helvetica', '', 8);
       $notifica->Write(0, $periodo, '', 0, 'L', true, 0, false, false, 0);
       $notifica->SetXY(15,45); 
       $notifica->SetFont('helveticaB', '', 8);
       $notifica->Write(0, 'Estimado Cliente :', '', 0, 'L', true, 0, false, false, 0);
       $notifica->SetFont('helvetica', '', 8);
       $notifica->writeHTMLCell(180,  0, 15, 50,'<p style="text-align:justify;" > Por la presente hacemos de su conocimiento  que en el proceso de toma de lectura del presente mes se ha determindado  que su medidor ha registrado un consumo de '.$consumo.' metros cúbicos, el cual "supera en más del 100% al promedio histórico de consumo y es igual o mayor a 2 asignaciones de consumo" (Art. 88, Res. N° 011-2007-SUNASS-CD), teniendo el medidor un registro actual de '.$lectura.'. Al haberse detectado este mayor volumen estaremos realizando la inspección correspondiente a su predio el día '.$fecha_sup.' a horas '.$hora_inicio.' a '.$hora_fin.', a fin de determinar las causas de este mayor consumo, por lo que le solicitamos le brinde las facilidades del caso al inspector,debidamente identificado, para realizar la inspección y recomendarle los correctivos a realizar. </p>', 0, 1, 0, true, 'L',  true);
       $notifica->SetFont('helveticaB', '', 9);
       $notifica->writeHTMLCell(180,  0, 78, 75,'<u>RECEPCIÓN DE LA NOTIFICACIÓN</u>', 0, 1, 0, true, 'L',  true);
       $notifica->SetFont('helvetica', '', 8);
       $notifica->writeHTMLCell(180,  0, 15, 82,'<table border="0.5"><tr><td style="width:60%;" height="20"></td><td height="20" style="width:20%;"></td><td height="20" style="width:20%;"></td></tr><tr><td align="center">Reclamante(nombre)</td><td align="center">DNI</td><td align="center">Firma</td></tr></table>', 0, 1, 0, true, 'L',  true);
       $notifica->writeHTMLCell(180,  0, 15, 95,'<table border="0.5"><tr><td style="width:60%;" height="20"></td><td height="20" style="width:20%;"></td><td height="20" style="width:20%;"></td></tr><tr><td align="center">Persona distinta(nombre)</td><td align="center">DNI</td><td align="center">Firma</td></tr></table>', 0, 1, 0, true, 'L',  true);
       //OBSERVACIONES
       $notifica->Line(16, 110, 16, 125, $style);
       $notifica->Line(16, 110, 194, 110, $style);
       $notifica->Line(16, 125, 194, 125, $style);
       $notifica->Line(194, 110, 194, 125, $style);
       $notifica->SetXY(17,110); 
       $notifica->SetFont('helveticaB', '', 6);
       $notifica->Write(0, 'OBSERVACIONES', '', 0, 'L', true, 0, false, false, 0);
       $notifica->Line(17, 115, 190, 115, $style);
       $notifica->Line(17, 120, 190, 120, $style);
       // SECCION DE NO SER POSIBLE LAS NOTIFICACIONES
       $notifica->Line(16, 127, 16, 145, $style);
       $notifica->Line(16, 127, 194, 127, $style);
       $notifica->Line(16, 145, 194, 145, $style);
       $notifica->Line(194, 127, 194, 145, $style);
       $notifica->SetXY(17,127); 
       $notifica->Write(0, 'DE NO SER POSIBLE REALIZAR LA NOTIFICACION', '', 0, 'L', true, 0, false, false, 0);
       $notifica->SetXY(17,132);
       $notifica->SetFont('helvetica', '', 6); 
       $notifica->Write(0, 'Características de la fachada del inmueble', '', 0, 'L', true, 0, false, false, 0);
       $notifica->Line(60, 134, 190, 134, $style);
       $notifica->Line(17, 138, 190, 138, $style);
       $notifica->SetXY(17,140);
       $notifica->Write(0, 'Numero de suministro de energía eléctrica', '', 0, 'L', true, 0, false, false, 0);
       $notifica->Line(60, 142, 190, 142, $style);
       //SECCION DE LA IMAGEN DE MEDIDOR
       if($cadena != null){
             $notifica->Line(16, 148, 16, 230, $style);
             $notifica->Line(16, 148, 194, 148, $style);
             $notifica->Line(16, 230, 194, 230, $style);
             $notifica->Line(194, 148, 194, 230, $style);
             $notifica->Image( $cadena , 50, 156, 110, 70, '', '', '', false, 300, '', false, false, 0);
             $notifica->SetFont('helvetica', '', 8);
             $notifica->SetXY(72,150); 
             $notifica->Write(0, 'Fecha de Toma de Lectura : '.substr($fecha_lectura, 0, 10), '', 0, 'L', true, 0, false, false, 0);
             //DATOS DE NOTIFICADOR
             $notifica->SetFont('helvetica', '', 8);
             $notifica->writeHTMLCell(180,  0, 15, 235,'<table border="0.5"><tr><td height="20" style="width:30%;"></td><td height="20" style="width:10%;"></td><td height="20" style="width:15%;"></td><td style="width:15%;" height="20"></td><td height="20" style="width:15%;"></td><td height="20" style="width:15%;"></td></tr><tr><td height="15" align="center">Notificador(Nombre y Firma)</td><td align="center" height="15">Código</td><td align="center" height="15">DNI</td><td height="15" align="center">Fecha de emisión</td><td height="15" align="center">Fecha de entrega</td><td align="center">Hora</td></tr></table>', 0, 1, 0, true, 'L',  true);
             //PARTE DE LA BASE
             $notifica->SetXY(16,280); 
             $notifica->SetFont('helveticaB', '', 6);
             $notifica->Write(0, 'SUBGERENTE DE PROG. Y CTRL. DE VENTAS', '', 0, 'L', true, 0, false, false, 0);
             $notifica->Line(16, 280, 65, 280, $style);
             $notifica->Image( base_url().'frontend/excel/firma.jpg', 25, 249, 30, 30, '', '', '', false, 300, '', false, false, 0);
              $notifica->SetFont('helveticaB', '', 7);
             $notifica->writeHTMLCell(60,  0, 135, 260,'<table border="0.5"><tr><td align="center"> PARA CUALQUIER CONSULTA :</td></tr></table>', 0, 1, 0, true, 'L',  true);
             $notifica->SetXY(62,260);
             $notifica->SetFont('code30F9', '', 37, '', false);
             $notifica->Write(0, '*'.$suministro.'*', '', 0, 'L', true, 0, false, false, 0);
             //$notifica->write1DBarcode("*".$suministro."*", 'C128', '', '', 63, 18, 0.4, '', 'N');
             $notifica->SetXY(138,265); 
             $notifica->SetFont('helveticaB', '', 7);
             $notifica->Write(0, 'SEDALIB S.A.', '', 0, 'L', true, 0, false, false, 0);
             $notifica->SetXY(139,268); 
             $notifica->Write(0, 'Call Center', '', 0, 'L', true, 0, false, false, 0);
             $notifica->SetXY(139,271); 
             $notifica->Write(0, '044-480555', '', 0, 'L', true, 0, false, false, 0);
             //VEOLIA
             $notifica->SetXY(164,265); 
             $notifica->Write(0, 'VEOLIA Trujillo SIAC', '', 0, 'L', true, 0, false, false, 0);
             $notifica->SetFont('helveticaB', '', 5);
             $notifica->SetXY(158,268); 
             $notifica->Write(0, 'Empresa Colaboradora de SEDALIB S.A.', '', 0, 'L', true, 0, false, false, 0);
             $notifica->SetXY(166,271); 
             $notifica->SetFont('helveticaB', '', 7);
             $notifica->Write(0, '044-548348', '', 0, 'L', true, 0, false, false, 0);
             $notifica->SetXY(166,274); 
             $notifica->SetFont('helveticaB', '', 7);
             $notifica->Write(0, '965351622', '', 0, 'L', true, 0, false, false, 0);
             return $notifica;  
       } else{
            $notifica->SetFont('helvetica', '', 8);
            //DATOS DE NOTIFICADOR
             $notifica->SetFont('helvetica', '', 8);
             $notifica->writeHTMLCell(180,  0, 15, 160,'<table border="0.5"><tr><td height="25" style="width:30%;"></td><td height="25" style="width:10%;"></td><td height="25" style="width:15%;"></td><td style="width:15%;" height="25"></td><td height="25" style="width:15%;"></td><td height="25" style="width:15%;"></td></tr><tr><td height="15" align="center">Notificador(Nombre y Firma)</td><td align="center" height="15">Código</td><td align="center" height="15">DNI</td><td height="15" align="center">Fecha de emisión</td><td height="15" align="center">Fecha de entrega</td><td align="center">Hora</td></tr></table>', 0, 1, 0, true, 'L',  true);
             //PARTE DE LA BASE
             $notifica->SetXY(16,217); 
             $notifica->SetFont('helveticaB', '', 6);
             $notifica->Write(0, 'SUBGERENTE DE PROG. Y CTRL. DE VENTAS', '', 0, 'L', true, 0, false, false, 0);
             $notifica->Line(16, 215, 65, 215, $style);
             $notifica->Image( base_url().'frontend/excel/firma.jpg', 25, 183, 30, 30, '', '', '', false, 300, '', false, false, 0);
              $notifica->SetFont('helveticaB', '', 7);
             $notifica->writeHTMLCell(60,  0, 135, 195,'<table border="0.5"><tr><td align="center"> PARA CUALQUIER CONSULTA :</td></tr></table>', 0, 1, 0, true, 'L',  true);
             $notifica->SetXY(60,190);
             $notifica->SetFont('code30F9', '', 37, '', false);
             $notifica->Write(0, '*'.$suministro.'*', '', 0, 'L', true, 0, false, false, 0);
             //$notifica->write1DBarcode("*".$suministro."*", 'C128', '', '', 63, 18, 0.4, '', 'N');
             $notifica->SetXY(138,200); 
             $notifica->SetFont('helveticaB', '', 7);
             $notifica->Write(0, 'SEDALIB S.A.', '', 0, 'L', true, 0, false, false, 0);
             $notifica->SetXY(139,204); 
             $notifica->Write(0, 'Call Center', '', 0, 'L', true, 0, false, false, 0);
             $notifica->SetXY(139,208); 
             $notifica->Write(0, '044-480555', '', 0, 'L', true, 0, false, false, 0);
             //VEOLIA
             $notifica->SetXY(164,200); 
             $notifica->Write(0, 'VEOLIA Trujillo SIAC', '', 0, 'L', true, 0, false, false, 0);
             $notifica->SetFont('helveticaB', '', 5);
             $notifica->SetXY(158,203); 
             $notifica->Write(0, 'Empresa Colaboradora de SEDALIB S.A.', '', 0, 'L', true, 0, false, false, 0);
             $notifica->SetXY(166,206); 
             $notifica->SetFont('helveticaB', '', 7);
             $notifica->Write(0, '044-548348', '', 0, 'L', true, 0, false, false, 0);
             $notifica->SetXY(166,209); 
             $notifica->SetFont('helveticaB', '', 7);
             $notifica->Write(0, '986977027', '', 0, 'L', true, 0, false, false, 0);
            return $notifica;  


       }
       
    }
}
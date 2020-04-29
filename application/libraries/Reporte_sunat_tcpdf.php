<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

include_once APPPATH.'third_party/tcpdf/tcpdf.php';
class Reporte_sunat_tcpdf extends TCPDF {

    public $desde ; 
    public $hasta;
    public $fecha;
    public $hora ,  $periodo , $nomMes, $anio;
    public $meses = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SETIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
    public function agregar_datos($desde,$hasta,$fecha,$hora){
      $this->desde = $desde;
      $this->hasta = $hasta;
      $this->fecha = $fecha;
      $this->hora = $hora;
      $this->periodo = substr($hasta, 3, 2);
      $this->anio = substr($hasta, 6, 4);
      $this->nomMes = $this->meses[ ((int)($this->periodo))-1];
    }
    //Page header
    public function Header() {
        // Logo
        $this->Image(base_url().'frontend/recibo/favicon.png', 5, 5, 10, 15, '', '', '', false, 300, '', false, false, 0);
        // Set font
        $this->SetFont('helvetica', '', 7);
        $this->writeHTMLCell(25,  12, 20, 8,"<p><strong>SEDALIB S.A.</strong></p>", 0, 1, 0, true, 'L',  true);
        $this->writeHTMLCell(28,  12, 20, 12,"<p><strong>R.U.C. </strong> 20131911310</p>", 0, 1, 0, true, 'L',  true);
        $this->SetFont('helveticaB', '', 12);
        $this->writeHTMLCell(58,  12, 115, 4,"<p>REGISTRO DE VENTAS </p>", 0, 1, 0, true, 'L',  true);
        $this->SetFont('helvetica', '', 7);
        //$this->writeHTMLCell(58,  12, 124, 10,"<p><strong>PERIODO ".$this->nomMes." 2017 </strong> </p>", 0, 1, 0, true, 'L',  true);
        $this->writeHTMLCell(58,  12, 124, 10,"<p><strong>PERIODO ".$this->nomMes." ".$this->anio."</strong> </p>", 0, 1, 0, true, 'L',  true);
        $this->writeHTMLCell(40,  12, 260, 4,"<p><strong>FECHA : </strong>".$this->fecha."</p>", 0, 1, 0, true, 'L',  true);
        $this->writeHTMLCell(40,  12, 260, 8,"<p><strong>HORA : </strong>".$this->hora."</p>", 0, 1, 0, true, 'L',  true);
        $this->writeHTMLCell(40,  12, 260, 11,"<p><strong>PÁGINA : </strong>".$this->getAliasNumPage()."</p>", 0, 1, 0, true, 'L',  true);
       
    }

}

?>
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

include_once APPPATH.'third_party/tcpdf/tcpdf.php';
class Reporte_antiguo_tcpdf extends TCPDF {

    public $desde ; 
    public $hasta;
    public $fecha;
    public $hora;
    public $nombre;
    public function agregar_datos($desde,$hasta,$fecha,$hora,$nombre){
      $this->desde = $desde;
      $this->hasta = $hasta;
      $this->fecha = $fecha;
      $this->hora = $hora;
      $this->nombre = $nombre;
    }
    //Page header
    public function Header() {
        // Logo
        $this->Image(base_url().'frontend/recibo/favicon.png', 5, 5, 10, 15, '', '', '', false, 300, '', false, false, 0);
        // Set font
        $this->SetFont('helvetica', '', 7);
        $this->writeHTMLCell(25,  12, 20, 8,"<p><strong>SEDALIB S.A.</strong></p>", 0, 1, 0, true, 'L',  true);
        $this->writeHTMLCell(28,  12, 20, 12,"<p><strong>R.U.C. </strong> 20131911310</p>", 0, 1, 0, true, 'L',  true);
        $this->writeHTMLCell(58,  12, 20, 16,"<p><strong>Usuario: </strong> ".$this->nombre."</p>", 0, 1, 0, true, 'L',  true);
        $this->SetFont('helveticaB', '', 12);
        $this->writeHTMLCell(58,  12, 115, 4,"<p>REGISTRO DE VENTAS </p>", 0, 1, 0, true, 'L',  true);
        $this->SetFont('helvetica', '', 7);
        $this->writeHTMLCell(58,  12, 115, 10,"<p> DESDE ".$this->desde." HASTA ".$this->hasta."</p>", 0, 1, 0, true, 'L',  true);
        $this->writeHTMLCell(40,  12, 260, 4,"<p><strong>FECHA : </strong>".$this->fecha."</p>", 0, 1, 0, true, 'L',  true);
        $this->writeHTMLCell(40,  12, 260, 8,"<p><strong>HORA : </strong>".$this->hora."</p>", 0, 1, 0, true, 'L',  true);
       
    }

    // Page footer
    public function Footer() {
    	 $style = array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
		$this->Line(5, 199, 290, 199, $style);
        $this->SetFont('helvetica', '', 8);
         $this->writeHTMLCell(250,  12, 250, 200,"<p><strong>PAGINA </strong> ".$this->getAliasNumPage()." DE ".$this->getAliasNbPages()."</p>", 0, 1, 0, true, 'L',  true);
        
    }
}

?>
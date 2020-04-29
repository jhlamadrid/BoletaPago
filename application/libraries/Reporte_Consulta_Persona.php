<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

include_once APPPATH.'third_party/tcpdf/tcpdf.php';
class Reporte_Consulta_Persona extends TCPDF {

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
         // get the current page break margin
         $bMargin = $this->getBreakMargin();
         // get current auto-page-break mode
         $auto_page_break = $this->AutoPageBreak;
         // disable auto-page-break
         $this->SetAutoPageBreak(false, 0);
         // set bacground image
         $this->SetAlpha(0.3);
         $this->Image( base_url()."img/sedalito.png", 100, 40, 90, 110, '', '', '', false, 300, '', false, false, 0);
         $this->SetAlpha(1);
         // restore auto-page-break status
         $this->SetAutoPageBreak($auto_page_break, $bMargin);
         // set the starting point for the page content
         $this->setPageMark();
       
       
    }

}

?>
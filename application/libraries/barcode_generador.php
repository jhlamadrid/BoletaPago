<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class barcode_generador {
    
    function dompdf_pdf() {
        $CI = & get_instance();
        log_message('Debug', 'BARCODE class is loaded.');
    }
 
    function cargar() {
        include_once APPPATH.'third_party/barcode/barcode.class.php';
        //include_once APPPATH.'third_party/dompdf/include/dompdf.cls.php';

        /*$dompdf = new DOMPDF();
        $dompdf->load_html('hola');
		$dompdf->set_paper('letter', 'landscape'); 
		$dompdf->render();
		$dompdf->stream("hello_world.pdf");*/
        return new BARCODE();
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class boletaPago_ctrllr extends CI_Controller {

	public function __construct() {
		parent::__construct();
        $this->load->model('Buscar_model');
        $this->load->library('grafico_barras');
        $this->grafico_barras->cargar();
        $this->load->library('session');
        $this->load->helper('captcha');
        $this->load->helper('url');
	}
	public function index()
	{
		$this->load->helper('url');
        $random_number = substr(number_format(time() * rand(),0,'',''),0,6);
        // setting up captcha config
        $vals = array(
                 'word' => $random_number,
                 'img_path' => './captcha/',
                 'img_url' => base_url().'captcha/',
                 'img_width' => 200,
                 'img_height' => 50,
                 'font_size' =>  30,
                 'expiration' => 7200,
                 'colors'        => array(
                                            'background' => array(145, 216, 248),
                                            'border' => array(0,0,0),
                                            'text' => array(0, 0, 0),
                                            'grid' => array(255, 40, 40)
                                    )
                );
        $data['captcha'] = create_captcha($vals);
        $_SESSION['clave'] = $data['captcha']['word'];
		$this->load->view('BoletaPago/boleta_pago' , $data);
	}


    
}

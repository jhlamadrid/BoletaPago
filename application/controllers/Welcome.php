<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

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
		$this->load->view('welcome_message' , $data);
	}
	public function buscar(){
        $this->load->helper('url');
        $ajax = $this->input->get('ajax');
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
        $nuevo_captcha =  create_captcha($vals);
        if(!$ajax){
            $json = array('result' => false, 'tipo' => 'error', 'mensaje' => 'Debe acceder mediante ajax', 'titulo' => 'Ingreso restringido' );
            echo json_encode($json);
            return;
        }else{
            $suministro = $this->input->post('sumini'); // numero de DNI O RUC
            $periodo    = $this->input->post('periodo');
            $correo     = $this->input->post('corr'); // numero de documento
            $telefono   = $this->input->post('telf');
            $tipo       = $this->input->post('tip');
            // verifico suministro y periodo 
            if(ctype_digit($suministro) || ctype_digit($periodo) ){
                //verifico existencia de suministro
                $existe=true;
                if(strlen($suministro)==11){
                    $resultado = $this->Buscar_model->obtengo_dato_tam11($suministro);
                    if(!(count($resultado)>0)){
                        $existe = false;
                    }
                }else{
                    if(strlen($suministro)==7){
                        $resultado = $this->Buscar_model->obtengo_dato_nombre_tam7($suministro);
                        if(!(count($resultado)>0)){
                            $existe = false;
                        }
                    }
                }
                if($existe){
                    $datos= $this->Buscar_model->get_Recibo($suministro, $periodo);
                    if (count($datos)>0) {
                        $consumo= "";
                        $datos[0]['CLINOMBRE']= substr($datos[0]['CLINOMBRE'], 0, 6 );
                        if(trim($datos[0]['TIPIMP']) != "P" && trim($datos[0]['TIPIMP'])!= "A"){
                            if ($datos[0]['CONSUMO'] != 0 ) {
                              $consumo = str_pad($datos[0]['CONSUMO'],8, "0", STR_PAD_LEFT); 
                            }else{
                              $consumo="";
                            } 
                        }else{
                            $consumo = 0 ;
                        }
                        $consumo = $consumo ." ". trim($datos[0]['DESCRIREG']);
                        $total_pagar = number_format(str_replace(',', '.', $datos[0]['FACTOTAL']), 2, '.', '') ;
                        $deuda_anterior = 0;
                        if ($datos[0]['FACSALDO'] > 0) {
                            $deuda_anterior = number_format(str_replace(',', '.', $datos[0]['FACSALDO']), 2, '.', '') ;
                        }
                        $total= number_format(($total_pagar + $deuda_anterior), 2, '.', '');
                        // primero obtengo los datos del suministro
                        $relacion= $this->Buscar_model->get_Relacion_datos($suministro);
                        $caracteres_permitidos = '0123456789abcdefghijklmnopqrstuvwxyz';
                        $cadena_aleatoria      = substr(str_shuffle($caracteres_permitidos), 0, 20);
                        if(count($relacion)>0){
                            // INSERTO EL DETALLE 
                            $param_detalle = array(
                                'SUMINISTRO'      => $suministro,
                                'HORA_REGISTRO'   => date("H:i:s"),
                                'PERIODO'         => $periodo,
                                'CONTADOR'        => '',
                                'TIPO_OPCION'     => $tipo,
                                'CADENA_CODIGO'   => $cadena_aleatoria,
                                'FECHA_REGITRO'   => date("d/m/Y")
                            );

                            $detalle = $this->Buscar_model->set_detalle($param_detalle, $suministro, $periodo );
                            if($detalle== false){
                                $json = array('result' => false, 'mensaje' => "Ocurrio un error al modificar los datos " , 'captcha' => $nuevo_captcha ,'numero' => $random_number );
                                header('Access-Control-Allow-Origin: *');
                                header('Content-Type: application/x-json; charset=utf-8');
                                echo json_encode($json);
                                return;
                            }

                            $param_datos = array(
                                'HORA_REGISTRO'   => date("H:i:s"),
                                'FECHA_REGITRO'  => date("d/m/Y")
                            );
                            $bandera = false;
                            if($relacion[0]['EMAIL'] =='' && $correo !=''){
                                $param_datos['EMAIL'] = $correo;
                                $bandera = true;
                            }
                            if($relacion[0]['MOVIL_USUARIO'] =='' && $telefono !=''){
                                $param_datos['MOVIL_USUARIO'] = $telefono;
                                $bandera = true;
                            }

                            if($bandera){
                                $relacion= $this->Buscar_model->modificar_cliente($param_datos, $suministro);
                                if($relacion){
                                    if($tipo=='2'){
                                        $this->enviar_recibo($datos, $nuevo_captcha, $random_number, $suministro, $periodo, $correo, $tipo, $total, $consumo, $total_pagar, $cadena_aleatoria);
                                    }else{
                                        $json = array('result' => true, 'busqueda' => $datos , 'captcha' => $nuevo_captcha , 'numero' => $random_number, 'tipo' =>$tipo, 'total'=>$total, "total_recibo" =>$total_pagar,  "consumo"=>$consumo, "cadena"=>$cadena_aleatoria );
                                        header('Access-Control-Allow-Origin: *');
                                        header('Content-Type: application/x-json; charset=utf-8');
                                        echo json_encode($json);
                                    }
                                    
                                }else{
                                    $json = array('result' => false, 'mensaje' => "Ocurrio un error al modificar los datos " , 'captcha' => $nuevo_captcha ,'numero' => $random_number );
                                    header('Access-Control-Allow-Origin: *');
                                    header('Content-Type: application/x-json; charset=utf-8');
                                    echo json_encode($json);
                                }
                            }else{
                                if($tipo=='2'){
                                    $this->enviar_recibo($datos, $nuevo_captcha, $random_number, $suministro, $periodo, $correo, $tipo, $total, $consumo, $total_pagar, $cadena_aleatoria);
                                }else{
                                    $json = array('result' => true, 'busqueda' => $datos ,"cadena"=>$cadena_aleatoria, 'captcha' => $nuevo_captcha , 'numero' => $random_number, 'tipo' =>$tipo, 'total'=>$total, "total_recibo" =>$total_pagar, "consumo"=>$consumo);
                                    header('Access-Control-Allow-Origin: *');
                                    header('Content-Type: application/x-json; charset=utf-8');
                                    echo json_encode($json);
                                }
                                
                            }
                        }else{
                            $param_datos = array(
                                'SUMINISTRO'      => $suministro,
                                'HORA_REGISTRO'   => date("H:i:s"),
                                'EMAIL'           => $correo,
                                'MOVIL_USUARIO'   => $telefono,
                                'FECHA_REGITRO'  => date("d/m/Y")
                            );
                            $param_detalle = array(
                                'SUMINISTRO'      => $suministro,
                                'HORA_REGISTRO'   => date("H:i:s"),
                                'PERIODO'         => $periodo,
                                'CONTADOR'        => 1,
                                'TIPO_OPCION'     => $tipo,
                                'CADENA_CODIGO'   => $cadena_aleatoria,
                                'FECHA_REGITRO'   => date("d/m/Y")
                            );
                            $relacion= $this->Buscar_model->insertar_cliente($param_datos, $param_detalle);
                            if($relacion){
                                if($tipo=='2'){
                                    $this->enviar_recibo($datos, $nuevo_captcha, $random_number, $suministro, $periodo, $correo, $tipo, $total, $consumo, $total_pagar, $cadena_aleatoria);
                                }else{
                                    $json = array('result' => true, 'busqueda' => $datos , "cadena"=>$cadena_aleatoria, 'captcha' => $nuevo_captcha , 'numero' => $random_number, 'tipo' =>$tipo, 'total'=>$total, "total_recibo" =>$total_pagar, "consumo"=>$consumo);
                                    header('Access-Control-Allow-Origin: *');
                                    header('Content-Type: application/x-json; charset=utf-8');
                                    echo json_encode($json);
                                }
                            }else{
                                $json = array('result' => false, 'mensaje' => "Ocurrio un error ingresando los datos " , 'captcha' => $nuevo_captcha ,'numero' => $random_number );
                                header('Access-Control-Allow-Origin: *');
                                header('Content-Type: application/x-json; charset=utf-8');
                                echo json_encode($json);
                            }
                        }
                            
                    }else{
                        $json = array('result' => false, 'mensaje' => "Lo sentimos su recibo todavia no fue facturado " , 'captcha' => $nuevo_captcha ,'numero' => $random_number );
                        header('Access-Control-Allow-Origin: *');
                        header('Content-Type: application/x-json; charset=utf-8');
                        echo json_encode($json);
                    }
                }else{
                    $json = array('result' => false, 'mensaje' => "El codigo de suministro no existe " , 'captcha' => $nuevo_captcha ,'numero' => $random_number );
                    header('Access-Control-Allow-Origin: *');
                    header('Content-Type: application/x-json; charset=utf-8');
                    echo json_encode($json);   
                }
                
            }else{
                $json = array('result' => false, 'mensaje' => "Lo sentimos ha ingresado datos incorrectos " , 'captcha' => $nuevo_captcha ,'numero' => $random_number );
                header('Access-Control-Allow-Origin: *');
                header('Content-Type: application/x-json; charset=utf-8');
                echo json_encode($json);
            }
            

        }
    }

    private function creoReciboCorreo($suministro, $periodo, $cadena_aleatoria){
        $this->load->library('lib_tcpdf');
        $pdf = $this->lib_tcpdf->cargar();//cargo el dompdf   
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
        $pdf->AddPage('P', 'A5');
        $pdf->SetAutoPageBreak(false, 0);
        $recibos = $this->Buscar_model->get_dato_general($suministro, $periodo);
        $nombre_grafi_barra='';
        if(count($recibos)>0){
            $nombre_codi_barra = $this->creo_codi_barras_rango($recibos[0]['CLICODFAX'],$recibos[0]['CODIGO_BARRA']);//'CODI_BARRA'.$periodo.$ciclo.trim($recibos[0]['CLICODFAX']).$_SESSION['login'].date("d-m-Y");
            if(trim($recibos[0]['FMEDIDOR']) != ""){
                $nombre_grafi_barra = $this->creo_grafico_barras_rango($recibos[0]['CLICODFAX'],$recibos[0]['CON01'],$recibos[0]['CON02'],$recibos[0]['CON03'],$recibos[0]['CON04'],$recibos[0]['CON05'],$recibos[0]['CON06'],$recibos[0]['CON07'],$recibos[0]['CON08'],$recibos[0]['CON09'], $recibos[0]['CON10'],$recibos[0]['CON11'],$recibos[0]['CON12'],$recibos[0]['CON13'],$recibos[0]['MES01'],$recibos[0]['MES02'],$recibos[0]['MES03'],$recibos[0]['MES04'],$recibos[0]['MES05'],$recibos[0]['MES06'],$recibos[0]['MES07'],$recibos[0]['MES08'],$recibos[0]['MES09'],$recibos[0]['MES10'],$recibos[0]['MES11'],$recibos[0]['MES12'],$recibos[0]['MES13']);
            }
            $dato_detalle=$this->Buscar_model->get_dato_detalle( $recibos[0]['FACNRO'], $recibos[0]['FACSERNRO']);
            $distancia = 0;
            $pdf = $this ->lib_tcpdf -> cargo_plantilla_doble1($pdf,$recibos[0],$dato_detalle, $distancia, $nombre_codi_barra, $nombre_grafi_barra,1,1, $cadena_aleatoria);
            unlink ( 'assets/recibo/'.$nombre_codi_barra.'.jpg' );
            $nombre = $suministro.'_'.$periodo.'_'.date('d_m_Y').date("h_i_s");
            $pdf->Output($_SERVER["DOCUMENT_ROOT"].base_url().'assets/recibo/pdf/Recibo_'.$nombre.'.pdf', 'F');
            $respuesta = array();
            $respuesta['nombre'] = $nombre;
            $respuesta['desmes'] = $recibos[0]['DESMES'];
            return $respuesta;
            //$pdf->Output('Recibo_individual_A5.pdf', 'D');
        }
    }

    private function enviar_recibo($datos, $nuevo_captcha, $random_number, $suministro, $periodo, $correo, $tipo, $total, $consumo, $total_pagar, $cadena_aleatoria){
        $archivo = $this->creoReciboCorreo($suministro, $periodo, $cadena_aleatoria);
        $this->load->library("email");
        $motivo = "SEDALIB S.A. - DUPLICADO VIRTUAL DEL RECIBO - SUMINISTRO: ".$suministro." - FACTURACIÓN DE ".$archivo['desmes']."- ".substr($periodo, 0, 4);
        $destinatario = $correo;
        $mensaje = '
        <h3>Estimado '.$correo.' :</h3>
        <h4>SE ADJUNTA EL DUPLICADO VIRTUAL DEL RECIBO Nro. '.$suministro.' CORRESPONDIENTE A LA FACTURACIÓN DE '.$archivo['desmes'].'- '.substr($periodo, 0, 4).'</h4>
        <hr>
        <h4>Atentamente</h4>
        <b> SEDALIB S.A.</b><br>
        ';
        $configGmail = array(
            'protocol' => 'smtp',
            'smtp_host' => '150.10.8.57',
            //'smtp_host' => 'mail.sedalib.com.pe',
            //'smtp_host' => 'https://mx.sedalib.com.pe',
            'smtp_port' => 25,
            'smtp_user' => 'sicmoviles@sedalib.com.pe',
            'smtp_pass' => '12345678',
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n"
            );
        $this->email->initialize($configGmail);
        $this->email->from('recibodigital@sedalib.com.pe');
        $this->email->to($destinatario);
        $this->email->subject($motivo);
        $this->email->message($mensaje);
        $this->email->attach('assets/recibo/pdf/Recibo_'.$archivo['nombre'].'.pdf');
        $this->email->send();
        unlink ( 'assets/recibo/pdf/Recibo_'.$archivo['nombre'].'.pdf' );
        $json = array('result' => true, 'busqueda' => $datos , 'captcha' => $nuevo_captcha , 'numero' => $random_number, 'tipo' =>$tipo, 'total'=>$total, "total_recibo" =>$total_pagar, "consumo"=>$consumo);
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($json);
    }

    public function genera_recibo(){
        if($this->input->server('REQUEST_METHOD') == 'POST'){
            $array = json_decode($this->input->post('descarga_recibo'),true);
            $this->load->library('lib_tcpdf');
            $pdf = $this->lib_tcpdf->cargar();//cargo el dompdf   
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
            $pdf->AddPage('P', 'A5');
            $pdf->SetAutoPageBreak(false, 0);
            $recibos = $this->Buscar_model->get_dato_general($array[0],$array[1]);
            $nombre_grafi_barra='';
            if(count($recibos)>0){
                $nombre_codi_barra = $this->creo_codi_barras_rango($recibos[0]['CLICODFAX'],$recibos[0]['CODIGO_BARRA']);//'CODI_BARRA'.$periodo.$ciclo.trim($recibos[0]['CLICODFAX']).$_SESSION['login'].date("d-m-Y");
                if(trim($recibos[0]['FMEDIDOR']) != ""){
                    $nombre_grafi_barra = $this->creo_grafico_barras_rango($recibos[0]['CLICODFAX'],$recibos[0]['CON01'],$recibos[0]['CON02'],$recibos[0]['CON03'],$recibos[0]['CON04'],$recibos[0]['CON05'],$recibos[0]['CON06'],$recibos[0]['CON07'],$recibos[0]['CON08'],$recibos[0]['CON09'], $recibos[0]['CON10'],$recibos[0]['CON11'],$recibos[0]['CON12'],$recibos[0]['CON13'],$recibos[0]['MES01'],$recibos[0]['MES02'],$recibos[0]['MES03'],$recibos[0]['MES04'],$recibos[0]['MES05'],$recibos[0]['MES06'],$recibos[0]['MES07'],$recibos[0]['MES08'],$recibos[0]['MES09'],$recibos[0]['MES10'],$recibos[0]['MES11'],$recibos[0]['MES12'],$recibos[0]['MES13']);
                }
                $dato_detalle=$this->Buscar_model->get_dato_detalle( $recibos[0]['FACNRO'], $recibos[0]['FACSERNRO']);
                $distancia = 0;
                $pdf = $this ->lib_tcpdf -> cargo_plantilla_doble1($pdf,$recibos[0],$dato_detalle, $distancia, $nombre_codi_barra, $nombre_grafi_barra,1,1, $array[2]);
                unlink ( 'assets/recibo/'.$nombre_codi_barra.'.jpg' );
                $pdf->Output('DUPLICADO_VIRTUAL_RECIBO_'.$recibos[0]['CLICODFAX'].'.pdf', 'D');
            }
        }
    }
    private function creo_codi_barras_rango($suministro,$mensaje){
        $this->load->library('codi_barra_lib');
        $mensaje = trim($mensaje);
        $mensaje2 = "";
        for( $index = 0; $index < strlen($mensaje); $index++ )
        {
            if( is_numeric($mensaje[$index]) || $mensaje[$index]=='*' )
            {
                $mensaje2 .= $mensaje[$index];
            }
        }
        $barcode=$this->codi_barra_lib->cargar($mensaje2);
        $barcode->setEanStyle(false);
        $barcode->setShowText(false);
        $barcode->setPixelWidth(2);
        $barcode->setBorderWidth(0);
        $nombre ='CODI_BARRA'.trim($suministro).date("d-m-Y-H-s");
        $barcode->saveBarcode('assets/recibo/'.$nombre.'.jpg');
        return $nombre;
    }
    
    private function creo_grafico_barras_rango($suministro,$con01,$con02,$con03,$con04,$con05,$con06,$con07,$con08,$con09,$con10,$con11,$con12,$con13,$mes01,$mes02,$mes03,$mes04,$mes05,$mes06,$mes07,$mes08,$mes09,$mes10,$mes11,$mes12,$mes13){
        
        $grafico_barras=new Graph(450, 250, "auto");
        /*ingreso los valores de cada mes  */
        $ydata = array($con01,$con02,$con03,$con04,$con05,$con06,$con07,$con08,$con09,$con10,$con11,$con12,$con13);
        /* datos en la cuadrante x  del grafico*/
        $datax = array(trim($mes01),trim($mes02),trim($mes03),trim($mes04),trim($mes05),trim($mes06),trim($mes07),trim($mes08),trim($mes09),trim($mes10),trim($mes11),trim($mes12),trim($mes13));
        $grafico_barras->SetScale("textlin");
        $grafico_barras->img->SetMargin(40, 40, 40, 40);
        /*titulo del grafico*/
        $grafico_barras->title->Set("CONSUMOS MENSUALES (en m3)");
        $grafico_barras->xaxis->title->Set("");
        $grafico_barras->yaxis->title->Set("");
        $grafico_barras->xaxis->SetTickLabels($datax);
        $grafico_barras->SetMarginColor('white');
        $barplot =new BarPlot($ydata);
        /*color de las barras del grafico*/
        $barplot->SetColor("black");
        $barplot->value->SetFormat('%01.0f');
        $barplot->value->Show();
        $grafico_barras->Add($barplot);
        /*$nombre =$periodo.$ciclo_facturacion.trim($suministro).$_SESSION['login'].date("d-m-Y");
        $grafico_barras->Stroke('assets/recibo/'.$nombre.'.jpg');*/

        $img = $grafico_barras->Stroke(_IMG_HANDLER);
        ob_start();                                            
        imagejpeg($img);
        $img_data = ob_get_contents();
        ob_end_clean();
        //$image_data_base64 = base64_encode ($img_data);
        return $img_data;
        
    }

    
}

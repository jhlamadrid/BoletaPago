<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
//$route['BoletaPago/buscar'] = 'welcome/buscar';
//$route['EnlaceFactura/getAdjuntos'] = 'welcome/getAdjuntos';
$route['BoletaPago'] = 'BoletaPago/boletaPago_ctrllr/index';


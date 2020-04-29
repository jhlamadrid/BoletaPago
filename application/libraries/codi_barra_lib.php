<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class codi_barra_lib {
    
 
    function cargar($mensaje) {
        include_once APPPATH.'third_party/php_codi_barra/code128.php';
        return new  phpCode128($mensaje, 150, APPPATH.'third_party/php_codi_barra/fuente/verdana.ttf', 18);
        
    }
}

?>
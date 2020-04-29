<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class PhpGraph {

	function load($params){
        include_once APPPATH.'/libraries/phpgraphlib/phpgraphlib.php';
         
        if ($params == NULL)
        {
            return new PHPGraphLib(300, 300, 'img/salio.png');        
        }
         
        return new PHPGraphLib($params['width'], $params['height'], $params['name']);
    }

}
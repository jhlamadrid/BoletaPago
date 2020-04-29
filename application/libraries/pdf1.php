<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class pdf1 {

    function pdf1()
    {
        $CI = & get_instance();
        log_message('Debug', 'mPDF class is loaded.');
    }

    function load($param,$param1,$param2,$param3,$param4,$param5,$param6,$param7,$param8,$param9,$param10)
    {
        include_once APPPATH.'/third_party/mpdf/mpdf.php';

        if ($param == NULL)
        {
            return new mPDF("utf-8","A4","",0,5,5,5,6,3,"P");     
        }else {
            //var_dump($param1);
            return new mPDF($param,$param1,$param2,$param3,$param4,$param5,$param6,$param7,$param8,$param9,$param10);
        }
        //return  new mPDF("en-GB-x","A4","","",10,10,10,10,6,3);
    }
}

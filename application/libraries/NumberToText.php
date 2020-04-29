<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class NumberToText {
    
    function load() {

        include_once APPPATH.'/libraries/numbertotext/NumberToLetterConverter.php';
         
         
        return new NumberToLetterConverter();
    }
}
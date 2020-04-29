<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';

class Tcp extends TCPDF
{
    function __construct()
    {
        parent::__construct();
    }

    public function Header() {
        $headerData = $this->getHeaderData();
        $this->SetFont('helvetica', 'B', 10);
        $this->writeHTML($headerData['string']);
    }
}
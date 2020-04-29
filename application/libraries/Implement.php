<?php 
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');  
    require APPPATH.'/libraries/JWT.php';

    class Implement{
        PRIVATE $key = "dadasd#@p.-34eaFG3c*-Wd6";

        public function generateToken($data){
            $jwt = JWT::encode($data, $this->key);
            return $jwt;
        }

        public function decodeToken($token){
            $decoded = JWT::decode($token, $this->key, array('HS256'));
            $decodedData = (array) $decoded;
            return $decodedData;
        }
    }
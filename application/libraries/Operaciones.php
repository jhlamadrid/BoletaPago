<?php 
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');  
    class Operaciones{
        
        public function dateDiff($f1, $f2){
            $start = strtotime($f1);
            $end = strtotime($f2);
            $diff = $end - $start;
            return round($diff / 86400);
        }

        function getClientIP() {
            $ipaddress = '';
            if (getenv('HTTP_CLIENT_IP'))
                $ipaddress = getenv('HTTP_CLIENT_IP');
            else if(getenv('HTTP_X_FORWARDED_FOR'))
                $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
            else if(getenv('HTTP_X_FORWARDED'))
                $ipaddress = getenv('HTTP_X_FORWARDED');
            else if(getenv('HTTP_FORWARDED_FOR'))
                $ipaddress = getenv('HTTP_FORWARDED_FOR');
            else if(getenv('HTTP_FORWARDED'))
               $ipaddress = getenv('HTTP_FORWARDED');
            else if(getenv('REMOTE_ADDR'))
                $ipaddress = getenv('REMOTE_ADDR');
            else
                $ipaddress = 'UNKNOWN';
            return $ipaddress;
        }

        function getIPInfo($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
            $output = NULL;
            if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
                $ip = $_SERVER["REMOTE_ADDR"];
                if ($deep_detect) {
                    if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                    if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                        $ip = $_SERVER['HTTP_CLIENT_IP'];
                }
            }
            $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
            $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
            $continents = array(
                "AF" => "Africa",
                "AN" => "Antarctica",
                "AS" => "Asia",
                "EU" => "Europe",
                "OC" => "Australia (Oceania)",
                "NA" => "North America",
                "SA" => "South America"
            );
            if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
                $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
                if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
                    switch ($purpose) {
                        case "location":
                            $output = array(
                                "city"           => @$ipdat->geoplugin_city,
                                "state"          => @$ipdat->geoplugin_regionName,
                                "country"        => @$ipdat->geoplugin_countryName,
                                "country_code"   => @$ipdat->geoplugin_countryCode,
                                "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                                "continent_code" => @$ipdat->geoplugin_continentCode
                            );
                            break;
                        case "address":
                            $address = array($ipdat->geoplugin_countryName);
                            if (@strlen($ipdat->geoplugin_regionName) >= 1)
                                $address[] = $ipdat->geoplugin_regionName;
                            if (@strlen($ipdat->geoplugin_city) >= 1)
                                $address[] = $ipdat->geoplugin_city;
                            $output = implode(", ", array_reverse($address));
                            break;
                        case "city":
                            $output = @$ipdat->geoplugin_city;
                            break;
                        case "state":
                            $output = @$ipdat->geoplugin_regionName;
                            break;
                        case "region":
                            $output = @$ipdat->geoplugin_regionName;
                            break;
                        case "country":
                            $output = @$ipdat->geoplugin_countryName;
                            break;
                        case "countrycode":
                            $output = @$ipdat->geoplugin_countryCode;
                            break;
                    }
                }
            }
            return $output;
        }

        function getOS(){
            $browser = array("IE", "OPERA", "MOZILLA", "NETSCAPE", "FIREFOX", "SAFARI", "CHROME");
            $os = array("WIN","MAC","LINUX");
        
            $info['browser'] = "OTHER";
            $info['os'] = "OTHER";
        
            foreach($browser as $parent) {
                $s = strpos(strtoupper($_SERVER['HTTP_USER_AGENT']), $parent);
                $f = $s + strlen($parent);
                $version = substr($_SERVER['HTTP_USER_AGENT'], $f, 15);
                $version = preg_replace('/[^0-9,.]/','',$version);
                if ($s) {
                    $info['browser'] = $parent;
                    $info['version'] = $version;
                }
            }

            foreach($os as $val){
                if (strpos(strtoupper($_SERVER['HTTP_USER_AGENT']),$val)!==false)
                    $info['os'] = $val;
            }
        
            return $info;
        }

        function addDay($fch){
            $fch = str_replace("/", "-",  $fch);
            $nuevafecha = strtotime ( '+1 day' , strtotime ( $fch ) ) ;
            return date ( 'd/m/Y' , $nuevafecha );
        }

        function findPermisoUser($usuario, $token, $actividad){
            $CI = & get_instance();
            $CI->load->library('implement'); 
            $CI->load->model('sistema/Global_model');
            $tk = $CI->Global_model->obtenerToken($usuario);
            if($token == $tk){
                $jwtToken = $CI->implement->decodeToken($token);
                if($jwtToken['uniqueId'] == $usuario){
                    $permiso = $CI->Global_model->findPermiso($usuario,$actividad);
                    if($permiso){
                        return array('res' => true, 'msg' => $CI->config->item('msg_ok'), 'status' => 200);
                    } else {
                        return array('res' => false, 'msg' => $CI->config->load('msg_error'), 'status' => 404);
                    }
                } else {
                    return array('res' => false, 'msg' => $CI->config->item('msg_error_autenticacion'), 'status' => 404);
                }
            } else {
                return array('res' => false, 'msg' => $CI->config->item('msg_error_autenticacion'), 'status' => 404);
            }
        }

        function getLastDayMonth($month, $year){
            return date("d",(mktime(0,0,0,$month+1,1,$year)-1))."/".(($month < 10) ? "0".$month : $month)."/".$year;
        }

        function burbuja($arr){
            $n = sizeof($arr);
            for( $i = 1; $i < $n; $i++){
                for($j=0; $j<$n-$i; $j++){
                    if($arr[$j]['ORDEN'] > $arr[$j + 1]['ORDEN']){
                        $k = $arr[$j];
                        $arr[$j] = $arr[$j+1];
                        $arr[$j+1] = $k;
                    }
                }
            }

            return $arr;
        }

        function response($json, $status){
            http_response_code( $status);
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/x-json; charset=utf-8');
            echo json_encode($json);
        }

        public function getMes($mes){
            $mes = intval($mes);
            switch($mes){
                case 1 : return 'ENERO'; break;
                case 2 : return 'FEBRERO'; break;
                case 3 : return 'MARZO'; break;
                case 4 : return 'ABRIL'; break;
                case 5 : return 'MAYO'; break;
                case 6 : return 'JUNIO'; break;
                case 7 : return 'JULIO'; break;
                case 8 : return 'AGOSTO'; break;
                case 9 : return 'SETIEMBRE'; break;
                case 10 : return 'OCTUBRE'; break;
                case 11 : return 'NOVIEMBRE'; break;
                case 12 : return 'DICIEMBRE'; break;
            }
        }

    }

<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Acceso_cls {

    public function isLogin() {
        if (!(isset($_SESSION['user_nom'])) || !(isset($_SESSION['user_id']))) {
            redirect(base_url() . 'login');
        }
    }

    public function get_userdata($idUsuario = 'no importa') {
        if (!isset($_SESSION['user_data'])) {
            $CI = & get_instance();
            $CI->load->model('acceso/Acceso_model');
            $this->userdata = $CI->Acceso_model->findOneUsuarioCod($_SESSION['user_id']);
            $_SESSION['user_data'] = $this->userdata;
        }else{
            $this->userdata = $_SESSION['user_data'];
        }
        return $this->userdata;
    }

    public function recargar_userdata() {
        unset($_SESSION['user_data']);
        $this->get_userdata();
    }

    public function findMenu($usuario){
        $CI = & get_instance();
        $CI->load->model('sistema/Global_model');
        $menu = $CI->Global_model->findMenu($usuario);
        foreach ($menu as $key => $m) {
            $resultado = $CI->Global_model->findActividades($_SESSION['user_id'],$m['ID_MENUGEN']);
            $menu[$key]['actividades'] = $resultado;
        }
        return $menu;
    }
}

<?php 

class Buscar_model extends CI_MODEL {

	function __construct() {
        parent::__construct();
        $this->oracle = $this->load->database('oracle', TRUE);
    }

    

    function getAdjuntos($iddoc){
        $sql = "SELECT DOCREFERENCIA, ENLACEDOCUMENTO, IDENLACEARCHIVO
                FROM PRDDBFCOMERCIAL.WF_ENLACEARCHIVOS  
                WHERE  DOCREFERENCIA =".$iddoc. " AND ESTADO ='1'";
        $outValue = $this->oracle->query($sql)->result();
        return $outValue;
    }
    public function get_Recibo($suministro, $periodo_inicio){
        $query = $this->oracle->query("SELECT CLINOMBRE,FACTOTAL, FACSALDO, 
                                     FACNRO, FACSERNRO, DESMES,  CLICODFAX, TIPIMP, CONSUMO, DESCRIREG  FROM PRDDBFCOMERCIAL.REPFACIMP WHERE CLICODFAX=".$suministro." AND PERIODO = ".$periodo_inicio);
        return $query->result_array();
    }
    public function get_dato_general($suministro,$periodo){
        $query = $this->oracle->query("select   ROWNUM,TRIM(BARCOD) AS CODIGO_BARRA, PORDESEXC,CLINOMBRE, CONREALMED, VOLFAC ,CLIELECT,".
                                  "CLIRUC ,PERIODO,CLICODFAX,DESCALLE,DESURBA,DESMES,FACEMIFEC,FECACT,FECANT,".
                              " FMEDIDOR,DESIMPORTE,CONSUMO,FSETIPCOD, TIPIMP , DESCRIREG, DESPREM, OBSLEC, FACVENFEC,
                                CON01,CON02,CON03,CON04,CON05,CON06,CON07,CON08,CON09,CON10,CON11,CON12,CON13,".
                              "MES01,MES02,MES03,MES04,MES05,MES06,MES07,MES08,MES09,MES10,MES11,MES12,MES13,FACTOTAL,".
                              " FACSALDO,HORARIO,FGRUCOD,FGRUSUB,HORABS,FCICLO,DXSEM,PRECICFAC, LECACT,
                                LECANT,FACNRO,FACSERNRO,FACTARIFA,FACCHEDIG,CODCIM,
                                NUMERO,CARGARD,DESPREM,SUBTOT_ANT,ORDENRD,".
                             " DESFH ,MENSAJE2,MENSAJE,FACTOTSUB,FACIGV,REDONACT,REDONANT,".
                             " MENSCORTES,FACCICCOR,MENSCORTES,DESLOCAL FROM PRDDBFCOMERCIAL.REPFACIMP  WHERE CLICODFAX=".$suministro."AND PERIODO=".$periodo);
        return $query->result_array();
    }
    public function get_dato_detalle($numero_recibo,$serie_recibo){
        $query = $this->oracle->query("select FACLINRO,DESCONCEP,IMPPRIRANG,IMPSEGRANG,IMPTERRANG,FACPRECI,REPFACIMP_FACNRO,REPFACIMP_FACSERNRO FROM PRDDBFCOMERCIAL.REPLINIMP WHERE REPFACIMP_FACNRO=".$numero_recibo.
                                 " AND REPFACIMP_FACSERNRO= ".$serie_recibo);
        return $query->result_array();
    }

    public function get_Relacion_datos($suministro){
        $query = $this->oracle->query("SELECT SUMINISTRO, MOVIL_USUARIO, EMAIL FROM PRDDBFCOMERCIAL.USUARIO_DUPLI_RECIBO WHERE SUMINISTRO = ".$suministro);
        return $query->result_array();
    }

    public function insertar_cliente($param_datos, $param_detalle){
        $this->oracle->insert('PRDDBFCOMERCIAL.USUARIO_DUPLI_RECIBO',$param_datos);
        if ($this->oracle->trans_status() === FALSE){
            return false;
        }else{
            $this->oracle->insert('PRDDBFCOMERCIAL.DETA_DUPLI_RECIBO',$param_detalle);
            if($this->oracle->trans_status() === FALSE){
                return false;
            }else{
                return true;
            }
        }
    }

    public function set_detalle($param_detalle, $suministro, $periodo){
        $query = $this->oracle->query("SELECT MAX(CONTADOR) as Maximo FROM PRDDBFCOMERCIAL.DETA_DUPLI_RECIBO WHERE SUMINISTRO = ".$suministro." AND PERIODO='".$periodo."'");
        $respuesta= $query->result_array();
        //var_dump($respuesta);
        //exit();
        if(count($respuesta)>0){
            $dato = (int)$respuesta[0]['MAXIMO'] + 1;
            $param_detalle['CONTADOR'] = $dato;
            $this->oracle->insert('PRDDBFCOMERCIAL.DETA_DUPLI_RECIBO',$param_detalle);
            if($this->oracle->trans_status() === FALSE){
                return false;
            }else{
                return true;
            }
        }else{
            $param_detalle['CONTADOR'] = 1;
            $this->oracle->insert('PRDDBFCOMERCIAL.DETA_DUPLI_RECIBO',$param_detalle);
            if($this->oracle->trans_status() === FALSE){
                return false;
            }else{
                return true;
            }
        }
        
    }

    public function modificar_cliente($param_datos, $suministro){
        $this->oracle->where('SUMINISTRO', $suministro);
        $this->oracle->update('PRDDBFCOMERCIAL.USUARIO_DUPLI_RECIBO', $param_datos);
        if ($this->oracle->trans_status() === FALSE){
            return false;
        }else{
            return true;
        }
    }

    public function obtengo_dato_tam11($codigo_suministro){
        $ConsPro = "";
        $ConsPro = $ConsPro . "SELECT CLINOMBRE ";
        $ConsPro = $ConsPro . "FROM PRDCOMCATMEDLEC.PROPIE ";
        $ConsPro = $ConsPro . "WHERE CLICODFAC = '".$codigo_suministro."'";
        $query = $this->oracle->query($ConsPro);
        return $query->result_array();

    }

    public function  obtengo_dato_nombre_tam7($codigo_suministro){
        $grupo = substr($codigo_suministro, 0,3);
        $subGrupo = substr($codigo_suministro, 3,strlen($codigo_suministro));
        $ConsPro = "";
        $ConsPro = $ConsPro . "SELECT CLINOMBRE ";
        $ConsPro = $ConsPro . "FROM PRDCOMCATMEDLEC.PROPIE ";
        $ConsPro = $ConsPro . "WHERE CLICODFAC = '" . $grupo . "0000". $subGrupo . "'";
        $query = $this->oracle->query($ConsPro);
        return $query->result_array();
    }
}

?>
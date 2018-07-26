<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Modelo para interactuar en la BD
 * SELECT ID_CUOTA,RUTA_RECIBO,RUTA_FORMATO_PAGO,STATUS,CUOTA_DEL_MES,FECHA_PAGO,FECHA_FORMATO_PAGO,FECHA_VIGENCIA_FORMATO,IMPORTE,ID_EDIFICIO,ID_DEPTO,TORRE,REFERENCIA,REFERENCIA_OPENPAY,ID_TRANSACCION_OPEN_PAY,TIPO_PAGO` FROM `CUOTAS
 */
 
class MDL_cuotas extends CI_Model {

    public function update_cuota($param)
    {			
	$this->db->where('TORRE'      ,  $param['torre']);
        $this->db->where('ID_DEPTO'   ,  $param['id_depto']);
        $this->db->where('ID_EDIFICIO',  $param['id_edificio']);
        $this->db->update('CUOTAS', array("NUMERACION"=>$param['num']));           
    }
    
    public function insert_cuota($data)
    {		
        return $this->db->insert('CUOTAS',$data);
    }
                
    
    public function delete_edificio( $id_edi)
    {			
	$this->db->where('ID_EDIFICIO',  $id_edi);
       return  $this->db->update('EDIFICIOS', array('ACTIVO' => 0));           
    }
    
    public function traeCuotas($param)
    {    					
        $this -> db -> select('*');
        $this->db->where('TORRE'      ,  $param['torre']);
        $this->db->where('ID_DEPTO'   ,  $param['id_depto']);
        $this->db->where('ID_EDIFICIO',  $param['id_edificio']);
        $query = $this -> db -> get('CUOTAS C');
        
     if($query -> num_rows() > 0 )      
           { return   $query->result_array(); }
	else 
           { return  NULL;  }
    }
    
    public function poblarSelect()
    {    					
        $this -> db -> select('E.ID_EDIFICIO,E.NOMBRE,E.CALLE,E.NUMERO,E.COLONIA,E.LOGOTIPO');
        $this -> db -> order_by("E.FECHA_ALTA","ASC");					
        $query = $this -> db -> get('EDIFICIOS E');
	$options = array();
        if($query -> num_rows() > 0 )
            {   $options[0] = '::Seleccione una opción::';
                foreach ($query->result() as $row)							 
                    { $options[$row->ID_EDIFICIO] = $row->NOMBRE." ".$row->CALLE." ".$row->NUMERO." ".$row->COLONIA; }
            }
        return $options;  
    }
    
    public function traeEdificio($id_edificio)
    {    					
        $this -> db -> select('E.ID_EDIFICIO, E.NOMBRE, E.CALLE, E.NUMERO, E.COLONIA, E.ALCALDIA, E.ESTADO, E.CP, E.LATITUD, E.LONGITUD, E.CUOTA_MANTO, E.DIA_CORTE, E.TIPO_PENALIZACION, E.PENALIZACION, E.NUM_TORRES, E.NUM_VIVIENDAS, E.LOGOTIPO');
        $this->db->where('ID_EDIFICIO',  $id_edificio);
        $query = $this -> db -> get('EDIFICIOS E');
        
     if($query -> num_rows() > 0 )      
           { return   $query->result_array(); }
	else 
           { return  array();                 }
    }
   
    public function traePagCuotasFiltros($param)
    {   
        $off  = (($param['pagina']-1) * $param['registrosPagina']);
    	$this -> db -> select('count(C.ID_CUOTA) as conteo');        
        $this -> db -> join('CATALOGOS CAT','CAT.ID_CATALOGOS = C.TIPO_PAGO AND CAT.CAMPO=\'tipo_pago\' ','inner outer');
        
        if (!empty($param['f1']))
            { $this -> db -> or_like(array('i.num_file' => $param['f1'] ) ); }
        if (!empty($param['f2']))
            { $this -> db -> or_like(array('i.master' => $param['f2'])); }
        if (!empty($param['f3']))
            { $this -> db -> or_like(array('i.shipper' => $param['f3'])); }

        $this->db->where('C.ID_DEPTO'   , $param['id_depto']);
        $this->db->where('C.TORRE'      , $param['torre']);
        $this->db->where('C.ID_EDIFICIO', $param['id_edificio']);
        $query = $this->db->get('CUOTAS C')->result();
	$conteo = $query[0]->conteo;
        
        $this -> db -> select('C.ID_CUOTA, C.RUTA_RECIBO, C.RUTA_FORMATO_PAGO, C.STATUS, C.CUOTA_DEL_MES, C.IMPORTE, C.REFERENCIA, C.REFERENCIA_OPENPAY, C.ID_TRANSACCION_OPEN_PAY, C.TIPO_PAGO, CAT.DESCRIPCION AS TIPOPAGO, C.ID_DEPTO, C.TORRE, C.ID_EDIFICIO');
        $this -> db -> select("DATE_FORMAT(`C`.`FECHA_PAGO`,'%d %b %Y') as FECHA_PAGO, DATE_FORMAT(`C`.`FECHA_FORMATO_PAGO`,'%d %b %Y') as FECHA_FORMATO_PAGO, DATE_FORMAT(`C`.`FECHA_VIGENCIA_FORMATO`,'%d %b %Y') as FECHA_VIGENCIA_FORMATO", FALSE);
        $this -> db -> join('CATALOGOS CAT','CAT.ID_CATALOGOS = C.TIPO_PAGO AND CAT.CAMPO=\'tipo_pago\' ','inner outer');
        
        if (!empty($param['f1']))
            { $this -> db -> or_like(array('i.num_file' => $param['f1'] ) ); }
        if (!empty($param['f2']))
            { $this -> db -> or_like(array('i.master' => $param['f2'])); }
        if (!empty($param['f3']))
            { $this -> db -> or_like(array('i.shipper' => $param['f3'])); }                            
        
        $this->db->order_by("C.ID_CUOTA","DESC");        
        $this->db->where('C.ID_DEPTO'   , $param['id_depto']);
        $this->db->where('C.TORRE'      , $param['torre']);
        $this->db->where('C.ID_EDIFICIO', $param['id_edificio']);
        $queryReg = $this->db->get('CUOTAS C',$param['registrosPagina'],$off);			

        if($queryReg -> num_rows() > 0 )      
                { return array("conteo"=>$conteo, "registros"=>$queryReg->result_array(), "offset"=>$off); }
             else 
                { return false;  }                       
    }
    
    public function traeCuotasAX($param)
    {
        $this->db->select(' D.NUMERACION');        
        $this->db->where('D.TORRE'      , $param['torre']);
        $this->db->where('D.ID_EDIFICIO', $param['id_edificio']);
        $this->db->where('D.ID_DEPTO'   , $param['id_depto']);
        $queryReg = $this -> db -> get('DEPARTAMENTOS D');

        if($queryReg -> num_rows() > 0 )      
           { return $queryReg->result_array(); }
	else 
           { return array();                   }
    }
    
    
    public function traeCuotasPendientes($id_edificio, $agruparPorDepto, $torre, $id_depto)
    {
     $whereTorre      = ($torre    === NULL?"":" AND `D`.`TORRE`    = '".$torre."'");
     $whereDepto      = ($id_depto === NULL?"":" AND `D`.`ID_DEPTO` = ".$id_depto  );
     $groupByDepto    = $agruparPorDepto?"":", `FC`.`CUOTAS`";
     $selGroupByDepto = $agruparPorDepto?"":", `FC`.`CUOTAS` AS CUOTA_PENDIENTE";
     
     $this->db->query("SET @idEdificio   = ".$id_edificio);
     $this->db->query("SET @primeraCuota = (SELECT CONCAT(DATE_FORMAT(DATE_ADD(`ED`.`FECHA_ALTA`, INTERVAL 1 MONTH),'%Y-%m'),'-',`ED`.`DIA_CORTE`) AS PRIMERA_CUOTA 
                                            FROM EDIFICIOS `ED` WHERE `ED`.`ID_EDIFICIO` = @idEdificio)");
     $this->db->query("SET @ultimaCuota  = (SELECT IF(`ED`.`DIA_CORTE` > CAST(DATE_FORMAT(NOW(),'%d') AS INT)
                                                      , DATE_FORMAT(LAST_DAY(DATE_ADD(NOW(), INTERVAL -1 MONTH)),'%Y-%m-%d')
                                                      , DATE_FORMAT(NOW(),'%Y-%m-%d')
                                                     ) AS ULTIMA_CUOTA
                                            FROM EDIFICIOS `ED` WHERE `ED`.`ID_EDIFICIO` = @idEdificio)");
     $this->db->query("SET @months       = -1                       ");
     $cuotasQRY = $this->db->query("SELECT `D`.`ID_DEPTO`, `D`.`TORRE`, `D`.`NUMERACION` AS DEPTO$selGroupByDepto
                                    FROM `DEPARTAMENTOS` `D` 
                                    INNER JOIN  `EDIFICIOS` `E` ON `E`.`ID_EDIFICIO` = `D`.`ID_EDIFICIO`
                                    INNER JOIN  (SELECT FC.CUOTAS, FC.ID_EDIFICIO
                                                 FROM
                                                     ( SELECT CAST( DATE_FORMAT(date_range,'%Y-%m') AS CHAR) AS CUOTAS, @idEdificio AS ID_EDIFICIO
                                                       FROM (SELECT (DATE_ADD(@primeraCuota, INTERVAL(@months := @months +1) month)) AS date_range
                                                             FROM mysql.help_topic a limit 0,1000
                                                            ) a
                                                       WHERE a.date_range BETWEEN @primeraCuota and LAST_DAY(@ultimaCuota)
                                                     ) FC
                                                 ) `FC` ON `E`.`ID_EDIFICIO` = `FC`.`ID_EDIFICIO` AND `FC`.`CUOTAS` IS NOT NULL
                                    LEFT OUTER JOIN `CUOTAS` `C` ON  `C`.`ID_DEPTO` = `D`.`ID_DEPTO` AND `C`.`ID_EDIFICIO` = `D`.`ID_EDIFICIO` 
                                                                 AND `C`.`STATUS` = 'PAGADA' AND `C`.`CUOTA_DEL_MES` = `FC`.`CUOTAS`
                                    WHERE `E`.`ID_EDIFICIO` = @idEdificio AND `C`.`CUOTA_DEL_MES` IS NULL $whereTorre $whereDepto
                                    GROUP BY `D`.`ID_DEPTO`, `D`.`TORRE`, `D`.`NUMERACION`$groupByDepto
                                    ORDER BY `D`.`TORRE`, `D`.`NUMERACION`$groupByDepto"
                                  , FALSE);
     
     $cuotas    = ( is_array($cuotasQRY->result_array()) ? $cuotasQRY->result_array() : array() );
     return $cuotas;
    }//traeCuotasPendientes
    
    public function traeTotCuotasTasa($id_edificio, $id_depto)
    {$queryTotDeptos = $id_depto===NULL?"(SELECT `ED`.`NUM_TORRES` * `ED`.`NUM_VIVIENDAS` FROM EDIFICIOS `ED` WHERE `ED`.`ID_EDIFICIO` = @idEdificio)":"1";
     $whereDeptos    = $id_depto===NULL?"" :" AND `C`.`ID_DEPTO` =".$id_depto;
     $this->db->query("SET @idEdificio   = ".$id_edificio);
     $this->db->query("SET @primeraCuota = (SELECT CONCAT(DATE_FORMAT(DATE_ADD(`ED`.`FECHA_ALTA`, INTERVAL 1 MONTH),'%Y-%m'),'-',`ED`.`DIA_CORTE`) AS PRIMERA_CUOTA 
                                            FROM EDIFICIOS `ED` WHERE `ED`.`ID_EDIFICIO` = @idEdificio)");
     $this->db->query("SET @ultimaCuota  = (SELECT IF(`ED`.`DIA_CORTE` > CAST(DATE_FORMAT(NOW(),'%d') AS INT)
                                                    , DATE_FORMAT(LAST_DAY(DATE_ADD(NOW(), INTERVAL -1 MONTH)),'%Y-%m-%d')
                                                    , CONCAT(DATE_FORMAT(NOW(),'%Y-%m'),'-',`ED`.`DIA_CORTE`)
                                                    ) AS ULTIMA_CUOTA
                                            FROM EDIFICIOS `ED` WHERE `ED`.`ID_EDIFICIO` = @idEdificio)");
     $this->db->query("SET @totDeptos = ".$queryTotDeptos);
     $this->db->query("SET @totCuotas = (SELECT (TIMESTAMPDIFF(MONTH, @primeraCuota, @ultimaCuota)+1))");
     $this->db->query("SET @totCtaPag = (SELECT COUNT(`C`.`ID_CUOTA`) FROM CUOTAS `C` WHERE `C`.`STATUS` = 'PAGADA' AND `C`.`ID_EDIFICIO` = @idEdificio $whereDeptos)");
     $cuotasQRY = $this->db->query("SELECT (@totDeptos) AS TOT_DEPTOS, (@totCuotas) AS TOT_CUOTAS, (@totDeptos * @totCuotas) AS TOT_TASA, (@totCtaPag) AS TOT_PAGADAS, ( IF(@totCtaPag=0, 100, 100-(@totCtaPag/(@totDeptos * @totCuotas))*100) ) AS TASA ", FALSE);
     
     $totCuotas = ( is_array($cuotasQRY->result_array()) ? $cuotasQRY->result_array()[0] : array() );
     return $totCuotas;
    }//traeCuotasPendientes
    
    
}//MDL_edificio

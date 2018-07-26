<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Modelo para interactuar en la BD
 * SELECT E.ID_EDIFICIO, E.NOMBRE, E.CALLE, E.NUMERO, E.COLONIA, E.ALCALDIA, E.ESTADO, E.LATITUD, E.LONGITUD, E.CUOTA_MANTO, E.DIA_CORTE, E.TIPO_PENALIZACION, E.PENALIZACION, E.NUM_TORRES, E.NUM_VIVIENDAS, E.LOGOTIPO,  E.FECHA_ALTA
FROM EDIFICIOS WHERE 1
 */
 
class MDL_edificio extends CI_Model {

    public function update_edificio( $id_edi, $data)
    {			
	$this->db->where('ID_EDIFICIO',  $id_edi);
        $this->db->update('EDIFICIOS', $data);           
    }
    
    public function update_depto($param)
    {			
	$this->db->where('TORRE'      ,  $param['torre']);
        $this->db->where('ID_DEPTO'   ,  $param['id_depto']);
        $this->db->where('ID_EDIFICIO',  $param['id_edificio']);
        $this->db->update('DEPARTAMENTOS', array("NUMERACION"=>$param['num']));           
    }
    
    public function insert_edificio($data)
    {		
        return $this->db->insert('EDIFICIOS',$data);
    }
    
    public function insert_deptos($data)
    {		
        return $this->db->insert('DEPARTAMENTOS',$data);
    }
    
    public function insert_detalle_deptos($data)
    {		
        return $this->db->insert('DETALLE_DEPTO',$data);
    }
    
    public function update_deptos( $id_depto, $data)
    {			
	$this -> db -> select('D.ID_DEPTO');        
        $this->db->where('D.ID_DEPTO',  $id_depto);
        $query = $this -> db -> get('DEPARTAMENTOS D');        
        if($query -> num_rows() > 0 )
        {
            $this->db->where('ID_DEPTO',  $id_depto);
            $this->db->update('DEPARTAMENTOS', $data);
        }
        else
        {   $data['ID_DEPTO'] = $id_depto;
            $this->db->insert('DEPARTAMENTOS',$data);        
        }
    }
    
    public function delete_edificio( $id_edi)
    {			
	$this->db->where('ID_EDIFICIO',  $id_edi);
       return  $this->db->update('EDIFICIOS', array('ACTIVO' => 0));           
    }
    
    public function traeIdEdificio($param)
    {    					
        $this -> db -> select('E.ID_EDIFICIO');
        $this->db->where(' E.NOMBRE'    ,  $param['NOMBRE']);
        $this->db->where(' E.CALLE'     ,  $param['CALLE']);
        $this->db->where(' E.NUMERO'    ,  $param['NUMERO']);
        $this->db->where(' E.COLONIA'   ,  $param['COLONIA']);
        $this->db->where(' E.CREADO_MOD',  $param['CREADO_MOD']);
        $query = $this -> db -> get('EDIFICIOS E');
        
     if($query -> num_rows() > 0 )      
           { return   $query->result_array()[0]['ID_EDIFICIO']; }
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
    
    public function poblarSelectPresupuestos($id_edificio)
    {    					
        $this -> db -> select('P.PRESUPUESTO_ID, P.NOMBRE_PTO');
        $this->db->where('P.ID_EDIFICIO',  $id_edificio);
        $this -> db -> order_by("P.FECHA_ALTA","ASC");					
        $query = $this -> db -> get('PRESUPUESTO P');
	$options = array();
        if($query -> num_rows() > 0 )
             {   $options[0] = 'Nuevo Presupuesto';
                 foreach ($query->result() as $row)							 
                    { $options[$row->PRESUPUESTO_ID] = $row->NOMBRE_PTO; }
             }
        else { $options[0] = 'Nuevo Presupuesto'; }    
        return $options;  
    }
    
    public function traeEdificio($id_edificio)
    {    					
        $this->db->select('E.ID_EDIFICIO, E.NOMBRE, E.CALLE, E.NUMERO, E.COLONIA, E.ALCALDIA, E.ESTADO, E.CP, E.LATITUD, E.LONGITUD, E.CUOTA_MANTO, E.DIA_CORTE, E.TIPO_PENALIZACION, E.PENALIZACION, E.NUM_TORRES, E.NUM_VIVIENDAS, E.LOGOTIPO, E.TIENE_AMENIDADES');
        $this->db->select("DATE_FORMAT(`E`.`FECHA_ALTA`,'%Y-%m') as FECHA_ALTA", FALSE);
        $this->db->select("CONCAT(DATE_FORMAT(DATE_ADD(`E`.`FECHA_ALTA`, INTERVAL 1 MONTH),'%Y-%m'),'-',`E`.`DIA_CORTE`) AS PRIMERA_CUOTA", FALSE);
        $this->db->where('ID_EDIFICIO',  $id_edificio);
        $query = $this -> db -> get('EDIFICIOS E');
        
        if($query -> num_rows() > 0 )      
           { return   $query->result_array(); }
	else 
           { return  array();                 }
    }
    
    public function traeE_Depto($id_edificio, $id_depto, $cuenta, $nivelacceso)
    {    					
        $this->db->select('E.ID_EDIFICIO, E.NOMBRE, E.CALLE, E.NUMERO, E.COLONIA, E.ALCALDIA, E.ESTADO, E.CP, E.LATITUD, E.LONGITUD, E.CUOTA_MANTO, E.DIA_CORTE, E.TIPO_PENALIZACION, E.PENALIZACION, E.LOGOTIPO, D.TORRE, D.ID_DEPTO, D.NUMERACION, D.STATUS, D.CUMPLIMIENTO');
        $this->db->select("DATE_FORMAT(`E`.`FECHA_ALTA`,'%Y-%m') as FECHA_ALTA", FALSE);
        $this->db->select("CONCAT(DATE_FORMAT(DATE_ADD(`E`.`FECHA_ALTA`, INTERVAL 1 MONTH),'%Y-%m'),'-',`E`.`DIA_CORTE`) AS PRIMERA_CUOTA", FALSE);
        $this->db->from('EDIFICIOS E');
        $this->db->join('DEPARTAMENTOS D ', 'E.ID_EDIFICIO = D.ID_EDIFICIO','inner outer');
        $this->db->join('DETALLE_DEPTO DD', 'D.ID_DEPTO    = DD.ID_DEPTO AND D.TORRE = DD.TORRE ','inner outer');
        $this->db->where('E.ID_EDIFICIO'  ,  $id_edificio);
        $this->db->where('D.ID_DEPTO'     ,  $id_depto);
        if ($nivelacceso == USER ) { $this->db->where('DD.CUENTA',  $cuenta);} 
        $query = $this->db->get();
        
     if($query -> num_rows() > 0 )      
           { return   $query->result_array(); }
	else 
           { return  array();                 }
    }
    
      public function traeDeptoXEdTor($id_edificio,$torre,$id_depto)
    {    					
        $this->db->select('E.ID_EDIFICIO, E.NOMBRE, E.CALLE, E.NUMERO, E.COLONIA, E.ALCALDIA, E.ESTADO, E.CP, E.LATITUD, E.LONGITUD, E.CUOTA_MANTO, E.DIA_CORTE, E.TIPO_PENALIZACION, E.PENALIZACION, E.LOGOTIPO, D.TORRE, D.ID_DEPTO, D.NUMERACION, D.STATUS, D.CUMPLIMIENTO');
        $this->db->select("DATE_FORMAT(`E`.`FECHA_ALTA`,'%Y-%m') as FECHA_ALTA", FALSE);
        $this->db->from('EDIFICIOS E');
        $this->db->join('DEPARTAMENTOS D ', 'E.ID_EDIFICIO = D.ID_EDIFICIO','inner outer');
        $this->db->join('DETALLE_DEPTO DD', 'D.ID_DEPTO    = DD.ID_DEPTO AND D.TORRE = DD.TORRE ','inner outer');
        $this->db->where('E.ID_EDIFICIO'  , $id_edificio);
        $this->db->where('D.ID_DEPTO'     , $id_depto);
        $this->db->where('DD.TORRE'       , $torre);
        $query = $this->db->get();
        
     if($query -> num_rows() > 0 )      
           { return   $query->result_array(); }
	else 
           { return  array();                 }
    }
    
    public function traeDeptoDetalle($param)
    {    					
        $this -> db -> select('DD.ID_DETALLE_DEPTO, DD.CUENTA, DD.CONTACTO, C.DESCRIPCION AS TIPO');
        $this -> db -> select("CONCAT_WS(' ',`U`.`nombre`,`U`.`apellidos`) as CONTACTO_NOMBRE", FALSE);
        $this -> db -> join  ('USUARIOS U' , 'U.CUENTA = DD.CUENTA'         ,'inner outer');        
        $this -> db -> join  ('CATALOGOS C', 'DD.CONTACTO = C.ID_CATALOGOS ','inner outer');
        $this -> db -> where ('DD.ID_EDIFICIO', $param['id_edificio']);
        $this -> db -> where ('DD.ID_DEPTO'   , $param['id_depto']);
        $this -> db -> where ('DD.TORRE'      , $param['torre']);
        $query = $this -> db -> get('DETALLE_DEPTO DD');
        
     if($query -> num_rows() > 0 )      
           { return   $query->result_array(); }
	else 
           { return  array();                 }
    }
    
    public function traeDepto($param)
    {    					
        $this -> db -> select('D.ID_EDIFICIO, D.ID_DEPTO, D.TORRE, D.NUMERACION, D.STATUS, D.CUMPLIMIENTO');
        $this -> db -> where( 'D.ID_EDIFICIO', $param['id_edificio']);
        $this -> db -> where( 'D.ID_DEPTO'   , $param['id_depto']);
        $this -> db -> where( 'D.TORRE'      , $param['torre']);
        $query = $this -> db -> get('DEPARTAMENTOS D');
        
     if($query -> num_rows() > 0 )      
           { return   $query->result_array(); }
	else 
           { return  array();                 }
    }
    
    public function traeTorres($id_edificio)
    {    					
        $this->db->select('D.TORRE');
        $this->db->group_by('D.TORRE'); 
        $this->db->order_by('D.TORRE', 'ASC'); 
        $this->db->where('ID_EDIFICIO',  $id_edificio);
        $query = $this -> db -> get('DEPARTAMENTOS D');
        
     if($query -> num_rows() > 0 )      
           { return $query->result_array(); }
	else 
           { return array();                 }
    }
    
    
    public function poblarSelectCat($campo, $initValue)
    {    					
        $this -> db -> select('C.ID_CATALOGOS, C.DESCRIPCION');
        $this -> db -> order_by("C.ID_CATALOGOS","ASC");
        $this -> db -> where('C.CAMPO',  $campo);
        $query = $this -> db -> get('CATALOGOS C');
	$options = array();
        if($initValue) { $options[0] = '::Seleccione::'; }
        if($query -> num_rows() > 0 )
            {   
                foreach ($query->result() as $row)							 
                    { $options[$row->ID_CATALOGOS] = $row->DESCRIPCION; }
            }
        return $options;  
    }

    public function traePagDeptosFiltros($param)
    {   $off  = (($param['pagina']-1) * $param['registrosPagina']);
        
    	$this -> db -> select('count(D.ID_DEPTO) as conteo');
        
        if (!empty($param['f1']))
            { $this -> db -> or_like(array('i.num_file' => $param['f1'] ) ); }
        if (!empty($param['f2']))
            { $this -> db -> or_like(array('i.master' => $param['f2'])); }
        if (!empty($param['f3']))
            { $this -> db -> or_like(array('i.shipper' => $param['f3'])); }                 
        $this->db->where('D.TORRE'      , $param['torre']);
        $this->db->where('D.ID_EDIFICIO', $param['id_edificio']);
        $query = $this->db->get('DEPARTAMENTOS D')->result();
	$conteo = $query[0]->conteo;
        
        $this -> db -> select(' D.ID_DEPTO, D.TORRE, D.NUMERACION, D.STATUS, D.CUMPLIMIENTO, D.ID_EDIFICIO');
        //$this -> db -> select("DATE_FORMAT(`i`.`fecha_exp`,'%d %b %Y') as fecha_exp, CONCAT_WS(' ',`u`.`nombre`,`u`.`apellidos`) as creadoPor  ", FALSE);        
        
        if (!empty($param['f1']))
            { $this -> db -> or_like(array('i.num_file' => $param['f1'] ) ); }
        if (!empty($param['f2']))
            { $this -> db -> or_like(array('i.master' => $param['f2'])); }
        if (!empty($param['f3']))
            { $this -> db -> or_like(array('i.shipper' => $param['f3'])); }                            
        
        $this -> db -> order_by("D.NUMERACION","asc");
        $this->db->where('D.TORRE'      , $param['torre']);
        $this->db->where('D.ID_EDIFICIO', $param['id_edificio']);
        $queryReg = $this -> db -> get('DEPARTAMENTOS D',$param['registrosPagina'],$off);			

        if($queryReg -> num_rows() > 0 )      
           {
           foreach ($queryReg->result_array() as $t) 
           {  
            $this->db->select('U.NOMBRE,U.APELLIDOS, C.DESCRIPCION AS TIPO');            
            $this->db->from('USUARIOS U');
            $this->db->join('DETALLE_DEPTO DE', 'U.CUENTA = DE.CUENTA','inner outer');
            $this->db->join('CATALOGOS C', 'DE.CONTACTO = C.ID_CATALOGOS  ','inner outer');
            $this->db->where('DE.ID_EDIFICIO',$t['ID_EDIFICIO']);
            $this->db->where('DE.TORRE'      ,$t['TORRE']);
            $this->db->where('DE.ID_DEPTO'   ,$t['ID_DEPTO']);
            $querydDET = $this->db->get();
            if($querydDET -> num_rows() > 0 ) 
            { $contactos = "<ul id='cl".$t['ID_EDIFICIO'].$t['TORRE'].$t['ID_DEPTO']."' class='contactoList'>";
              foreach ($querydDET->result_array() as $d) 
                { $contactos .= "<li class='fa fa-user'>".$d['TIPO']." - ".$d['NOMBRE']." ".$d['APELLIDOS']."</li>";}
                $contactos   .= "</ul>";
            }
            else 
            { $contactos = "<ul id='cl".$t['ID_EDIFICIO'].$t['TORRE'].$t['ID_DEPTO']."' class='contactoLis'></ul>";     }
            
            $result[] = array('ID_DEPTO'=>$t['ID_DEPTO'],'TORRE'=>$t['TORRE'],'NUMERACION'=>$t['NUMERACION'],'STATUS'=>$t['STATUS'],'CUMPLIMIENTO'=>$t['CUMPLIMIENTO'],'ID_EDIFICIO'=>$t['ID_EDIFICIO'],"CONTACTOS"=>$contactos);
           }
            
           return array("conteo"=>$conteo, "registros"=>$result, "offset"=>$off); }
	else 
           { return FALSE;  }
    }
    
    public function traePagDeptosFinFiltros($param)
    {   $off  = (($param['pagina']-1) * $param['registrosPagina']);
        
    	$this->db->select('count(D.ID_DEPTO) as conteo');
        
        if (!empty($param['f1']))
            { $this -> db -> or_like(array('i.num_file' => $param['f1'] ) ); }
        if (!empty($param['f2']))
            { $this -> db -> or_like(array('i.master' => $param['f2'])); }
        if (!empty($param['f3']))
            { $this -> db -> or_like(array('i.shipper' => $param['f3'])); }

        $this->db->where('D.TORRE'      , $param['torre']);
        $this->db->where('D.ID_EDIFICIO', $param['id_edificio']);
    
        $query  = $this->db->get('DEPARTAMENTOS D')->result();
	$conteo = $query[0]->conteo;

        $this -> db -> select(' D.ID_DEPTO, D.TORRE, D.NUMERACION, D.STATUS, D.CUMPLIMIENTO, D.ID_EDIFICIO');

        if (!empty($param['f1']))
            { $this -> db -> or_like(array('i.num_file' => $param['f1'] ) ); }
        if (!empty($param['f2']))
            { $this -> db -> or_like(array('i.master' => $param['f2'])); }
        if (!empty($param['f3']))
            { $this -> db -> or_like(array('i.shipper' => $param['f3'])); }                            
        
        $this->db->order_by("D.NUMERACION","asc");
        $this->db->where('D.TORRE'      , $param['torre']);
        $this->db->where('D.ID_EDIFICIO', $param['id_edificio']);
        $queryReg = $this -> db -> get('DEPARTAMENTOS D',$param['registrosPagina'],$off);			

        $util     = new Utils();        
        if($queryReg -> num_rows() > 0 )      
           {
           foreach ($queryReg->result_array() as $t) 
           {
            $cuotasPen = $this->MDL_cuotas->traeCuotasPendientes($t['ID_EDIFICIO'], FALSE, $t['TORRE'], $t['ID_DEPTO']);
            $status    = $util->statusDepto($t, $cuotasPen, date("d") );
           
            $result[] = array('ID_DEPTO'=>$t['ID_DEPTO'],'TORRE'=>$t['TORRE'],'NUMERACION'=>$t['NUMERACION'],'STATUS'=>$status,'CUMPLIMIENTO'=>$t['CUMPLIMIENTO'],'ID_EDIFICIO'=>$t['ID_EDIFICIO']);           
            }
            unset($util); 
            return array("conteo"=>$conteo, "registros"=>$result, "offset"=>$off);
           }                       
	else 
           { unset($util); return FALSE;  }        
    }    
    
    public function traeDeptoAX($param)
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
    
}//MDL_edificio

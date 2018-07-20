<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Modelo para interactuar en la BD
 * 
 * SELECT CUENTA, NOMBRE, APELLIDOS, CONTRASENA, NIVEL_ACCESO, TELEFONO_FIJO, CELULAR, CORREO_VERIFICADO, CELULAR_VERIFICADO, ACTIVO
FROM USUARIOS WHERE 1
 */
 
class MDL_finanzas extends CI_Model {		    

public function poblarRadioButtonTiposPago($campo)
    {    					
        $this -> db -> select('C.ID_CATALOGOS, C.DESCRIPCION');
        $this -> db -> order_by("C.ID_CATALOGOS","ASC");
        $this->db->where('C.CAMPO',  $campo);
        $query = $this -> db -> get('CATALOGOS C');
	$options = array();
        if($query -> num_rows() > 0 )
            {  
                foreach ($query->result() as $row)							 
                    { $options[] =  array('value'=> $row->ID_CATALOGOS,'label'=>$row->DESCRIPCION);}
            }
        return $options;  
    }    
    
public function traeCuotas($depto,$hoy)
    {    					     
     $this->db->select("DATE_FORMAT(`E`.`FECHA_ALTA`,'%Y-%m') as CUOTAS", FALSE);        
     $this->db->from('EDIFICIOS E');        
     $this->db->where('E.ID_EDIFICIO', $depto[0]['ID_EDIFICIO']);
     $this->db->where("DATE_FORMAT(`E`.`FECHA_ALTAs`,'%Y-%m') BETWEEN '".$depto[0]['FECHA_ALTA']."' AND '$hoy'",NULL, FALSE ); 
     $this->db->order_by("E.FECHA_ALTA","DESC");

     $query = $this->db->get();
        
     if($query -> num_rows() > 0 )      
           { return   $query->result_array(); }
	else 
           { return  array();                    }
    }  
    
public function traeCuotasPendientes($depto,$cuotas)
{try{
     $this->db->select("C.CUOTA_DEL_MES as PAGO");
     $this->db->from('CUOTAS C');        
     $this->db->where('C.ID_EDIFICIO', $depto[0]['ID_EDIFICIO']);
     $this->db->where('C.ID_DEPTO'   , $depto[0]['ID_DEPTO']);
     $this->db->where('C.TORRE'      , $depto[0]['TORRE']);     
     $this->db->order_by("C.FECHA_PAGO","DESC");          

     $query = $this->db->get();
      
     foreach ($query->result_array() as $c)
     { $key =array_search($c['PAGO'], $cuotas); 
       unset($cuotas[$key]);
     }      

     return  $cuotas;

    }catch (Exception $e) {echo 'Excepción traeCuotasPendientes:',  $e;}
}    
    
public function traeUltimaCuota($depto,$añoMes)
    {    					
     $this->db->select('C.ID_CUOTA, C.NOMBRE, C.FECHA_PAGO, C.IMPORTE');
     $this->db->from('CUOTAS C');        
     $this->db->where('C.ID_EDIFICIO', $depto[0]['ID_EDIFICIO']);
     $this->db->where('C.ID_DEPTO'   , $depto[0]['ID_DEPTO']);
     $this->db->where('C.TORRE'      , $depto[0]['TORRE']);
     $this->db->order_by("C.FECHA_PAGO","DESC");

     $query = $this->db->get();
        
     if($query -> num_rows() > 0 )      
           { return   $query->result_array()[0]; }
	else 
           { return  array();                    }
    }

public function chartResumenEjecutivo($id_edificio, $mesesLLaves)
    {try{
        $edificio = $this->MDL_edificio->traeEdificio($id_edificio);    
        foreach($mesesLLaves as $m)
        {
            $totales = $this->MDL_gastos->traeTotMesEdoCta($id_edificio, $m['ano'], $m['mes'], $edificio[0]['CUOTA_MANTO'] );
            $gastos  = ($totales['gastos']===NULL & $totales['tm']===NULL)?NULL:$totales['gastos'] + $totales['tm'];
            $balance = ($totales['cuotas']===NULL | $gastos===NULL)?NULL:$totales['cuotas'] - $gastos;
            
            $dataCuotas[]  = $totales['cuotas']===NULL?NULL:floatval($totales['cuotas']);
            $dataGastos[]  = $gastos;
            $dataBalance[] = $balance;
        }        
        $series[] = array("name" => 'Cuotas' , "type" => 'column', "data" => $dataCuotas  ,"yAxis"=> 0);
        $series[] = array("name" => 'Gastos' , "type" => 'column', "data" => $dataGastos  ,"yAxis"=> 1);
        $series[] = array("name" => 'Balance', "type" => 'spline', "data"  => $dataBalance,"yAxis"=> 2);        

        return $series;
        
    }catch (Exception $e) {echo 'Excepción chartResumenEjecutivo:',  $e;} 
            
    }//chartResumenEjecutivo
    
public function chartGaugeCuotas($id_edificio, $ano, $mes )
    {try{
        $edificio  = $this->MDL_edificio->traeEdificio($id_edificio);    
        $maxC      = $edificio[0]['CUOTA_MANTO'] * ($edificio[0]['NUM_TORRES'] * $edificio[0]['NUM_VIVIENDAS'] );
        
        $totales   = $this->MDL_gastos->traeTotMesEdoCta($id_edificio, $ano, $mes, $edificio[0]['CUOTA_MANTO'] );
        $totCuotas = $totales['cuotas']===NULL?0:floatval($totales['cuotas']);            

        return array("current"=>$totCuotas, "max"=>floatval($maxC));
        
    }catch (Exception $e) {echo 'Excepción chartGaugeCuotas:',  $e;} 
            
    }//chartGaugeCuotas
    
public function chartGanttTM($id_edificio, $ano, $util)
    {try{        
        
        $qTM = $this->db->query("SELECT `TA`.`TRABAJO`, `TA`.`STATUS`, DATE_FORMAT(`TA`.`FECHA_INICIO`,'%d-%c-%Y') AS INI, DATE_FORMAT(`TA`.`FECHA_COMPROMISO`,'%d-%c-%Y') AS FIN  FROM `TRABAJOS_MANTO` `TA` WHERE DATE_FORMAT(`TA`.`FECHA_INICIO` ,'%Y') = ".$ano." AND `TA`.`ID_EDIFICIO` = ".$id_edificio." AND `TA`.`STATUS` IN (9,10,12) ", FALSE);               
        $y   = -1;
        foreach ($qTM->result_array() as $tm)
        { $y++;
          $categories[] = array($tm['TRABAJO']);
          $partialFill  = $tm['STATUS']=="10"?1:0;
          $trabajos[]   = array("x"=>$util->dateUCT_javaScript($tm['INI']), "x2"=>$util->dateUCT_javaScript($tm['FIN']), "y"=>$y,"partialFill"=>$partialFill);
        }
        
        return array("categories"=>$categories, "data"=>$trabajos);
        
    }catch (Exception $e) {echo 'Excepción chartGanttTM:',  $e;} 
            
    }//chartGanttTM     
    
}//MDL_finanzas

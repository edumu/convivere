<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Modelo para interactuar en la BD
 * SELECT ID_GASTO,CONCEPTO,MONTO,IVA,TOTAL,COMPROBANTE,FACTURA,FECHA_GASTO,GASTO_FIJO,FECHA_ALTA,ID_EDIFICIO 
 * FROM GASTOS
 */
 
/**
 * SELECT ID_TRABAJOS, TRABAJO, DESCRIPCION, COSTO, TIPO_ANT, ANTICIPO, OBSERVACIONES, EVIDENCIA_ANTES, EVIDENCIA_DESPUES, FECHA_INICIO, DURACION, FECHA_COMPROMISO, FECHA_ALTA, ID_EDIFICIO
 * FROM TRABAJOS_MANTO
 */
class MDL_gastos extends CI_Model {

    public function update_gasto($param)
    {			
	$this->db->where('TORRE'      ,  $param['torre']);
        $this->db->where('ID_DEPTO'   ,  $param['id_depto']);
        $this->db->where('ID_EDIFICIO',  $param['id_edificio']);
        $this->db->update('GASTOS', array("NUMERACION"=>$param['num']));           
    }
    
    public function insert_gasto($data)
    {		
        return $this->db->insert('GASTOS',$data);
    } 
    
    public function insert_gasto_fijo($data)
    {	        
        $this->db->delete ('GASTOS_FIJOS',array('ID_GASTOS' => $data['ID_GASTOS']));           
        return $this->db->insert('GASTOS_FIJOS',$data);
    }
    
    public function delete_gasto($gasto)
    {			
	$this->db->where('ID_GASTO',  $gasto);
       return  $this->db->update('GASTOS', array('ACTIVO' => 0));           
    }
    
    public function delete_gasto_creado($gasto)
    {			
       return  $this->db->delete('GASTOS', array('parentChild' => $gasto));      
    }
       
    public function update_gastoEvidencia($param,$datos)
    {				
        $this->db->where('ID_GASTO'   ,  $param['ID_GASTO']);
        $this->db->where('ID_EDIFICIO',  $param['ID_EDIFICIO']);
        $this->db->update('GASTOS'    ,  $datos);           
    }
    
    public function update_tbjo_manto($param,$datos)
    {				
        $this->db->where('ID_TRABAJOS'    , $param['ID_TRABAJOS']);
        $this->db->where('ID_EDIFICIO' , $param['ID_EDIFICIO']);
        $this->db->update('TRABAJOS_MANTO', $datos);           
    }
    
    public function insert_tbjo_manto($data)
    {		
        return $this->db->insert('TRABAJOS_MANTO',$data);
    }
    
    public function update_presupuesto($param,$datos)
    {				
        $this->db->where('PRESUPUESTO_ID', $param['ID_TRABAJOS']);
        $this->db->where('ID_EDIFICIO'   , $param['ID_EDIFICIO']);
        $this->db->update('PRESUPUESTO'  , $datos);           
    }
    
    public function updateDesactivarPtos($datos)
    {   $this->db->update('PRESUPUESTO' , $datos);  }
    
    public function insert_presupuesto($tabla,$data)
    {		
        return $this->db->insert($tabla,$data);
    }
    
    public function delete_presupuesto($tabla,$data)
    {			
       return  $this->db->delete($tabla, $data);      
    }
    
    public function traePresupuestobyID($pto_id)
    {    					
        $this->db->select('P.PRESUPUESTO_ID, P.NOMBRE_PTO, P.STATUS');
        $this->db->select("DATE_FORMAT(`P`.`INICIO_PTO`,'%m/%d/%Y') as INICIO_PTO, DATE_FORMAT(`P`.`FIN_PTO`,'%m/%d/%Y') as FIN_PTO", FALSE);
        $this->db->where('P.PRESUPUESTO_ID', $pto_id);        
        $query = $this -> db -> get('PRESUPUESTO P');
        
        if($query -> num_rows() > 0 )      
             { $pto = $query->result_array()[0];
               $this->db->select("`PD`.`MES_PTO`, DATE_FORMAT(`PD`.`MES_PTO`,'%m') as CON_PTO_MN, DATE_FORMAT(`PD`.`MES_PTO`,'%Y') as CON_PTO_YR", FALSE);
               $this->db->where('PD.PRESUPUESTO_ID', $pto_id);
               $this->db->group_by('PD.MES_PTO');
               $query = $this->db->get('PRESUPUESTO_DETALLE PD');
               foreach ($query->result() as $row)							 
               { 
                $this->db->select('PD.CONCEPTO, PD.IMPORTE');
                $this->db->select("DATE_FORMAT(`PD`.`MES_PTO`,'%m/%d/%Y') as MES_PTO, DATE_FORMAT(`PD`.`MES_PTO`,'%m') as CON_PTO_MN, DATE_FORMAT(`PD`.`MES_PTO`,'%Y') as CON_PTO_YR", FALSE);
                $this->db->where('PD.PRESUPUESTO_ID', $pto_id);
                $this->db->where('PD.MES_PTO'       , $row->MES_PTO);
                $queryPD  = $this->db->get('PRESUPUESTO_DETALLE PD');                
                $ptoDet[] = array("mes"=>$row->MES_PTO, "CON_PTO_MN"=>$row->CON_PTO_MN, "CON_PTO_YR"=>$row->CON_PTO_YR, "detalle"=>$queryPD->result_array());
               }
               return array("pto"=>$pto, "ptoDet"=>$ptoDet);
             }
        else { return array("pto"=>array(), "ptoDet"=>array()); }
    }
    
    public function reservaIdGasto($idUnico, $id_edificio, $tiene_iva, $nombreCVR, $fecha_alta)
    {	
        $tipoCompro = ( $tiene_iva === TRUE?"FACTURA":"COMPROBANTE");
        $data       = array("CONCEPTO"=>$idUnico,$tipoCompro=>$nombreCVR,"ID_EDIFICIO"=>$id_edificio,"MONTO"=>0,"IVA"=>0,"FECHA_GASTO"=>"","GASTO_FIJO"=>0,"FECHA_ALTA"=>$fecha_alta);
        $this->db->insert('GASTOS',$data);
         
        $this -> db -> select('ID_GASTO');        
        $this->db->where('CONCEPTO'   ,  $idUnico);
        $this->db->where('ID_EDIFICIO',  $id_edificio);
        $query = $this -> db -> get('GASTOS G');
      
        if($query -> num_rows() > 0 )      
              { return   $query->result_array()[0]['ID_GASTO']; }
           else 
              { return  NULL;  }
    }
                
            
    public function traeGastos($param)
    {    					
        $this->db->select('*');
        $this->db->where('TORRE'      ,  $param['torre']);
        $this->db->where('ID_DEPTO'   ,  $param['id_depto']);
        $this->db->where('ID_EDIFICIO',  $param['id_edificio']);
        $query = $this -> db -> get('GASTOS G');
        
     if($query -> num_rows() > 0 )      
           { return   $query->result_array(); }
	else 
           { return  NULL;  }
    }
    
    public function traeEdoCta($id_edificio, $ano, $mes )
    { $this->db->query("SET lc_time_names = 'es_MX'");
      $query = $this->db->query("SELECT DATE_FORMAT(`C`.`FECHA_PAGO`,'%d%c%Y') AS `DIAS`, DATE_FORMAT(`C`.`FECHA_PAGO`,'%a %d - %b - %Y') AS FECHA  FROM `CUOTAS` `C` WHERE DATE_FORMAT(`C`.`FECHA_PAGO` ,'%c%Y') = ".$mes.$ano."  AND `C`.`ID_EDIFICIO` = ".$id_edificio." AND `C`.`STATUS` = '".STATUS_PAG."'  GROUP BY DATE_FORMAT(`C`.`FECHA_PAGO`,'%d%c%Y')
                                 UNION
                                 SELECT DATE_FORMAT(`G`.`FECHA_GASTO`,'%d%c%Y') AS `DIAS`, DATE_FORMAT(`G`.`FECHA_GASTO`,'%a %d - %b - %Y') AS FECHA  FROM `GASTOS` `G` WHERE DATE_FORMAT(`G`.`FECHA_GASTO` ,'%c%Y') = ".$mes.$ano." AND `G`.`ID_EDIFICIO`  = ".$id_edificio." AND `G`.`STATUS` = 1 GROUP BY DATE_FORMAT(`G`.`FECHA_GASTO`,'%d%c%Y')
                                 UNION
                                 SELECT DATE_FORMAT(`TA`.`FECHA_INICIO`,'%d%c%Y') AS `DIAS`, DATE_FORMAT(`TA`.`FECHA_INICIO`,'%a %d - %b - %Y') AS FECHA  FROM `TRABAJOS_MANTO` `TA` WHERE DATE_FORMAT(`TA`.`FECHA_INICIO` ,'%c%Y') = ".$mes.$ano." AND `TA`.`ID_EDIFICIO` = ".$id_edificio." AND `TA`.`STATUS` IN (9,10,12)  GROUP BY DATE_FORMAT(`TA`.`FECHA_INICIO`,'%d%c%Y')
                                 UNION
                                 SELECT DATE_FORMAT(`TD`.`FECHA_COMPROMISO`,'%d%c%Y') AS `DIAS`, DATE_FORMAT(`TD`.`FECHA_COMPROMISO`,'%a %d - %b - %Y') AS FECHA  FROM `TRABAJOS_MANTO` `TD` WHERE DATE_FORMAT(`TD`.`FECHA_COMPROMISO` ,'%c%Y') = ".$mes.$ano." AND `TD`.`ID_EDIFICIO` = ".$id_edificio." AND `TD`.`STATUS` IN (9,10,12)  GROUP BY DATE_FORMAT(`TD`.`FECHA_COMPROMISO`,'%d%c%Y')
                                 UNION
                                 SELECT DATE_FORMAT(`PD`.`MES_PTO`,'%d%c%Y') AS `DIAS`, DATE_FORMAT(`PD`.`MES_PTO`,'%a %d - %b - %Y') AS FECHA  FROM `PRESUPUESTO` `P` INNER JOIN `PRESUPUESTO_DETALLE` `PD` ON `P`.`PRESUPUESTO_ID` = `PD`.`PRESUPUESTO_ID` WHERE DATE_FORMAT(`PD`.`MES_PTO` ,'%c%Y') = ".$mes.$ano." AND `P`.`ID_EDIFICIO` = ".$id_edificio." AND `P`.`STATUS` =".PTO_ACTIVO." GROUP BY DATE_FORMAT(`PD`.`MES_PTO`,'%d%c%Y')
                                 ORDER BY 1",FALSE);       
       $dias      = $query->result_array();
       $cuotas    = array();
       $gastos    = array();
       $trabajosA = array();
       $trabajosD = array();
       $ptos      = array();
       $isPto     = FALSE;
       
       foreach ($dias as $d) {           
           $this->db->select("C.IMPORTE  AS IMPORTE, CONCAT('DEPTO ', COALESCE(DTO.TORRE,''), ' ', DTO.NUMERACION, ' ', C.CUOTA_DEL_MES) AS CONCEPTO");
           $this->db->join  ("DEPARTAMENTOS DTO", "C.ID_DEPTO = DTO.ID_DEPTO ",'inner outer'); 
           $this->db->where ("DATE_FORMAT(`C`.`FECHA_PAGO`,'%d%c%Y') = ".$d['DIAS']." AND `C`.`ID_EDIFICIO` = ".$id_edificio." AND `C`.`STATUS` = '".STATUS_PAG."' and 0=", FALSE);
           $queryC   = $this->db->get('CUOTAS C');
           $cuotas   = $queryC->result_array();

           $this->db->select("G.TOTAL AS IMPORTE, G.CONCEPTO AS CONCEPTO");           
           $this->db->where ("DATE_FORMAT(`G`.`FECHA_GASTO`,'%d%c%Y') = ".$d['DIAS']." AND `G`.`ID_EDIFICIO` = ".$id_edificio." AND `G`.`STATUS` = 1  and 0=", FALSE);
           $queryG   = $this->db->get('GASTOS G');
           $gastos   = $queryG->result_array();

           $this->db->select("(IF(TA.TIPO_ANT='1', TA.ANTICIPO, (TA.COSTO*(TA.ANTICIPO/100)) )) AS IMPORTE, CONCAT('ANTICIPO ',TA.TRABAJO,' ',TA.DESCRIPCION) AS CONCEPTO");           
           $this->db->where ("DATE_FORMAT(`TA`.`FECHA_INICIO`,'%d%c%Y') = ".$d['DIAS']." AND `TA`.`ID_EDIFICIO` = ".$id_edificio." AND `TA`.`STATUS` IN (9,10,12)  and 0=", FALSE);
           $queryTA   = $this->db->get('TRABAJOS_MANTO TA');
           $trabajosA = $queryTA->result_array();

           $this->db->select("(IF(TD.TIPO_ANT='1', (TD.COSTO-TD.ANTICIPO), TD.COSTO-(TD.COSTO*(TD.ANTICIPO/100)) )) AS IMPORTE, CONCAT('LIQUIDACIÓN ',TD.TRABAJO) AS CONCEPTO");           
           $this->db->where ("DATE_FORMAT(`TD`.`FECHA_INICIO`,'%d%c%Y') = ".$d['DIAS']." AND `TD`.`ID_EDIFICIO` = ".$id_edificio." AND `TD`.`STATUS` IN (9,10,12)  and 0=", FALSE);
           $queryTD   = $this->db->get('TRABAJOS_MANTO TD');
           $trabajosD = $queryTD->result_array();

           $this->db->select("PD.IMPORTE AS IMPORTE, PD.CONCEPTO AS CONCEPTO");
           $this->db->join  ("PRESUPUESTO_DETALLE PD", "P.PRESUPUESTO_ID = PD.PRESUPUESTO_ID ",'inner outer'); 
           $this->db->where ("DATE_FORMAT(`PD`.`MES_PTO`,'%d%c%Y') = ".$d['DIAS']." AND `P`.`ID_EDIFICIO` = ".$id_edificio." AND `P`.`STATUS` =".PTO_ACTIVO." and 0=", FALSE);
           $queryP = $this->db->get('PRESUPUESTO P');
           $ptos   = $queryP->result_array();
           if(sizeof($ptos) !==0 )
             { $isPto  = TRUE;   }

           if( sizeof($cuotas)!==0 | sizeof($gastos)!==0 | sizeof($trabajosA)!==0 | sizeof($trabajosD)!==0 | sizeof($ptos)!==0 )
             { $edoCta[] = array("fecha"=>$d['FECHA'],"cuotas"=>$cuotas,"gastos"=>$gastos,"trabajosA"=>$trabajosA,"trabajosD"=>$trabajosD,"ptos"=>$ptos); }
       }              
       
       return array("edoCta"=>$edoCta, "isPto"=>$isPto );
    }
    
    public function traeEdoCtaAcumulado($id_edificio, $ano, $mes )
    {
      $this->db->query("SET lc_time_names = 'es_MX'");
      $query = $this->db->query("SELECT DATE_FORMAT(`C`.`FECHA_PAGO`,'%c%Y') AS `MES_INT`, DATE_FORMAT(`C`.`FECHA_PAGO`,'%b') AS FECHA  FROM `CUOTAS` `C` WHERE (DATE_FORMAT(`C`.`FECHA_PAGO`,'%Y-%c-%d') BETWEEN '".$ano."-01"."-01' AND LAST_DAY('".$ano."-".$mes."-01') )  AND `C`.`ID_EDIFICIO` = ".$id_edificio." AND `C`.`STATUS` = '".STATUS_PAG."'  GROUP BY DATE_FORMAT(`C`.`FECHA_PAGO`,'%b')
                                 UNION
                                 SELECT DATE_FORMAT(`G`.`FECHA_GASTO`,'%c%Y') AS `MES_INT`, DATE_FORMAT(`G`.`FECHA_GASTO`,'%b') AS FECHA  FROM `GASTOS` `G` WHERE (DATE_FORMAT(`G`.`FECHA_GASTO`,'%Y-%c-%d') BETWEEN '".$ano."-01"."-01' AND LAST_DAY('".$ano."-".$mes."-01') ) AND `G`.`ID_EDIFICIO`  = ".$id_edificio."  AND `G`.`STATUS` = 1 GROUP BY DATE_FORMAT(`G`.`FECHA_GASTO`,'%b')
                                 UNION
                                 SELECT DATE_FORMAT(`TA`.`FECHA_INICIO`,'%c%Y') AS `MES_INT`, DATE_FORMAT(`TA`.`FECHA_INICIO`,'%b') AS FECHA  FROM `TRABAJOS_MANTO` `TA` WHERE (DATE_FORMAT(`TA`.`FECHA_INICIO`,'%Y-%c-%d') BETWEEN '".$ano."-01"."-01' AND LAST_DAY('".$ano."-".$mes."-01') ) AND `TA`.`ID_EDIFICIO` = ".$id_edificio." AND `TA`.`STATUS` IN (9,10,12)  GROUP BY DATE_FORMAT(`TA`.`FECHA_INICIO`,'%b')
                                 UNION
                                 SELECT DATE_FORMAT(`TD`.`FECHA_COMPROMISO`,'%c%Y') AS `MES_INT`, DATE_FORMAT(`TD`.`FECHA_COMPROMISO`,'%b') AS FECHA  FROM `TRABAJOS_MANTO` `TD` WHERE (DATE_FORMAT(`TD`.`FECHA_COMPROMISO`,'%Y-%c-%d') BETWEEN '".$ano."-01"."-01' AND LAST_DAY('".$ano."-".$mes."-01') )  AND `TD`.`ID_EDIFICIO` = ".$id_edificio." AND `TD`.`STATUS` IN (9,10,12)  GROUP BY DATE_FORMAT(`TD`.`FECHA_COMPROMISO`,'%b')
                                 ORDER BY 1",FALSE);       
      $meses  = $query->result_array();       
       
      foreach ($meses as $m) { 
        $qCu = $this->db->query("SELECT SUM(`C`.`IMPORTE`) AS TOTAL, DATE_FORMAT(`C`.`FECHA_PAGO`,'%b') AS FECHA FROM `CUOTAS` `C` WHERE DATE_FORMAT(`C`.`FECHA_PAGO` ,'%c%Y') = ".$m['MES_INT']." AND `C`.`ID_EDIFICIO` = ".$id_edificio." AND `C`.`STATUS` = '".STATUS_PAG."' GROUP BY DATE_FORMAT(`C`.`FECHA_PAGO`,'%b') ORDER BY 1",FALSE);
        $cuo = (is_array($qCu->result_array())?$qCu->result_array()[0]['TOTAL']:0);
      
        $qGa = $this->db->query("SELECT SUM(`G`.`TOTAL`) AS TOTAL, DATE_FORMAT(`G`.`FECHA_GASTO`,'%b') AS FECHA FROM `GASTOS` `G` WHERE DATE_FORMAT(`G`.`FECHA_GASTO` ,'%c%Y') = ".$m['MES_INT']." AND `G`.`ID_EDIFICIO` = ".$id_edificio." AND `G`.`STATUS` = 1  GROUP BY DATE_FORMAT(`G`.`FECHA_GASTO`,'%b') ORDER BY 1",FALSE);        
        $gas = (is_array($qGa->result_array())?$qGa->result_array()[0]['TOTAL']:0);
      
        $qTA = $this->db->query("SELECT SUM(IF( `TA`.`TIPO_ANT`='1', `TA`.`ANTICIPO`, (`TA`.`COSTO`*(`TA`.`ANTICIPO`/100)) )) AS TOTAL, DATE_FORMAT(`TA`.`FECHA_INICIO`,'%b') AS FECHA FROM `TRABAJOS_MANTO` `TA` WHERE DATE_FORMAT(`TA`.`FECHA_INICIO` ,'%c%Y') = ".$m['MES_INT']." AND `TA`.`ID_EDIFICIO` = ".$id_edificio." AND `TA`.`STATUS` IN (9,10,12)  GROUP BY DATE_FORMAT(`TA`.`FECHA_INICIO`,'%b') ORDER BY 1",FALSE);               
        $ta  = (is_array($qTA->result_array())?$qTA->result_array()[0]['TOTAL']:0);
      
        $qTD = $this->db->query("SELECT SUM(IF( `TD`.`TIPO_ANT`='1', (`TD`.`COSTO`-`TD`.`ANTICIPO`), `TD`.`COSTO`-(`TD`.`COSTO`*(`TD`.`ANTICIPO`/100)) )) AS TOTAL, DATE_FORMAT(`TD`.`FECHA_COMPROMISO`,'%b ') AS FECHA FROM `TRABAJOS_MANTO` `TD` WHERE DATE_FORMAT(`TD`.`FECHA_COMPROMISO` ,'%c%Y') = ".$m['MES_INT']." AND `TD`.`ID_EDIFICIO` = ".$id_edificio." AND `TD`.`STATUS` IN (9,10,12)  GROUP BY DATE_FORMAT(`TD`.`FECHA_COMPROMISO`,'%b') ORDER BY 1",FALSE);       
        $td  = (is_array($qTD->result_array())?$qTD->result_array()[0]['TOTAL']:0);        
        
        $leyendas[] = $m['FECHA'];
        $cuotasAc[] = $cuo;
        $gastosAc[] = $gas + $ta + $td;
      }
      
      return array("leyendas"=>$leyendas, "cuotas"=>$cuotasAc, "gastos"=>$gastosAc);
    }
    
    public function traeTotMesEdoCta($id_edificio, $ano, $mes, $cuotaFija )
    {      
        $qCu = $this->db->query("SELECT SUM(`C`.`IMPORTE`) AS TOTAL, COUNT(`C`.`ID_CUOTA`) AS NUM, SUM(`C`.`IMPORTE`-".$cuotaFija.") AS PENA FROM `CUOTAS` `C` WHERE DATE_FORMAT(`C`.`FECHA_PAGO` ,'%c%Y') = ".$mes.$ano." AND `C`.`ID_EDIFICIO` = ".$id_edificio." AND `C`.`STATUS` = '".STATUS_PAG."' ", FALSE);
        $cuo     = (is_array($qCu->result_array())?$qCu->result_array()[0]['TOTAL']:0);
        $cuoNum  = (is_array($qCu->result_array())?$qCu->result_array()[0]['NUM']  :0);        
        $cuoPena = (is_array($qCu->result_array())?$qCu->result_array()[0]['PENA'] :0);
      
        $qGa = $this->db->query("SELECT SUM(`G`.`TOTAL`) AS TOTAL, COUNT(`G`.`ID_GASTO`) AS NUM   FROM `GASTOS` `G` WHERE DATE_FORMAT(`G`.`FECHA_GASTO` ,'%c%Y') = ".$mes.$ano." AND `G`.`ID_EDIFICIO` = ".$id_edificio." AND `G`.`STATUS` = 1", FALSE);        
        $gas    = (is_array($qGa->result_array())?$qGa->result_array()[0]['TOTAL']:0);
        $gasNum = (is_array($qGa->result_array())?$qGa->result_array()[0]['NUM']  :0);
      
        $qTM = $this->db->query("SELECT SUM(`TA`.`COSTO`) AS TOTAL,COUNT(`TA`.`ID_TRABAJOS`) AS NUM  FROM `TRABAJOS_MANTO` `TA` WHERE DATE_FORMAT(`TA`.`FECHA_INICIO` ,'%c%Y') = ".$mes.$ano." AND `TA`.`ID_EDIFICIO` = ".$id_edificio." AND `TA`.`STATUS` IN (9,10,12) ", FALSE);               
        $tm    = (is_array($qTM->result_array())?$qTM->result_array()[0]['TOTAL']:0);
        $tmNum = (is_array($qTM->result_array())?$qTM->result_array()[0]['NUM']  :0);
                        
        $qPT = $this->db->query("SELECT SUM(`PD`.`IMPORTE`) AS TOTAL  FROM `PRESUPUESTO` `P` INNER JOIN `PRESUPUESTO_DETALLE` `PD` ON `P`.`PRESUPUESTO_ID` = `PD`.`PRESUPUESTO_ID` WHERE DATE_FORMAT(`PD`.`MES_PTO` ,'%c%Y') = ".$mes.$ano." AND `P`.`ID_EDIFICIO` = ".$id_edificio." AND `P`.`STATUS` =".PTO_ACTIVO, FALSE);
        $pt  = (is_array($qPT->result_array())?$qPT->result_array()[0]['TOTAL']:0);        

      return array("cuotas" => $cuo, "numCuotas" => $cuoNum, "penaCuotas" => $cuoPena, "gastos" => $gas, "numGastos" => $gasNum, "tm" => $tm, "numTM" => $tmNum, "pto" => $pt);
    }
    
    public function traeDetalleChartMesEdoCta($id_edificio, $ano, $mes)
    {      
        $qCu = $this->db->query("SELECT `C`.`IMPORTE`, CONCAT('DEPTO ', COALESCE(D.TORRE,''), ' ', D.NUMERACION) AS CUOTA FROM `CUOTAS` `C` INNER JOIN `DEPARTAMENTOS` `D` ON `C`.`ID_DEPTO` = `D`.`ID_DEPTO` WHERE DATE_FORMAT(`C`.`FECHA_PAGO` ,'%c%Y') = ".$mes.$ano." AND `C`.`ID_EDIFICIO` = ".$id_edificio." AND `C`.`STATUS` = '".STATUS_PAG."' GROUP BY `C`.`IMPORTE`, CONCAT('DEPTO ', COALESCE(D.TORRE,''), ' ', D.NUMERACION) ORDER BY `C`.`FECHA_PAGO`", FALSE);
        foreach ($qCu->result_array() as $c) { $cuo[] = array($c['CUOTA'],floatval($c['IMPORTE']));  }        
      
        $qGa = $this->db->query("SELECT (`G`.`TOTAL`) AS IMPORTE, (`G`.`CONCEPTO`) AS GASTO FROM `GASTOS` `G` WHERE DATE_FORMAT(`G`.`FECHA_GASTO` ,'%c%Y') = ".$mes.$ano." AND `G`.`ID_EDIFICIO` = ".$id_edificio." AND `G`.`STATUS` = 1", FALSE);        
        foreach ($qGa->result_array() as $g) { $gas[] = array($g['GASTO'], floatval($g['IMPORTE']));  }        
      
        $qTM = $this->db->query("SELECT (`TA`.`COSTO`) AS IMPORTE, (`TA`.`TRABAJO`) AS GASTO FROM `TRABAJOS_MANTO` `TA` WHERE DATE_FORMAT(`TA`.`FECHA_INICIO` ,'%c%Y') = ".$mes.$ano." AND `TA`.`ID_EDIFICIO` = ".$id_edificio." AND `TA`.`STATUS` IN (9,10,12) ", FALSE);
        foreach ($qTM->result_array() as $g) { $gas[] = array($g['GASTO'], floatval($g['IMPORTE']));  }        

      return array("cuotas" => $cuo
                  ,"gastos" => $gas//array( array("gas1", 65.3),array("gas2", 8.63),array("gas3"  ,11.11) )
                  );
    }
    
    public function traeGastosbyID($edificio, $gasto)
    {    					
        $this->db->select('G.ID_GASTO, G.CONCEPTO, G.MONTO, G.IVA, G.TOTAL, G.COMPROBANTE, G.FACTURA, G.GASTO_FIJO, G.ID_EDIFICIO, GF.ID_GASTOS_FIJOS, GF.GASTO_CADA_DIAS, GF.GASTO_DURANTE_MESES, G.STATUS');
        $this->db->select("DATE_FORMAT(`G`.`FECHA_GASTO`,'%d/%c/%Y') as FECHA_GASTO, DATE_FORMAT(`G`.`FECHA_ALTA`,'%b %D %Y') as FECHA_ALTA", FALSE);        
        $this->db->join('GASTOS_FIJOS GF', 'G.ID_GASTO = GF.ID_GASTOS','left outer');
        $this->db->where('ID_GASTO'   ,  $gasto);
        $this->db->where('ID_EDIFICIO',  $edificio);
        $query = $this -> db -> get('GASTOS G');
        
     if($query -> num_rows() > 0 )      
           { return   $query->result_array()[0]; }
	else 
           { return  array("ID_GASTO"=>NULL, "CONCEPTO"=>NULL, "MONTO"=>NULL, "IVA"=>NULL, "TOTAL"=>NULL, "COMPROBANTE"=>"", "FACTURA"=>"", "FECHA_GASTO"=>NULL, "GASTO_FIJO"=>NULL, "FECHA_ALTA"=>NULL, "ID_EDIFICIO"=>$edificio, "ID_GASTOS_FIJOS"=>NULL, "GASTO_CADA_DIAS"=>NULL, "GASTO_DURANTE_MESES"=>NULL, "STATUS"=>1) ;  }
    }
    
    public function traeTbjoMtobyID($edificio, $tbjoMto)
    {    					        
        $this->db->select('G.ID_TRABAJOS, G.TRABAJO, G.DESCRIPCION, G.COSTO, G.TIPO_ANT, G.ANTICIPO, G.OBSERVACIONES, G.EVIDENCIA_ANTES, G.EVIDENCIA_DESPUES, G.DURACION, G.ID_EDIFICIO, G.PROVEEDOR, G.STATUS');
        $this->db->select("DATE_FORMAT(`G`.`FECHA_INICIO`,'%d/%c/%Y') as FECHA_INICIO, DATE_FORMAT(`G`.`FECHA_COMPROMISO`,'%d/%c/%Y') as FECHA_COMPROMISO, DATE_FORMAT(`G`.`FECHA_ALTA`,'%d/%c/%Y') as FECHA_ALTA", FALSE);
        $this->db->select("(NULL) AS `NUEVO`", FALSE);
        $this->db->where('ID_TRABAJOS',  $tbjoMto);
        $this->db->where('ID_EDIFICIO',  $edificio);
        $query = $this -> db -> get('TRABAJOS_MANTO G');
        
     if($query -> num_rows() > 0 )      
           { return   $query->result_array()[0]; }
	else 
           { return  array("ID_TRABAJOS"=>intval(substr(now(), -7)), "TRABAJO"=>NULL, "DESCRIPCION"=>NULL, "COSTO"=>NULL, "TIPO_ANT"=>1, "EVIDENCIA_ANTES"=>NULL, "EVIDENCIA_DESPUES"=>NULL, "ANTICIPO"=>NULL, "OBSERVACIONES"=>NULL, "DURACION"=>NULL, "ID_EDIFICIO"=>$edificio, "PROVEEDOR"=>NULL, "STATUS"=>9, "NUEVO"=>"SI" ) ;  }
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
   
    public function traeGastosFiltros($param)
    {   
        $off  = (($param['pagina']-1) * $param['registrosPagina']);
        /****** CONTEO INI*************/
    	$this -> db -> select('count(G.ID_GASTO) as conteo');
        if (!empty($param['f1']) & !empty($param['f2']))
           { $this->db->where("`G`.`FECHA_GASTO` BETWEEN '".$param['f1']."' AND '".$param['f2']."'",NULL, FALSE ); }
        if (!empty($param['f3']))
            { $this -> db -> or_like(array('i.shipper' => $param['f3'])); }
 
        if (is_array($param['id_edificio']))
        { $util = new Utils();
          $edis = $util->edificiosString($param['id_edificio']);
          $this->db->where("`G`.`ID_EDIFICIO` IN $edis",NULL, FALSE ); 
          unset($util);
        }
        else
        { $this->db->where('G.ID_EDIFICIO', $param['id_edificio']);    }
        
        $query = $this->db->get('GASTOS G')->result();
	$conteo = $query[0]->conteo;
        /****** CONTEO FIN*************/
        
        /****** REGISTROS INI*************/
        $this -> db -> select('G.ID_GASTO, G.CONCEPTO, G.MONTO, G.IVA, G.TOTAL, G.COMPROBANTE, G.FACTURA, G.ID_EDIFICIO, G.STATUS');
        $this -> db -> select("DATE_FORMAT(`G`.`FECHA_GASTO`,'%d %b %Y') as FECHA_GASTO, DATE_FORMAT(`G`.`FECHA_ALTA`,'%d %b %Y') as FECHA_ALTA", FALSE);        
        if (!empty($param['f1']) & !empty($param['f2']))
           { $this->db->where("`G`.`FECHA_GASTO` BETWEEN '".$param['f1']."' AND '".$param['f2']."'",NULL, FALSE ); }
        if (!empty($param['f3']))
            { $this -> db -> or_like(array('i.shipper' => $param['f3'])); }                                                     
        if (is_array($param['id_edificio']))
        { $util = new Utils();
          $edis = $util->edificiosString($param['id_edificio']);
          $this->db->where("`G`.`ID_EDIFICIO` IN $edis",NULL, FALSE ); 
          unset($util);
        }
        else
        { $this->db->where('G.ID_EDIFICIO', $param['id_edificio']);    }
        
        $this->db->order_by("G.ID_GASTO","DESC"); 
        $queryReg = $this->db->get('GASTOS G',$param['registrosPagina'],$off);			
        /****** REGISTROS FIN*************/
    
        if($queryReg -> num_rows() > 0 )      
            { return array("conteo"=>$conteo, "registros"=>$queryReg->result_array(), "offset"=>$off,"totales"=>$this->calculaTotales($param)); }
        else 
            { return false;  }                       
    }
    
    private function calculaTotales($param)
    {
        /****** TOTAL GAS INI*************/
    	$this -> db -> select('SUM(G.TOTAL) as TOTAL');
        if (!empty($param['f1']) & !empty($param['f2']))
           { $this->db->where("`G`.`FECHA_GASTO` BETWEEN '".$param['f1']."' AND '".$param['f2']."'",NULL, FALSE ); }
        if (!empty($param['f3']))
            { $this -> db -> or_like(array('i.shipper' => $param['f3'])); }
 
        if (is_array($param['id_edificio']))
        { $util = new Utils();
          $edis = $util->edificiosString($param['id_edificio']);
          $this->db->where("`G`.`ID_EDIFICIO` IN $edis",NULL, FALSE ); 
          unset($util);
        }
        else
        { $this->db->where('G.ID_EDIFICIO', $param['id_edificio']);    }
        
        $this->db->where('G.STATUS', 1);
        $queryGas = $this->db->get('GASTOS G');
        $gas = (is_array($queryGas->result_array())?$queryGas->result_array()[0]['TOTAL']:0);	 
        /****** TOTAL GAS FIN*************/
        
        /****** TOTAL TM INI*************/
    	$this -> db -> select('SUM(TM.COSTO) as TOTAL');
        if (!empty($param['f1']) & !empty($param['f2']))
           { $this->db->where("`TM`.`FECHA_COMPROMISO` BETWEEN '".$param['f1']."' AND '".$param['f2']."'",NULL, FALSE ); }
        if (!empty($param['f3']))
            { $this -> db -> or_like(array('i.shipper' => $param['f3'])); }
 
        if (is_array($param['id_edificio']))
        { $util = new Utils();
          $edis = $util->edificiosString($param['id_edificio']);
          $this->db->where("`TM`.`ID_EDIFICIO` IN $edis",NULL, FALSE ); 
          unset($util);
        }
        else
        { $this->db->where('TM.ID_EDIFICIO', $param['id_edificio']);    }
        
        $this->db->where("`TM`.`STATUS` IN (9,10,12) ",NULL, FALSE ); 
        $queryTM = $this->db->get('TRABAJOS_MANTO TM');
        $tm = (is_array($queryTM->result_array())?$queryTM->result_array()[0]['TOTAL']:0);	 
        /****** TOTAL TM FIN*************/
        
        /****** TOTAL CUOTA INI*************/
    	$this -> db -> select('SUM(C.IMPORTE) as TOTAL');
        if (!empty($param['f1']) & !empty($param['f2']))
           { $this->db->where("`C`.`FECHA_PAGO` BETWEEN '".$param['f1']."' AND '".$param['f2']."'",NULL, FALSE ); }
        if (!empty($param['f3']))
            { $this -> db -> or_like(array('i.shipper' => $param['f3'])); }
 
        if (is_array($param['id_edificio']))
        { $util = new Utils();
          $edis = $util->edificiosString($param['id_edificio']);
          $this->db->where("`C`.`ID_EDIFICIO` IN $edis",NULL, FALSE ); 
          unset($util);
        }
        else
        { $this->db->where('C.ID_EDIFICIO', $param['id_edificio']);    }
        
        $this->db->where('C.STATUS', STATUS_PAG);                 
        $queryC = $this->db->get('CUOTAS C');
        $cuota = (is_array($queryC->result_array())?$queryC->result_array()[0]['TOTAL']:0);	 
        /****** TOTAL CUOTA FIN*************/
        
        /****** TOTAL PTO INI*************/
    	$this->db->select('SUM(PD.IMPORTE) as TOTAL');
        $this->db->join("PRESUPUESTO_DETALLE PD", "P.PRESUPUESTO_ID = PD.PRESUPUESTO_ID ",'inner outer'); 
        if (!empty($param['f1']) & !empty($param['f2']))
           { $this->db->where("`PD`.`MES_PTO` BETWEEN '".$param['f1']."' AND '".$param['f2']."'",NULL, FALSE ); }
        if (!empty($param['f3']))
            { $this -> db -> or_like(array('i.shipper' => $param['f3'])); }
 
        if (is_array($param['id_edificio']))
        { $util = new Utils();
          $edis = $util->edificiosString($param['id_edificio']);
          $this->db->where("`P`.`ID_EDIFICIO` IN $edis",NULL, FALSE ); 
          unset($util);
        }
        else
        { $this->db->where('P.ID_EDIFICIO', $param['id_edificio']);    }
                
        $this->db->where('P.STATUS', PTO_ACTIVO);
        $queryPTO = $this->db->get('PRESUPUESTO P');
        $pto = (is_array($queryPTO->result_array())?$queryPTO->result_array()[0]['TOTAL']:0);	 
        /****** TOTAL PTO FIN*************/
        
        return array("totGas"=>$gas, "totalGasStr"=>"$ ".number_format($gas, 2, '.', ','),"totTM"=>$tm, "totalTMStr"=>"$ ".number_format($tm, 2, '.', ','),"totCuota"=>$cuota, "totalCuotaStr"=>"$ ".number_format($cuota, 2, '.', ','),"totPto"=>$pto, "totalPtoStr"=>"$ ".number_format($pto, 2, '.', ',') );
    }
    
    public function traeTbjoMtoFiltros($param)
    {   
        $off  = (($param['pagina']-1) * $param['registrosPagina']);
        /****** CONTEO INI*************/
    	$this -> db -> select('count(G.ID_TRABAJOS) as conteo');
        if (!empty($param['f1']) & !empty($param['f2']))
           { $this->db->where("`G`.`FECHA_INICIO` BETWEEN '".$param['f1']."' AND '".$param['f2']."'",NULL, FALSE ); }
        if (!empty($param['f3']))
            { $this -> db -> or_like(array('i.shipper' => $param['f3'])); }
 
        if (is_array($param['id_edificio']))
        { $util = new Utils();
          $edis = $util->edificiosString($param['id_edificio']);
          $this->db->where("`G`.`ID_EDIFICIO` IN $edis",NULL, FALSE ); 
          unset($util);
        }
        else
        { $this->db->where('G.ID_EDIFICIO', $param['id_edificio']);    }
        
        $query = $this->db->get('TRABAJOS_MANTO G')->result();
	$conteo = $query[0]->conteo;
        /****** CONTEO FIN*************/        
        /****** REGISTROS INI*************/
        $this -> db -> select('G.ID_TRABAJOS, G.TRABAJO, G.DESCRIPCION, G.COSTO, G.TIPO_ANT, G.ANTICIPO, G.OBSERVACIONES, G.EVIDENCIA_ANTES, G.EVIDENCIA_DESPUES, G.DURACION, G.ID_EDIFICIO, G.PROVEEDOR, G.ORDEN_TRABAJO, G.STATUS');
        $this -> db -> select("DATE_FORMAT(`G`.`FECHA_INICIO`,'%d %b %Y') as FECHA_INICIO, DATE_FORMAT(`G`.`FECHA_COMPROMISO`,'%d %b %Y') as FECHA_COMPROMISO, DATE_FORMAT(`G`.`FECHA_ALTA`,'%d %b %Y') as FECHA_ALTA", FALSE);        
        if (!empty($param['f1']) & !empty($param['f2']))
           { $this->db->where("`G`.`FECHA_INICIO` BETWEEN '".$param['f1']."' AND '".$param['f2']."'",NULL, FALSE ); }
        if (!empty($param['f3']))
            { $this -> db -> or_like(array('i.shipper' => $param['f3'])); }
            
        if (is_array($param['id_edificio']))
        { $util = new Utils();
          $edis = $util->edificiosString($param['id_edificio']);
          $this->db->where("`G`.`ID_EDIFICIO` IN $edis",NULL, FALSE ); 
          unset($util);
        }
        else
        { $this->db->where('G.ID_EDIFICIO', $param['id_edificio']);    }
        
        $this->db->order_by("G.ID_TRABAJOS","DESC"); 
        $queryReg = $this->db->get('TRABAJOS_MANTO G',$param['registrosPagina'],$off);			
        /****** REGISTROS FIN*************/
    
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
    
    public function traePtoActivo($id_edificio)
    {
        $this->db->select('P.PRESUPUESTO_ID');
        $this->db->where ('P.ID_EDIFICIO', $id_edificio);
        $this->db->where ('P.STATUS'     , PTO_ACTIVO);
        $queryReg = $this->db->get('PRESUPUESTO P');

        if($queryReg -> num_rows() > 0 )      
           { return $queryReg->result_array()[0]; }
	else 
           { return 0;                            }
    }
    
}//MDL_edificio

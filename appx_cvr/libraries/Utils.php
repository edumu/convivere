<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Utils
{         
    public function traeCuotas($depto,$hoy)
    {    					     
        $start    = (new DateTime($depto[0]['FECHA_ALTA']))->modify('first day of this month');
        $end      = (new DateTime($hoy))->modify('first day of next month');
        $interval = DateInterval::createFromDateString('1 month');
        $period   = new DatePeriod($start, $interval, $end);
        $meses    = array();

        foreach ($period as $dt) { $meses[] = $dt->format("Y-m"); }
        
        return $meses;
    }
    
    public function trae6MesesAnt($hoy)
    {    					     
        $start    = date ( 'Y-m-d' , strtotime ('-5 month', strtotime($hoy))  );         
        $interval = DateInterval::createFromDateString('1 month');        
        $period   = new DatePeriod(new DateTime($start), $interval, new DateTime($hoy));
        $meses    = array();

        foreach ($period as $dt) { $meses[] = $this->traduceMesCortoEsp($dt->format("M")); }
        $meses[] = $this->traduceMesCortoEsp(date ('M'));
        
        return $meses;
    }
    
    public function trae6MesesAntLlaves($hoy)
    {    					     
        $start    = date ( 'Y-m-d' , strtotime ('-5 month', strtotime($hoy))  );         
        $interval = DateInterval::createFromDateString('1 month');        
        $period   = new DatePeriod(new DateTime($start), $interval, new DateTime($hoy));
        $meses    = array();

        foreach ($period as $dt) { $meses[] = array("mes" => $dt->format("m"),"ano" => $dt->format("Y")); }
        $meses[] = array("mes" => date ( 'm'),"ano" =>date ( 'Y'));
        
        return $meses;
    }
    
    
    public function hoy()
    {		
        $now  = new DateTime();        
        
        return array("date"=>$now,"dateStr"=>$this->fechaEspaniol($now->format('D j \d\e M \d\e\l Y g:i a')),"dateBD"=>$now->format('Y-m-d H:i:s'));
    }
    
    public function mesAñoActual()
    {		
        $now  = new DateTime();        
        
        return $this->fechaEspaniol($now->format('M \d\e\l Y '));
    }
    
    public function vigenciaHoyMas7()
    {		
        $vigencia  = new DateTime();
        $vigencia->add(new DateInterval('P7D'));
        
        return array("date"=>$vigencia,"dateStr"=>$this->fechaEspaniol($vigencia->format('D j \d\e M \d\e\l Y g:i a')),"dateBD"=>$vigencia->format('Y-m-d H:i:s'));
    }
    
    public function fechaEspaniol($mesAtraducir) 
    {
        $meses  = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $months = array("Jan"  ,"Feb"    ,"Mar"  ,"Apr"  ,"May" ,"Jun"  ,"Jul"  ,"Aug"   ,"Sep"       ,"Oct"    ,"Nov"      ,"Dec");
        
        $dias  = array("Sábado","Domingo","Lunes","Martes","Miércoles","Jueves","Viernes");
        $days  = array("Sat"   ,"Sun"    ,"Mon"  ,"Tue"   ,"Wed"      ,"Thu"   ,"Fri");

        $mesesTraducidos = str_replace($months,$meses,$mesAtraducir);
        $diasTraducidps  = str_replace($days,$dias,$mesesTraducidos);

        return $diasTraducidps;
    }
    
    public function traduceMesCortoEsp($mesAtraducir) 
    {
        $meses  = array("Ene","Feb","Mar","Abr","Mayo","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
        $months = array("Jan","Feb","Mar","Apr","May" ,"Jun","Jul","Aug","Sep","Oct","Nov","Dec");
                
        $mesesTraducidos = str_replace($months,$meses,$mesAtraducir);        

        return $mesesTraducidos;
    }
    
    
    public function mesesAcumArray($mes) 
    {
        $tmp = array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
        for($x = 0; $x <= $mes; $x++)
           { $meses[] = $tmp[$x];   }
        return $meses;
    }
    
    public function mesCortoEspanol($mes) 
    {
        $meses = array("","Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
        
        return $meses[$mes];
    }
    
    public function mesLargoEspanol($mes) 
    {
        $meses  = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        
        return $meses[$mes];
    }
    
    public function mesCuotaEspanol($mescuota)
    {
        $mesStr = split("-", $mescuota, 2);
        $mes    = intval($mesStr[1]);
        
        return $this->mesLargoEspanol($mes) . " " .$mesStr[0];
    }
    
    public function creaDirectorio($tipo,$edificio,$torre,$depto)
    {    					     
       if (file_exists($tipo.$edificio) == FALSE)
        { mkdir($tipo.$edificio, 0777); } 
        
        if (file_exists($tipo.$edificio."/".$torre) == FALSE)
        { mkdir($tipo.$edificio."/".$torre, 0777); } 
        
        if (file_exists($tipo.$edificio."/".$torre."/".$depto) == FALSE)
        { mkdir($tipo.$edificio."/".$torre."/".$depto, 0777); } 
        
        return $tipo.$edificio."/".$torre."/".$depto."/";
    }
    
    public function dateUCT_javaScript($fecha)
     {
    try{
        $mda     = split("-", $fecha, 3);
        $dateUCT = gmmktime(0, 0, 0, $mda[1], $mda[0], $mda[2]) * 1000;
     
        return $dateUCT;
        
       }catch (Exception $e) {echo 'Excepción descargaCodigoBarras:',  $e;}
    }
    
    public function descargaCodigoBarras($url,$referenciaOpenPay)
    {
    try{                
        $newfile = DIR_FORMATOS.DIR_CODE_BAR.$referenciaOpenPay.'.jpg';
        $server  = str_replace("sysx_cvr/", "", BASEPATH);
        
        copy($url, $server.$newfile); 
       
        return $newfile;
        
       }catch (Exception $e) {echo 'Excepción descargaCodigoBarras:',  $e;}
    }
    
    public function edificioDepto($cuenta, $acceso, $modelo)
    {
    try{
        switch ($acceso) {
        case ADMIN:
            $ediDepto = array("depto"=>NULL,"edificio"=>$modelo->traeEdificiosPorDefaultAdmin($cuenta),"edificios"=>$modelo->traeEdificiosAdmin($cuenta));
        break;
        case USER:
            $ediDepto = array("depto"=>$modelo->traeDeptosUser($cuenta,"ID_DEPTO"),"torre"=>$modelo->traeDeptosUser($cuenta,"TORRE"),"edificio"=>$modelo->traeDeptosUser($cuenta,"ID_EDIFICIO"));
        break;
        case SUPERADMIN:
            $ediDepto = array("depto"=>NULL,"torre"=>NULL,"edificio"=>$modelo->traeEdificiosPorDefaultAdmin($cuenta),"edificios"=>$modelo->traeEdificiosSuperAdmin());
        break;
        default:
            $ediDepto = array("depto"=>NULL,"edificio"=>NULL);
        break;
        }   
        
        return $ediDepto;
        
        }catch (Exception $e) {echo 'Excepción edificioDepto:',  $e;}
    }

    public function statusDepto($depto, $pagosPendientes, $dia)
    {
    try{$msj     = "";
        $class   = "";
        $classTR = "";
        if (sizeof($pagosPendientes) === 0)
        { $msj     = "<i class='fa fa-check-circle' style='font-size:16px'></i> Cuotas al corriente"; 
          $class   = "msjConfirmation";
          $classTR = "success";
        }
        else
        {$msj = "<i class='fa fa-times' style='font-size:16px'></i> Cuotas pendientes:".br()."<ul>";
          foreach ($pagosPendientes as $c)							 
          { $status .= "<li id='c".$c['CUOTA_PENDIENTE']."' class='msjError'><i class='fa fa-calendar-times-o' style='font-size:15px;color:red'> ".$c['CUOTA_PENDIENTE']."</i></li>"; }
          
          $msj    .= $status."</ul>";
          $class   = "msjError";
          $classTR = "danger";
        }
        
        return array("msj" => $msj, "class" => $class, "classTR" => $classTR);
        
       }catch (Exception $e) {echo 'Excepción statusDepto:',  $e;}
    }
    
    public function ratingDepto($depto, $pagosPendientes)
    {
    try{
        if( sizeof($pagosPendientes) === 0)
        {
            $rating = 4.5;
        }
        else
        { $rating = 1;  }
        
        return $rating;

       }catch (Exception $e) {echo 'Excepción ratingDepto:',  $e;}
    }    
    
    public function edificiosString($edi)
    {
    try{                
        $result = "( ";
        foreach ($edi as $c)							 
          { $result .= "'".$c["ID_EDIFICIO"]."',"; }
                
        return substr($result, 0, strlen($result)-1)." )";
        
       }catch (Exception $e) {echo 'Excepción edificiosString:',  $e;}
    }
    
    public function cuotasString($cuotas)
    {
    try{
        $result = "( ";
        foreach ($cuotas as $c)							 
          { $result .= "'".$c['CUOTAS']."',"; }
                
        return substr($result, 0, strlen($result)-1)." )";
        
       }catch (Exception $e) {echo 'Excepción cuotasString:',  $e;}
    }
    
	
        public function generateRandomString($length = 10) 
        { 
             return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length); 
        } 
        
        public function poblarSelectCuotasP($cuotas)
        {                                
            foreach ($cuotas as $c)            
                { $options[] = array("id"=>$c,"value"=>$c);}
            return $options;  
        }
        
        public function poblarSelectMes_TDC()
        {
            $options = array();         
            $options[0]  = '::Mes::';
            for($x = 1; $x <= 12; $x++)
                { $options[$x] = "$x";}
            return $options;
        }
        
        public function generaReferenciaCuota($depto,$cuotas)
        {
            return "CVR-".$depto[0]['ID_EDIFICIO']."-".$depto[0]['TORRE']."-".$depto[0]['ID_DEPTO']."-".reset($cuotas)."-".substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 3);  
        }
        
        public function traeImporteCuota($depto,$fechaPago,$cuotas)
        {   
            if (sizeof($cuotas) === 0)
            {   $importe = $this->ImporteCuota($depto);
                return array("penalizacion"=>0, "importe"=>$importe['total'], "importeStr"=>"$ ".number_format($importe['total'], 2, '.', ','), "pena"=>0, "penaStr"=>0 );
            }
            else
            {
                $dStart = new DateTime($cuotas[0]['CUOTA_PENDIENTE']."-10");//.$depto[0]['DIA_CORTE']);
                $dEnd   = new DateTime($fechaPago);                        
                $dDiff  = $dEnd->diff($dStart);

                $penalizacion = intval($dDiff->format('%R').$dDiff->days);
                if ($penalizacion < 0 )
                 { $importe = $this->ImporteCuotaPena($depto); }
                else 
                 { $importe = $this->ImporteCuota($depto);     }                        

            return array("penalizacion"=>$penalizacion, "importe"=>$importe['total'], "importeStr"=>"$ ".number_format($importe['total'], 2, '.', ','), "pena"=>$importe['pena'], "penaStr"=>"$ ".number_format($importe['pena'], 2, '.', ',') );
            }
        }
        
        public function ImporteCuotaPena($depto)
        { 
            if ($depto[0]['TIPO_PENALIZACION'] === 1 )
            { return array("total" => doubleval($depto[0]['CUOTA_MANTO']) * (1 + doubleval($depto[0]['PENALIZACION'])/100)
                          ,"pena"  => doubleval($depto[0]['CUOTA_MANTO']) * doubleval($depto[0]['PENALIZACION'])/100
                          );             
            }
            else
            { return array("total" => (doubleval($depto[0]['CUOTA_MANTO']) + doubleval($depto[0]['PENALIZACION']))
                          ,"pena"  => doubleval($depto[0]['PENALIZACION'])
                          );
            }
        }
        
        public function ImporteCuota($depto)
        { 

        return array("total" => doubleval($depto[0]['CUOTA_MANTO'])
                    ,"pena"  => 0
                    );
        }
        
        public function cuotaFija($fecha_gastoP, $gasto_cada_dia, $mes)
        {   $fecha_gasto = str_replace("/", "-", $fecha_gastoP);
            $actual    = (substr($fecha_gasto,2,1)==="-"?$gasto_cada_dia."-".substr($fecha_gasto, 3, 8):"0".$gasto_cada_dia."-".substr($fecha_gasto, 5, 2)."-".substr($fecha_gasto, 0, 4));
            $fecha     = new DateTime($actual);
            $intervalo = new DateInterval("P".$mes."M");
            $fecha->add($intervalo);
            
            return $fecha->format('d-m-Y');
        }
        
        public function poblarSelectAno_TDC($ano)
        {
            $options = array();         
            $options[0]  = '::Año::';
            for($x = $ano; $x <= ($ano+10); $x++)
                { $options[$x] = "$x";}            
            return $options;  
        }               
        
         public function dateFormat($paramDate) 
	{
            if ( empty($paramDate) )
                { return NULL; }                    
            else
                {   $paramDateStr = DateTime::createFromFormat('j#n#Y', $paramDate);
                    return $paramDateStr ->format('Y/m/j');                         
                }                    
	}
        
        public function dateFormatEspComp($paramDate) 
	{
            $paramDateStr = DateTime::createFromFormat('Y#n#j', $paramDate);                    
            $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
            $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
 
            return $dias[$paramDateStr ->format('w')]." ".$paramDateStr ->format('j')." de ".$meses[$paramDateStr ->format('m')-1]. " del ".$paramDateStr ->format('Y') ;                  
	}
        
        public function dateFormatHoyEspComp()
	{
        $dias  = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
 
        return $dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;
        }
        
        public function getOrdenTbjoData($data, $edificio)
        {   $ant = ($data['TIPO_ANT']==1 ?  $data['ANTICIPO']:$data['COSTO']*($data['ANTICIPO']/100));
            $fin = ($data['TIPO_ANT']==1 ? ($data['COSTO']-$data['ANTICIPO']):$data['COSTO']-($data['COSTO']*($data['ANTICIPO']/100)) );
            
            return array("titulo"         => "ORDEN DE TRABAJO"
                        ,"logoConvivere"  => '<img src="style/images/logo/LogoConvivere.png" width="110px" height="60px">'
                        ,"edificio"       => (empty($edificio[0]['LOGOTIPO'])?'':'<img src="logo_edificios/'.$edificio[0]['ID_EDIFICIO'].'/'.$edificio[0]['LOGOTIPO'].'" class="img-circle" width="70px" height="50px">').br().$edificio[0]['NOMBRE']
                        ,"nombreEdificio" => $edificio[0]['NOMBRE']
                        ,"dirEdificio"    => $edificio[0]['CALLE'].nbs().$edificio[0]['NUMERO'].br().$edificio[0]['COLONIA'].br().$edificio[0]['ALCALDIA'].nbs().$edificio[0]['ESTADO']
                        ,"trabajo"        => $data
                        ,"anticipo"       => $ant
                        ,"finiquito"      => $fin
                        ,"costoLetras"    => $this->convertNumToChar($data['COSTO'])
                        ,"anticipoLetras" => $this->convertNumToChar($ant)
                        ,"finiquitoLetras"=> $this->convertNumToChar($fin)
                        ,"fa"             => $this->dateFormatHoyEspComp()
                        ,"fi"             => $this->dateFormatEspComp($data['FECHA_INICIO'])
                        ,"fc"             => $this->dateFormatEspComp($data['FECHA_COMPROMISO'])
                        );        
        }
        
        public function getAvisoMoroData($data, $edificio)
        {
            return array("titulo"         => "AVISO DE MOROSIDAD"
                        ,"logoConvivere"  => '<img src="style/images/logo/LogoConvivere.png" width="110px" height="60px">'
                        ,"edificio"       => (empty($edificio[0]['LOGOTIPO'])?'':'<img src="logo_edificios/'.$edificio[0]['ID_EDIFICIO'].'/'.$edificio[0]['LOGOTIPO'].'" class="img-circle" width="70px" height="50px">').br().$edificio[0]['NOMBRE']
                        ,"nombreEdificio" => $edificio[0]['NOMBRE']
                        ,"dirEdificio"    => $edificio[0]['CALLE'].nbs().$edificio[0]['NUMERO'].br().$edificio[0]['COLONIA'].br().$edificio[0]['ALCALDIA'].nbs().$edificio[0]['ESTADO']
                        ,"morosos"        => $data
                        ,"hoy"            => $this->dateFormatHoyEspComp()                        
                        );        
        }
        
        public function getEdoCtaData($data, $edificio, $edoCtaMes, $edoCtaAcum, $totDatos, $mes_edoCta)
        {   if($data['isPto'])
            { $widthColum = "26.6%"; $widthColumTot="33.3%";}
            else
            { $widthColum = "40%"; $widthColumTot="50%"; }
            $totCuotasEdificio = $edificio[0]['NUM_TORRES'] * $edificio[0]['NUM_VIVIENDAS'];
            return array("titulo"          => "ESTADO DE CUENTA $mes_edoCta"
                        ,"logoConvivere"   => '<img src="style/images/logo/LogoConvivere.png" width="110px" height="60px">'
                        ,"edificio"        => (empty($edificio[0]['LOGOTIPO'])?'':'<img src="logo_edificios/'.$edificio[0]['ID_EDIFICIO'].'/'.$edificio[0]['LOGOTIPO'].'" class="img-circle" width="70px" height="50px">').br().$edificio[0]['NOMBRE']
                        ,"dirEdificio"     => $edificio[0]['CALLE'].nbs().$edificio[0]['NUMERO'].br().$edificio[0]['COLONIA'].br().$edificio[0]['ALCALDIA'].nbs().$edificio[0]['ESTADO']
                        ,"edoCta"          => $data['edoCta']
                        ,"isPto"           => $data['isPto']
                        ,"tot"             => $totDatos
                        ,"totCuotasEdi"    => $totCuotasEdificio
                        ,"totImporteEdi"   => $totCuotasEdificio * $edificio[0]['CUOTA_MANTO']
                        ,"porcentajeCuota" => ($totDatos['numCuotas']/$totCuotasEdificio)*100
                        ,"widthColum"      => $widthColum
                        ,"widthColumTot"   => $widthColumTot
                        ,"mes_edoCta"      => $mes_edoCta
                        ,"chartMesEdoCta"  => '<img src="'.$edoCtaMes.'">'
                        ,"chartAcumEdoCta" => '<img src="'.$edoCtaAcum.'">'
                        );
        }
        
	public function generaNombrePDF($fileName) 
	{
		$newCaracter = array("n", "N", "a","e","i","o","u","A","E","I","O","U");
		$oldCaracter = array("ñ","Ñ","á","é","í","ó","ú","Á","É","Í","Ó","Ú");
		
		$sinAcentos = str_replace($oldCaracter,$newCaracter,$fileName);
		$sinAcentos = str_replace(" ","_", $sinAcentos);
                $sinAcentos = str_replace(")","_", $sinAcentos);
                $sinAcentos = str_replace("(","_", $sinAcentos);
                $sinAcentos = str_replace("&","_", $sinAcentos);
                $sinAcentos = str_replace("%","_", $sinAcentos);
                $sinAcentos = str_replace("|","_", $sinAcentos);
                $sinAcentos = str_replace("°","_", $sinAcentos);
                $sinAcentos = str_replace("!","_", $sinAcentos);
                $sinAcentos = str_replace("@","_", $sinAcentos);
                $sinAcentos = str_replace("#","_", $sinAcentos);
                $sinAcentos = str_replace("$","_", $sinAcentos);
                $sinAcentos = str_replace("/","_", $sinAcentos);
                $sinAcentos = str_replace("\\","_", $sinAcentos);
                $sinAcentos = str_replace("^","_", $sinAcentos);
                $sinAcentos = str_replace("*","_", $sinAcentos);                
                $sinAcentos = str_replace("?","_", $sinAcentos);
                $sinAcentos = str_replace("[","_", $sinAcentos);
                $sinAcentos = str_replace("]","_", $sinAcentos);
                $sinAcentos = str_replace("{","_", $sinAcentos);
                $sinAcentos = str_replace("}","_", $sinAcentos);
                $sinAcentos = str_replace("[","_", $sinAcentos);
                $sinAcentos = str_replace("'","", $sinAcentos);
                $sinAcentos = str_replace("\"","", $sinAcentos);                

		return $sinAcentos;
	}                
	
        public function generaNombre($fileName) 
	{
		$newCaracter = array("n", "N", "a","e","i","o","u","A","E","I","O","U");
		$oldCaracter = array("ñ","Ñ","á","é","í","ó","ú","Á","É","Í","Ó","Ú");
		
		$sinAcentos = str_replace($oldCaracter,$newCaracter,$fileName);
		$sinAcentos = str_replace(" ","_", $sinAcentos);
                $sinAcentos = str_replace(")","_", $sinAcentos);
                $sinAcentos = str_replace("(","_", $sinAcentos);
                $sinAcentos = str_replace("&","_", $sinAcentos);
                $sinAcentos = str_replace("%","_", $sinAcentos);
                $sinAcentos = str_replace("|","_", $sinAcentos);
                $sinAcentos = str_replace("°","_", $sinAcentos);
                $sinAcentos = str_replace("!","_", $sinAcentos);
                $sinAcentos = str_replace("@","_", $sinAcentos);
                $sinAcentos = str_replace("#","_", $sinAcentos);
                $sinAcentos = str_replace("$","_", $sinAcentos);
                $sinAcentos = str_replace("/","_", $sinAcentos);
                $sinAcentos = str_replace("\\","_", $sinAcentos);
                $sinAcentos = str_replace("^","_", $sinAcentos);
                $sinAcentos = str_replace("*","_", $sinAcentos);                
                $sinAcentos = str_replace("?","_", $sinAcentos);
                $sinAcentos = str_replace("[","_", $sinAcentos);
                $sinAcentos = str_replace("]","_", $sinAcentos);
                $sinAcentos = str_replace("{","_", $sinAcentos);
                $sinAcentos = str_replace("}","_", $sinAcentos);
                $sinAcentos = str_replace("[","_", $sinAcentos);
                $sinAcentos = str_replace("'","", $sinAcentos);
                $sinAcentos = str_replace("\"","", $sinAcentos);                

		return $sinAcentos;
	}
        
	public function pdf_create($html, $filename='', $stream=TRUE) 
	{						
		$dompdf = new DOMPDF();
                
   		$dompdf->load_html($html);
                
                $dompdf->render();
		
		if ($stream) 
                { return $dompdf->stream($filename.".pdf"); } 
		else 
                { return $dompdf->output(); }         
	}
		

	public function revisaValorVacio($v_entrada)
	{
            $v_salida = "";
            if (!empty($v_entrada))
               { $v_salida = $v_entrada; }

            return $v_salida;
	}
/** conversor de numeros a letras  **/
private function unidad($numuero){
switch ($numuero)
{
        case 9:  { $numu = "NUEVE"; break; }
        case 8:  { $numu = "OCHO";  break; }
        case 7:  { $numu = "SIETE"; break; }		
        case 6:  { $numu = "SEIS";  break; }		
        case 5:  { $numu = "CINCO"; break; }		
        case 4:  { $numu = "CUATRO";break; }		
        case 3:  { $numu = "TRES";  break; }		
        case 2:  { $numu = "DOS";   break; }		
        case 1:  { $numu = "UN";    break; }		
        case 0:  { $numu = "";      break; }		
}
return $numu;	
}

 private function decena($numdero){
	
		if ($numdero >= 90 && $numdero <= 99)
		{
                    $numd = "NOVENTA ";
                    if ($numdero > 90)
                    { $numd = $numd."Y ".($this->unidad($numdero - 90)); }
		}
		else if ($numdero >= 80 && $numdero <= 89)
		{
                    $numd = "OCHENTA ";
                    if ($numdero > 80)
                    { $numd = $numd."Y ".($this->unidad($numdero - 80)); }
		}
		else if ($numdero >= 70 && $numdero <= 79)
		{
                    $numd = "SETENTA ";
                    if ($numdero > 70)
                    { $numd = $numd."Y ".($this->unidad($numdero - 70)); }
		}
		else if ($numdero >= 60 && $numdero <= 69)
		{
                    $numd = "SESENTA ";
                    if ($numdero > 60)
                    { $numd = $numd."Y ".($this->unidad($numdero - 60)); }
		}
		else if ($numdero >= 50 && $numdero <= 59)
		{
                    $numd = "CINCUENTA ";
                    if ($numdero > 50)
                    { $numd = $numd."Y ".($this->unidad($numdero - 50)); }
		}
		else if ($numdero >= 40 && $numdero <= 49)
		{
                    $numd = "CUARENTA ";
                    if ($numdero > 40)
                    { $numd = $numd."Y ".($this->unidad($numdero - 40)); }
		}
		else if ($numdero >= 30 && $numdero <= 39)
		{
                    $numd = "TREINTA ";
                    if ($numdero > 30)
                    { $numd = $numd."Y ".($this->unidad($numdero - 30)); }
		}
		else if ($numdero >= 20 && $numdero <= 29)
		{
                    if ($numdero == 20)
                    { $numd = "VEINTE ";} 
                    else
                    { $numd = "VEINTI".($this->unidad($numdero - 20));   }
		}
		else if ($numdero >= 10 && $numdero <= 19)
		{
			switch ($numdero){
                        case 10: { $numd = "DIEZ ";       break; }
                        case 11: { $numd = "ONCE ";       break; }
                        case 12: { $numd = "DOCE ";       break; }
                        case 13: { $numd = "TRECE ";      break; }
                        case 14: { $numd = "CATORCE ";    break; }
                        case 15: { $numd = "QUINCE ";     break; }
                        case 16: { $numd = "DIECISEIS ";  break; }
                        case 17: { $numd = "DIECISIETE "; break; }
                        case 18: { $numd = "DIECIOCHO ";  break; }
                        case 19: { $numd = "DIECINUEVE "; break; }
			}	
		}
		else
                 { $numd = $this->unidad($numdero); }
	return $numd;
}

private function centena($numc){
        if ($numc >= 100)
        {
                if ($numc >= 900 && $numc <= 999)
                {
                    $numce = "NOVECIENTOS ";
                    if ($numc > 900)
                    {  $numce = $numce.($this->decena($numc - 900)); }
                }
                else if ($numc >= 800 && $numc <= 899)
                {
                    $numce = "OCHOCIENTOS ";
                    if ($numc > 800)
                    { $numce = $numce.($this->decena($numc - 800)); }
                }
                else if ($numc >= 700 && $numc <= 799)
                {
                    $numce = "SETECIENTOS ";
                    if ($numc > 700)
                    { $numce = $numce.($this->decena($numc - 700)); }
                }
                else if ($numc >= 600 && $numc <= 699)
                {
                    $numce = "SEISCIENTOS ";
                    if ($numc > 600)
                    { $numce = $numce.($this->decena($numc - 600)); }
                }
                else if ($numc >= 500 && $numc <= 599)
                {
                    $numce = "QUINIENTOS ";
                    if ($numc > 500)
                    { $numce = $numce.($this->decena($numc - 500)); }
                }
                else if ($numc >= 400 && $numc <= 499)
                {
                    $numce = "CUATROCIENTOS ";
                    if ($numc > 400)
                    { $numce = $numce.($this->decena($numc - 400)); }
                }
                else if ($numc >= 300 && $numc <= 399)
                {
                    $numce = "TRESCIENTOS ";
                    if ($numc > 300)
                    { $numce = $numce.($this->decena($numc - 300)); }
                }
                else if ($numc >= 200 && $numc <= 299)
                {
                    $numce = "DOSCIENTOS ";
                    if ($numc > 200)
                    { $numce = $numce.($this->decena($numc - 200)); }
                }
                else if ($numc >= 100 && $numc <= 199)
                {
                    if ($numc == 100)
                    { $numce = "CIEN "; }
                    else
                    { $numce = "CIENTO ".($this->decena($numc - 100)); }
                }
        }
        else
        { $numce = $this->decena($numc); }

        return $numce;	
}

private function miles($nummero){
        if ($nummero >= 1000 && $nummero < 2000){ $numm = "MIL ".($this->centena($nummero%1000)); }
        if ($nummero >= 2000 && $nummero <10000){ $numm = $this->unidad(Floor($nummero/1000))." MIL ".($this->centena($nummero%1000)); }
        if ($nummero < 1000)  { $numm = $this->centena($nummero); } 

        return $numm;
}

private function decmiles($numdmero){
        if ($numdmero == 10000) { $numde = "DIEZ MIL"; }
        if ($numdmero > 10000  && $numdmero <20000)  { $numde = $this->decena(Floor($numdmero/1000))."MIL " .($this->centena($numdmero%1000)); }
        if ($numdmero >= 20000 && $numdmero <100000) { $numde = $this->decena(Floor($numdmero/1000))." MIL ".($this->miles($numdmero%1000));  }		
        if ($numdmero < 10000)  { $numde = $this->miles($numdmero); } 

        return $numde;
}		

private function cienmiles($numcmero){
        if ($numcmero == 100000) {  $num_letracm = "CIEN MIL"; }
        if ($numcmero >= 100000 && $numcmero <1000000){ $num_letracm = $this->centena(Floor($numcmero/1000))." MIL ".($this->centena($numcmero%1000)); }
        if ($numcmero < 100000)  { $num_letracm = $this->decmiles($numcmero); }
        return $num_letracm;
}	

private function millon($nummiero){
        if ($nummiero >= 1000000 && $nummiero <2000000) { $num_letramm = "UN MILLON ".($this->cienmiles($nummiero%1000000)); }
        if ($nummiero >= 2000000 && $nummiero <10000000){ $num_letramm = $this->unidad(Floor($nummiero/1000000))." MILLONES ".($this->cienmiles($nummiero%1000000)); }
        if ($nummiero < 1000000)  { $num_letramm = $this->cienmiles($nummiero); }

        return $num_letramm;
}	

private function decmillon($numerodm){
        if ($numerodm == 10000000) { $num_letradmm = "DIEZ MILLONES";          }
        if ($numerodm > 10000000  && $numerodm <20000000)  { $num_letradmm = $this->decena(Floor($numerodm/1000000))."MILLONES ". ($this->cienmiles($numerodm%1000000)); }
        if ($numerodm >= 20000000 && $numerodm <100000000) { $num_letradmm = $this->decena(Floor($numerodm/1000000))." MILLONES ".($this->millon($numerodm%1000000));   }
        if ($numerodm < 10000000)  { $num_letradmm = $this->millon($numerodm); }

        return $num_letradmm;
}

private function cienmillon($numcmeros){
        if ($numcmeros == 100000000) { $num_letracms = "CIEN MILLONES";              }
        if ($numcmeros >= 100000000 && $numcmeros <1000000000){ $num_letracms = $this->centena(Floor($numcmeros/1000000))." MILLONES ".($this->millon($numcmeros%1000000)); }
        if ($numcmeros < 100000000)  { $num_letracms = $this->decmillon($numcmeros); }
        return $num_letracms;
}	

private function milmillon($nummierod){
        if ($nummierod >= 1000000000 && $nummierod <2000000000) { $num_letrammd = "MIL ".($this->cienmillon($nummierod%1000000000)); }
        if ($nummierod >= 2000000000 && $nummierod <10000000000){ $num_letrammd = $this->unidad(Floor($nummierod/1000000000))." MIL ".($this->cienmillon($nummierod%1000000000)); }
        if ($nummierod < 1000000000)  { $num_letrammd = $this->cienmillon($nummierod); }

        return $num_letrammd;
}	
			
		
public function convertNumToChar($numero){ $numf = $this->milmillon($numero);
                                           return $numf." PESOS MXN 00/100" ;
                                         }
        
/** conversor de numeros a letras FIN **/        
        
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Finanzas extends CI_Controller {


public function test()
{  
try{$util = new Utils();
    $ds   = $this->validaSesion(USER,NULL);
    /*
    $fecha_gasto    = "2018/06/21";//"2018/05/23";
    $gasto_cada_dia = "1";    
    $fechaC_F  = $util->cuotaFija($fecha_gasto, $gasto_cada_dia, 1);
    echo 'VER: '.$fechaC_F.  br();
    
    echo 'TEST: '.$util->dateFormatEspComp("2018/06/14");
    echo br().'TEST II: '.$util->dateFormatHoyEspComp();
    
    echo br().' convertir numero 2210 ' . $util->convertNumToChar(1582);
        
    echo br().' CUOTA MES:' . $util->mesCuotaEspanol("2018-06");
    */
    
    $field      = $this->input->post(array('tipoPago', 'referencia', 'importe', 'cuotas','token_id','deviceIdHiddenFieldName','id_depto', 'id_edificio', 'torre'));
    /*
    $tipoPago   = STORE;//CARD;//$field['tipoPago'];
    $mescuota   = "2018-04";//$field['mescuota'];
    $depto      = $this->MDL_edificio->traeE_Depto( ($field['id_edificio']===NULL?$ds['edificio']:$field['id_edificio']), ($field['id_depto']===NULL?$ds['depto']:$field['id_depto']), $ds['cuenta'], $ds['nivelacceso']);
    $edificio   = $this->MDL_edificio->traeEdificio(($field['id_edificio']===NULL?$ds['edificio']:$field['id_edificio']));
    $referencia = $util->generaReferenciaCuota($depto, array($mescuota) );//"CVR-1-A-1110-2018-03-vHO";
    $importe    = $util->traeImporteCuota($depto, date("Y-m-d"), array($mescuota));//array("penalizacion"=>"","importe"=>230, "importeStr"=>"$ 230","pena"=>23, "penaStr"=>"$ 23 " );
    $token_id   = "kkyc1dvibhvtohmvhprd";//$field['token_id'];
    $deviceIdHiddenFieldName = "SietYJgOFYqAG6jMS6gy6QklRb1RTfxj";//$field['deviceIdHiddenFieldName'];
    $importeEnLetras         = "TEST IMPORTE";
    echo br().'VER: '.$depto[0]['DIA_CORTE'];    
    
    $cuotas   =  $this->MDL_cuotas->traeCuotasPendientes("1", TRUE, NULL, NULL);
    foreach($cuotas as $c)
    { echo br().'cuota: '.$c['DEPTO']." - ".$c['CUOTA_PENDIENTE']; }
    */
    $tot =  $this->MDL_cuotas->traeTotCuotasTasa("1", NULL);//"1110");
    echo br().'cuota: '.$tot['TOT_DEPTOS']." - ".$tot['TOT_CUOTAS']." - ".$tot['TOT_TASA']." - ".$tot['TOT_PAGADAS'];
    
    /*
    $me = $util->trae6MesesAntLlaves(date("Y-m-d"));
    foreach($me as $m)
    { echo br().'MES: '.$m; }
    */
    $meses       = $util->trae6MesesAnt(date("Y-m-d"));
    $mesesLLaves = $util->trae6MesesAntLlaves(date("Y-m-d"));
    $title       = "Balance Convivere";         
    $subtitulo   = "Últimos 6 meses ".$meses[0]."-".$meses[5]." ".date("Y");
    $dataChart   = $this->MDL_finanzas->chartResumenEjecutivo($ds['edificio'], $mesesLLaves);
    $data        = array( "series"     => $dataChart
                         ,"categories" => $meses
                        );
    var_dump($dataChart[0]);
    echo br().'dataCHARt: '. $dataChart[1]["name"]." - ".$dataChart[1]["data"];
    echo br().'title: '. $title." - ".$subtitulo;
    unset($util);
    /*
    $this->load->library('PhpChart');
      
    $pChart = new PhpChart();
    $pChart->barChart( array("titulo"=>"Acumulado Edo. Cuenta Ene-Jun 2018", "datosCuotas"=>array(150,220,300,-250,-420,-200,300,200,100), "datosGastos"=>array(140,0,340,-300,-320,-300,200,100,50), "leyendas"=>array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre") ) );
    $pChart->pieChart( array("titulo"=>"Estado de Cuenta Jun 2018", "datos"=>array(40,30), "leyendas"=>array("Cuotas","Gastos")) );    
    unset($pChart);
*/
    
    $this->load->view('portal/TEST',$data);  

/*   $pagoOnline = new Pago();
    echo 'BIEN';
    $dataPago = $this->paramPagoOnline($ds, $this->input->post(array('tipoPago', 'referencia', 'importe', 'mescuota','token_id','deviceIdHiddenFieldName')), DIR_RECIBOS ); 
*/
    }/*catch (OpenpayApiTransactionError $e){ echo 'ERROR on the transaction: '.$e->getMessage().' [error code: ' . $e->getErrorCode().', error category: ' . $e->getCategory().', HTTP code: '. $e->getHttpCode().', request ID: ' . $e->getRequestId() . ']';} 
     catch (OpenpayApiConnectionError $e ){ echo 'ERROR while connecting to the API: ' . $e->getMessage(); } 
     catch (OpenpayApiRequestError $e    ){ echo 'ERROR on the request: ' . $e->getMessage();}      
     catch (OpenpayApiAuthError $e       ){ echo 'ERROR on the authentication: ' . $e->getMessage(); }
     catch (OpenpayApiError $e           ){ echo 'ERROR on the API: ' . $e->getMessage();}      
     */
     catch (Exception $e                 ){ echo 'ERROR Excepción test FINANZAS: ' . $e->getMessage();}
}//test


public function index()
{  
try{    $ds   = $this->validaSesion(USER,NULL);

        $menu = new GeneradorMenu($ds,"Finanzas");                
        $data = $menu->getmenu();
        $util = new Utils();
        $tipoPagoSeleccionado = CARD;
        foreach($this->MDL_finanzas->poblarRadioButtonTiposPago("tipo_pago") as $rd) { $tiposPago = $tiposPago."<label class='radio'><input type='radio' name='tiposPago' class='radioTipoPago' ".($tipoPagoSeleccionado==$rd['value']?"checked":"")." value='".$rd['value']."'><i></i>".$rd['label']."</label>"; }
        
        if ($ds['nivelacceso'] == USER )
        {   $depto     = $this->MDL_edificio->traeE_Depto($ds['edificio'], $ds['depto'], $ds['cuenta'], $ds['nivelacceso']);            
            $cuotasPen = $this->MDL_cuotas->traeCuotasPendientes($depto[0]['ID_EDIFICIO'], FALSE, $depto[0]['TORRE'], $depto[0]['ID_DEPTO']);

            $data['depto']      = $depto;
            $data['status']     = $util->statusDepto($depto, $cuotasPen, date("d") );
            $data['ratingDepto']= $util->ratingDepto($depto, $cuotasPen);
            $data['cuotas']     = $util->poblarSelectCuotasP($cuotasPen);            
            $data['referencia'] = $util->generaReferenciaCuota($depto, $cuotasPen );
            $data['imp']        = $util->traeImporteCuota($depto, date("Y-m-d"), $cuotasPen);
            $data['menu1']      = "Mis Cuotas";
            $data['menu2']      = "Gastos";
            $data['iconMenu1']  = "<i class='fa fa-check'></i>";
            $data['iconMenu2']  = "<i class='fa fa-minus'></i>";            
            $data['hoy']        = date("d/m/Y");            
            $data['edificio']   = $ds['edificio'];
            $data['ptos']       = $this->MDL_edificio->poblarSelectPresupuestos($ds['edificio']);//id_edificio PARAM
            $data['ptoActivo']  = $this->MDL_gastos->traePtoActivo($ds['edificio']);
            
            $data['tiposPagoRadioButton'] = $tiposPago;
        }
        /*** TODO' select para edificios***/
        else {$data['menu1']     = "Gastos";
              $data['menu2']     = "Cuotas";
              $data['iconMenu1'] = "<i class='fa fa-minus'></i>";
              $data['iconMenu2'] = "<i class='fa fa-check'></i>";
              $data['type_ant']  = $this->MDL_edificio->poblarSelectCat("tipo_penal", FALSE);              
              $data['statusTM']  = $this->MDL_edificio->poblarSelectCat("status_tbjo_mto", FALSE);                            
              $data['edificio']  = $ds['edificio'];/*** TODO' select para edificios***/
              $data['edificios'] = $ds['edificios'];//REVISAR
              $data['edif']      = $this->MDL_edificio->poblarSelect();// ojo restringir por nivel acceso y cuenta
              $data['torres']    = array("0"=>'');
              $data['ptos']      = $this->MDL_edificio->poblarSelectPresupuestos("1");//id_edificio PARAM
              $data['ptoActivo'] = $this->MDL_gastos->traePtoActivo("1");//id_edificio PARAM
             }
        $data['statusPTO']      = $this->MDL_edificio->poblarSelectCat("status_pto", FALSE);     
        $data['nivelacceso']    = $ds['nivelacceso'];
        $data['mesAno']         = $util->MesAñoActual();
        $data['incluirOpenPay'] = TRUE;
        
        unset($util); 
        
        $this->load->view('portal/vw_home_fin',$data);

    }catch (OpenpayApiTransactionError $e){ echo 'ERROR on the transaction: '.$e->getMessage().' [error code: ' . $e->getErrorCode().', error category: ' . $e->getCategory().', HTTP code: '. $e->getHttpCode().', request ID: ' . $e->getRequestId() . ']';} 
     catch (OpenpayApiConnectionError $e ){ echo 'ERROR while connecting to the API: ' . $e->getMessage(); } 
     catch (OpenpayApiRequestError $e    ){ echo 'ERROR on the request: ' . $e->getMessage();}      
     catch (OpenpayApiAuthError $e       ){ echo 'ERROR on the authentication: ' . $e->getMessage(); }
     catch (OpenpayApiError $e           ){ echo 'ERROR on the API: ' . $e->getMessage();} 
     catch (Exception $e                 ){ echo 'ERROR Excepción Index FINANZAS: ' . $e->getMessage();}
}//index

public function pagoTarjetaAX()
{   $ds         = $this->validaSesion(USER,NULL);
    $msjError   = array("desc"=>NULL, "codigo"=>NULL);
    $pagoOnline = new Pago();
    $dataPago   = $this->paramPagoOnline($ds, $this->input->post(array('tipoPago', 'referencia', 'importe', 'cuotas','token_id','deviceIdHiddenFieldName')), DIR_RECIBOS ); 
    
try{$this->load->library('PDF');
    $chargeData = $pagoOnline->getChargeDataCard($dataPago);    
    $charge     = $pagoOnline->createCharge($chargeData);
    
    $paramPDF   = $pagoOnline->getFormatoPagoCard($dataPago, $charge);
    $htmlPDF    = $this->load->view('portal/vw_formato_recibo_pago_pdf', $paramPDF, TRUE);  
    $formatoPagoPDF = new PDF($dataPago['dir'].$dataPago['fileName'], $htmlPDF);    
    $formatoPagoPDF->crearPDF();
    $linkRecbioPDF  = $pagoOnline->getFormatoPago($dataPago, "Recibo Pago de Manto. ".$dataPago['mescuota']); 

    $cuota = $pagoOnline->getCuotaCard($dataPago, $formatoPagoPDF, $charge->authorization, $charge->id);
    $this->MDL_cuotas->insert_cuota($cuota);

   }catch (OpenpayApiTransactionError  $e){ $msjError = array("desc"=>$pagoOnline->getDescriptionError($e->getErrorCode(),$dataPago), "codigo"=>$e->getErrorCode()); /*echo 'ERROR on the transaction: '.$e->getMessage().' [error code: ' . $e->getErrorCode().', error category: ' . $e->getCategory().', HTTP code: '. $e->getHttpCode().', request ID: ' . $e->getRequestId() . ']';*/} 
    catch (OpenpayApiConnectionError $e  ){ $msjError = 'ERROR while connecting to the API: ' . $e->getMessage(); } 
    catch (OpenpayApiRequestError $e     ){ $msjError = 'ERROR on the request: ' . $e->getMessage();}      
    catch (OpenpayApiAuthError $e        ){ $msjError = 'ERROR on the authentication: ' . $e->getMessage(); }
    catch (OpenpayApiError $e            ){ $msjError = 'ERROR on the API: ' . $e->getMessage();} 
    catch (Exception $e                  ){ $msjError = 'ERROR Excepción Index FINANZAS: ' . $e->getMessage();}
    
  unset($pagoOnline);
  
  echo json_encode ( array ("op"=>$charge, "error"=>$msjError, "linkRecbioPDF"=>$linkRecbioPDF ) );
}//pagoTarjeta


public function tipoPagoAX()
{
 try{   
     $ds       = $this->validaSesion(USER,NULL);     
     $dataPago = $this->paramPagoOnline($ds, $this->input->post(array('tipoPago', 'referencia', 'importe', 'cuotas','token_id','deviceIdHiddenFieldName','id_depto', 'id_edificio', 'torre')), DIR_FORMATOS ); 
     $formTP   = $this->tipoPagoOpenPayAX($dataPago);

     echo json_encode ($formTP);        
        
    }catch (Exception $e ){ echo 'ERROR tipoPagoAX  Excepción : ' . $e->getMessage();}
}//tipoPagoAX

public function traeReferenciaAX()
{
 try{
     $ds         = $this->validaSesion(USER,NULL);   
     $util       = new Utils();
     $cuota      = $this->input->post('cuota');
     $id_edificio= $this->input->post('id_edificio');
     $id_depto   = $this->input->post('id_depto');     
     $depto      = $this->MDL_edificio->traeE_Depto(($id_edificio===NULL?$ds['edificio']:$id_edificio), ($id_depto===NULL?$ds['depto']:$id_depto), $ds['cuenta'], $ds['nivelacceso']);
     $referencia = $util->generaReferenciaCuota($depto, array($cuota) );
     $imp        = $util->traeImporteCuota($depto, date("Y-m-d"), array($cuota));
    
     unset($util);

     echo json_encode (array("referencia"=>$referencia,"cuota"=>$cuota,"imp"=>$imp));
        
    }catch (Exception $e ){ echo 'ERROR traeReferenciaAX  Excepción : ' . $e->getMessage();}
}//traeReferenciaAX

private function paramPagoOnline($ds, $field, $paramDir)
{
try{$u    = $this->MDL_usuario->traeUsuario($ds['cuenta']);
    $util = new Utils();
 /*
    $tipoPago   = STORE;//CARD;//$field['tipoPago'];
    $mescuota   = "2018-04";//$field['mescuota'];
    $depto      = $this->MDL_edificio->traeE_Depto( ($field['id_edificio']===NULL?$ds['edificio']:$field['id_edificio']), ($field['id_depto']===NULL?$ds['depto']:$field['id_depto']), $ds['cuenta'], $ds['nivelacceso']);
    $edificio   = $this->MDL_edificio->traeEdificio(($field['id_edificio']===NULL?$ds['edificio']:$field['id_edificio']));
    $referencia = $util->generaReferenciaCuota($depto, array($mescuota) );//"CVR-1-A-1110-2018-03-vHO";
    $importe    = $util->traeImporteCuota($depto, date("Y-m-d"), array($mescuota));//array("penalizacion"=>"","importe"=>230, "importeStr"=>"$ 230","pena"=>23, "penaStr"=>"$ 23 " );
    $token_id   = "kkyc1dvibhvtohmvhprd";//$field['token_id'];
    $deviceIdHiddenFieldName = "SietYJgOFYqAG6jMS6gy6QklRb1RTfxj";//$field['deviceIdHiddenFieldName'];
    $importeEnLetras         = "TEST IMPORTE";
*/
    $tipoPago   = $field['tipoPago'];
    $mescuota   = $field['cuotas'];
    $id_edificio= ( isset($field['id_edificio'])?$ds['edificio']:$field['id_edificio']);
    $id_depto   = ( isset($field['id_depto'])?$ds['depto']:$field['id_depto']);
    $depto      = $this->MDL_edificio->traeE_Depto ($id_edificio,$id_depto, $ds['cuenta'], $ds['nivelacceso']);
    $edificio   = $this->MDL_edificio->traeEdificio($id_edificio);
    $referencia = $util->generaReferenciaCuota($depto, array($mescuota) );
    $importe    = $util->traeImporteCuota($depto, date("Y-m-d"), array($mescuota));    
    $token_id   = $field['token_id'];
    
    $deviceIdHiddenFieldName = $field['deviceIdHiddenFieldName'];
    $importeEnLetras         = $util->convertNumToChar($importe['importe']);    
  
    $customer   = array('name' => $u[0]['NOMBRE'],'last_name' => $u[0]['APELLIDOS'],'phone_number' => $u[0]['CELULAR'],'email' => $ds['cuenta'],'edificio'=>$ds['edificio']);
    $dir        = $util->creaDirectorio($paramDir, $ds['edificio'], $this->MDL_usuario->traeDeptosUser($ds['cuenta'],"TORRE"), $ds['depto']);
    $fileName   = $referencia.".pdf";
        
    return array("tipoPago"=>$tipoPago, "referencia"=>$referencia, "imp"=>$importe, "mescuota"=>$mescuota, "customer"=>$customer, "dir"=>$dir, "fileName"=>$fileName, "hoy"=>$util->hoy(), "vigencia"=>$util->vigenciaHoyMas7(), "token_id"=>$token_id, "deviceIdHiddenFieldName"=>$deviceIdHiddenFieldName, "edificio"=>$edificio, "depto"=>$depto, "importeEnLetras"=>$importeEnLetras, "mescuotaEspanol"=>$util->mesCuotaEspanol($mescuota) );
    
   }catch (Exception $e ){ echo 'ERROR paramPagoOnline  Excepción: ' . $e->getMessage();}
}

private function tipoPagoOpenPayAX($dataPago)
{$formTipoPago = ""; 
try{ $this->load->library('PDF');
     $charge   = NULL;            
     switch ($dataPago['tipoPago']) 
            { case CARD: 
                 $recibo = array();
                
                 $formTipoPago    = $this->load->view('portal/webpart_formOpenPay' , $recibo , true );
                 $divFooter       = "";                 
                 $busquedaTiendas = "";                 
              break;
              case BANK: $pagoOnline = new Pago();                                    
                         $chargeData = $pagoOnline->getChargeDataBank($dataPago);
                         $charge     = $pagoOnline->createCharge($chargeData);                  

                         $paramPDF       = $pagoOnline->getFormatoPagoBank($dataPago, $charge, TRUE );
                         $paramHTML      = $pagoOnline->getFormatoPagoBank($dataPago, $charge, FALSE);
                         $htmlPDF        = $this->load->view('portal/vw_formato_pago_pdf' , $paramPDF , true );                          
                         $formatoPagoPDF = new PDF($dataPago['dir'].$dataPago['fileName'], $htmlPDF);             
                         $formatoPagoPDF->crearPDF();

                         $cuota = $pagoOnline->getCuotaBank($dataPago, $formatoPagoPDF, $charge->payment_method->name, $charge->id);
                         $this->MDL_cuotas->insert_cuota($cuota);           
            
                         $formTipoPago    = $this->load->view('portal/webpart_formato_pago', $paramHTML , true );                              
                         $divFooter       = $pagoOnline->getFormatoPago($dataPago, "Formato de Pago en Efectivo Banco");                         
                         $busquedaTiendas = "";
                         
                         unset($pagoOnline);
                         unset($formatoPagoPDF);
              break;
              case STORE: $pagoOnline = new Pago();
                          $util       = new Utils();
                          
                          $chargeData = $pagoOnline->getChargeDataStore($dataPago);
                          $charge     = $pagoOnline->createCharge($chargeData);                          
                          $barcode    = $util->descargaCodigoBarras($charge->payment_method->barcode_url,$charge->payment_method->reference);                         

                          $paramPDF       = $pagoOnline->getFormatoPagoStore($dataPago, $charge, $barcode, TRUE );                 
                          $paramHTML      = $pagoOnline->getFormatoPagoStore($dataPago, $charge, $barcode, FALSE);
                          $htmlPDF        = $this->load->view('portal/vw_formato_pago_pdf', $paramPDF , true );            
                          $formatoPagoPDF = new PDF($dataPago['dir'].$dataPago['fileName'], $htmlPDF);             
                          $formatoPagoPDF->crearPDF();
                                  
                          $cuota = $pagoOnline->getCuotaStore($dataPago, $formatoPagoPDF, $charge->payment_method->reference, $charge->id);
                          $this->MDL_cuotas->insert_cuota($cuota);
  
                          $formTipoPago    = $this->load->view('portal/webpart_formato_pago', $paramHTML , true );
                          $divFooter       = $pagoOnline->getFormatoPago($dataPago, "Formato de Pago en Efectivo Tienda");
                        //  $dirEdificio     = $this->MDL_edificio->traeEdificio($dataPago['customer']['edificio']);
                          $busquedaTiendas = '<section class="col col-4" ><i class="fa fa-search" id="togSearchTiendas"> Mapa de Tiendas para realizar pago</i></section>'
                                  . '         <section class="col col-11"><div id="frameBusquedaTiendas"><iframe width="750" height="450" frameborder="0" allowfullscreen src="https://s3.amazonaws.com/public.openpay.mx/mapa-tiendas/index.html?locationNotAllowed=true"></iframe></div></section>';
                          unset($pagoOnline);
                          unset($formatoPagoPDF);
                          unset($util);
              break;
            }

      return array("formTipoPago"=>$formTipoPago, "divFooter"=>$divFooter, "busquedaTiendas"=>$busquedaTiendas, "referencia"=>$dataPago['referencia'], "imp"=>$dataPago['imp']);

    }catch (OpenpayApiTransactionError $e){ echo 'OpenpayApiTransactionError tipoPagoOpenPayAX on the transaction: '.$e->getMessage().' [error code: ' . $e->getErrorCode().', error category: ' . $e->getCategory().', HTTP code: '. $e->getHttpCode().', request ID: ' . $e->getRequestId() . ']';} 
     catch (OpenpayApiConnectionError $e ){ echo 'OpenpayApiConnectionError tipoPagoOpenPayAX while connecting to the API: ' . $e->getMessage(); } 
     catch (OpenpayApiRequestError $e    ){ echo 'OpenpayApiRequestError tipoPagoOpenPayAX  on the request: ' . $e->getMessage();}      
     catch (OpenpayApiAuthError $e       ){ echo 'OpenpayApiAuthError tipoPagoOpenPayAX  on the authentication: ' . $e->getMessage(); }
     catch (OpenpayApiError $e           ){ echo 'OpenpayApiError tipoPagoOpenPayAX  on the API: ' . $e->getMessage();}        
     catch (Exception $e                 ){ echo 'Exception ERROR tipoPagoOpenPayAX '.$dataPago['tipoPago'].' Excepción : ' . $e->getMessage();}
}//tipoPagoOpenPayAX       



public function saveGastoAX($id_edificio=NULL)
{
 try{$this->load->helper('date');
     $util = new Utils();

     $id_gasto            = $this -> input -> post('id_gasto');
     $concepto            = $this -> input -> post('concepto');
     $monto               = $this -> input -> post('monto');
     $total               = $this -> input -> post('total');
     $tiene_iva           = ($this->input->post('tiene_iva' )=="SI"?1:0);
     $gasto_fijo          = ($this->input->post('gasto_fijo')=="SI"?1:0);
     $fecha_gasto         = $util -> dateFormat($this -> input -> post('fecha_gasto'));     
     $gasto_cada_dia      = $this -> input -> post('gasto_cada_dia');
     $gasto_durante_meses = $this -> input -> post('gasto_durante_meses');
     $gastoAdjunto        = $this -> input -> post('gastoAdjunto');
     $factuComp           = ($tiene_iva===1?$gastoAdjunto:"");
     $comprobante         = ($tiene_iva===1?"":$gastoAdjunto);
     $datos               = array("CONCEPTO"=>$concepto,"MONTO"=>$monto,"IVA"=>$tiene_iva,"TOTAL"=>$total,"FACTURA"=>$factuComp,"COMPROBANTE"=>$comprobante,"FECHA_GASTO"=>$fecha_gasto,"GASTO_FIJO"=>$gasto_fijo);
     
     $this->MDL_gastos->update_gastoEvidencia(array('id_gasto'=>$id_gasto, 'id_edificio'=>$id_edificio), $datos);
     $this->MDL_gastos->delete_gasto_creado($id_gasto);
    
     for ($i = 1; $i <= $gasto_durante_meses; $i++) 
     {        
        $fechaC_F  = $util->cuotaFija($fecha_gasto, $gasto_cada_dia, $i);
        $data      = array("CONCEPTO"=>$concepto,"MONTO"=>$monto,"IVA"=>$tiene_iva,"TOTAL"=>$total,"FECHA_GASTO"=>$fechaC_F,"GASTO_FIJO"=>$gasto_fijo,"FECHA_ALTA"=>standard_date('DATE_W3C', time()),"ID_EDIFICIO"=>$id_edificio,"parentChild"=>$id_gasto);
        $this->MDL_gastos->insert_gasto($data);
     }
     if ($gasto_fijo === 1) { $this->MDL_gastos->insert_gasto_fijo(array("ID_GASTOS"=>$id_gasto,"GASTO_CADA_DIAS"=>$gasto_cada_dia,"GASTO_DURANTE_MESES"=>$gasto_durante_meses)); }
    
     unset($util);
     
     echo json_encode (array("resp"=>$fecha_gasto."-".$fechaC_F));
     
    }catch (Exception $e ){ echo 'ERROR saveGastoAX  Excepción : ' . $e->getMessage();}
}//saveGastoAX


public function savetbjoMantoAX($id_edificio=NULL)
{
 try{$this->load->library('PDF');
     $util = new Utils();
     
     $id_tbjoManto     = $this -> input -> post('id_tbjoManto');
     $nuevoTM          = $this -> input -> post('nuevoTM');
     $trabajo          = $this -> input -> post('trabajo');
     $tbjo_desc        = $this -> input -> post('tbjo_desc');
     $type_ant         = $this -> input -> post('type_ant');
     $anticipo         = $this -> input -> post('anticipo');
     $costo            = $this -> input -> post('costo');
     $duracion         = $this -> input -> post('duracion' );          
     $fecha_inicio     = $util -> dateFormat($this->input->post('fecha_inicioTM'));
     $fecha_compromiso = $util -> dateFormat($this->input->post('fecha_finTM'));     

     $obs              = $this -> input -> post('obsTM');
     $status           = $this -> input -> post('statusTM');
     $provee           = $this -> input -> post('proveedorTM');     
     
     $path             = DIR_TBJO_MANTO . $id_edificio."/";
     $tbjoMantoA       = $this->input->post('txtTbjoMantoA')==NULL?NULL:$path.$this->input->post('txtTbjoMantoA');
     $tbjoMantoD       = $this->input->post('txtTbjoMantoD')==NULL?NULL:$path.$this->input->post('txtTbjoMantoD');
     
     $fileNameOT       = $path.SELLO."_TBJ_MTO_".$id_tbjoManto.".pdf";     
     $edificio         = $this->MDL_edificio->traeEdificio($id_edificio);    
     $datos            = array("ID_TRABAJOS"=>$id_tbjoManto, "TRABAJO"=>$trabajo, "DESCRIPCION"=>$tbjo_desc, "COSTO"=>$costo, "TIPO_ANT"=>$type_ant, "ANTICIPO"=>$anticipo, "DURACION"=>$duracion, "OBSERVACIONES"=>$obs, "EVIDENCIA_ANTES"=>$tbjoMantoA, "EVIDENCIA_DESPUES"=>$tbjoMantoD, "FECHA_INICIO"=>$fecha_inicio, "FECHA_COMPROMISO"=>$fecha_compromiso, "FECHA_ALTA"=>standard_date('DATE_W3C', time()), "ID_EDIFICIO"=>$id_edificio, "STATUS"=>$status, "PROVEEDOR"=>$provee, "ORDEN_TRABAJO"=>$fileNameOT);
     
     if($nuevoTM == NULL || $nuevoTM == "")
          {  $this->MDL_gastos->update_tbjo_manto(array("ID_TRABAJOS"=>$id_tbjoManto,"ID_EDIFICIO"=>$id_edificio), $datos);     }
     else {  $this->MDL_gastos->insert_tbjo_manto($datos);      }
   
     if ( file_exists($fileNameOT) )
        { unlink($fileNameOT);     }
        
     $htmlPDF        = $this->load->view('portal/vw_formato_orden_tbjo', $util->getOrdenTbjoData($datos, $edificio), TRUE);     
     $formatoPagoPDF = new PDF($fileNameOT, $htmlPDF);
     $formatoPagoPDF->crearPDF();
     
     unset($util);
     
     echo json_encode (array("orden_tbjo"=>$fileNameOT));
      
    }catch (Exception $e ){ echo 'ERROR savetbjoMantoAX  Excepción : ' . $e->getMessage();}
}//savetbjoMantoAX 

public function	borraRegistroAX()
{	
try{$vs = $this->validaSesion(USER,TRUE);  
    if( isset($vs['session']))
    {   echo json_encode ($vs); 
        exit(0);
    }
    
    $tipo          = $this -> input -> post('tipo');
    $id_registro   = $this -> input -> post('id_registro');   
    $id_edificio   = $this -> input -> post('id_edificio');   

    switch ($tipo) 
    {case "gastos":                  
         $param = array("ID_GASTO" => $id_registro, "ID_EDIFICIO" => $id_edificio);
         $datos = array("STATUS"   => 0);
         $this->MDL_gastos->update_gastoEvidencia($param,$datos);
     break;
 
     case "tbjoMto";         
         $param = array("ID_TRABAJOS" => $id_registro, "ID_EDIFICIO" => $id_edificio);         
         $datos = array("STATUS" => 11);
         $this->MDL_gastos->update_tbjo_manto($param,$datos);
     break;

    } 

    echo json_encode (array("tipo" => $tipo, "id_registro" => $id_registro, "id_edificio" => $id_edificio));

    } catch (Exception $e) {echo 'borraRegistroAX Excepción: ',  $e, "\n";}	
}//borraRegistroAX

public function generaPtoAX()
{
 try{$this->load->helper('date');
     $util = new Utils();
     
     $id           = ($this->input->post('id_pto')=="")?substr(''.now(),-5):$this->input->post('id_pto');
     $nuevo        = ($this->input->post('id_pto')=="")? TRUE : FALSE;
     $nombre       = $this -> input -> post('nombre_pto' );
     $id_edificio  = $this -> input -> post('edificioPto' );
     $statusPto    = $this -> input -> post('statusPto' );
     $fecha_inicio = $util -> dateFormat($this -> input -> post('fecha_ini'));
     $fecha_fin    = $util -> dateFormat($this -> input -> post('fecha_fin'));
     
     $this->MDL_gastos->delete_presupuesto('PRESUPUESTO_DETALLE', array('PRESUPUESTO_ID'=>$id));
     $this->MDL_gastos->delete_presupuesto('PRESUPUESTO'        , array('PRESUPUESTO_ID'=>$id));
     
     if( $statusPto == PTO_ACTIVO)
       { $this->MDL_gastos->updateDesactivarPtos( array("STATUS"=>PTO_DESACTIVADO) );  }
      
     $datos = array("PRESUPUESTO_ID"=>$id,"NOMBRE_PTO"=>$nombre,"INICIO_PTO"=>$fecha_inicio,"FIN_PTO"=>$fecha_fin,"ID_EDIFICIO"=>$id_edificio,"STATUS"=>$statusPto,"FECHA_ALTA"=>standard_date('DATE_W3C', time()));
     $this->MDL_gastos->insert_presupuesto('PRESUPUESTO',$datos);     

     $year1 = date('Y', strtotime($fecha_inicio) );
     $year2 = date('Y', strtotime($fecha_fin) );

     $month1 = date('m', strtotime($fecha_inicio) );
     $month2 = date('m', strtotime($fecha_fin) );

     $totMonths = (($year2 - $year1) * 12) + ($month2 - $month1);       
     $tempMont = $month1 - 1;
     
     for ($m = 0; $m <= $totMonths; $m++)
     {
        $totalConceptos = $this->input->post('totConceptos'.($m+$tempMont).$year1);
        for ($c = 0; $c <= $totalConceptos; $c++)
        {
          $concepto = $this->input->post('conceptoPto'.($m+$tempMont).$year1.$c);
          $importe  = $this->input->post('importePto' .($m+$tempMont).$year1.$c);
          $datos = array("CONCEPTO"=>$concepto, "IMPORTE"=>$importe, "MES_PTO"=>$year1.'-'.($month1+$m).'-01', "PRESUPUESTO_ID"=>$id);
          if($concepto !== NULL & $importe !== NULL)
            { $this->MDL_gastos->insert_presupuesto('PRESUPUESTO_DETALLE',$datos); }
        }
     }

     unset($util);
     
     echo json_encode (array("idPto"=>$id, "pto"=>$nombre,"nuevo"=>$nuevo));
      
    }catch (Exception $e ){ echo 'ERROR generaPtoAX  Excepción : ' . $e->getMessage();}
}//generaPtoAX 


public function generaCuotasFijasAX()
{
 try{$fecha_gasto         = $this -> input -> post('fecha_gasto');
     $gasto_cada_dia      = $this -> input -> post('gasto_cada_dia');
     $gasto_durante_meses = $this -> input -> post('gasto_durante_meses');
     $total               = $this -> input -> post('total');
     $cuotas              = "";
     
     $util                = new Utils();     

     for ($i = 1; $i <= $gasto_durante_meses; $i++) 
     {        
        $fechaC_F  = $util->cuotaFija($fecha_gasto, $gasto_cada_dia, $i);
        $cuotas   .= '<label class="label"><i class="fa fa-calendar" style="font-size:11px;font-style: italic;"> '.$fechaC_F.' $ '.number_format($total, 2, '.', ',').'</i></label>';
     }
     
     unset($util);
     echo json_encode ($cuotas);
     
    }catch (Exception $e ){ echo 'ERROR generaCuotasFijasAX  Excepción : ' . $e->getMessage();}
}//generaCuotasFijasAX


public function cargaMorososAX()
{
 try{     
     $deptosMorosos = $this->MDL_cuotas->traeCuotasPendientes($this->input->post('id_edificio'), TRUE, NULL, NULL);
     $totalesMoro   = $this->MDL_cuotas->traeTotCuotasTasa($this->input->post('id_edificio'), NULL);   

     echo json_encode (array("dm"=>$deptosMorosos, "tm"=>$totalesMoro));
     
    }catch (Exception $e ){ echo 'ERROR cargaMorososAX  Excepción : ' . $e->getMessage();}
}//cargaMorososAX

public function cargaDeptoMorosoAX()
{
 try{     
     $deptoMoroso = $this->MDL_cuotas->traeCuotasPendientes($this->input->post('id_edificio'), FALSE, $this->input->post('torre'), $this->input->post('id_depto'));
     $totalesMoro = $this->MDL_cuotas->traeTotCuotasTasa($this->input->post('id_edificio'), $this->input->post('id_depto'));
     
     echo json_encode (array("dm"=>$deptoMoroso, "tm"=>$totalesMoro));
     
    }catch (Exception $e ){ echo 'ERROR cargaDeptoMorosoAX  Excepción : ' . $e->getMessage();}
    
}//cargaMorososAX



public function printDMAX()
{
 try{$this->load->library('PDF');
     $util = new Utils();
          
     $id_edificio = $this->input->post('id_edificio');
     $path        = DIR_DOCUMENTS . $id_edificio."/";
     
     if (file_exists($path) == FALSE)
        {   mkdir($path, 0777);     }
       
     $fileNameAM = $path."Aviso_Morosidad.pdf";
     
     if (file_exists($fileNameAM))
        {  unlink($fileNameAM);  }
        
     $edificio = $this->MDL_edificio->traeEdificio($id_edificio);
     $tmp      = $this->MDL_cuotas->traeCuotasPendientes($id_edificio, TRUE, NULL, NULL);
     foreach ($tmp as $c)
        {  $cuotas          = $this->MDL_cuotas->traeCuotasPendientes($id_edificio, FALSE, $c['TORRE'], $c['ID_DEPTO']);
           $deptosMorosos[] = array('depto' => $c,'cuotas' => $cuotas);
        }

     $htmlPDF        = $this->load->view('portal/vw_formato_aviso_moro', $util->getAvisoMoroData($deptosMorosos, $edificio), TRUE);     
     $formatoPagoPDF = new PDF($fileNameAM, $htmlPDF);
     $formatoPagoPDF->crearPDF();
     
     unset($util);
     echo json_encode ($fileNameAM);
     
    }catch (Exception $e ){ echo 'ERROR printDMAX  Excepción : ' . $e->getMessage();}
    
}//printDMAX



public function generaEdoCtaAX()
{
 try{$this->load->library('PDF');
     $this->load->library('PhpChart');
 
     $mes         = $this -> input -> post('mesEdoCta');//"06";    //
     $ano         = $this -> input -> post('anoEdoCta');//"2018"; //
     $id_edificio = $this -> input -> post('id_edificio');//"1";    //
     $mes_edoCta  = $this -> input -> post('mes_edoCta');//"Jun 2018";//

     $util        = new Utils();
     $pChart      = new PhpChart();
     
     $edificio    = $this->MDL_edificio->traeEdificio($id_edificio);    
     $filename    = $util->generaNombrePDF( $mes_edoCta."_".$edificio[0]['NOMBRE'] ) . ".pdf";
     $pathEdoCta  = DIR_EDO_CTA . $id_edificio . "/";
     $fileEdoCta  = $pathEdoCta . $filename;     
     
     $datos       = $this->MDL_gastos->traeEdoCta($id_edificio, $ano, $mes );
     $totDatos    = $this->MDL_gastos->traeTotMesEdoCta($id_edificio, $ano, $mes, $edificio[0]['CUOTA_MANTO'] );
     $acumDatos   = $this->MDL_gastos->traeEdoCtaAcumulado($id_edificio, $ano, $mes );
     
     $edoCtaAcum  = $pChart->edoCtaAcumBarChart(array("id"=>$id_edificio.$ano.$mes ,"titulo"=>"Acumulado Ene-".$mes_edoCta, "datosCuotas"=>$acumDatos['cuotas'], "datosGastos"=>$acumDatos['gastos'], "leyendas"=>$acumDatos['leyendas'] ) );
     $mesData     = (($datos[isPto]) ? array($totDatos['cuotas'], ($totDatos['gastos']+$totDatos['tm']), $totDatos['pto'] ) : array($totDatos['cuotas'], ($totDatos['gastos']+$totDatos['tm']) ) );
     $leyendaData = (($datos[isPto]) ? array("Cuotas","Gastos","Presupuesto") : array("Cuotas","Gastos"));
     $edoCtaMes   = $pChart->edoCtaMessPieChart(array("id"=>$id_edificio.$ano.$mes ,"titulo"=>"Estado de Cuenta ".$mes_edoCta, "datos"=>$mesData, "leyendas"=>$leyendaData ) );
     
     $htmlPDF     = $this->load->view('portal/vw_formato_edo_cta', $util->getEdoCtaData($datos, $edificio, $edoCtaMes, $edoCtaAcum, $totDatos, $mes_edoCta), TRUE);  
     
     if (file_exists($pathEdoCta) == FALSE)
        { mkdir($pathEdoCta, 0777);       }
        
     if (file_exists($fileEdoCta)) 		
        { unlink($fileEdoCta);            }
     
     $formatoPagoPDF = new PDF($fileEdoCta, $htmlPDF);
     $formatoPagoPDF->crearPDF();
     
     $titleChart    = "Estado de cuenta " . $mes_edoCta;
     $subTitChart   = "click para ver más detalle";
     $detalleChart  = $this->MDL_gastos->traeDetalleChartMesEdoCta($id_edificio, $ano, $mes);     
     $dataDrilldown = array("series"=>array( array( "name" => $leyendaData[0], "id" => $leyendaData[0], "data" => $detalleChart['cuotas']
                                                  )
                                            ,array( "name" => $leyendaData[1], "id" => $leyendaData[1], "data" => $detalleChart['gastos']
                                                  )
                                           )
                           );     
     $data          = array( array("name" => $leyendaData[0], "y" => floatval($mesData[0]), "drilldown" => $leyendaData[0])
                            ,array("name" => $leyendaData[1], "y" => floatval($mesData[1]), "drilldown" => $leyendaData[1])
                           );
     $series        = array(array("name" => $mes_edoCta, "colorByPoint" => TRUE, "data" => $data));
     
     unset($pChart);
     unset($util  );
     
     echo json_encode (array("path" => $fileEdoCta, "filename" => $filename, "title" => $titleChart, "subtitle" => $subTitChart, "series" => $series, "drilldown" => $dataDrilldown));
     
    }catch (Exception $e ){ echo 'ERROR generaEdoCtaAX  Excepción : ' . $e->getMessage();}
}//generaEdoCtaAX


public function cargaPtoAX()
{
 try{$id_pto = $this -> input -> post('id_pto');
           
     $pto = $this->MDL_gastos->traePresupuestobyID($id_pto);         
     
     echo json_encode ($pto);
     
    }catch (Exception $e ){ echo 'ERROR cargaPtoAX  Excepción : ' . $e->getMessage();}
}//cargaPtoAX

}//FINANZAs

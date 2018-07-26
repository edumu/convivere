<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  
require_once APPPATH.'third_party/openpay/Openpay.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Pago
 *
 * @author edumu
 */
class Pago {
   var $openpay;
   var $id;
   var $cards;
   var $charges;
   var $payouts;
   var $fees;
   var $plans;
   var $webhooks;
   var $customers;
   var $tokens;
        
    public function Pago()
    {                
        $this->openpay = Openpay::getInstance(OPENPAY_ID, OPENPAY_PRIVATE_KEY);         
        Openpay::setProductionMode(OPENPAY_MODE_PRODUCTION);        
    }
    
    public function getCustomer($findData)
    {                
        $this->customers = $this->openpay->customers->getList($findData);         
    }
    
    public function saveCustomer($customerData)
    {          
        $customer = $this->openpay->customers->get(OPENPAY_ID);
        $customer->name      = $customerData['name'];
        $customer->last_name = $customerData['last_name'];
        $customer->save();
    }        
    
    public function createCharge($chargeData)
    {          
        return $this->openpay->charges->create($chargeData);
    }
    
    public function getChargeDataCard ($dataPago)
    {                
        return array('method'           => 'card',
                    'source_id'         => $dataPago['token_id'],
                    'amount'            => $dataPago['imp']['importe'],
                    'description'       => 'Cargo a tarjeta '.$dataPago['referencia'],                    
                    'order_id'          => $dataPago['referencia'],
                   // 'use_card_points' => $dataPago['use_card_points'], // Opcional, si estamos usando puntos
                    'device_session_id' => $dataPago['deviceIdHiddenFieldName'],
                    'customer'          => $dataPago['customer']
                    );

    }
    
    public function getChargeDataBank ($dataPago)
    {                
        return  array('method'       => 'bank_account'
                      ,'amount'      => $dataPago['imp']['importe']
                      ,'description' => 'Cargo a banco '.$dataPago['referencia']
                      ,'order_id'    => $dataPago['referencia']
                      ,'customer'    => $dataPago['customer']);
    }        
    
    public function getCuotaBank ($dataPago, $formatopagoPDF, $referenciaBanco,$idTransacion)
    {   list($c, $edificio, $torre, $depto,$mes,$ano) = split("-", $dataPago['referencia'], 7);             
        return array("RUTA_FORMATO_PAGO"      =>$formatopagoPDF->nombrePDF
                    ,"STATUS"                 =>STATUS_PEN
                    ,"FECHA_FORMATO_PAGO"     =>$dataPago['hoy']['dateBD']
                    ,"FECHA_VIGENCIA_FORMATO" =>$dataPago['vigencia']['dateBD']
                    ,"CUOTA_DEL_MES"          =>$mes."-".$ano
                    ,"IMPORTE"                =>$dataPago['imp']['importe']
                    ,"ID_EDIFICIO"            =>$edificio
                    ,"ID_DEPTO"               =>$depto
                    ,"TORRE"                  =>$torre
                    ,"REFERENCIA"             =>$dataPago['referencia']
                    ,"REFERENCIA_OPENPAY"     =>$referenciaBanco
                    ,"ID_TRANSACCION_OPEN_PAY"=>$idTransacion
                    ,"TIPO_PAGO"              =>$dataPago['tipoPago']);
    }
    
    public function getCuotaCard ($dataPago, $formatopagoPDF, $referenciaBanco,$idTransacion)
    {   list($c, $edificio, $torre, $depto,$mes,$ano) = split("-", $dataPago['referencia'], 7);             
        return array("RUTA_RECIBO"            =>$formatopagoPDF->nombrePDF
                    ,"STATUS"                 =>STATUS_PAG
                    ,"FECHA_PAGO"             =>$dataPago['hoy']['dateBD']                    
                    ,"CUOTA_DEL_MES"          =>$mes."-".$ano
                    ,"IMPORTE"                =>$dataPago['imp']['importe']
                    ,"ID_EDIFICIO"            =>$edificio
                    ,"ID_DEPTO"               =>$depto
                    ,"TORRE"                  =>$torre
                    ,"REFERENCIA"             =>$dataPago['referencia']
                    ,"REFERENCIA_OPENPAY"     =>$referenciaBanco
                    ,"ID_TRANSACCION_OPEN_PAY"=>$idTransacion
                    ,"TIPO_PAGO"              =>$dataPago['tipoPago']);
    }
  
    //"Total a pagar / MXN".br()."$ ".number_format($dataPago['importe'], 2, '.', ',')
    public function getFormatoPagoCard ($dataPago, $charge)
    {   return array("titulo"        => "Recibo Electrónico de Pago"
                    ,"logoConvivere" => '<img src="style/images/logo/LogoConvivere.png" width="110px" height="60px">'
                    ,"edificio"      => (empty($dataPago['edificio'][0]['LOGOTIPO'])?'':'<img src="logo_edificios/'.$dataPago['edificio'][0]['ID_EDIFICIO'].'/'.$dataPago['edificio'][0]['LOGOTIPO'].'" class="img-circle" width="70px" height="50px">').br().$dataPago['edificio'][0]['NOMBRE']
                    ,"dirEdificio"   => $dataPago['edificio'][0]['CALLE'].nbs().$dataPago['edificio'][0]['NUMERO'].br().$dataPago['edificio'][0]['COLONIA'].br().$dataPago['edificio'][0]['ALCALDIA'].nbs().$dataPago['edificio'][0]['ESTADO']
                    ,"charge"        => $charge
                    ,"recibo"        => $dataPago
                    ,"cuota"         => $dataPago['mescuota']
                    ,"leyendaContact"=> "Cualquier duda o comentario comunicate a CONVIVERE al ".CALL_CENTER." o al correo ".CORREO_OFICIAL.br()
                    );
    }
    
    public function getChargeDataStore ($dataPago)
    {                
        return  array('method'     => 'store'
                    ,'amount'      => $dataPago['imp']['importe']
                    ,'description' => 'Cargo a tienda '.$dataPago['referencia']
                    ,'order_id'    => $dataPago['referencia']
                    ,'customer'    => $dataPago['customer']);
    }
    
    public function getFormatoPagoBank($dataPago, $charge, $viewPDF)
    {   return array("titulo"        => "Transferencia Interbancaria (SPEI)"
                    ,"logoConvivere" => '<img src="'.($viewPDF===TRUE?"":base_url()).'style/images/logo/LogoConvivere.png" width="110px" height="60px">'
                    ,"edificio"      => (empty($dataPago['edificio'][0]['LOGOTIPO'])?'':'<img src="'.($viewPDF===TRUE?"":base_url()).'logo_edificios/'.$dataPago['edificio'][0]['ID_EDIFICIO'].'/'.$dataPago['edificio'][0]['LOGOTIPO'].'" class="img-circle" width="70px" height="50px">').br().$dataPago['edificio'][0]['NOMBRE']
                    ,"dirEdificio"   => NULL
                    ,"section1_1"    => ""
                    ,"section1_2"    => ""
                    ,"section2_1"    => "Fecha Límite de Pago".br().$dataPago['vigencia']['dateStr']
                    ,"section2_2"    => "Total a pagar / MXN".br().$dataPago['imp']['importeStr']
                    ,"detalle"       => 'Cargo con banco. Cuota '.$dataPago['mescuotaEspanol'].br().$dataPago['referencia']        
                    ,"fechaHora"     => $dataPago['hoy']['dateStr']
                    ,"vigencia"      => $dataPago['vigencia']['dateStr']
                   ,"mescuotaEspanol"=> $dataPago['mescuotaEspanol']
                    ,"section3_1"    => "Pasos para realzar el pago"
                    ,"section3_2"    => ""
                    ,"section4_1"    => "<ul> <li><strong>Desde BBVA Bancomer</strong>".br(2)."1. Dentro del menú de \"Pagar\", seleccione la opción \"De Servicios\" e ingrese el siguiente \"Número deconvenio CIE\":".br()."</li>
                                           <li>".br().nbs(3)."<strong>Número de convenio CIE:</strong> ".$charge->payment_method->agreement.br()."
                                           <br>2. Ingrese los datos de registro para concluir con la operación".br()."</li>
                                           <li>".br().nbs(3)."<strong>Referencia:</strong> ".$charge->payment_method->name.br()."</li>
                                           <li>".br().nbs(3)."<strong>Importe:</strong>  ".$dataPago['imp']['importeStr']." MXN".br()."</li>
                                           <li>".br().nbs(3)."<strong>Concepto:</strong> Cargo con banco ".$dataPago['referencia']."</li></ul>"
                    ,"section4_2"    => "<ul> <li><strong>Desde cualquier otro banco</strong>".br(2)."1. Ingresa a la sección de transferencias y pagos o pagos a otros bancos y proporciona los datos de la transferencia:".br()."</li>
                                           <li>".br().nbs(3)."<strong>Beneficiario:</strong> CONVIVERE".br()."</li>
                                           <li>".br().nbs(3)."<strong>Banco destino:</strong> ".$charge->payment_method->bank.br()."</li>
                                           <li>".br().nbs(3)."<strong>CLABE:</strong> ".$charge->payment_method->clabe.br()."</li>
                                           <li>".br().nbs(3)."<strong>Concepto de pago:</strong> ".$charge->payment_method->name.br()."</li>
                                           <li>".br().nbs(3)."<strong>Referencia:</strong>  ".$charge->payment_method->agreement.br()."</li>
                                           <li>".br().nbs(3)."<strong>Importe:</strong> ".$dataPago['imp']['importeStr']." MXN</li>
                                           <li>".br().nbs(3)."<strong>Concepto:</strong> Cargo con banco ".$dataPago['referencia']."</li></ul>"
                    ,"section5_1"    => "Si tienes dudas comunicate a CONVIVERE al ".CALL_CENTER." o al correo ".CORREO_OFICIAL.br().'<img src="'.($viewPDF===TRUE?"":base_url()).'style/images/bancos.jpg">'
                    ,"viewPDF"       => $viewPDF);
    }
    
    public function getFormatoPagoStore($dataPago, $charge, $barcode, $viewPDF)
    {   return array("titulo"        => "Pago en Tienda"
                    ,"logoConvivere" => '<img src="'.($viewPDF===TRUE?"":base_url()).'style/images/logo/LogoConvivere.png" width="110px" height="60px">'
                    ,"edificio"      => (empty($dataPago['edificio'][0]['LOGOTIPO'])?'':'<img src="'.($viewPDF===TRUE?"":base_url()).'logo_edificios/'.$dataPago['edificio'][0]['ID_EDIFICIO'].'/'.$dataPago['edificio'][0]['LOGOTIPO'].'" class="img-circle" width="70px" height="50px">').br().$dataPago['edificio'][0]['NOMBRE']
                    ,"dirEdificio"   => NULL
                    ,"section1_1"    => ""
                    ,"section1_2"    => "Servicio a pagar ".nbs().'<img src="'.($viewPDF===TRUE?"":base_url()).'style/images/paynet.jpg">'
                    ,"section2_1"    => '<img src="'.($viewPDF===TRUE?"":base_url()).$barcode.'">'.br().$charge->payment_method->reference.br().OPENPAY_REFERENCIA_PAYNET
                    ,"section2_2"    => "Total a pagar / MXN".br().$dataPago['imp']['importeStr'].br().OPENPAY_COMISION_PAYNET
                    ,"detalle"       => 'Cargo a tienda. Cuota '.$dataPago['mescuotaEspanol'].br().$dataPago['referencia']
                    ,"fechaHora"     => $dataPago['hoy']['dateStr']
                    ,"vigencia"      => $dataPago['vigencia']['dateStr']
                   ,"mescuotaEspanol"=> $dataPago['mescuotaEspanol']
                    ,"section3_1"    => "Como realizar el pago"
                    ,"section3_2"    => "Instrucciones para el cajero"
                    ,"section4_1"    => "<ol>
                                            <li>Acude a cualquier tienda afiliada</li>
                                            <li>Entrega al cajero el código de barras y menciona que realizarás un pago de servicio Paynet</li>
                                            <li>Realizar el pago en efectivo por ".$dataPago['imp']['importeStr']." (".OPENPAY_COMISION_PAYNET.")</li>
                                            <li>Conserva el ticket para cualquier aclaración</li>
                                        </ol>".br()."Si tienes dudas comunicate a CONVIVERE al ".CALL_CENTER." o al correo ".CORREO_OFICIAL
                    ,"section4_2"    => "<ol>
                                           <li>Ingresar al menú de Pago de Servicios</li>
                                           <li>Seleccionar Paynet</li>
                                           <li>Ingresa la cantidad total a pagar</li>
                                           <li>Cobrar al cliente el monto total ".OPENPAY_COMISION_PAYNET."</li>
                                           <li>Confirmar la transacción y entregar el ticket al cliente</li>
                                         </ol>".  br().OPENPAY_ACLARACION_PAYNET
                    ,"section5_1"    => '<img src="'.($viewPDF===TRUE?"":base_url()).'style/images/tiendas.jpg">'
                    ,"viewPDF"       => $viewPDF);
    }
    
    public function getCuotaStore ($dataPago, $formatopagoPDF, $referenciaBanco,$idTransacion)
    {   list($c, $edificio, $torre, $depto,$mes,$ano) = split("-", $dataPago['referencia'], 7);
        return array("RUTA_FORMATO_PAGO"     =>$formatopagoPDF->nombrePDF
                    ,"STATUS"                 => STATUS_PEN
                    ,"FECHA_FORMATO_PAGO"     =>$dataPago['hoy']['dateBD']
                    ,"FECHA_VIGENCIA_FORMATO" =>$dataPago['vigencia']['dateBD']
                    ,"CUOTA_DEL_MES"          =>$mes."-".$ano
                    ,"IMPORTE"                =>$dataPago['imp']['importe']
                    ,"ID_EDIFICIO"            =>$edificio
                    ,"ID_DEPTO"               =>$depto
                    ,"TORRE"                  =>$torre
                    ,"REFERENCIA"             =>$dataPago['referencia']
                    ,"REFERENCIA_OPENPAY"     =>$referenciaBanco
                    ,"ID_TRANSACCION_OPEN_PAY"=>$idTransacion
                    ,"TIPO_PAGO"              =>$dataPago['tipoPago']);
    }
    
public function getFormatoPago ($dataPago, $leyendaTipo)
    {   
       return "<a href='".base_url()."portal/download/".$dataPago['dir'].$dataPago['fileName']."' title='Descargar ".$leyendaTipo."'> <img src='".base_url()."style/images/logoPDF.png' width='25' height='25'> <i class='fa fa-download'></i> ".$leyendaTipo."</a>";
    }
    

public function getDescriptionError($errorCode,$dataPago)
{   $descError = "";
    switch ($errorCode) 
    { 
        case 1000 : $descError="Ocurrió un error interno en el servidor de Openpay"; break;
        case 1001 : $descError="El formato de la petición no es JSON, los campos no tienen el formato correcto, o la petición no tiene campos que son requeridos."; break;
        case 1002 : $descError="La llamada no esta autenticada o la autenticación es incorrecta."; break;
        case 1003 : $descError="La operación no se pudo completar por que el valor de uno o más de los parametros no es correcto."; break;
        case 1004 : $descError="Un servicio necesario para el procesamiento de la transacción no se encuentra disponible."; break;
        case 1005 : $descError="Uno de los recursos requeridos no existe."; break;
        case 1006 : $descError="Ya existe una transacción con la misma referencia ".$dataPago['referencia']."."; break;
        case 1007 : $descError="La transferencia de fondos entre una cuenta de banco o tarjeta y la cuenta de Openpay no fue aceptada."; break;
        case 1008 : $descError="Una de las cuentas requeridas en la petición se encuentra desactivada."; break;
        case 1009 : $descError="El cuerpo de la petición es demasiado grande."; break;
        case 1010 : $descError="Se esta utilizando la llave pública para hacer una llamada que requiere la llave privada, o bien, se esta usando la llave privada desde JavaScript."; break;
        case 1011 : $descError="Se solicita un recurso que esta marcado como eliminado."; break;
        case 1012 : $descError="El monto transacción esta fuera de los limites permitidos."; break;
        case 1013 : $descError="La operación no esta permitida para el recurso."; break;
        case 1014 : $descError="La cuenta esta inactiva."; break;
        case 1015 : $descError="No se ha obtenido respuesta de la solicitud realizada al servicio."; break;
        case 1016 : $descError="El mail del comercio ya ha sido procesada."; break;
        case 1017 : $descError="El gateway no se encuentra disponible en ese momento."; break;
        case 1018 : $descError="El número de intentos de cargo es mayor al permitido."; break;
        case 2001 : $descError="La cuenta de banco con esta CLABE ya se encuentra registrada en el cliente."; break;
        case 2002 : $descError="La tarjeta con este número ya se encuentra registrada en el cliente."; break;
        case 2003 : $descError="El cliente con este identificador externo (External ID) ya existe."; break;
        case 2004 : $descError="El dígito verificador del número de tarjeta es inválido de acuerdo al algoritmo Luhn."; break;
        case 2005 : $descError="La fecha de expiración de la tarjeta es anterior a la fecha actual."; break;
        case 2006 : $descError="El código de seguridad de la tarjeta (CVV2) no fue proporcionado."; break;
        case 2007 : $descError="El número de tarjeta es de prueba, solamente puede usarse en Sandbox."; break;
        case 2008 : $descError="La tarjeta no es valida para puntos Santander."; break;
        case 2009 : $descError="El código de seguridad de la tarjeta (CVV2) es inválido."; break;
        case 3001 : $descError="La tarjeta fue declinada por la institución bancaria."; break;
        case 3002 : $descError="La tarjeta ha expirado."; break;
        case 3003 : $descError="La tarjeta no tiene fondos suficientes."; break;
        case 3004 : $descError="La tarjeta ha sido identificada como una tarjeta robada."; break;
        case 3005 : $descError="La tarjeta ha sido rechazada por el sistema antifraudes."; break;
        case 3006 : $descError="La operación no esta permitida para este cliente o esta transacción."; break;
        case 3007 : $descError="Deprecado. La tarjeta fue declinada."; break;
        case 3008 : $descError="La tarjeta no es soportada en transacciones en línea."; break;
        case 3009 : $descError="La tarjeta fue reportada como perdida."; break;
        case 3010 : $descError="El banco ha restringido la tarjeta."; break;
        case 3011 : $descError="El banco ha solicitado que la tarjeta sea retenida. Contacte al banco."; break;
        case 3012 : $descError="Se requiere solicitar al banco autorización para realizar este pago."; break;
        case 4001 : $descError="La cuenta de Openpay no tiene fondos suficientes."; break;
        case 4002 : $descError="La operación no puede ser completada hasta que sean pagadas las comisiones pendientes."; break;
        case 5001 : $descError="La orden con este identificador externo (external_order_id) ya existe."; break;
        case 6001 : $descError="El webhook ya ha sido procesado."; break;
        case 6002 : $descError="No se ha podido conectar con el servicio de webhook."; break;
        case 6003 : $descError="El servicio respondio con errores."; break;
    }
    return $descError;
}    

    
}

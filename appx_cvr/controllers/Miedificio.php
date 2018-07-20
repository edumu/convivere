<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Miedificio extends CI_Controller {
    
    
public function index()
{  
try{    $this->validaSesion(USER,NULL);        

        $menu = new GeneradorMenu($this->session->userdata('datos_sesion'),"Mi Edificio");                
        $data = $menu->getmenu();
        
        $this->load->view('portal/vw_home_edificio',$data);
        
    }catch (Exception $e) {echo 'Excepción Index Portal: '.$e;}
}//index



public function traeEdificioAX()
{
 try{   $vs = $this->validaSesion(ADMIN,TRUE);
        if( isset($vs['session']))
        {   echo json_encode ($vs); 
            exit(0);
        }
        $torresField[] = array();        
        
        $id_edificio = $this -> input -> post('id_edificio');
        $edificio    = $this -> MDL_edificio -> traeEdificio($id_edificio);
        $x           = 0;
        foreach($this -> MDL_edificio -> traeTorres($id_edificio) as $t)        
            { $x++; 
              $torresField[] = inputText_crv(array('col'=>'col-2','label'=>'Torre:','icon'=>'fa-building','inputName'=>'torre'.$x,'class'=>'validate[required,custom[onlyLetterNumber]] text-input','value'=>$t['TORRE'],'placeholder'=>'Ej. A') );
              $torres[]      = array("val"=>$t['TORRE'],"text"=>$t['TORRE']);
            }

        echo json_encode (array("e"=>$edificio,"t"=>$torresField,"torres"=>$torres,"dir"=>DIR_LOGOS));

    } catch (Exception $e) {echo ' traeEdificioAX Excepción: ',  $e, "\n";}	
}//traeEdificioAX




public function guardarAX()
{
 try{   $vs = $this->validaSesion(ADMIN,TRUE);
        if( isset($vs['session']))
        {   echo json_encode ($vs); 
            exit(0);
        }
        $this->load->helper('date');
        $ds           = $this -> session -> userdata('datos_sesion');
        $id_edificio  = $this -> input   -> post('id_edificio');
        $num_viviendas= $this -> input   -> post('num_viviendas');
        $num_torres   = $this -> input   -> post('num_torres');
        $guardoBD     = 0;

        if($id_edificio === "0")                
        {
         $camposForm = array("NOMBRE"=>$this->input->post('nombre'),"FECHA_ALTA"=>standard_date('DATE_W3C', time()),"CREADO_MOD"=>$ds['cuenta'],"CALLE"=>$this->input->post('calle'),"NUMERO"=>$this->input->post('numero'),"COLONIA"=>$this->input->post('colonia') ,"ALCALDIA"=>$this->input->post('alcaldia'),"ESTADO"=>$this->input->post('estado'),"CP"=>$this->input->post('cp'),"LATITUD"=>$this->input->post('latitud'),"LONGITUD"=>$this->input->post('longitud'),"CUOTA_MANTO"=>$this->input->post('cuota_manto'),"DIA_CORTE"=>$this->input->post('dia_corte'),"TIPO_PENALIZACION"=>$this->input->post('tipo_penalizacion'),"PENALIZACION"=>$this->input->post('penalizacion'),"NUM_TORRES"=>$num_torres,"NUM_VIVIENDAS"=>$num_viviendas,"LOGOTIPO"=>$this->input->post('logoEdificio'));
         $guardoBD   = $this -> MDL_edificio -> insert_edificio($camposForm);
         $id_edificio= $this -> MDL_edificio -> traeIdEdificio(array("NOMBRE"=>$this->input->post('nombre'),"CREADO_MOD"=>$ds['cuenta'],"CALLE"=>$this->input->post('calle'),"NUMERO"=>$this->input->post('numero'),"COLONIA"=>$this->input->post('colonia')));
         for ($x = 1; $x <= $num_torres; $x++) 
            {   for ($y = 1; $y <= $num_viviendas; $y++) 
                {  $this ->  MDL_edificio -> insert_deptos(array("ID_DEPTO"=>$id_edificio.$x.$y,"TORRE"=>$this->input->post('torre'.$x),"NUMERACION"=>$x.$y,"ID_EDIFICIO"=>$id_edificio)); }
            }
        }
        else
        {
         $camposForm = array("NOMBRE"=>$this->input->post('nombre'),"CREADO_MOD"=>$ds['cuenta'],"CALLE"=>$this->input->post('calle'),"NUMERO"=>$this->input->post('numero'),"COLONIA"=>$this->input->post('colonia') ,"ALCALDIA"=>$this->input->post('alcaldia'),"ESTADO"=>$this->input->post('estado'),"CP"=>$this->input->post('cp'),"LATITUD"=>$this->input->post('latitud'),"LONGITUD"=>$this->input->post('longitud'),"CUOTA_MANTO"=>$this->input->post('cuota_manto'),"DIA_CORTE"=>$this->input->post('dia_corte'),"TIPO_PENALIZACION"=>$this->input->post('tipo_penalizacion'),"PENALIZACION"=>$this->input->post('penalizacion'),"NUM_TORRES"=>$num_torres,"NUM_VIVIENDAS"=>$num_viviendas,"LOGOTIPO"=>$this->input->post('logoEdificio'));
         $guardoBD   = $this -> MDL_edificio -> update_edificio($id_edificio, $camposForm);
         for ($x = 1; $x <= $num_torres; $x++) 
            {   for ($y = 1; $y <= $num_viviendas; $y++) 
                {  $this ->  MDL_edificio -> update_deptos($id_edificio.$x.$y,array("TORRE"=>$this->input->post('torre'.$x),"NUMERACION"=>$x.$y,"ID_EDIFICIO"=>$id_edificio)); }
            }
        }                			        

        echo json_encode ( array("registros"=>$guardoBD) );

    } catch (Exception $e) {echo ' guardarAX Excepción: ',  $e, "\n";}	
}//guardarAX


public function creaTorresAX()
{
 try{   $vs = $this->validaSesion(ADMIN,TRUE);
        if( isset($vs['session']))
        {   echo json_encode ($vs); 
            exit(0);
        }
        $letras   = array("","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
        $torres[] = array();
        $num_torres = $this -> input -> post('num_torres');
        if ($num_torres === "1")
            { $torres[] = inputText_crv(array('col'=>'col-2','label'=>'Torre:','icon'=>'fa-building','inputName'=>'torre1','class'=>'validate[required,custom[onlyLetterNumber]] text-input','value'=>"Te. Única",'placeholder'=>'Ej. A') );}        
        else{
            for ($x = 1; $x <= $num_torres; $x++) 
                { $torres[] = inputText_crv(array('col'=>'col-2','label'=>'Torre:','icon'=>'fa-building','inputName'=>'torre'.$x,'class'=>'validate[required,custom[onlyLetterNumber]] text-input','value'=>$letras[$x],'placeholder'=>'Ej. A') );}}

        echo json_encode ($torres);                          

    } catch (Exception $e) {echo ' creaTorresAX Excepción: ',  $e, "\n";}	
}//creaTorresAX



public function detalleDeptoAX()
{
try{$vs = $this->validaSesion(ADMIN,TRUE);
    if( isset($vs['session']))
    {   echo json_encode ($vs); 
        exit(0);
    }

    $this->load->helper('date');    
    $ds     = $this -> session -> userdata('datos_sesion');
    $cuenta = $this -> input -> post('usuario');
            
    $param = array("CUENTA"      => $cuenta
                  ,"CONTACTO"    => $this -> input -> post('tipoDueno')
                  ,"ID_EDIFICIO" => $this -> input -> post('id_edificio')
                  ,"TORRE"       => $this -> input -> post('torre')
                  ,"ID_DEPTO"    => $this -> input -> post('id_depto')
                  ,"FECHA_ALTA"  => standard_date('DATE_W3C', time())
            	  ,"CREADO_MOD"  => $ds['cuenta']
                 );
    
    $this->MDL_edificio->insert_detalle_deptos($param);
    $name= $this->MDL_usuario->traeUsuario($cuenta);

    echo json_encode ($name);

    } catch (Exception $e) {echo ' detalleDeptoAX Excepción: ',  $e, "\n";}	
}//detalleDeptoAX

}//Edificio

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

echo doctype('html5');
echo '<html>';
echo ' <head>';

$meta = array(array('name' => 'Content-type','content' => 'text/html; charset=utf-8', 'type' => 'equiv')
             ,array('name' => 'viewport'    ,'content' => 'width=device-width, initial-scale=1.0')             
             ,array('name' => 'description' ,'content' => 'Administracion integral de inmuebles')
             ,array('name' => 'keywords'    ,'content' => 'depto, departamento, mantenimiento, pago, prosoc,condiminos')
             ,array('name' => 'author'      ,'content' => 'DATARE')
             ,array('http-equiv' => 'X-UA-Compatible','content' => 'IE=EmulateIE10')
            );
echo meta($meta);

echo link_tag('favicon.ico', 'shortcut icon', 'style/images');

echo title_page(TITULO_NAVEGADOR);

//Bootstrap core CSS
echo link_tag(array('href' => 'style/css/style.css'     ,'rel' => 'stylesheet', 'type' => 'text/css'));
echo link_tag(array('href' => 'style/css/bootstrap.min.css'     ,'rel' => 'stylesheet', 'type' => 'text/css'));
echo link_tag(array('href' => 'style/css/color/blue.css','rel' => 'stylesheet', 'type' => 'text/css'));

//EMS style
echo link_tag(array('href' => 'style/css/style.css'            ,'rel' => 'stylesheet', 'type' => 'text/css'));
echo link_tag(array('href' => 'style/css/color/blue.css'       ,'rel' => 'stylesheet', 'type' => 'text/css'));
echo link_tag(array('href' => 'style/css/ems/jquery.alerts.css','rel' => 'stylesheet', 'type' => 'text/css'));
echo link_tag(array('href' => 'style/css/ems/uploadfile.css'   ,'rel' => 'stylesheet', 'type' => 'text/css'));
echo link_tag(array('href' => 'style/css/ems/jquery-ui.css'    ,'rel' => 'stylesheet', 'type' => 'text/css'));
echo link_tag(array('href' => 'style/css/ems/validationEngine.jquery.css','rel' => 'stylesheet', 'type' => 'text/css'));
echo link_tag(array('href' => 'style/css/ems/sky-forms-blue.css','rel' => 'stylesheet', 'type' => 'text/css'));
echo link_tag(array('href' => 'style/css/ems/sky-forms.css'     ,'rel' => 'stylesheet', 'type' => 'text/css'));
//PAGINADOR style
echo link_tag(array('href' => 'style/css/ems/simplePagination.css','rel' => 'stylesheet', 'type' => 'text/css'));
//colorbox
echo link_tag(array('href' => 'style/css/ems/colorbox.css','rel' => 'stylesheet', 'type' => 'text/css'));

echo '  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="style/js/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
     ';
///STYLE SCRIPT
echo script_tag(array('src' => 'style/js/jquery-1.11.3.min.js','charset' => 'utf-8','type' => 'text/javascript'));
echo script_tag(array('src' => 'style/js/bootstrap.min.js'    ,'charset' => 'utf-8','type' => 'text/javascript'));
echo script_tag(array('src' => 'style/js/menu-script.js'      ,'charset' => 'utf-8','type' => 'text/javascript'));        

///FUNCTUANALITY SCRIPT
echo script_tag(array('src' => 'js/jquery.alerts.js'    ,'charset' => 'utf-8','type' => 'text/javascript'));
echo script_tag(array('src' => 'js/jquery.uploadfile.js','charset' => 'utf-8','type' => 'text/javascript'));
echo script_tag(array('src' => 'js/jquery.number.js'    ,'charset' => 'utf-8','type' => 'text/javascript'));
echo script_tag(array('src' => 'js/jQueryUI_v1_11_4.js' ,'charset' => 'utf-8','type' => 'text/javascript'));
//PAGINADOR 
echo script_tag(array('src' => 'js/jquery.simplePagination.js','charset' => 'utf-8','type' => 'text/javascript'));
//VALIDATION
echo script_tag(array('src' => 'js/jquery.validationEngine-esp.js','charset' => 'utf-8','type' => 'text/javascript'));
echo script_tag(array('src' => 'js/jquery.validationEngine.js'    ,'charset' => 'utf-8','type' => 'text/javascript'));
echo script_tag(array('src' => 'js/datePicker-esp.js'             ,'charset' => 'utf-8','type' => 'text/javascript'));
echo script_tag(array('src' => 'js/convivereUtilsFunction.js'     ,'charset' => 'utf-8','type' => 'text/javascript'));
//carga logo
echo script_tag(array('src' => 'js/loadgo.js'                     ,'charset' => 'utf-8','type' => 'text/javascript'));
//colorbox
echo script_tag(array('src' => 'js/jquery.colorbox.js'            ,'charset' => 'utf-8','type' => 'text/javascript'));
//Rating
echo script_tag(array('src' => 'js/jRate.js'                      ,'charset' => 'utf-8','type' => 'text/javascript'));

if (isset($incluirOpenPay) )
{   echo link_tag( array('href'=> 'style/css/openpay.css','rel' => 'stylesheet', 'type' => 'text/css') );
    echo '<script type="text/javascript" src="https://openpay.s3.amazonaws.com/openpay.v1.min.js"></script>
          <script type="text/javascript" src="https://openpay.s3.amazonaws.com/openpay-data.v1.min.js"></script>';    
}

if (isset($fullCalendar) )
{   echo link_tag  ( array('href'=> 'style/css/fullcalendar.css'      , 'rel' => 'stylesheet') );
    echo link_tag  ( array('href'=> 'style/css/fullcalendar.print.css', 'rel' => 'stylesheet', "media"=>'print') );

    echo script_tag( array('src' => 'js/moment.min.js'  ));    
    echo script_tag( array('src' => 'js/fullcalendar.js'));
    echo script_tag( array('src' => 'js/locale-all.js'  ));
}
echo ' </head>';
echo '<body>';

echo form_input(array('name'=>'tituloAlert','id'=>'tituloAlert', 'type'=>'hidden', 'value'=>TITULO_NAVEGADOR));
echo form_input(array('name'=>'baseURL'    ,'id'=>'baseURL'    , 'type'=>'hidden', 'value'=>base_url() ));
echo form_input(array('name'=>'nivelacceso','id'=>'nivelacceso', 'type'=>'hidden', 'value'=>$nivelacceso ));

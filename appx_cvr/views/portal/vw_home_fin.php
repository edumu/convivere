<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include(__DIR__."/../webpart_header.php"); 


include(__DIR__."/../webpart_menu.php");

if( $nivelacceso == USER )
 { echo script_tag(array('src' => 'js/ajax/finCondominoAJAX.js', 'charset' => 'utf-8','type' => 'text/javascript')); }
else
 { echo script_tag(array('src' => 'js/ajax/finAdminAJAX.js'    , 'charset' => 'utf-8','type' => 'text/javascript')); }    

 /* highcharts V6 */
 echo script_tag(array('src' => 'js/chart/code/highcharts.js'       ,'type' => 'text/javascript'));

include(__DIR__."/../webpart_barra_path.php");

echo form_input(array('name'=>'openPayId'    ,'id'=>'openPayId'    , 'type'=>'hidden', 'value'=>OPENPAY_ID));
echo form_input(array('name'=>'openPayApiKey','id'=>'openPayApiKey', 'type'=>'hidden', 'value'=>OPENPAY_PUBLIC_KEY));
echo form_input(array('name'=>'id_edificio'  ,'id'=>'id_edificio'  , 'type'=>'hidden', 'value' => $edificio));
?>

<!-- Start Tabs Style -->
<section id="Tabs-Style" class="light-wrapper">
<div class="container inner">        	  
<div class="row">
    <div class="col-md-12">        
        <div class="Tabs-Style9 side-tabs" role="tabpanel">
           <!-- Nav tabs -->
                <ul class="nav nav-tabs tab-nav ui-tabs-nav" role="tablist">
                    <li role="presentation" class="active"><a href="#tabs-1" aria-controls="tabs-1" role="tab" data-toggle="tab" id="f_webpart_t1"><?php echo $iconMenu1?><i class="fa fa-usd"></i> <?php echo $menu1 ?></a></li>
                    <li role="presentation"               ><a href="#tabs-2" aria-controls="tabs-2" role="tab" data-toggle="tab" id="f_webpart_t2"><?php echo $iconMenu2?><i class="fa fa-usd"></i> <?php echo $menu2 ?></a></li>
                <?php  if( $nivelacceso != USER )
                         { echo '<li role="presentation"><a href="#tabs-6" aria-controls="tabs-6" role="tab" data-toggle="tab" id="f_webpart_t6"><i class="fa fa-calendar-times-o"></i><i class="fa fa-usd"></i>  Cuotas adeudo</a></li>'; }
                ?>
                    <li role="presentation">               <a href="#tabs-3" aria-controls="tabs-3" role="tab" data-toggle="tab" id="f_webpart_t3"><i class="fa fa-list"></i> Trabajos de Manto.</a></li>
                    <li role="presentation">               <a href="#tabs-4" aria-controls="tabs-4" role="tab" data-toggle="tab" id="f_webpart_t4"><i class="fa fa-usd" ></i><i class="fa fa-calendar"></i> Presupuesto </a></li>                    
                    <li role="presentation">               <a href="#tabs-5" aria-controls="tabs-5" role="tab" data-toggle="tab" id="f_webpart_t5"><i class="fa fa-file-pdf-o"></i> Estado de Cuenta</a></li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <?php  if( $nivelacceso == USER )
                           { echo '<div role="tabpanel" class="tab-pane active" id="tabs-1">';
                                include("webpart_finanzas_pago.php");
                             echo '</div><!--tabs-1 -->';
                             echo '<div role="tabpanel" class="tab-pane" id="tabs-2">';
                                include("webpart_finanzas_gastos.php");
                             echo '</div><!--tabs-2 -->';
                           }
                           else
                           { echo '<div role="tabpanel" class="tab-pane active" id="tabs-1">';
                                include("webpart_finanzas_gastos.php");
                             echo '</div><!--tabs-1 -->';
                             echo '<div role="tabpanel" class="tab-pane" id="tabs-2">';
                                include("webpart_depto_edificio.php");
                                //include("webpart_finanzas_pago.php");
                             echo '</div><!--tabs-2 -->';
                             
                             echo '<div role="tabpanel" class="tab-pane fade" id="tabs-6">';
                                  include("webpart_fin_morosos.php"); 
                             echo '</div><!--tabs-6 -->';
                           }
                     ?>                     

                    <div role="tabpanel" class="tab-pane fade" id="tabs-3">                        
                        <?php
                            include("webpart_fin_trbjo_manto.php"); 
                        ?>
                    </div><!--tabs-3 -->
                    <div role="tabpanel" class="tab-pane fade" id="tabs-4">
                       <?php
                            include("webpart_fin_presupuesto.php"); 
                        ?>
                    </div> <!--tabs-4 -->                    
                    <div role="tabpanel" class="tab-pane fade" id="tabs-5">                        
                       <?php
                            include("webpart_fin_edo_cuenta.php"); 
                        ?>
                    </div> <!--tabs-5 -->
                </div> <!--tab-content -->
        </div><!--End tabpanel -->
    </div><!-- col-md-12   -->
</div>  <!--row             -->
</div>  <!--container inner -->
</section>
<!-- End Tabs Style -->

<?php

include(__DIR__."/../webpart_footer_portal.php"); 

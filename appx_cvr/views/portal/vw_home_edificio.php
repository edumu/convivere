<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include(__DIR__."/../webpart_header.php"); 


include(__DIR__."/../webpart_menu.php");

/* highcharts V6 */
echo script_tag(array('src' => 'js/chart/code/highcharts.js'       ,'type' => 'text/javascript'));
echo script_tag(array('src' => 'js/chart/code/modules/xrange.js'   ,'type' => 'text/javascript'));
echo script_tag(array('src' => 'js/chart/code/modules/exporting.js','type' => 'text/javascript'));

echo script_tag(array('src' => 'js/ajax/edificioAJAX.js', 'charset' => 'utf-8','type' => 'text/javascript'));

include(__DIR__."/../webpart_barra_path.php");

?>

<!-- Start Tabs Style -->
<section id="Tabs-Style" class="light-wrapper">
<div class="container inner">        	  
<div class="row">
    <div class="col-md-12">        
        <div class="Tabs-Style9 side-tabs" role="tabpanel">
           <!-- Nav tabs -->
                <ul class="nav nav-tabs tab-nav ui-tabs-nav" role="tablist">
                    <li role="presentation" class="active"><a href="#tabs-1" aria-controls="tabs-1" role="tab" data-toggle="tab" id="f_webpart_t1"><i class="fa fa-building"></i> Home </a></li>
                    <?php
                        if( $nivelacceso != USER )
                            { echo '<li role="presentation"><a href="#tabs-2" aria-controls="tabs-2" role="tab" data-toggle="tab" id="f_webpart_t2"><i class="fa fa-home"></i> Departamentos</a></li>'; 
                              echo '<li role="presentation"><a href="#tabs-3" aria-controls="tabs-3" role="tab" data-toggle="tab" id="f_webpart_t3"><i class="fa fa-th-large"></i> Amenidades</a></li>';
                            }
                    ?>                    
                    <li role="presentation"><a href="#tabs-4" aria-controls="tabs-4" role="tab" data-toggle="tab" id="f_webpart_t4"><i class="fa fa-users">         </i> Asambleas</a></li>
                    <li role="presentation"><a href="#tabs-5" aria-controls="tabs-5" role="tab" data-toggle="tab" id="f_webpart_t5"><i class="fa fa-calendar-o">    </i> Reservaciones</a></li>
                    <li role="presentation"><a href="#tabs-6" aria-controls="tabs-6" role="tab" data-toggle="tab" id="f_webpart_t6"><i class="fa fa-list">          </i>Trabajos</a></li>
                    <li role="presentation"><a href="#tabs-7" aria-controls="tabs-7" role="tab" data-toggle="tab" id="f_webpart_t7"><i class="fa fa-hand-pointer-o"></i>Votaciones</a></li>
                    <li role="presentation"><a href="#tabs-8" aria-controls="tabs-8" role="tab" data-toggle="tab" id="f_webpart_t8"><i class="fa fa-archive">       </i>Inventario Activos</a></li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="tabs-1">                        
                          <?php
                            if( $nivelacceso == USER )
                              { include("webpart_home_miedificio.php");   }
                            else
                              { include("webpart_home_edificio.php");     }
                          ?>                        
                    </div>
                    <?php
                        if( $nivelacceso != USER )
                        { echo ' <div role="tabpanel" class="tab-pane fade" id="tabs-2">
                                    <div class="Block-Case">';
                                    include("webpart_depto_edificio.php");   
                          echo '    </div>
                                 </div>';

                          echo '<div role="tabpanel" class="tab-pane fade" id="tabs-3">                                        
                                        <p>Proin elit arcu, rutrum commodo, vehicula tempus, commodo a, risus. Curabitur nec arcu. Donec sollicitudin mi sit amet mauris. Nam elementum quam ullamcorper ante. Etiam aliquet massa et lorem. Mauris dapibus lacus auctor risus. Aenean tempor ullamcorper leo. Vivamus sed magna quis ligula eleifend adipiscing. Duis orci. Aliquam sodales tortor vitae ipsum. Aliquam nulla. Duis aliquam molestie erat. Ut et mauris vel pede varius sollicitudin. Sed ut dolor nec orci tincidunt interdum. Phasellus ipsum. Nunc tristique tempus lectus.</p>                                        
                                </div>';
                        }
                    ?>                                        
                    <div role="tabpanel" class="tab-pane fade" id="tabs-4">
                        <?php  include("webpart_asamblea.php");          ?>
                    </div>
                    
                    <div role="tabpanel" class="tab-pane fade" id="tabs-5">
                        <?php  include("webpart_loadingLogo.php");       ?>
                    </div>
                    
                    <div role="tabpanel" class="tab-pane fade" id="tabs-6">
                        <div class="Block-Case">
                            <div class="col-md-12">
                               <div id="containerChartCVR_TM" style="min-width: 300px; max-width: 900px;width: 800px; height: 400px; margin: 1em auto"></div>
                            </div> 
                            <p><a href="<?php echo base_url()?>finanzas/"><i class="fa fa-list">          </i>Trabajos</a></p>                            
                        </div>
                    </div>
                    
                    <div role="tabpanel" class="tab-pane fade" id="tabs-7">
                        <div class="Block-Case">
                            <p>votaciones</p>
                            <p>Proin elit arcu, rutrum commodo, vehicula tempus, commodo a, risus. Curabitur nec arcu. Donec sollicitudin mi sit amet mauris. Nam elementum quam ullamcorper ante. Etiam aliquet massa et lorem. Mauris dapibus lacus auctor risus. Aenean tempor ullamcorper leo. Vivamus sed magna quis ligula eleifend adipiscing. Duis orci. Aliquam sodales tortor vitae ipsum. Aliquam nulla. Duis aliquam molestie erat. Ut et mauris vel pede varius sollicitudin. Sed ut dolor nec orci tincidunt interdum. Phasellus ipsum. Nunc tristique tempus lectus.</p>
                            <p>Proin elit arcu, rutrum commodo, vehicula tempus, commodo a, risus. Curabitur nec arcu. Donec sollicitudin mi sit amet mauris. Nam elementum quam ullamcorper ante. Etiam aliquet massa et lorem. Mauris dapibus lacus auctor risus. Aenean tempor ullamcorper leo. Vivamus sed magna quis ligula eleifend adipiscing. Duis orci. Aliquam sodales tortor vitae ipsum. Aliquam nulla. Duis aliquam molestie erat. Ut et mauris vel pede varius sollicitudin. Sed ut dolor nec orci tincidunt interdum. Phasellus ipsum. Nunc tristique tempus lectus.</p>
                            <p>Proin elit arcu, rutrum commodo, vehicula tempus, commodo a, risus. Curabitur nec arcu. Donec sollicitudin mi sit amet mauris. Nam elementum quam ullamcorper ante. Etiam aliquet massa et lorem. Mauris dapibus lacus auctor risus. Aenean tempor ullamcorper leo. Vivamus sed magna quis ligula eleifend adipiscing. Duis orci. Aliquam sodales tortor vitae ipsum. Aliquam nulla. Duis aliquam molestie erat. Ut et mauris vel pede varius sollicitudin. Sed ut dolor nec orci tincidunt interdum. Phasellus ipsum. Nunc tristique tempus lectus.</p>
                        </div>
                    </div>
                    
                    <div role="tabpanel" class="tab-pane fade" id="tabs-8">
                        <div class="Block-Case">
                            <p>inventario activo</p>
                            <p>Proin elit arcu, rutrum commodo, vehicula tempus, commodo a, risus. Curabitur nec arcu. Donec sollicitudin mi sit amet mauris. Nam elementum quam ullamcorper ante. Etiam aliquet massa et lorem. Mauris dapibus lacus auctor risus. Aenean tempor ullamcorper leo. Vivamus sed magna quis ligula eleifend adipiscing. Duis orci. Aliquam sodales tortor vitae ipsum. Aliquam nulla. Duis aliquam molestie erat. Ut et mauris vel pede varius sollicitudin. Sed ut dolor nec orci tincidunt interdum. Phasellus ipsum. Nunc tristique tempus lectus.</p>
                            <p>Proin elit arcu, rutrum commodo, vehicula tempus, commodo a, risus. Curabitur nec arcu. Donec sollicitudin mi sit amet mauris. Nam elementum quam ullamcorper ante. Etiam aliquet massa et lorem. Mauris dapibus lacus auctor risus. Aenean tempor ullamcorper leo. Vivamus sed magna quis ligula eleifend adipiscing. Duis orci. Aliquam sodales tortor vitae ipsum. Aliquam nulla. Duis aliquam molestie erat. Ut et mauris vel pede varius sollicitudin. Sed ut dolor nec orci tincidunt interdum. Phasellus ipsum. Nunc tristique tempus lectus.</p>
                            <p>Proin elit arcu, rutrum commodo, vehicula tempus, commodo a, risus. Curabitur nec arcu. Donec sollicitudin mi sit amet mauris. Nam elementum quam ullamcorper ante. Etiam aliquet massa et lorem. Mauris dapibus lacus auctor risus. Aenean tempor ullamcorper leo. Vivamus sed magna quis ligula eleifend adipiscing. Duis orci. Aliquam sodales tortor vitae ipsum. Aliquam nulla. Duis aliquam molestie erat. Ut et mauris vel pede varius sollicitudin. Sed ut dolor nec orci tincidunt interdum. Phasellus ipsum. Nunc tristique tempus lectus.</p>
                        </div>
                    </div>                    
                    
                </div>
                <!--End Tab panes -->
        </div>	
    </div>
</div>
</div>
</section>
<!-- End Tabs Style -->

<?php

include(__DIR__."/../webpart_footer_portal.php"); 

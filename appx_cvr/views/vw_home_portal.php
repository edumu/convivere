<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include("webpart_header.php"); 

include("webpart_login.php"); 

include("webpart_menu.php"); 

include("webpart_barra_path.php");

/* highcharts V6 */
echo script_tag(array('src' => 'js/chart/code/highcharts.js'       ,'type' => 'text/javascript'));
echo script_tag(array('src' => 'js/chart/code/highcharts-3d.js'    ,'type' => 'text/javascript'));
echo script_tag(array('src' => 'js/chart/code/modules/exporting.js','type' => 'text/javascript'));
echo script_tag(array('src' => 'js/chart/code/modules/export-data.js','type' => 'text/javascript'));
echo script_tag(array('src' => 'js/chart/code/modules/wordcloud.js','type' => 'text/javascript'));

echo script_tag(array('src' => 'js/ajax/homePortalAJAX.js', 'charset' => 'utf-8','type' => 'text/javascript'));

?>

<!-- Start Tabs Style -->
<section id="Tabs-Style" class="light-wrapper">
<div class="container inner">        	  
<div class="row">
    <div class="col-md-12">        
        <div class="Tabs-Style9 side-tabs" role="tabpanel">
           <!-- Nav tabs -->
                <ul class="nav nav-tabs tab-nav ui-tabs-nav" role="tablist">
                    <li role="presentation" class="active"><a id="f_webpart_t1" href="#tabs-1" aria-controls="tabs-1" role="tab" data-toggle="tab"><i class="fa fa-user-md"></i> Resumen Ejecutivo</a></li>
                    <li role="presentation"><a id="f_webpart_t2" href="#tabs-2" aria-controls="tabs-2" role="tab" data-toggle="tab"><i class="fa fa-feed"></i> Anuncios</a></li>
                    <li role="presentation"><a id="f_webpart_t3" href="#tabs-3" aria-controls="tabs-3" role="tab" data-toggle="tab"><i class="fa fa-user"></i> Perfil</a></li>
                    <li role="presentation"><a id="f_webpart_t4" href="#tabs-4" aria-controls="tabs-4" role="tab" data-toggle="tab"><i class="fa fa-question-circle"></i> ¿Cómo le hago?</a></li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="tabs-1">
                        <div class="Block-Case">
                            <div class="counters counters-style2">
                                <div class="col-md-3">
                                    <div class="one_fourth text-center">
                                        <i class="icon icon-TeaMug"></i> <span class="counter">50,124</span><h4>Total cuotas y total gastos</h4>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="one_fourth text-center">
                                        <i class="icon icon-Briefcase"></i> <span class="counter">315</span> <h4>Trabajos para este mes</h4>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="one_fourth text-center">
                                        <i class="icon icon-Users"></i> <span class="counter">5,854</span> <h4>Proxima asamblea</h4>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="one_fourth text-center">
                                        <i class="icon icon-Timer"></i> <span class="counter">9,972</span> <h4>Working Hours</h4>
                                    </div>
                                </div>
                            </div>
                            <br><br>  
                            <div class="col-md-9">
                               <div id="containerChartCVR_RE" style="min-width: 400px; max-width: 900px;width: 800px; height: 400px; margin: 0 auto"></div>
                            </div>        
                        </div>
                    </div>
                        <div role="tabpanel" class="tab-pane fade" id="tabs-2">
                                <div class="Block-Case">
                                    <div class="col-md-11">
                                        <div id="containerChartCVR_AN" style="min-width: 200px; max-width: 500px;width: 400px; height: 200px; margin: 0 auto"></div>
                                    </div>
                                    <p> DESPLEGAR ANUNCIOS TIPO FACEBOOK </p>
                                    <p> Duis cursus. Maecenas ligula eros, blandit nec, pharetra at, semper at, magna. Nullam ac lacus. Nulla facilisi. Praesent viverra justo vitae neque. Praesent blandit adipiscing velit. Suspendisse potenti. Donec mattis, pede vel pharetra blandit, magna ligula faucibus eros, id euismod lacus dolor eget odio. Nam scelerisque. Donec non libero sed nulla mattis commodo. Ut sagittis. Donec nisi lectus, feugiat porttitor, tempor ac, tempor vitae, pede. Aenean vehicula velit eu tellus interdum rutrum. Maecenas commodo. Pellentesque nec elit. Fusce in lacus. Vivamus a libero vitae lectus hendrerit hendrerit.</p>
                                </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tabs-3">
                                <div class="Block-Case">
                                        <p> FORMULARIO DE DATOS PERSONALES, CONFIRMACIÓN DE CELULAR Y CORREO </p>
                                        <p>Proin elit arcu, rutrum commodo, vehicula tempus, commodo a, risus. Curabitur nec arcu. Donec sollicitudin mi sit amet mauris. Nam elementum quam ullamcorper ante. Etiam aliquet massa et lorem. Mauris dapibus lacus auctor risus. Aenean tempor ullamcorper leo. Vivamus sed magna quis ligula eleifend adipiscing. Duis orci. Aliquam sodales tortor vitae ipsum. Aliquam nulla. Duis aliquam molestie erat. Ut et mauris vel pede varius sollicitudin. Sed ut dolor nec orci tincidunt interdum. Phasellus ipsum. Nunc tristique tempus lectus.</p>
                                        <p>Proin elit arcu, rutrum commodo, vehicula tempus, commodo a, risus. Curabitur nec arcu. Donec sollicitudin mi sit amet mauris. Nam elementum quam ullamcorper ante. Etiam aliquet massa et lorem. Mauris dapibus lacus auctor risus. Aenean tempor ullamcorper leo. Vivamus sed magna quis ligula eleifend adipiscing. Duis orci. Aliquam sodales tortor vitae ipsum. Aliquam nulla. Duis aliquam molestie erat. Ut et mauris vel pede varius sollicitudin. Sed ut dolor nec orci tincidunt interdum. Phasellus ipsum. Nunc tristique tempus lectus.</p>
                                </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tabs-4">                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="Features-Block">
                                            <h3>¿Cómo pagar?</h3>
                                        <div class="line-break"></div>
                                        <div class="Block-Img">
                                        <iframe width="545" height="300" src="https://www.youtube.com/embed/K2FOLzqsWTg" frameborder="0" allowfullscreen=""></iframe>
                                        </div>
                                    </div>
                                </div>
                                 <div class="col-md-6">
                                    <div class="Features-Block">
                                            <h3>¿Cómo pagar II?</h3>
                                        <div class="line-break"></div>
                                        <div class="Block-Img">
                                        <iframe width="545" height="300" src="https://www.youtube.com/embed/K2FOLzqsWTg" frameborder="0" allowfullscreen=""></iframe>
                                        </div>
                                    </div>
                                </div> 
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

include("webpart_footer_portal.php"); 

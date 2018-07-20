<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!-- Start Footer -->
<section id="footer-4">
	<div class="container inner-f">
    	<div class="row">
                <div class="Footer-Blocks">
                <!-- Start About with logo Footer -->
            	<div class="col-md-4">
			<div class="Logo-About"> <a class="Footer-logo" href="index.html"></a> </div>
                	<div class="Bottom-Block-Footer">
                    	<div class="About">
                        	<p>Suspendisse non augue tincidunt, ullaorper odio vel, tempor risus. In cursus lacus mattis consectetur.</p>
                        </div>
                    </div>
                </div>
                <!-- End About with logo Footer -->
                <!-- Start Last Post Footer -->
            	<div class="col-md-4">
                    <div class="Top-Block-Footer">
                    	<h2>Información de Contacto</h2>
                    </div>                    
                    <div class="Contact-Footer">
                            <ul> <li><i class="fa fa-map-marker"></i><p><?php echo DIR_OFICIAL;    ?></p></li>
                                 <li><i class="fa fa-phone">     </i><p><?php echo CALL_CENTER;    ?></p></li>
                                 <li><i class="fa fa-envelope">  </i><p><?php echo CORREO_OFICIAL; ?></p></li>
                            </ul>
                    </div>
                </div>
                <!-- End Last Post Footer -->

                <!-- Start Follow Footer -->
                <div class="col-md-4">
                    <div class="Top-Block-Footer">
                            <h2>Síguenos en Redes Sociales</h2>
                    </div>                    
                    <div class="Bottom-Block-Footer">						
                        <div class="Social-join">
                                <div class="Social-Footer">
                                <ul class="icons-ul">
                                    <li class="facebook"><a href="#"><span class="fa fa-facebook hvr-icon-up"></span></a></li>
                                    <li class="twitter"> <a href="#"><span class="fa fa-twitter hvr-icon-up"></span></a></li>
                                    <li class="google">  <a href="#"><span class="fa fa-google-plus hvr-icon-up"></span></a></li>
                                    <li class="linkedin"><a href="#"><span class="fa fa-linkedin hvr-icon-up"></span></a></li>
                                    <li class="youtube"> <a href="#"><span class="fa fa-youtube-play hvr-icon-up"></span></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                 </div>
                <!-- End Follow Footer -->
                </div>
         </div>
	</div>
</section>

<section id="Bottom-Footer">
	<div class="container inner-f">
    	<div class="row">
	<div class="col-md-6">
            	<div class="Rights-Reserved">
                	<h2>Derechos Reservados © <?php echo date("Y"); ?>. / <a href="#"><span>Power by Datare</span></a></h2>
                </div>
            </div>			
        </div>
    </div>
</section>
<!-- End Footer -->

</div><!-- content-wrap se abre en la vista vw_login   -->

<!-- Back to top Link -->
  <div id="to-top" class="main-bg"><span class="fa fa-chevron-up"></span></div>
<!-- Back to top Link -->

</div><!-- body-wrapper se abre en la vista vw_login   -->

<!-- STYLE SCRIPT  -->
<?php

echo script_tag(array('src' => 'style/js/customPortal.js'    ,'charset' => 'utf-8','type' => 'text/javascript'));

echo '
</body>

</html>';
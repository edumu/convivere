<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include("webpart_header.php"); 



include("webpart_menu.php"); 

echo script_tag(array('src' => 'js/ajax/loginAJAX.js', 'charset' => 'utf-8','type' => 'text/javascript'));
?>

<script>    
    $(document).ready(function(){      
      $('#fileUploaderFotoPerfil').addClass('pointer');    
      subirImagenProfile(baseURL);
      
    });//document ready
  
</script>

<!-- Start Pages Title Style5 -->

<section id="Page-title" class="Page-title-Style5">
	<div class="color-overlay"></div>
	<div class="container inner-Pages">
    	<div class="row">
            <div class="Page-title">
				<div class="col-md-6 Title-Pages">
                	<h2>Header Style 5</h2>
                </div>
                <div class="col-md-6 Catogry-Pages">
					<p>You are here :  <a href="#">Home</a>   / <a href="#">Features</a> / Header Style 5</p>
                </div>
            </div>
 		</div>
    </div>
</section>

 <!--End Pages Title Style5 -->
 
 <div id="fileUploaderFotoPerfil">&nbsp;Click para seleccionar Imagen&nbsp;</div>
 <div id="statusPF"></div>
 
 <a class='button color' href='javascript:generarPDFAX(baseURL,"test");'><span>Generar PDF</span></a>
 <div id="generaPDF"></div>
 
</div><!-- content-wrap se abre en la vista vw_login   -->

<!-- Back to top Link -->
	<div id="to-top" class="main-bg"><span class="fa fa-chevron-up"></span></div>

</div><!-- body-wrapper se abre en la vista vw_login   -->
 
 </body>

</html>
 
 
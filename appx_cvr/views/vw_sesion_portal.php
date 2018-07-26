<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include("webpart_header.php"); 

include("webpart_login.php"); 

include("webpart_menu.php"); 

include("webpart_barra_path.php");
echo script_tag(array('src' => 'style/js/classie.js','charset' => 'utf-8','type' => 'text/javascript'));

echo script_tag(array('src' => 'style/js/main.js'   ,'charset' => 'utf-8','type' => 'text/javascript'));

?>
<script>
(function() {
var bodyEl   = document.body;
classie.add( bodyEl, 'show-menu' ); 

})();
</script>
<!-- Start Tabs Style -->
<section id="Tabs-Style" class="light-wrapper">
<div class="container inner">        	  
<div class="row">
    <div class="col-md-8">
        <?php          
          echo '<center>'.img( array('src' =>  base_url().'style/images/important.gif', "width"=>"55", "heigth"=>"55"));
          echo '<h2>'.MSJ_SES_C.'</h2></center>';
          echo br(2);
        ?> 
    </div>
</div>
</div>
</section>
<!-- End Tabs Style -->

<?php

include("webpart_footer_portal.php"); 

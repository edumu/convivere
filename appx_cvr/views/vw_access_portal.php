<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include("webpart_header.php"); 

include("webpart_login.php"); 

include("webpart_menu.php"); 

include("webpart_barra_path.php");

?>

<!-- Start Tabs Style -->
<section id="Tabs-Style" class="light-wrapper">
<div class="container inner">        	  
<div class="row">
    <div class="col-md-12 access">
        <?php          
          echo '<center>'.img( array('src' =>  base_url().'style/images/important.gif', "width"=>"55", "heigth"=>"55")).'</center>';
          echo '<h2>'.$sesion.'</h2>';          
        ?> 
    </div>
</div>
</div>
</section>
<!-- End Tabs Style -->

<?php

include("webpart_footer_portal.php"); 

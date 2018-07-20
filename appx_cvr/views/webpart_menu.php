<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!-- Start Section Header style5 -->
<section class="Header-Style5">
    <div class="TopHeader">
        <div class="container">
            <div class="row">
                <div class="Contact-h col-md-6">
                    <div class="PhoneNamber">
                        <p><i class="fa fa-phone">   </i><?php echo CALL_CENTER; ?></p>
                    </div>
                    <div class="Email-Site">
                        <p><i class="fa fa-envelope"></i><?php echo CORREO_OFICIAL; ?></p>
                    </div>
               </div>
                <div class="col-md-6">
                    <div class="LoginUser"><p> <?php echo $login; ?></p></div>
                </div>
             </div>
        </div>
    </div>
<?php
echo $menu;        
?>
</section>
<!-- End Section Header style5 -->
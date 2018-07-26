<?php
defined('BASEPATH') OR exit('No direct script access allowed');

echo script_tag(array('src' => 'js/ajax/loginAJAX.js', 'charset' => 'utf-8','type' => 'text/javascript'));
?>          
<!-- Start Login User  -->
<div class="menu-wrap" id="menuLogin">
    <nav class="menu">        
            <div class="TopSide-bar">
                <div class="bottomLineDiv"> <a class="login-logo" href="#"></a> </div>
                <div class="Top-Block-Sidebar"><h2><?php echo $path ?></h2></div>
            <?php 
            echo form_open(base_url().'portal/login/', array('id'=>'login','name'=>'login','class'=>'sky-form'));
            echo '<div class="row">'.inputText_crv( array('label'=>'Usuario'   ,'icon'=>'fa-envelope','inputName'=>'usuario','inputType'=>'text'    ,'class'=>'validate[required,custom[email]] text-input'           ,'value'=>set_value('usuario'),'placeholder'=>'Cuenta Ej: usr@cnvr.mx') ).
                 '</div>';
            echo '<div class="row">'.inputText_crv( array('label'=>'Contraseña','icon'=>'fa-key'     ,'inputName'=>'pwd'    ,'inputType'=>'password','class'=>'validate[required,custom[onlyLetterNumber]] text-input','value'=>set_value('pwd')    ,'placeholder'=>'Contraseña de Acceso'              ) ).
                 '</div>';
            echo "<div class='row'>
                        <a class='button button-secondary' id='close-button'>Cerrar</a>
                        <a class='button' id='login-button' href='#'>Ingresar</a>
                    </div>
                 "; 
            ?>            
           <div class="row">
                <div id="confirmlogin" class="msjErrCentro"><?php echo $sesion ?></div>
           </div>
            <div class="row"><br>
                <div class="check-box">
                    <a href="#">¿Olvidó su contraseña?</a>
                </div>
                <div class="Sign-Up">
                    <p><a href="#">Solicitar acceso</a></p>
                </div>
            </div>
            <?php
            echo form_close();
            ?>
        </div>        
    </nav>
</div>
<!-- End Login User  -->


<!-- container   -->
<div class="content-wrap">
<div id="home" class="body-wrapper">
<!-- container se cierra en la vista vw_footer   -->
<?php 
echo '<div style="display:none;">
      <div id="modalCB_depto" >
         ';
echo form_open(base_url().'portal/guardausrdeptoAX/', array('class' => 'sky-form', 'id' => 'sky-formDepto','name' => 'formPwd'));
    echo form_input(array('name'=>'hf_id_edificio','id'=>'hf_id_edificio', 'type'=>'hidden', 'value'=>NULL));
    echo form_input(array('name'=>'hf_id_depto'   ,'id'=>'hf_id_depto'   , 'type'=>'hidden', 'value'=>NULL));    
    echo form_input(array('name'=>'hf_torre'      ,'id'=>'hf_torre'      , 'type'=>'hidden', 'value'=>NULL));
    echo form_fieldset();
    echo '<header>
          <section class="col col-4">
             <label class="label"><i class="fa fa-building"></i>'.nbs().'Numeración: </label>'.br().'<label class="label" id="numDeptoLbl"></label>
          </section>
          <section class="col col-4">
             <label class="label"><i class="fa fa-user"></i>'.nbs().'Contactos del Depto: </label>'.br().'<label class="label" id="contactosDeptoLbl"></label>
          </section>
          <section class="col col-4">
            <label class="label"><i class="fa fa-building"></i>'.nbs().'Cumplimiento </label><label class="label" id="cumpDeptoLbl"></label>
          </section>  
          </header>';
    echo form_fieldset_close();  
    echo form_fieldset();    
    echo '<div class="row">
            <section class="col col-4">'.nbs().'</section>
            <section class="col col-4"><i class="fa fa-plus" id="togNewUser"><i class="fa fa-user">Crear un Nuevo Usuario</i></i></section>
            <section class="col col-4">'.nbs().'</section>
          </div>
          <div class="row" id="detalleDepto">
            <section class="col col-3">
              <label class="label"><i class="fa fa-building"></i>'.nbs().'Tipo Dueño: </label>
              <label class="select">'.form_dropdown('tipoDueno', $tipoDueno, 0, ' id=\'tipoDueno\' ').'</label>
            </section>
            <section class="col col-2">'.nbs().'</section>
            <section class="col col-3">
              <label class="label"><i class="fa fa-user"></i>'.nbs().'Usuarios: </label>
              <label class="select">'.dropdown_crv($usuarios,'usuarios', array(), "0", ' id=\'usuarios\' ').'</label>
            </section>            
          </div>
          ';
    echo form_fieldset_close();    
    echo form_fieldset();    
    echo '<div id="nuevousuario">
            <div class="row">';
    echo    inputText_crv(array('col'=>'col-4','label'=>'Nombre'  ,'icon'=>'fa-user','inputName'=>'nombre','class'=>'validate[required,custom[onlyLetterNumber]] text-input usr','value'=>NULL,'placeholder'=>'Ej. Juan') );
    echo    inputText_crv(array('col'=>'col-4','label'=>'Apelldos','icon'=>'fa-user','inputName'=>'apellido','class'=>'validate[required,custom[onlyLetterNumber]] text-input usr','value'=>NULL,'placeholder'=>'Ej. Perez') );
    echo    inputText_crv(array('col'=>'col-4','label'=>'Correo','icon'=>'fa-envelope','inputName'=>'cuenta','class'=>'validate[required,custom[email]] text-input usr','value'=>NULL,'placeholder'=>'Ej. juan.p@hotmail.com') );
    echo ' </div>
           <div class="row">';
    echo    inputText_crv(array('col'=>'col-4','label'=>'Celular'  ,'icon'=>'fa-user','inputName'=>'celular','class'=>'validate[required,custom[onlyLetterNumber]] text-input usr','value'=>NULL,'placeholder'=>'Ej. 55-55-44-33-22-11') );
    echo    inputText_crv(array('col'=>'col-4','label'=>'Teléfono Fijo','icon'=>'fa-user','inputName'=>'telefono','class'=>'validate[custom[onlyLetterNumber]] text-input usr','value'=>NULL,'placeholder'=>'Ej. 55-123456789') );    
    echo ' <section class="col col-4"> <span class="button" id="saveUsr"><i class="fa fa-check-circle pointer"> Guardar</i></span> <span class="button button-secondary" id="canUsr"><i class="fa fa-close pointer"> Cerrar</i></span> '
       . '   <div id="confirmsky-formDepto"></div></section>'
       . '</div>'
       .'</div>';
    echo form_fieldset_close();
    echo "<footer id='footerDetalleDepto'>               
            <span class='button button-secondary canButtonModal' id='canButtonModalDU'><i class='fa fa-close'>".nbs()."       </i>Cancelar</span>
            <span class='button'           id='savButtonModalDU'><i class='fa fa-check-circle'>".nbs()."</i>Guardar</span>
            <span id='confirmDetalleDepto'></span>
          </footer>
        ";
          
echo form_close();

echo '</div>             
      </div>';

 
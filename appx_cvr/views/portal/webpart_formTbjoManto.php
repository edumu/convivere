<?php 

echo '<div style="display:none;">
      <div id="modalColorbox_contentTM" >
     ';
echo form_open(base_url().'finanzas/savetbjoMantoAX/'.$edificio, array('id'=>'tbjoMantoForm','name'=>'tbjoMantoForm','class'=>'sky-form'));
echo form_input(array('name'=> 'id_tbjoManto', 'id' => 'id_tbjoManto', 'type' => 'hidden', 'value' => NULL));
echo form_input(array('name'=> 'nuevoTM'     , 'id' => 'nuevoTM'     , 'type' => 'hidden', 'value' => NULL));
echo form_input(array('name'=> 'firstTimeTM' , 'id' => 'firstTimeTM' , 'type' => 'hidden', 'value' => 0));
echo form_input(array('name'=> 'fecha_finTM' , 'id' => 'fecha_finTM' , 'type' => 'hidden', 'value' => NULL));
echo form_fieldset();    
echo '<div class="row">
       <section class="col col-4">
       <label class="label">Nombre:</label>
            <label class="input">
                <i class="icon-append fa fa-list"></i>'.                                           
                form_input(array('name'=> 'trabajo', 'id' => 'trabajo', 'class' => 'validate[required,custom[onlyLetterNumber]] text-input','placeholder' => "Ej. Vigilancia",)).'
            </label>
       <label class="label">Descripción:</label>
            <label class="input">
                <i class="icon-append fa fa-list"></i>'.                                           
                form_input(array('name'=> 'tbjo_desc', 'id' => 'tbjo_desc', 'class' => 'validate[required,custom[onlyLetterNumber]] text-input','placeholder' => "Ej. Nueva caseta",)).'
            </label>            
       </section>   
       <section class="col col-1"></section> 
       <section class="col col-2">
            <label class="label">Anticipo: </label>
            <label class="select">'.form_dropdown('type_ant', $type_ant, 0, 'id=\'type_ant\' ').'<i></i></label> 
            <label class="label">&nbsp; </label>
            <label class="input">
                <i class="icon-append fa fa-usd"></i>'.                                           
                form_input(array('name'=> 'anticipo', 'id' => 'anticipo', 'class' => 'validate[required,custom[onlyLetterNumber]] text-input pp','placeholder' => "Ej. $100",'maxlength' => '10')).'
            </label>
        </section>              
           <section class="col col-2">
       <label class="label">Costo:</label>
            <label class="input">
                <i class="icon-append fa fa-usd"></i>'.                                           
                form_input(array('name'=> 'costo', 'id' => 'costo', 'class' => 'validate[required,custom[onlyLetterNumber]] text-input pp','placeholder' => "Ej. 1000",)).'
            </label>             
       </section>
       <section class="col col-2">
            <label class="label">Duración (días):</label>
            <label class="input">
                <i class="icon-append fa fa-list"></i>'.                                           
                form_input(array('name'=> 'duracion', 'id' => 'duracion', 'class' => 'validate[required,custom[onlyLetterNumber]] text-input pp','placeholder' => "Ej. 2 días",)).'
            </label>
            <label class="label">Inicio Trabajos:</label>
            <label class="input">
                <i class="icon-append fa fa-calendar"></i>'.
                form_input(array('name'=> 'fecha_inicioTM', 'id' => 'fecha_inicioTM', 'class' => 'validate[required,custom[onlyLetterNumber]] text-input pp','placeholder' => "Ej. 01/01/2018",)).'
            </label>             
       </section>
       
      </div><!--row -->';
echo form_fieldset_close();

echo form_fieldset();    
echo '<div class="row">
       <section class="col col-4"><label class="label"><i class="fa fa-image"></i> Antes:</label>
       <div id="divtbjoMantoA">'.img( array('src' => base_url().'logo_edificios/LogoConvivere.jpg','class'=>"img-circle centerDiv", "width"=>"100", "heigth"=>"250")).'</div>
       <div id="subirArchivoCNVRtbjoMantoA">Click para cargar evidencia</div>
       <span></span><div id="statustbjoMantoA"></div>
        '.form_input(array('name'=> 'txtTbjoMantoA', 'id' => 'txtTbjoMantoA', 'type' => 'hidden', 'value' => NULL)).'
       </section>        
       <section class="col col-4"><label class="label"><i class="fa fa-image"></i> Después:</label>        
       <div id="divtbjoMantoD">'.img( array('src' => base_url().'logo_edificios/LogoConvivere.jpg','class'=>"img-circle centerDiv", "width"=>"100", "heigth"=>"250")).'</div>
       <div id="subirArchivoCNVRtbjoMantoD">Click para cargar evidencia</div>
       <span></span><div id="statustbjoMantoD"></div>       
        '.form_input(array('name'=> 'txtTbjoMantoD', 'id' => 'txtTbjoMantoD', 'type' => 'hidden', 'value' => NULL)).'
       </section> 
       <section class="col col-3">
            <span class="labelTM" id="lblPagoAnticipo">&nbsp;</span><br>
            <span class="labelTM" id="lblFecha_fin"   >&nbsp;</span>
       </section> 
      </div><!--row -->';
echo form_fieldset_close(); 

echo form_fieldset(); 
echo '<div class="row">
        <section class="col col-3"><label class="label">Observaciones:</label>
        '.form_textarea(array('class' => 'validate[custom[onlyLetterNumber]] text-input', 'rows'=>'3', 'cols'=>'20', 'name' => 'obsTM', 'id' => 'obsTM', 'value' => NULL)).'</section>
         <section class="col col-1"></section> 
        '.inputText_crv(array('col'=>'col-3','label'=>'Proveedor:','icon'=>'fa-user-md','inputName'=>'proveedorTM','class'=>'validate[required,custom[onlyLetterNumber]] text-input','value'=>NULL,'placeholder'=>'Ej. Mantenimineto SA de CV') ).'
        <section class="col col-1"></section> 
        <section class="col col-2">
            <label class="label">Status: </label>
            <label class="select">'.form_dropdown('statusTM', $statusTM, 0, 'id=\'statusTM\' ').'<i></i></label>         
        </section>
        <section class="col col-1"></section> 
      </div><!--row -->';
echo form_fieldset_close(); 

echo "<footer class='col col-11' id='divFooter'>        
        <span class='button button-secondary canButtonModal' id='cancelarButtonTM'><i class='fa fa-close'>".nbs()."       </i>Cancelar</span>
        <span class='button'             id='savButtTM'><i class='fa fa-check-circle'>".nbs()."</i>Guardar</span>
        <span id='confirmtbjoMantoForm'></span>
      </footer>
     ";
echo form_close();
echo '</div><!--modalColorbox_content -->             
      </div><!--display:none -->';
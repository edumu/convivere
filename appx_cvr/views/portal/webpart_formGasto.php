<?php 

echo '<div style="display:none;">
      <div id="modalColorbox_contentGas" >
     ';

echo form_open(base_url().'finanzas/saveGastoAX/'.$edificio, array('id'=>'gasto-form','name'=>'gasto-form','class'=>'sky-form'));
echo form_input(array('name'=> 'iva'         , 'id' => 'iva'         , 'type' => 'hidden', 'value' => IVA));
echo form_input(array('name'=> 'gastoAdjunto', 'id' => 'gastoAdjunto', 'type' => 'hidden', 'value' => NULL));
echo form_input(array('name'=> 'id_gasto'    , 'id' => 'id_gasto'    , 'type' => 'hidden', 'value' => NULL));
echo form_input(array('name'=> 'firstTimeGas', 'id' => 'firstTimeGas', 'type' => 'hidden', 'value' => 0));
echo form_fieldset();    
echo '<div class="row">
       '.inputText_crv(array('col'=>'col-3','label'=>'Concepto:','icon'=>'fa-usd','inputName'=>'concepto','class'=>'validate[required,custom[onlyLetterNumber]] text-input','value'=>NULL,'placeholder'=>'Ej. Limpieza') ).'
       '.inputText_crv(array('col'=>'col-2','label'=>'Monto:'   ,'icon'=>'fa-usd','inputName'=>'monto','class'=>'validate[required,custom[number]] text-input','value'=>NULL,'placeholder'=>'Ej. 800') ).'       
       <section class="col col-2"><label class="checkbox"><input type="checkbox" id="tiene_iva" name="tiene_iva" value="SI"><i></i>¿Gasto facturado?</section>
       <section class="col col-2"><label class="label"><i class="fa fa-usd"></i> Total:</label><label class="label" id="lblTotal"></label>'.form_input(array('name'=>'total','id'=>'total', 'type'=>'hidden', 'value'=>NULL)).'</section>
       '.inputText_crv(array('col'=>'col-2','label'=>'Gasto del:'   ,'icon'=>'fa-calendar','inputName'=>'fecha_gasto','class'=>'validate[required,custom[onlyLetterNumber]] text-input','value'=>NULL,'placeholder'=>'Ej. 01/01/2018') ).'
      </div><!--row -->';
echo form_fieldset_close();

echo form_fieldset();    
echo '<div class="row">
       <section class="col col-4"><label class="label" id="lblComprobante"><i class="fa fa-image"></i> Comprobante:</label> 
       <div id="divGasto">'.img( array('src' => base_url().'logo_edificios/LogoConvivere.jpg','class'=>"img-circle centerDiv", "width"=>"200", "heigth"=>"350")).'</div>
       <div id="subirArchivoCNVRGasto">Click para cargar evidencia</div>
       <span></span><div id="statusGasto"></div>       
       </section>
       <section class="col col-2"><label class="checkbox"><input type="checkbox" id="gasto_fijo" name="gasto_fijo" value="SI"><i></i>¿Es gasto fijo?</section>
       <section class="col col-3 gj">
                <label class="label">¿Qué día de cada mes se aplicará el gasto fijo?:</label>
                <label class="input">
                    <i class="icon-append fa fa-calendar"></i>'.                                           
                    form_input(array('name'=> 'gasto_cada_dia', 'id' => 'gasto_cada_dia', 'class' => 'text-input', 'value'=>NULL, 'placeholder' => "Ej. 2",)).'
                </label>
                <label class="label">¿Durante cuántos meses será gasto fijo?:</label>
                <label class="input">
                    <i class="icon-append fa fa-calendar"></i>'.                                           
                    form_input(array('name'=> 'gasto_durante_meses', 'id' => 'gasto_durante_meses', 'class' => 'text-input', 'value'=>NULL, 'placeholder' => "Ej. 12",)).'
                </label>
       </section>
       <section class="col col-2"><label class="label" id="lblCuotasFijas"></label></section>
      </div><!--row -->';
echo form_fieldset_close(); 

echo "<footer class='col col-11' id='divFooter'>        
        <span class='button button-secondary canButtonModal' id='cancelarButtonGas'><i class='fa fa-close'>".nbs()."       </i>Cancelar</span>
        <span class='button'             id='savButtGas'><i class='fa fa-check-circle'>".nbs()."</i>Guardar</span>
        <span id='confirmgasto-form'></span>
      </footer>
     ";
echo form_close();
echo '</div><!--modalColorbox_content -->             
      </div><!--display:none -->';
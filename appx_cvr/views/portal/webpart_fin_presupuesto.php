<?php 
    echo form_open(base_url().'finanzas/generaPtoAX/', array('id'=>'ptoForm','name'=>'ptoForm','class' => 'sky-form'));
    echo form_fieldset();
    echo form_input(array('name' => 'id_pto'     , 'id' => 'id_pto'     , 'type' => 'hidden', 'value' => NULL));
    echo form_input(array('name' => 'edificioPto', 'id' => 'edificioPto', 'type' => 'hidden', 'value' => NULL));
    echo form_input(array('name' => 'fecha_ini'  , 'id' => 'fecha_ini'  , 'type' => 'hidden', 'value' => NULL));
    echo form_input(array('name' => 'fecha_fin'  , 'id' => 'fecha_fin'  , 'type' => 'hidden', 'value' => NULL));
    echo '<div class="row">
            <section class="col col-3">
                <label class="label">Presupuesto: </label>
                <label class="select">'.form_dropdown('ptos', $ptos, $ptoActivo, 'id=\'ptos\' ').'</label>                
            </section>
            <section class="col col-1"></section>
            <section class="col col-3">
                <label class="label">Nombre:</label>
                <label class="input">
                    <i class="icon-append fa fa-calendar-check-o"></i>'.                                           
                    form_input(array('name'=> 'nombre_pto', 'id' => 'nombre_pto', 'class' => 'validate[required,custom[onlyLetterNumber]] text-input', 'value'=>NULL, 'placeholder' => "Ej.Presupuesto 2018",)).'
                </label>
                <label class="label">Status: </label>
                <label class="select">'.form_dropdown('statusPto', $statusPTO, PTO_DESACTIVADO, 'id=\'statusPto\' ').'</label>
            </section>
            <section class="col col-1"></section>
            <section class="col col-2">
                <label class="label">De:</label>
                <label class="input">
                    <i class="icon-append fa fa-calendar-check-o"></i>'.                                           
                    form_input(array('name'=> 'pto_init', 'id' => 'pto_init', 'class' => 'monthPickerPTO', 'value'=>NULL, 'placeholder' => "Ej.Ene-2018",)).'
                </label>                         
                <label class="label">A:</label>
                <label class="input">
                    <i class="icon-append fa fa-calendar-check-o"></i>'.                                           
                    form_input(array('name'=> 'pto_fin', 'id' => 'pto_fin', 'class' => 'monthPickerPTO', 'value'=>NULL, 'placeholder' => "Ej.Dic-2018",)).'
                </label>                
            </section>             
            <section class="col col-2"><span class="pointer button" id="genPtoButton"><i class="fa fa-calendar-check-o"> Generar</i></span></section> 
          </div>';
    echo form_fieldset_close();
    
    echo form_fieldset();
    echo '<div class="row" id="divPto"><br><center><strong>No hay presupuesto seleccionado o generado</strong></center><br>
	</div>';
    echo form_fieldset_close();        
    
    echo "<footer>
                <span class='button button-secondary' id='canButtonPto'><i class='fa fa-close'>".nbs()."</i>Cancelar</span>
                <span class='button'                  id='savButtonPto'><i class='fa fa-check-circle'>".nbs()."</i>Guardar</span>
                <div id='confirmptoForm'></div>
            </footer>
         ";    

    echo form_close();



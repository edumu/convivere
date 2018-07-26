<?php 
    echo form_open(base_url(), array('id'=>'edAKForm','name'=>'edAKForm','class' => 'sky-form'));
    echo form_input(array('name'=> 'firstTimeHM','id'=> 'firstTimeHM', 'type'=>'hidden', 'value' => 0));
    echo '<fieldset> 
                <div class="row">
                <section class="col col-6">
                    <label class="label"><i class="fa fa-building"></i>'.nbs().'Edificio: </label>
                    <label class="select">'.form_dropdown('edificio', $edif, 0, 'id=\'edificio\' ').'</label>
                </section>
                <section class="col col-3"><span id="confirmEdiAX"></span></section>
                <section class="col col-2"><i class="fa fa-plus newEdificio">'.nbs().'</i><i class="fa fa-building newEdificio"></i> </section>
               </div>
           </fieldset>
         ';    
    echo form_close();
    echo '<div class="row"></div>';
    echo form_open(base_url().'edificio/guardarAX/', array('id'=>'edificioForm','name'=>'edificioForm','class' => 'sky-form'));
    echo form_input(array('name'  => 'id_edificio' , 'id' => 'id_edificio' , 'type'  => 'hidden','value' => NULL));
    echo form_input(array('name'  => 'logoEdificio', 'id' => 'logoEdificio', 'type'  => 'hidden','value' => NULL));
    echo '<fieldset> 
            <div class="row">'.
                inputText_crv(array('col'=>'col-4','label'=>'Nombre','icon'=>'fa-tag','inputName'=>'nombre','class'=>'validate[required,custom[onlyLetterNumber]] text-input','value'=>NULL,'placeholder'=>'Ej. Condiminio SuperStar') ).'
                 <section class="col col-4"><div id="subirArchivoCNVRLogo">&nbsp;Click para seleccionar Logotipo&nbsp;</div>
                                            <div id="statusLogo"></div>
                 </section>
                 <section class="col col-4" id="divLogo">'.img( array('src' => base_url().'logo_edificios/LogoConvivere.jpg','class'=>"img-circle centerDiv","id"=>"logoEdImg", "width"=>"75", "heigth"=>"55")).'
                 </section>
            </div>
            <div class="row">'
                .inputText_crv(array('col'=>'col-4','label'=>'Calle','icon'=>'fa-road','inputName'=>'calle','class'=>'validate[required,custom[onlyLetterNumber]] text-input','value'=>NULL,'placeholder'=>'Ej. Tajín') )
                .inputText_crv(array('col'=>'col-4','label'=>'Número Exterior','icon'=>'fa-road','inputName'=>'numero','class'=>'validate[required,custom[onlyLetterNumber]] text-input','value'=>NULL,'placeholder'=>'Ej 1234') )
                .inputText_crv(array('col'=>'col-4','label'=>'Colonia','icon'=>'fa-road','inputName'=>'colonia','class'=>'validate[required,custom[onlyLetterNumber]] text-input','value'=>NULL,'placeholder'=>'Ej. Del Valle') )
                .' 
            </div>
            <div class="row">'
                .inputText_crv(array('col'=>'col-4','label'=>'Alcaldía','icon'=>'fa-road','inputName'=>'alcaldia','class'=>'validate[required,custom[onlyLetterNumber]] text-input','value'=>NULL,'placeholder'=>'Ej. Benito Juarez') )
                .inputText_crv(array('col'=>'col-4','label'=>'Estado','icon'=>'fa-road','inputName'=>'estado','class'=>'validate[required,custom[onlyLetterNumber]] text-input','value'=>"CDMX",'placeholder'=>'Ej. CDMX') )                
                .inputText_crv(array('col'=>'col-4','label'=>'Código Postal','icon'=>'fa-envelope','inputName'=>'cp','class'=>'validate[required,custom[onlyLetterNumber]] text-input','value'=>NULL,'placeholder'=>'Ej. 03320') )
                .'
            </div>
          </fieldset>          
          <fieldset>
            <div class="row"> 
                <section class="col col-4"><label class="checkbox"><i class="fa fa-th-large"></i> ¿El edificio tiene amenidades?</label></section>            
                <section class="col col-7">'.$fieldsRadioAme.'</section>
            </div>
          </fieldset>
           <fieldset>
           <div class="row">'
                .inputText_crv(array('col'=>'col-3','label'=>'Cuota Manto.','icon'=>'fa-usd','inputName'=>'cuota_manto','class'=>'validate[required,custom[onlyLetterNumber]] text-input','value'=>NULL,'placeholder'=>'Ej. 800') )
                .inputText_crv(array('col'=>'col-3','label'=>'Último día de pago','icon'=>'fa-calendar','inputName'=>'dia_corte','class'=>'validate[required,custom[onlyLetterNumber]] text-input','value'=>NULL,'placeholder'=>'Ej. 10') )
                .'<section class="col col-3">
                    <label class="label">Tipo Penalización: </label>
                    <label class="select">'.form_dropdown('tipo_penalizacion', $penal, 0, 'id=\'tipo_penalizacion\' ').'</label>
                </section>'
                .inputText_crv(array('col'=>'col-3','label'=>'Penalización','icon'=>'fa-gavel','inputName'=>'penalizacion','class'=>'validate[required,custom[onlyLetterNumber]] text-input','value'=>NULL,'placeholder'=>'Ej. 100') )
                .'
            </div>
            <div class="row">'
                .inputText_crv(array('col'=>'col-3','label'=>'Número de Torres','icon'=>'fa-building','inputName'=>'num_torres','class'=>'validate[required,custom[onlyLetterNumber]] text-input','value'=>NULL,'placeholder'=>'Ej. 2') )
                .inputText_crv(array('col'=>'col-3','label'=>'Deptos por Torre','icon'=>'fa-home','inputName'=>'num_viviendas','class'=>'validate[required,custom[onlyLetterNumber]] text-input','value'=>NULL,'placeholder'=>'Ej. A') )
                .' <section class="col col-2"></section>
                   <section class="col col-2"><label class="label">Total Deptos</label><label class="label" id="totalDeptos"></label></section>
                   <section class="col col-2"><label class="label">Total Cuotas</label><label class="label" id="totalCuotas"></label></section>
            </div>
            </fieldset>
             <fieldset>
            <div class="row">'                
                .'<section class="col col-3"><i class="fa fa-map" id="tgC"></i></section>'
                .'<section class="col col-3"></section><div id="coordenadas">'
                .inputText_crv(array('col'=>'col-3','label'=>'Latitud','icon'=>'fa-road','inputName'=>'latitud','class'=>'validate[required,custom[onlyLetterNumber]] text-input','value'=>NULL,'placeholder'=>'Ej. 123456789') )
                .inputText_crv(array('col'=>'col-3','label'=>'Longitud','icon'=>'fa-road','inputName'=>'longitud','class'=>'validate[required,custom[onlyLetterNumber]] text-input','value'=>NULL,'placeholder'=>'Ej. 987654321') )
                .'</div>
            </div>
          </fieldset>
           <fieldset>
            <div class="row col-12" id="divTorres"></div>             
          </fieldset>';
    echo "<footer>
                <span class='button button-secondary' id='canButton'><i class='fa fa-close'>".nbs()."</i>Cancelar</span>
                <span class='button'                  id='savButton'><i class='fa fa-check-circle'>".nbs()."</i>Guardar</span>
                <div id='confirmedificioForm'></div>
            </footer>
         ";    

    echo form_close();



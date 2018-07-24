
 <?php 
 echo form_open(base_url(), array('id'=>'formAB','name'=>'formAB','class' => 'sky-form'));
 echo form_input(array('name'=> 'firstTimeAB','id'=> 'firstTimeAB', 'type'=>'hidden', 'value' => 0));
 echo '<fieldset> 
            <div class="row">
            <section class="col col-6">
                <label class="label"><i class="fa fa-building"></i>'.nbs().'Edificio: </label>
                <label class="select">'.form_dropdown('edTorres', $edif, 0, 'id=\'edTorres\' ').'</label>
            </section>
            <section class="col col-2"><span id="confirmedTorres"></span></section>
            <section class="col col-3">                
            </section>
           </div>
       </fieldset>
     ';
echo form_close(); 
echo '<div class="row">'
.    '  <section class="col col-2"><i class="fa fa-calendar-minus-o" id="togCalendarAB">Ver Calendario</i></section> '
.    '  <section class="col col-9"></section> '
.    '</div>';
echo '<div class="row">
        <section class="col col-11" id="calendarAB">
            <div id="errorAB"  > <i class="fa fa-warning">Error no se pudo cargar las Asambleas del edificio. Favor de reportar '.CALL_CENTER.' o al correo '.CORREO_OFICIAL.'</i> </div>
            <div id="loadingAB"><img src="'.base_url().'style/images/loading.gif" width="60" height="60"> Cargando...</div>
            <div id="calendar" ></div>
        </section> 
      </div>';



    
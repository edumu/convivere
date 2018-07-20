<?php 
/* highcharts V6 */
echo script_tag(array('src' => 'js/chart/code/highcharts-more.js'       ,'type' => 'text/javascript'));
echo script_tag(array('src' => 'js/chart/code/modules/solid-gauge.js'   ,'type' => 'text/javascript'));


echo form_open(base_url(), array('id'=>'headGastoForm','name'=>'headGastoForm','class'=>'sky-form'));
echo form_fieldset();
echo '  <div class="row">
            <section class="col col-4">
                <div class="recuadroGris">
                    <label class="label" id="lblTotCuota"><i class="pointer fa fa-usd"></i> Cuotas: <span id="totCuotas"></span></label>'.form_input(array('name'=> 'totCuotasTxt', 'id' => 'totCuotasTxt', 'type' => 'hidden', 'value' => NULL)).'
                        <div id="containerChartCVR_GAS" style="min-width: 100px; max-width: 400px; height: 115px; margin: 1em auto"></div>
                </div>                
            </section>
            <section class="col col-4"></section>
            <section class="col col-4 recuadroGris">
               <label class="label" id="lblTotGAS"><i class="pointer fa fa-usd"></i> Gastos: <span id="totGastos">       </span> </label>'.form_input(array('name'=> 'totGastosTxt', 'id' => 'totGastosTxt', 'type' => 'hidden', 'value' => NULL)).br(2).'
               <label class="label" id="lblTotTM"> <i class="pointer fa fa-usd"></i> Trabajos de Manto: <span id="totTM"></span> </label>'.form_input(array('name'=> 'totTMTxt'    , 'id' => 'totTMTxt'    , 'type' => 'hidden', 'value' => NULL)).br(2).'
               <label class="label" id="lblTotPTO"><i class="pointer fa fa-usd"></i> Presupuesto:<span id="totPto">      </span> </label>'.form_input(array('name'=> 'totPTOTxt'   , 'id' => 'totPTOTxt'   , 'type' => 'hidden', 'value' => NULL)).br(3).'
            </section>
        </div><!--row -->
        <div class="row"><section class="col col-4"><i class="pointer fa fa-search-minus" id="togSearchGas"> Busqueda </i></section>
                         <section class="col col-5"><strong id="lblGastosMes">Gastos de '.$mesAno.'</strong></section>
                         <section class="col col-3"><span id="buttonRegistrarGas" class="pointer modalColorbox button" href="#modalColorbox_contentGas" title="Formulario para capturar Gastos del Edificio"> <i class="pointer fa fa-usd"> Registrar </i></span></section>
        </div><!--row -->
        <div id="gastosParam">
            <div class="row">
               '.inputText_crv(array('col'=>'col-2','label'=>'Fecha de:'   ,'icon'=>'fa-calendar','inputName'=>'f1','class'=>'validate[required,custom[onlyLetterNumber]] text-input datecvr','value'=>NULL,'placeholder'=>'Ej. 01/01/2018') ).'
               '.inputText_crv(array('col'=>'col-2','label'=>'Fecha A:'    ,'icon'=>'fa-calendar','inputName'=>'f2','class'=>'validate[required,custom[onlyLetterNumber]] text-input datecvr','value'=>NULL,'placeholder'=>'Ej. 31/01/2018') ).'                      
               '.inputText_crv(array('col'=>'col-2','label'=>'Importe De:' ,'icon'=>'fa-usd','inputName'=>'f3','class'=>'validate[required,custom[onlyLetterNumber]] text-input ','value'=>NULL,'placeholder'=>'Ej. 1') ).'                       
               '.inputText_crv(array('col'=>'col-2','label'=>'Importe A:'  ,'icon'=>'fa-usd','inputName'=>'f4','class'=>'validate[required,custom[onlyLetterNumber]] text-input ','value'=>NULL,'placeholder'=>'Ej. 100') ).'
               '.inputText_crv(array('col'=>'col-4','label'=>'Concepto:'  ,'icon'=>'fa-list-ul','inputName'=>'f5','class'=>'validate[required,custom[onlyLetterNumber]] text-input ','value'=>NULL,'placeholder'=>'Ej. Limpieza') ).'
               <section class="col col-4"></section>
               <section class="col col-4"><i class="pointer fa fa-search"> Buscar </i></section>
            </div><!--row -->
        </div><!--gastosParam -->
     ';
echo form_fieldset_close();
echo form_close();

echo form_fieldset(); 
echo '  <div class="row">
        <section class="col col-12">';            
echo  ' <div class="table-responsive">
            <table class="table table-striped table-hover" id="gastosTable">
            <thead>
                <tr class="negritas">
                  <th>#</th>
                  <th>Concepto</th>
                  <th>Monto</th>
                  <th>Iva</th>
                  <th>Total</th>                                    
                  <th>Evidencia</th>
                  <th class="accionesGas">Acciones</th>
                </tr>
          </thead>
          <tbody></tbody>
          </table>
        </div><!--table responsive -->'; 
echo br(1).'<div id="linksPaginargastos"></div><span id="spinPaginargastos"></span>';
echo '</section>
      </div><!--row -->
     ';
echo form_fieldset_close(); 

include("webpart_formGasto.php");




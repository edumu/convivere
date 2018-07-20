<?php 
echo form_open(base_url(), array('id'=>'headtbjoMantoForm','name'=>'headtbjoMantoForm','class'=>'sky-form'));
echo form_fieldset();
echo '  <div class="row"><section class="col col-3"><i class="pointer fa fa-search-minus" id="togSearchTM"> Busqueda </i></section>
                         <section class="col col-6"><strong id="lblTMMes">Trabajos de Mantenimiento de '.$mesAno.'</strong></section>
                         <section class="col col-3"><span id="buttonRegistrarTM" class="pointer modalColorbox button" href="#modalColorbox_contentTM" title="Formulario para registrar un Trabajo de Mantenimiento"> <i class="pointer fa fa-list"> Registrar </i></span></section>
        </div><!--row -->
        <div id="tbjoMantoParam">
            <div class="row">
               '.inputText_crv(array('col'=>'col-2','label'=>'Fecha de:'   ,'icon'=>'fa-calendar','inputName'=>'f1TM','class'=>'validate[required,custom[onlyLetterNumber]] text-input datecvrTM','value'=>NULL,'placeholder'=>'Ej. 01/01/2018') ).'
               '.inputText_crv(array('col'=>'col-2','label'=>'Fecha A:'    ,'icon'=>'fa-calendar','inputName'=>'f2TM','class'=>'validate[required,custom[onlyLetterNumber]] text-input datecvrTM','value'=>NULL,'placeholder'=>'Ej. 31/01/2018') ).'                      
               '.inputText_crv(array('col'=>'col-2','label'=>'Importe De:' ,'icon'=>'fa-usd'     ,'inputName'=>'f3TM','class'=>'validate[required,custom[onlyLetterNumber]] text-input '         ,'value'=>NULL,'placeholder'=>'Ej. 1') ).'                       
               '.inputText_crv(array('col'=>'col-2','label'=>'Importe A:'  ,'icon'=>'fa-usd'     ,'inputName'=>'f4TM','class'=>'validate[required,custom[onlyLetterNumber]] text-input '         ,'value'=>NULL,'placeholder'=>'Ej. 100') ).'
               '.inputText_crv(array('col'=>'col-4','label'=>'Concepto:'   ,'icon'=>'fa-list-ul' ,'inputName'=>'f5TM','class'=>'validate[required,custom[onlyLetterNumber]] text-input '         ,'value'=>NULL,'placeholder'=>'Ej. Limpieza') ).'
               <section class="col col-4"></section>
               <section class="col col-4"><i class="pointer fa fa-search"> Buscar </i></section>
            </div><!--row -->
        </div><!--tbjoMantoParam -->            
     ';
echo form_fieldset_close();
echo form_close();

echo form_fieldset(); 
echo '  <div class="row">
        <section class="col col-12">';            
echo  ' <div class="table-responsive">
            <table class="table table-striped table-hover" id="tbjoMantoTable">
            <thead>
                <tr class="negritas">
                  <th>#</th>
                  <th>Trabajo</th>
                  <th>Proveedor</th>
                  <th>Costo</th>
                  <th>Fecha Compromiso</th>
                  <th>Orden de Trabajo</th>
                  <th>Antes / Después</th>
                  <th class="accionesTM">Acciones</th>
                </tr>
          </thead>
          <tbody></tbody>
          </table>
        </div><!--table responsive -->'; 
echo br(1).'<div id="linksPaginartbjoMto"></div><span id="spinPaginartbjoMto"></span>';
echo '</section>
      </div><!--row -->
     ';
echo form_fieldset_close(); 

include("webpart_formTbjoManto.php");




 <?php 
 
echo form_open(base_url(), array('id'=>'torForm','name'=>'torForm','class' => 'sky-form'));
echo form_input(array('name'=> 'firstTimeDP','id'=> 'firstTimeDP', 'type'=>'hidden', 'value' => 0));

include("webpart_edificios_torres.php");

echo form_close();

echo form_open(base_url().'edificio/buscarDeptoAX/', array('id'=>'searchDeptoForm','name'=>'searchDeptoForm','class' => 'sky-form'));    
echo '  <div class="row"><section class="col col-4"><i class="fa fa-search-plus" id="togSerchDep"> Busqueda </i></section>
                         <section class="col col-4"><strong id="lblDeptoMes"></strong></section>
                         <section class="col col-4" id="secCuotasChart"></section>
        </div><!--row -->';
echo form_fieldset()
        .'<div class="row" id="buscarDeptoForm">'
          .inputText_crv(array('col'=>'col-3','label'=>'Depto','icon'=>'fa-home','inputName'=>'f1Depto','class'=>'validate[required,custom[onlyLetterNumber]] text-input','value'=>NULL,'placeholder'=>'Ej. 101') ).
        ' <section class="col col-5">
            <span class="button" id="savButton"><i class="fa fa-search">'.nbs().'</i>Buscar</span>
            <div  id="confirmFiltrarDepForm"></div>
          </section>
        </div><!--row -->'
    .form_fieldset_close();
echo form_close();

echo '  <div class="row">
        <section class="col col-12">';  
echo '<div class="table-responsive">
        <table class="table table-striped table-hover" id="deptosTable">
        <thead>
            <tr class="negritas">
              <th>#</th>
              <th>Torre</th>
              <th>Numeración</th>
              <th>Dueño</th>
              <th>'.nbs().'</th>
            </tr>
      </thead>
      <tbody></tbody>
      </table>
    </div>';
echo br(1).'<div id="linksPaginardeptos"></div><span id="spinPaginardeptos"></span>';
echo '</section>
      </div><!--row -->
     ';

include("webpart_formDepto.php");

include("webpart_formPagoManto.php");

echo   '<div style="display:none;">
        <div id="modalCB_gridCuotas" >';
echo form_input(array('name'=> 'edificioGridCuotas','id'=> 'edificioGridCuotas', 'type'=>'hidden', 'value' => NULL));
echo form_input(array('name'=> 'torreGridCuotas'   ,'id'=> 'torreGridCuotas'   , 'type'=>'hidden', 'value' => NULL));
echo form_input(array('name'=> 'deptoGridCuotas'   ,'id'=> 'deptoGridCuotas'   , 'type'=>'hidden', 'value' => NULL));
        include("webpart_fin_grid_cuotas.php");
echo    '</div>             
         </div>';

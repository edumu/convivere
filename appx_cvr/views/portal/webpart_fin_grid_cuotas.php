<?php

echo form_fieldset();   
echo '  <div class="row"><section class="col col-12"><i class="pointer fa fa-folder" id="misCuotas">'.nbs().'Mis Cuotas</i></section></div>
        <div id="misCuotasDet" class="row">
        <section class="col col-12">';            
echo  ' <div class="table-responsive">
            <table class="table table-striped table-hover" id="cuotasTable">
            <thead >
                <tr class="negritas">
                  <th>#</th>
                  <th>Referencia</th>
                  <th>Cuota del Mes</th>
                  <th>Importe</th>
                  <th>Status</th>
                  <th>Tipo Pago</th>
                  <th>'.nbs().'</th>
                </tr>
          </thead>
          <tbody></tbody>
          </table>
        </div>'; 
echo br(1).'<div id="linksPaginarcuotas"></div><span id="spinPaginarcuotas"></span>';
echo '</section>
        </div>
     ';
echo form_fieldset_close(); 
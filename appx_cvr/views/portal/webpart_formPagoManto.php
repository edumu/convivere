<?php 
echo '<div style="display:none;">
      <div id="modalCB_pagoEnLinea" >
     ';

echo form_open(base_url().'finanzas/pagoTarjetaAX/', array('id'=>'payment-form','name'=>'payment-form','class'=>'sky-form'));
echo form_input(array('name'=>'referencia'    ,'id'=>'referencia'    , 'type'=>'hidden', 'value'=>$referencia));
echo form_input(array('name'=>'importe'       ,'id'=>'importe'       , 'type'=>'hidden', 'value'=>$imp['importe']));    
echo form_input(array('name'=> 'firstTimePago','id'=> 'firstTimePago', 'type'=>'hidden', 'value' => 0));
echo form_fieldset();    
echo '<div class="row">      
      <section class="col col-3">
        <label class="label"><i class="fa fa-building"></i>'.nbs().'Cuotas pendientes: </label>
        <label class="select">'.dropdown_crv($cuotas,'cuotas', array(), "0", ' id=\'cuotas\' ').'</label>
      </section>
      <section class="col col-1"> </section>
      <section class="col col-4"><label class="label"><i class="fa fa-money"></i> Tipo de Pago: </label><div id="tiposPagoDiv">'.$tiposPagoRadioButton.'</div></section>
      <section class="col col-1"> </section>
      <section class="col col-3">
        <label class="label"><i class="fa fa-link" ></i> Referencia: </label>'.br().'<label class="label" id="lblReferencia">'.$referencia.'</label>'.br(2).'
        <label class="label"><i class="fa fa-usd"  ></i> Importe Total a Pagar:</label>'.br().'<label class="label" id="lblImporte">'.$imp['importeStr'].'</label>'.br().'<label class="label" id="lblpena">'.($imp['penalizacion']<0?'(<i class="fa fa-gavel" style="font-size:11px;font-style: italic;"> monto penalizado '.$imp['penaStr'].'</i>)':"").'</label>
      </section>      
      </div>';
echo form_fieldset_close(); 

echo form_fieldset();    
echo '<div class="row" id="tipoPagoContenedor">';

include("webpart_formOpenPay.php");

echo '</div>';
echo '<div id="divBusquedaTiendas"></div>';
echo form_fieldset_close();

echo "<footer class='col col-11' id='divFooter'>        
        <span class='button button-secondary canButtonModal' id='cancelarButtonTDC'><i class='fa fa-close'>".nbs()."       </i>Cancelar</span>
        <span class='button'                                 id='savButtonModalTDC'><i class='fa fa-check-circle'>".nbs()."</i>Pagar</span>
        <span id='confirmPaid'></span>
      </footer>
     ";
echo form_close();
echo '</div>             
      </div>';
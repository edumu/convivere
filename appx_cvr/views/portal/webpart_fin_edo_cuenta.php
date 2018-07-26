<?php 
/* highcharts V6 */
echo script_tag(array('src' => 'js/chart/code/modules/data.js'     ,'type' => 'text/javascript'));
echo script_tag(array('src' => 'js/chart/code/modules/drilldown.js','type' => 'text/javascript'));

    echo form_open(base_url().'finanzas/generaEdoCtaAX/', array('id'=>'edoCtaForm','name'=>'edoCtaForm','class' => 'sky-form'));
    
    echo form_fieldset();
    echo form_input(array('name' => 'mesEdoCta', 'id' => 'mesEdoCta', 'type' => 'hidden', 'value' => NULL));
    echo form_input(array('name' => 'anoEdoCta', 'id' => 'anoEdoCta', 'type' => 'hidden', 'value' => NULL));    
    echo '<div class="row">
          <section class="col col-3">
            <label class="label">Estado de Cuenta:</label>
            <label class="input">
                <i class="icon-append fa fa-calendar"></i>'.                                           
                form_input(array('name'=> 'edo_mesEC', 'id' => 'edo_mesEC', 'class' => 'text-input monthPickerEC', 'value'=>NULL, 'placeholder' => "Ej. Ene-2018",)).'
            </label>
            <div id="divEdoCta">'.br(4).'</div>
          </section>
          <section class="col col-2"><span class="pointer button" id="genEdoCtaButton"><i class="fa fa-file-pdf-o"> Generar</i>'.nbs(4).'</span>
                            '.br(2).'<span class="button pointer" id="sendEC" ><i class="fa fa-envelope"> Enviar a Condominos </i> </span>
          </section>          
          <section class="col col-7"><div id="containerChartCVR_EC" style="width: 100%; height: 100%; float: center"></div>
          </section>           
          </div>';    
    echo form_fieldset_close();    
    
    echo "<footer> <um>CONVIVERE</um> </footer>";    

    echo form_close();

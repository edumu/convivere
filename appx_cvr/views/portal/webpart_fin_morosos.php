<?php 
/* highcharts V6 */
echo script_tag(array('src' => 'js/chart/code/modules/bullet.js'   ,'type' => 'text/javascript'));

echo form_open(base_url(), array('id'=>'morososForm','name'=>'morososForm','class'=>'sky-form'));
echo form_fieldset();
echo form_input(array('name'=> 'tasaMoroField','id'=> 'tasaMoroField', 'type'=>'hidden', 'value' => 0));
echo '<div class="row">
            <section class="col col-4 recuadroGris">
                <label class="label">Departamentos con cuotas pendientes:</label><br>
                <div id="divDeptosMorosos"></div>
            </section>
            <section class="col col-1"></section>
            <section class="col col-4">
                <div class="recuadroGris">
                    <label class="label" id="titCP">Cuotas pendientes:</label><br>
                    <div id="divCuotasMorosos"></div>
                </div>
                '.br(2).'
                <div class="recuadroGris" id="tasasDivMoro"></div>
                '.br().'
                <div id="containerChartCVR_MOR" style="width: 300px; height: 100px; float: center"></div>
            </section>
            <section class="col col-3">
               <span class="button pointer" id="sendDM" ><i class="fa fa-envelope"> Enviar Aviso &nbsp;&nbsp; </i> </span>
               <span class="button pointer" id="printDM"><i class="fa fa-print"> Imprimir Aviso </i></span>
               '.br(2).'
               <div id="divActionMorosos"></div>
            </section>
        </div><!--row -->         
     ';
echo form_fieldset_close();
echo form_close();






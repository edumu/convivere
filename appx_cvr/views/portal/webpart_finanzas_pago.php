<?php     
echo form_open(base_url(), array('id'=>'headPagoForm','name'=>'headPagoForm','class'=>'sky-form'));
echo form_input(array('name'=>'ratingDepto', 'id'=>'ratingDepto', 'type'=>'hidden', 'value'=>$ratingDepto));
echo form_fieldset();
echo '<div class="row">
            <section class="col col-3 recuadroGris">
                <label class="label"><i class="fa fa-home"></i>'.nbs().'Depto: '.$depto[0]['NUMERACION'].'</label>
                <span class="row '.$status['class'].'">'.$status['msj'].'</span>';
echo            ($status['class']==="msjConfirmation"?"":'<span title="Pago en línea de la Cuota del Mantenimiento" href="#modalCB_pagoEnLinea" class="mcb_pl button" id="savButton" torre="'.$depto[0]['TORRE'].'" edificio="'.$depto[0]['ID_EDIFICIO'].'" depto="'.$depto[0]['ID_DEPTO'].'"><i class="fa fa-usd"></i>'.nbs().'Pagar</span>');                
echo '      </section>
            <section class="col col-1">'.nbs().'</section>
            <section class="col col-3 recuadroGris">
                <label class="label row"><i class="fa fa-calendar"></i>'.nbs().$hoy.'</label>
                '.br().'
                <label class="label row">Cumplimiento: '.$depto[0]['CUMPLIMIENTO'].'</label>
                <div id="cumplientoRating" style="height:30px;width: 150px;"> <i class="fa fa-gavel" style="font-size:20px;color:red;"></i> </div>
                '.br(2).'
            </section>
            <section class="col col-1">'.nbs().'</section>
            <section class="col col-2">                
                <label class="label" style="font-size:8pt;"><i class="fa fa-building"></i>'.nbs().$depto[0]['CALLE'].nbs().$depto[0]['NUMERO'].br().$depto[0]['COLONIA'].br().$depto[0]['ALCALDIA'].nbs().$depto[0]['ESTADO'].'</label>
                '.br().'
                <label class="label">'.img( array('src' => base_url().'logo_edificios/'.$depto[0]['ID_EDIFICIO'].'/'.$depto[0]['LOGOTIPO'],'class'=>"img-circle", "width"=>"75", "heigth"=>"55")).br().$depto[0]['NOMBRE'].'</label>
            </section>
            <section class="col col-1">'.nbs().'</section>
        </div>            
     ';
echo form_fieldset_close();
echo form_close();

include("webpart_fin_grid_cuotas.php");

include("webpart_formPagoManto.php");




 <?php 
 
echo form_fieldset();
 
echo '<div class="row">
        <section class="col col-6">
            <label class="label"><i class="fa fa-building"></i>'.nbs().'Edificio: </label>
            <label class="select">'.form_dropdown('edTorres', $edif, 0, 'id=\'edTorres\' ').'</label>
        </section>
        <section class="col col-2"><span id="confirmedTorres"></span></section>
        <section class="col col-3">
            <label class="label"><i class="fa fa-building"></i>'.nbs().'Torre: </label>
            <label class="select">'.form_dropdown('torres', $torres, 0, 'id=\'torres\' ').'</label>
        </section>
       </div>       
     ';
 
 echo form_fieldset_close();
 

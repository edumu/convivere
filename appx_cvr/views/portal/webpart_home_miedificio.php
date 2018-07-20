<?php 
    echo form_open(base_url(), array('id'=>'edAKForm','name'=>'edAKForm','class' => 'sky-form'));
    
    
    echo "<div class='row'>               
                <span class='button button-secondary' id='canButton'><i class='fa fa-close'>".nbs()."</i>Cancelar</span>
                <span class='button'                  id='savButton'><i class='fa fa-check-circle'>".nbs()."</i>Guardar</span>
                <div id='confirmedificioForm'></div>
            </div>
         ";    

    echo form_close();
?>



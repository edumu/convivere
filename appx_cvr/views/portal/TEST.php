<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include(__DIR__."/../webpart_header.php"); 

?>

<script type="text/javascript">

$(document).ready(function(){

    $(".arrastrablePto").draggable();//defino los elementos que se pueden arrastrar
    $(".arrastrablePto").data("soltado", false);


    $(".sueltaPto").data("numsoltar", 0); //voy a crear una variable para contar los elementos que estoy soltando

    $(".sueltaPto").droppable({//defino elementos donde se puede soltar
            drop: function( event, ui ) {
                    if (!ui.draggable.data("soltado")){
                            ui.draggable.data("soltado", true);
                            var elem = $(this);
                            elem.data("numsoltar", elem.data("numsoltar") + 1)
                            elem.html("Llevo " + elem.data("numsoltar") + " elementos soltados");
                    }
            },
            out: function( event, ui ) {
                    if (ui.draggable.data("soltado")){
                            ui.draggable.data("soltado", false);
                            var elem = $(this);
                            elem.data("numsoltar", elem.data("numsoltar") - 1);
                            elem.html("Llevo " + elem.data("numsoltar") + " elementos soltados");
                    }
            }
    });

    $("#sueltaMesPto").droppable("option", "accept", ".concepto");//soltar solo elementos rojos
});
</script>
<h1>Probando el comportamiento droppable de jQueryUI</h1>	
	
	
	<div id="sueltaMesPto" class="sueltaPto">
		MES
	</div>
<div id="pto-conceptos">
      <h4>Draggable Events</h4>
      <div class="concepto arrastrablePto">My Event 1</div>
      <div class="concepto arrastrablePto">My Event 2</div>
      <div class="concepto arrastrablePto">My Event 3</div>
      <div class="concepto arrastrablePto">My Event 4</div>
      <div class="concepto arrastrablePto">My Event 5</div>
      <p> <label>remove after drop</label></p>
</div>
<?php
echo br(8);
include(__DIR__."/../webpart_footer_portal.php"); 

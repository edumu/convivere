<?php 

/************FORMULARIO OPEN PAY************/
echo '<section class="col col-11">
      <div class="bkng-tb-cntnt">
        <div class="pymnts">           
            <input type="hidden" name="token_id" id="token_id">
            <input type="hidden" name="tipoPago" id="tipoPago" value="'.CARD.'">            
            <div class="pymnt-itm card active">
                <h2>Tarjeta de crédito o débito</h2>
                <div class="pymnt-cntnt">
                    <div class="card-expl">
                        <div class="credit"><h4>Tarjetas de crédito</h4></div>
                        <div class="debit" ><h4>Tarjetas de débito </h4></div>
                    </div>
                    <div class="sctn-row">
                        <div class="sctn-col l">
                            <label>Nombre del titular</label><input type="text" placeholder="Como aparece en la tarjeta" autocomplete="off" data-openpay-card="holder_name" name="holder_name" id="holder_name" class="cvrField">
                        </div>
                        <div class="sctn-col">
                            <label>Número de tarjeta</label><input type="text" autocomplete="off" data-openpay-card="card_number" name="card_number" id="card_number" class="cvrField">
                        </div>
                        <div class="sctn-row">
                            <div class="sctn-col l">
                                <label>Fecha de expiración</label>
                                <div class="sctn-col half l"><input type="text" placeholder="Mes. Ej: 01" maxlength="2" class="onlyNumber" data-openpay-card="expiration_month" name="expiration_month" id="expiration_month"></div>
                                <div class="sctn-col half l"><input type="text" placeholder="Año. Ej: 18" maxlength="2" class="onlyNumber" data-openpay-card="expiration_year"  name="expiration_year"  id="expiration_year" ></div>
                            </div>
                            <div class="sctn-col cvv"><label>Código de seguridad</label>
                                <div class="sctn-col half l"><input type="text" placeholder="3 dígitos" autocomplete="off" class="onlyNumber" data-openpay-card="cvv2" name="CVV2" id="CVV2" maxlength="4" class="cvrField"></div>
                            </div>
                        </div>
                        <div class="openpay"><div class="logo">Transacciones realizadas vía:</div>
                        <div class="shield">Tus pagos se realizan de forma segura con encriptación de 256 bits</div>
                    </div>
                </div>
            </div>            
        </div>
    </div>
   </section>';
/************FORMULARIO OPEN PAY************/
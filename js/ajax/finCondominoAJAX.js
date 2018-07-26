
$("document").ready(function (){ habilitaJS_Webpart("PAG");
                                 $("#f_webpart_t1").click(function(){ habilitaJS_Webpart("PAG"); });
                                 $("#f_webpart_t2").click(function(){ habilitaJS_Webpart("GAS"); });
                                 $("#f_webpart_t3").click(function(){ habilitaJS_Webpart("TM" ); });
                                 $("#f_webpart_t4").click(function(){ habilitaJS_Webpart("PTO"); });
                                 $("#f_webpart_t5").click(function(){ habilitaJS_Webpart("EC" ); });                                
                               }); //$("document").ready


function habilitaJS_Webpart(tipo)
{
var today    = new Date();
var FirstDay = new Date(today.getFullYear(), today.getMonth()    , 1);
var LastDay  = new Date(today.getFullYear(), today.getMonth() + 1, 0);

switch(tipo){ 
case "PAG": /*********     Formulario PAGO CUOTA  INI       ***********/     
    var param  = {"id_depto":null, "id_edificio":null, "torre":null};// param setteados como admins unicamente
    habilitaCamposPago(param);

    if($("#firstTimePago").val() == 0 )
     { habilitaMODAL("pagos");
       $("#cumplientoRating").jRate({ rating: $("#ratingDepto").val() });
       $("#cumplientoRating").css("cursor", "");
       $("#misCuotasDet").toggle();
       $("#misCuotas"   ).click(function(){ var isHidden = $("#misCuotasDet").is(":hidden");                                    
                                            if(isHidden) { $("#misCuotas").removeClass("fa-folder").addClass("fa-folder-open" ); 
                                                           paginarAX("cuotas", "cuotasTable", 1, 10);
                                                         }
                                            else         { $("#misCuotas").removeClass("fa-folder-open" ).addClass("fa-folder"); }
                                            $("#misCuotasDet").toggle("swing");
                                          });
      $("#firstTimePago").val(1); 
      }    
 break;     /*********     Formulario PAGO CUOTA  FIN       ***********/
 
 case "GAS": /*********     Formulario Gastos  INI       ***********/
    cargaChartAX("GAS");
    $("#f1"         ).datepicker({dateFormat: 'dd/mm/yy'}).datepicker('setDate', FirstDay);
    $("#f2"         ).datepicker({dateFormat: 'dd/mm/yy'}).datepicker('setDate', LastDay);
    $(".datecvr"    ).change(function(){ $("#lblGastosMes").html("Gastos del "+$("#f1").val()+" al "+$("#f2").val()); });    
    $("#fecha_gasto").datepicker({dateFormat: 'dd/mm/yy'}).datepicker('setDate',today);    
    paginarAX("gastos", "gastosTable", 1, 10);    
    if( Number($("#firstTimeGas").val()) === 0 )
     {
      toogleCVR("gastosParam", "togSearchGas");
      $("#buttonRegistrarGas").hide();
      $(".accionesGas"       ).hide();     
      $("#firstTimeGas"      ).val(1); 
     }    
 break;     /*********     Formulario Gastos  FIN       ***********/
 
 case "TM": /*********     Formulario Trabajos Manto  INI       ***********/          
     $("#f1TM"          ).datepicker({dateFormat: 'dd/mm/yy'}).datepicker('setDate', FirstDay);
     $("#f2TM"          ).datepicker({dateFormat: 'dd/mm/yy'}).datepicker('setDate', LastDay);
     $(".datecvrTM"     ).change(function(){ $("#lblTMMes").html("Trabajos de Mantenimiento del "+$("#f1TM").val()+" al "+$("#f2TM").val()); });     
     paginarAX('tbjoMto', 'tbjoMantoTable', 1, 10);    
     
     if( Number($("#firstTimeTM").val()) === 0 )
     {
        toogleCVR("tbjoMantoParam", "togSearchTM");
        $("#buttonRegistrarTM").hide();
        $(".accionesTM"       ).hide();     
        $("#firstTimeTM"      ).val(1);        
     }               
 break;      /*********     Formulario Trabajos Manto  FIN       ***********/
 
 case "PTO": /*********     Formulario Presupuesto  INI       ***********/             
     $(".monthPickerPTO").datepicker({ dateFormat: 'MM yy', changeMonth: true, changeYear: true, showButtonPanel: true });
     $("#pto_init"  ).attr('disabled','disabled');
     $("#pto_fin"   ).attr('disabled','disabled');
     $("#nombre_pto").attr('disabled','disabled');
     $("#statusPto" ).attr('disabled','disabled');
     
     if( $("#ptos" ).val() !== "0" )
       { cargaPtoAX($("#ptos").val(), true); }
     $("#ptos"        ).change(function () { cargaPtoAX($(this).val(), true); });
     $("#genPtoButton").hide();
     $("#edificioPto" ).val( $("#id_edificio").val() );    
 break;     /*********     Formulario Presupuesto  FIN      ***********/   
 
 case "EC": /*********     Formulario Estado Cuenta  INI       ***********/
     $(".monthPickerEC").datepicker({ dateFormat: 'MM yy', changeMonth: true, changeYear: true, showButtonPanel: true,
                                    onClose: function(){ var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                                                         var year  = $("#ui-datepicker-div .ui-datepicker-year  :selected").val(); 
                                                         var thisMonth = new Date(year, month, 1);
                                                         
                                                         $(this).val($.datepicker.formatDate('MM yy', thisMonth)); 
                                                         $("#mesEdoCta").val( getMonthCalendarDatePicker(Number(thisMonth.getMonth())) );
                                                         $("#anoEdoCta").val( thisMonth.getFullYear() );
                                                       }
                                  });
     $(".monthPickerEC"  ).val("");
     $("#genEdoCtaButton").click(function () { generaEdoCtaAX();   });     
     $("#sendEC"         ).hide();
 break; /*********     Formulario Estado Cuenta  FIN       ***********/
    
}//switch
}//habilitaJS_Webpart


var success_callbak = function(response) 
{
    var token_id = response.data.id;
    $('#token_id').val(token_id);
    submitFinAX('payment-form');    
};

var error_callbak = function(response) 
{
    var desc = response.data.description === undefined ? response.message : response.data.description;
    erroresOpenPay(response.status, desc);
    //jAlert("ERROR [" + response.status + "] " + desc, $('#tituloAlert').val()); 
    $("#savButtonModal").prop("disabled", false);
};

function erroresOpenPay(status, desc) 
{
switch(true)
    {
     case desc.startsWith("expiration_month") && desc.includes("invalid"):
          $("#expiration_month").after("<span class='msjErr'>* El campo Mes debe ser de 2 digitos con el rango valido de 01 a 12, el valor "+$("#expiration_month").val()+" NO es correcto</span>");
     break;
     case desc.startsWith("expiration_year") && desc.includes("invalid"):
          $("#expiration_year").after("<span class='msjErr'>* El campo Año debe ser de 2 digitos con el rango valido 01 a 99, el valor "+$("#expiration_year").val()+" NO es correcto</span>");
      break;    
     case desc==="The expiration date has already passed":
          $("#expiration_year").after("<span class='msjErr'>* La tarjeta no se encuentra vigente, favor de revisar la fecha de expiración</span>");
      break;    
     default : var campos = desc.split(",");          
               var campoForm = "";
               for (var i = 0; i < campos.length; i++) { 
                    campoForm = campos[i].replace("is required", "").trim();
                    if(campoForm==="expiration_year expiration_month")
                    { $("#expiration_year").after("<span class='msjErr'>* La fecha de expiración es requerida</span>"); }
                    else
                    if(desc.includes("The CVV2"))
                    { $("#CVV2").after("<span class='msjErr'>* Campo requerido</span>");       }
                    else
                    { $("#"+campoForm).after("<span class='msjErr'>* Campo requerido</span>"); }
                  }
     break;
    }
}

function submitFormFin(forma) 
{   $("#"+forma).validationEngine();	  
    if($("#"+forma).validationEngine('validate'))
      { submitFinAX($('#baseURL').val(),forma,$('#tituloAlert').val()); }
}
 

function submitFinAX(forma)
{
$("#confirmPaid").removeClass("msjErrII").removeClass("msjOkII").addClass("msjconfirmII").html(""); 
$.ajax({data      : $("#"+forma).serialize(),
        url       : $("#"+forma).attr("action"),
        type      : 'post',
        dataType  : 'json',
        beforeSend: function () { $("#confirmPaid").html("<img src=\""+$('#baseURL').val()+"style/images/loading.gif\" width='60' height='60'> Procesando el pago, espere por favor..."); },
        success   : function (response) { if(response['error']['desc'] === null)
                                          { var cuota = $("#cuotas  > option:selected").attr('value');
                                            $("#cuotas  > option:selected").attr('value','P').css('text-decoration-line', 'line-through');
                                            $("#cuotas  > option:selected").text(cuota + ' PAGADA');
                                            $("#c"+cuota).html('<i class="fa fa-calendar-times-o" style="font-size:15px;color:red; text-decoration-line: line-through;"> '+$("#cuotas").val()+' </i> Pagada ').css('text-decoration-line', 'line-through');                                            
                                            $("#cuotas  > option:selected").next().attr('selected','selected');
                                            $("#confirmPaid"  ).removeClass("msjconfirmII").addClass("msjOkII" ).html('<i class="fa fa-check msjOkII"> ¡Pago realizado con éxito!</i><br> ' + response['linkRecbioPDF']);
                                            $("input:radio"   ).removeAttr("checked");
                                            $("#lblReferencia").html('');
                                            $("#lblImporte"   ).html('');
                                            $("#lblpena"      ).html('');
                                            $(".cvrField"     ).val ('');
                                            $(".onlyNumber"   ).val ('');                                            
                                            $("#savButtonModal"   ).hide();
                                            $("#cancelarButtonTDC").html("<i class='fa fa-close'> </i> Cerrar");
                                          }
                                          else
                                          { $("#confirmPaid").removeClass("msjconfirmII").addClass("msjErrII").html('<i class="fa fa-warning" style="color:red;"></i> '+response['error']['desc']); }
                                        },
        error     : function(xhr, textStatus, error)
                        { jAlert("Ha ocurrido un error al procesar el pago: " + xhr.statusText + " " + textStatus+" "+error,$('#tituloAlert').val()); 
                         // $("#confirm"+forma).removeClass("msjconfirm").removeClass("msjOk").addClass("msjErr").html("<img src=\""+baseURL+"images/close.png\">Ocurrio un problema al guardar la seccion, intentelo mas tarde");
                        }
       });
}




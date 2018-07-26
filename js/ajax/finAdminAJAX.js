
$("document").ready(function (){ habilitaJS_Webpart("GAS");                                
                                 $("#f_webpart_t1").click(function(){ habilitaJS_Webpart("GAS"); });
                                 $("#f_webpart_t2").click(function(){ habilitaJS_Webpart("PAG"); });
                                 $("#f_webpart_t3").click(function(){ habilitaJS_Webpart("TM" ); });
                                 $("#f_webpart_t4").click(function(){ habilitaJS_Webpart("PTO"); });
                                 $("#f_webpart_t5").click(function(){ habilitaJS_Webpart("EC" ); });
                                 $("#f_webpart_t6").click(function(){ habilitaJS_Webpart("MOR"); });
                               }); //$("document").ready


function habilitaJS_Webpart(tipo)
{
var today    = new Date();
var FirstDay = new Date(today.getFullYear(), today.getMonth()    , 1);
var LastDay  = new Date(today.getFullYear(), today.getMonth() + 1, 0);

switch(tipo){ 
case "GAS": /*********     Formulario Gastos  INI       ***********/
    cargaChartAX("GAS");
    $("#f1"         ).datepicker({dateFormat: 'dd/mm/yy'}).datepicker('setDate', FirstDay);
    $("#f2"         ).datepicker({dateFormat: 'dd/mm/yy'}).datepicker('setDate', LastDay);
    $(".datecvr"    ).change(function(){ $("#lblGastosMes").html("Gastos del "+$("#f1").val()+" al "+$("#f2").val()); });
    $("#savButtGas" ).click (function(){ submitFormFin('gasto-form','gastos', 'gastosTable', 'Gasto', 'Gas'); });        
    $("#fecha_gasto").datepicker({dateFormat: 'dd/mm/yy'}).datepicker('setDate',today);
    $("#gasto_durante_meses").change(function(){ generaCuotasFijasAX(); });
    paginarAX("gastos", "gastosTable", 1, 10);

    if( Number($("#firstTimeGas").val()) === 0 )
     {
      toogleCVR("gastosParam", "togSearchGas");     
      var param = {"tipo"        :"Gasto"
                  ,"allowedTypes":"jpg,png,gif,pdf,xml"
                  ,"url"         :$('#baseURL').val()+"portal/agregaArchivoAX"             
                  ,"urlBorrar"   :$('#baseURL').val()+"portal/borrarArchivoAX"
                  ,"urlRename"   :$('#baseURL').val()+"portal/renombraArchivoAX"             
                  ,"campo"       :"gastoAdjunto"
                  ,"divFile"     :"divGasto"
                 }; 
      subirArchivoCNVR(param);
      $("#firstTimeGas").val(1); 
     }    
 break;      /*********     Formulario Gastos  FIN           ***********/
 case "PAG": /*********     Formulario PAGO CUOTA  INI       ***********/         
    ///despliega deptos        
    if( Number($("#firstTimeDP").val()) === 0 )
    {   $("#secCuotasChart").html('<div id="containerChartCVR_GAS2" style="min-width: 100px; max-width: 400px; height: 125px; margin: 1em auto"></div>');
        $("#edTorres"      ).change(function(){ traeEdificioFinAX($(this).val() ); });
        $("#torres"        ).change(function(){ traeDeptosFinAX  ($(this).val() ); });
        $('#deptosTable > thead > tr').html("<th>#</th><th>Depto</th><th>Cumplimiento</th><th>Status</th><th>Acciones</th>");
        $("#buscarDeptoForm").toggle();
        $("#togSerchDep"    ).click(function(){ var isHidden = $("#buscarDeptoForm").is(":hidden");                                    
                                                if(isHidden) { $("#togSerchDep").removeClass("fa-search-plus" ).addClass("fa-search-minus" ); }
                                                else         { $("#togSerchDep").removeClass("fa-search-minus").addClass("fa-search-plus"); }
                                                $("#buscarDeptoForm").toggle("swing"); 
                                              });
        $("#togSerchDep"    ).addClass("pointer");
        $("#lblDeptoMes"    ).html("Cuotas de Mantenimiento");                
        $(".radioTipoPago"  ).click(function(){ habilitaTipoPago($('input[name=tiposPago]:checked').val()); });
        $(".onlyNumber").keydown(function (e) 
        {        
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 ||             // Allow: backspace, delete, tab, escape, enter and .
                (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || // Allow: Ctrl+A, Command+A        
                (e.keyCode >= 35 && e.keyCode <= 40))                               // Allow: home, end, left, right, down, up   
                    { return null; }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) 
               { e.preventDefault(); }
        });     
        $("#cuotas").change(function(){ traeReferenciaAX($(this).val()); });
        $("#firstTimeDP").val(1);
        cargaChartAX("GAS2");
        traeDeptosFinAX("0");
    }
 break;     /*********     Formulario PAGO CUOTA  FIN       ***********/
 
 case "TM": /*********     Formulario Trabajos Manto  INI   ***********/     
     $("#f1TM"          ).datepicker({dateFormat: 'dd/mm/yy'}).datepicker('setDate', FirstDay);
     $("#f2TM"          ).datepicker({dateFormat: 'dd/mm/yy'}).datepicker('setDate', LastDay);
     $(".datecvrTM"     ).change(function(){ $("#lblTMMes").html("Trabajos de Mantenimiento del "+$("#f1TM").val()+" al "+$("#f2TM").val()); });
     
     $("#type_ant"      ).change(function(){ cambioIconTipoAnticipo(); });
     $(".pp      "      ).change(function(){ calculaAnticipo();        });     
     $("#fecha_inicioTM").datepicker({dateFormat: 'dd/mm/yy'});
     
     if( Number($("#firstTimeTM").val()) === 0 )
     {
        toogleCVR("tbjoMantoParam", "togSearchTM");
        subirArchivoCNVR({"tipo"        :"tbjoMantoA"
                         ,"allowedTypes":"jpg,png,gif"
                         ,"url"         :$('#baseURL').val()+"portal/agregaArchivoAX"             
                         ,"urlBorrar"   :$('#baseURL').val()+"portal/borrarArchivoAX"
                         ,"urlRename"   :$('#baseURL').val()+"portal/renombraArchivoAX"             
                         ,"campo"       :"txtTbjoMantoA"
                         ,"divFile"     :"divtbjoMantoA"
                         } 
                        );     
        subirArchivoCNVR({"tipo"        :"tbjoMantoD"
                         ,"allowedTypes":"jpg,png,gif"
                         ,"url"         :$('#baseURL').val()+"portal/agregaArchivoAX"             
                         ,"urlBorrar"   :$('#baseURL').val()+"portal/borrarArchivoAX"
                         ,"urlRename"   :$('#baseURL').val()+"portal/renombraArchivoAX"             
                         ,"campo"       :"txtTbjoMantoD"
                         ,"divFile"     :"divtbjoMantoD"
                         } 
                        );
        $("#firstTimeTM").val(1);        
     }        
     $("#savButtTM" ).click (function(){ submitFormFin('tbjoMantoForm','tbjoMto', 'tbjoMantoTable', 'Trabajo de Mantenimineto', 'TM'); });
     paginarAX('tbjoMto', 'tbjoMantoTable', 1, 10);     
 break;      /*********     Formulario Trabajos Manto  FIN       ***********/
 
 case "PTO": /*********     Formulario Presupuesto  INI       ***********/        
     var monthIni = 0, yearIni = 0, monthFin = 0, yearFin = 0;
     $(".monthPickerPTO").datepicker({ dateFormat: 'MM yy', changeMonth: true, changeYear: true, showButtonPanel: true,
                                    onClose: function(){ var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                                                         var year  = $("#ui-datepicker-div .ui-datepicker-year  :selected").val();                                                         
                                                         $(this).val($.datepicker.formatDate('MM yy', new Date(year, month, 1)));
                                                         if ( $(this).attr("name") ==="pto_init") 
                                                               { monthIni = month; 
                                                                 yearIni = year; 
                                                                 $("#fecha_ini").val("01/"+getMonthCalendarDatePicker(month)+"/"+year);  
                                                               }
                                                         else  { monthFin = month; 
                                                                 yearFin = year; 
                                                                 var t = new Date(yearFin, getMonthCalendarDatePicker(Number(monthFin)), 0); 
                                                                 $("#fecha_fin").val(t.getDate()+"/"+getMonthCalendarDatePicker(Number(t.getMonth()))+"/"+t.getFullYear());  
                                                               }
                                                       }
                                  });
     $("#genPtoButton").click(function () { generaDivPto(Number(monthIni), yearIni, Number(monthFin), yearFin); });
     $("#canButtonPto").click(function () { $("#ptoForm"     )[0].reset(); 
                                            $("#divPto"      ).html("<br><center><strong>No hay presupuesto seleccionado o generado</strong></center><br>");
                                            $("#statusPto"   ).val(14);
                                            $("#genPtoButton").show();
                                            $("#canButtonPto").hide();
                                            $("#savButtonPto").hide();
                                          });
     $("#savButtonPto").click(function () { submitFormPto(); });
     $("#edificioPto" ).val( $("#id_edificio").val() );  
      if( $("#ptos" ).val() !== "0" )
       { cargaPtoAX($("#ptos").val(), false); }
     $("#ptos"        ).change(function () { cargaPtoAX($(this).val(), false); });
     $("#genPtoButton").show();
     $("#canButtonPto").hide();
     $("#savButtonPto").hide();     
 break;     /*********     Formulario Presupuesto    FIN       ***********/   
 
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
     $("#sendEC"         ).click(function () { /* TO DO FUNCTION*/ });
     $("#sendEC"         ).hide();
 break;  /*********     Formulario Estado Cuenta  FIN       ***********/
 case "MOR": /*********     Formulario MORISIDAD INI       ***********/
    cargaMorososAX( $("#id_edificio").val() );
    $("#printDM").click(function () { printDMAX($("#id_edificio").val()); });
    $("#sendDM" ).click(function () {  sendDMAX($("#id_edificio").val()); });
    cargaChartAX("MOR");
 break;      /*********     Formulario MORISIDAD  FIN       ***********/
}//switch
}//habilitaJS_Webpart

function traeEdificioFinAX(id_edificio)
 {
    if(id_edificio === "0")
    { $("#edTorres"    ).val(0);
      borraOptions("torres");     
    }
    else
    {   var param = {"id_edificio" : id_edificio }; 
        $.ajax({data      : param,
                url       : $('#baseURL').val()+'edificio/traeEdificioAX/',
                type      : 'post',
                dataType  : 'json',
                beforeSend: function ( ){                                },
                success   : function (r){ agregarTorres(r['e'][0]['ID_EDIFICIO'],r['torres']); }, 
                error     : function(xhr, textStatus, error)
                                        { jAlert("Ha ocurrido un error al ingresar al sistema: " + xhr.statusText + " " + textStatus+" "+error,$('#tituloAlert').val()); }
               });    
    }
 } //traeEdificioFinAX
 
 function traeDeptosFinAX(torre)
 {
    if( torre === "0" || torre === "")
    {  $("#deptosTable > tbody").html("<tr><td colspan='5'><center><strong>Favor de seleccionar la Torre</strong></center></td></tr>");  }
    else
    {  paginarAX("deptosCuotas", "deptosTable", 1, 10);        }
 } //traeDeptosFinAX

function cambioIconTipoAnticipo()
{
   if ($("#type_ant").val() === "1"){
        $("#anticipo").prev().addClass("fa-usd").removeClass("fa-percent");
        $("#anticipo").attr("placeholder","Ej. 1000");
      }
  else{
       $("#anticipo").prev().addClass("fa-percent").removeClass("fa-usd");
       $("#anticipo").attr("placeholder","Ej. 50%");
      }
      
  calculaAnticipo();  
  
}


function calculaAnticipo()
{    
     if (isNaN($("#anticipo").val())){ jAlert("El valor ingresado: "+$("#anticipo").val()+" no es valido, solo se permiten números",$('#tituloAlert').val());
                                       $("#anticipo").val(''); 
                                     }
    else{ 
        if (isNaN($("#costo").val())){ jAlert("El valor ingresado: "+$("#costo").val()+" no es valido, solo se permiten números",$('#tituloAlert').val());
                                       $("#costo").val(''); 
                                     }
    else{     
        if (isNaN($("#duracion").val())){ jAlert("El valor ingresado: "+$("#duracion").val()+" no es valido, solo se permiten números",$('#tituloAlert').val());
                                          $("#duracion").val(''); 
                                        }
        else{ var ant       = Number($("#anticipo").val());
              var costo     = Number($("#costo"   ).val());
              var dura      = Number($("#duracion").val());
              var iniT      = $("#fecha_inicioTM").datepicker("getDate");
              var finT      = null;              
              var options   = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
              var fechaIni  = "";
              var fechaComp = "";
              var Pago1     =  0;
              var Pago2     =  0;
              
              if( iniT !== null )
                {  finT    = new Date(iniT);
                   var tmp = new Date(iniT);
                   finT.setDate(finT.getDate() + dura);                
                   fechaIni  = tmp.toLocaleDateString("es-ES", options);
                   fechaComp = finT.toLocaleDateString("es-ES", options);
                   $("#fecha_finTM" ).val(finT.getDate()+"/"+getMonthCalendarDatePicker(finT.getMonth())+"/"+finT.getFullYear() );
                }
                
              Pago1 = ($("#type_ant").val() === "1")? (costo-ant) : (costo*(ant/100));
              Pago2 = costo -  Pago1;
                            
              if( costo !== 0 & dura !== 0)
                {
                 $("#lblPagoAnticipo").html("Comienzo del Trabajo:<br>&nbsp;&nbsp;&nbsp;<strong>"+fechaIni+" </strong><br>1° Pago Anticipo <strong>$ "+$.number(($("#type_ant").val() === "1"?Pago2:Pago1),2, '.', ',' )+"</strong>");
                 $("#lblFecha_fin"   ).html("<br>Fecha compromiso:<br>&nbsp;&nbsp;&nbsp;<strong>"+fechaComp+"</strong><br>2° Pago Liquidación <strong>$ "+$.number(($("#type_ant").val() === "1"?Pago1:Pago2),2, '.', ',' )+"</strong>");
                }
            }
        }
       }
}
                                
function calculaIva(monto, tieneIva)
{
    if (isNaN(monto)){  jAlert("El valor ingresado: "+monto+" no es valido, solo se permiten números",$('#tituloAlert').val());
                        $("#monto").val(''); 
                     }
    else{ var montoN = Number(monto);
          var iva    = Number($('#iva').val())/100;         
          var total  = (tieneIva === true)?(montoN+(montoN*iva)):(montoN);
          $("#lblTotal").html("$ "+$.number(total,2, '.', ',' )  );
          $("#total").val(total);                    
        }
}

function submitFormFin(forma, tipo, tabla, lblTipo, sufijo) 
{   $("#"+forma).validationEngine();	  
    if($("#"+forma).validationEngine('validate'))
      { submitFinAX(forma, tipo, tabla, lblTipo, sufijo); }
}
 

function submitFinAX(forma, tipo, tabla, lblTipo, sufijo)
{
$("#confirm".forma).removeClass("msjErrII").removeClass("msjOkII").removeClass("msjOkIII").addClass("msjconfirmII").html(""); 
$.ajax({data      : $("#"+forma).serialize(),
        url       : $("#"+forma).attr("action"),
        type      : 'post',
        dataType  : 'json',
        beforeSend: function () { $("#confirm"+forma).html("<img src=\""+$('#baseURL').val()+"style/images/loading.gif\" width='60' height='60'> Registrando "+lblTipo+", espere por favor..."); },
        success   : function (response) { $("#confirm"+forma).removeClass("msjconfirmII").addClass("msjOkII" ).html('<i class="fa fa-check msjOkII"> ¡'+lblTipo+' registrado con éxito!</i>');
                                          if(tipo==="tbjoMto") { $("#confirm"+forma).removeClass("msjOkII").addClass("msjOkIII").append('<a href=\''+$('#baseURL').val()+'portal/downloadTbjoManto/'+response['orden_tbjo']+'\' title=\'Orden de Trabajo \'> <img src="'+$('#baseURL').val()+'style/images/logoPDF.png" width="25" height="25"> Orden de Trabajo</a>'); }
                                          
                                          $("#savButt"+sufijo       ).hide();
                                          $("#cancelarButton"+sufijo).html("<i class='fa fa-close'> </i> Cerrar");
                                          paginarAX(tipo, tabla, 1, 10);                                  
                                        },
        error     : function(xhr, textStatus, error)
                        { jAlert("Ha ocurrido un error al registrar el gasto: " + xhr.statusText + " " + textStatus+" "+error,$('#tituloAlert').val()); 
                          $("#confirm"+forma).removeClass("msjconfirmII").removeClass("msjOkII").addClass("msjErr").html("<img src=\""+$('#baseURL').val()+"style/images/close.png\">Ocurrio un problema al guardar la seccion, intentelo mas tarde");
                        }
       });
}


function submitFormPto() 
{   $("#ptoForm").validationEngine();	  
    if($("#ptoForm").validationEngine('validate'))
      { submitFinPtoAX(); }
}
 

function submitFinPtoAX()
{
$("#confirmptoForm").removeClass("msjErrII").removeClass("msjOkII").addClass("msjconfirmII").html(""); 
$.ajax({data      : $("#ptoForm").serialize(),
        url       : $("#ptoForm").attr("action"),
        type      : 'post',
        dataType  : 'json',
        beforeSend: function () { $("#confirmptoForm").html("<img src=\""+$('#baseURL').val()+"style/images/loading.gif\" width='60' height='60'> Registrando Presupuesto, espere por favor..."); },
        success   : function (response) { $("#confirmptoForm").removeClass("msjconfirmII").addClass("msjOkII" ).html('<i class="fa fa-check msjOkII"> ¡Presupuesto registrado con éxito!</i>');
                                          if(response['nuevo']) { $('#ptos').append($('<option>', { value: response['idPto'], text: response['pto'] })); }
                                         
                                        },
        error     : function(xhr, textStatus, error)
                        { jAlert("Ha ocurrido un error al registrar el gasto: " + xhr.statusText + " " + textStatus+" "+error,$('#tituloAlert').val()); 
                          $("#confirmptoForm").removeClass("msjconfirmII").removeClass("msjOkII").addClass("msjErr").html("<i class='fa fa-close'></i> Ocurrio un problema al guardar la seccion, intentelo mas tarde");
                        }
       });
}


function generaCuotasFijasAX()
{if ($("#total").val() !=="" & $("#fecha_gasto").val()!=="")
 {
   $.ajax({ data      : {"fecha_gasto":$("#fecha_gasto").val(), "gasto_cada_dia" : $("#gasto_cada_dia").val(), "gasto_durante_meses": $("#gasto_durante_meses").val(), "total":$("#total").val() },
            url       : $('#baseURL').val()+'finanzas/generaCuotasFijasAX/',
            type      : 'post',
            dataType  : 'json',
            beforeSend: function () { $("#lblCuotasFijas").html("<img src=\""+$('#baseURL').val()+"style/images/loading.gif\" width='40' height='40'> Generando cuotas fijas, espere por favor..."); },
            success   : function (response) { $("#lblCuotasFijas").html(response); },
            error     : function(xhr, textStatus, error)
                        { jAlert("Ha ocurrido un error al generaCuotasFijasAX: " + xhr.statusText + " " + textStatus+" "+error,$('#tituloAlert').val()); }
           });
 }
}


function cargaMorososAX(id_edificio)
 {
    $.ajax({data      : {"id_edificio":id_edificio},
            url       : $('#baseURL').val()+'finanzas/cargaMorososAX/',
            type      : 'post',
            dataType  : 'json',
            beforeSend: function () { $('#divDeptosMorosos').html('');
                                      $('#divCuotasMorosos').html('');
                                      $('#tasasDivMoro'    ).html('');
                                      $("#titCP"  ).html("Cuotas pendientes:");
                                      $('#printDM').show();
                                      $('#sendDM' ).show(); 
                                    },
            success   : function (response){ var deptosMorosos = "<ul>";
                                             for (var x = 0; x < response['dm'].length ; x++)
                                                 { deptosMorosos += '<li class="deptoMoro pointer" id_edificio='+id_edificio+' torre='+response['dm'][x]['TORRE']+' id_depto='+response['dm'][x]['ID_DEPTO']+' num='+response['dm'][x]['DEPTO']+'><i class="fa fa-home">'+empty(response['dm'][x]['TORRE'])+' '+response['dm'][x]['DEPTO']+'</i> <i class="fa fa-long-arrow-right"></i></li>'; }
                                             deptosMorosos += "</ul>";                                            
                                             $('#divDeptosMorosos').html (deptosMorosos);
                                             $('#divCuotasMorosos').html ('Click en el depto para más detalle');
                                             $('#tasasDivMoro'    ).html ('<br><i class="fa fa-certificate"> Tasa de Morosidad '+$.number(response['tm']['TASA'],2, '.', ',' )+' % ( '+response['tm']['TOT_PAGADAS']+' de '+response['tm']['TOT_TASA']+' deptos)</i><br>&nbsp;');
                                             $(".deptoMoro"       ).click(function () { cargaDeptoMorosoAX(id_edificio, $(this).attr('torre'), $(this).attr('id_depto'), $(this).attr('num')); });
                                             $('#tasaMoroField'   ).val  (response['tm']['TASA']);
                                           }, 
            error     : function (xhr, textStatus, error)
                                 { jAlert("Ha ocurrido un error al ingresar al sistema: " + xhr.statusText + " " + textStatus+" "+error,$('#tituloAlert').val()); }
           });    
 } //cargaMorososAX
 
 
 function cargaDeptoMorosoAX(id_edificio, torre, depto, num)
 { 
    $.ajax({data      : {"id_edificio":id_edificio, "torre":torre, "id_depto":depto},
            url       : $('#baseURL').val()+'finanzas/cargaDeptoMorosoAX/',
            type      : 'post',
            dataType  : 'json',
            beforeSend: function () { $('#divCuotasMorosos').html("<img src=\""+$('#baseURL').val()+"style/images/loading.gif\" width='60' height='60'>Consultando información...");
                                      $('#tasasDivMoro'    ).html('');
                                      $("#titCP"  ).html("Cuotas pendientes:");
                                      $('#printDM').show();
                                      $('#sendDM' ).show(); 
                                    },
            success   : function (response){ $("#titCP").html("Cuotas pendientes del depto <u>"+empty(torre)+" "+num+"</u>:");
                                             var cuotasMorosos = "<ul>";
                                             for (var x = 0; x < response['dm'].length ; x++)
                                                 { cuotasMorosos += '<li><i class="fa fa-calendar-times-o"></i><i class="fa fa-usd"></i> '+response['dm'][x]['CUOTA_PENDIENTE']+'</i><li>'; }
                                             cuotasMorosos += "</ul>";
                                             $('#divCuotasMorosos').html(cuotasMorosos);
                                             $('#tasasDivMoro'    ).html ('<br><i class="fa fa-certificate"> Tasa de Morosidad del depto <u>'+empty(torre)+' '+num+'</u>:<br> '+$.number(response['tm']['TASA'],2, '.', ',' )+' % ( '+response['tm']['TOT_PAGADAS']+' de '+response['tm']['TOT_TASA']+' cuotas de manto. )</i><br>&nbsp;');
                                           }, 
            error     : function (xhr, textStatus, error)
                                 { jAlert("Ha ocurrido un error al ingresar al sistema: " + xhr.statusText + " " + textStatus+" "+error,$('#tituloAlert').val()); }
           });    
 } //cargaMorososAX


function printDMAX(id_edificio)
{
    $.ajax({data      : {"id_edificio":id_edificio},
            url       : $('#baseURL').val()+'finanzas/printDMAX/',
            type      : 'post',
            dataType  : 'json',
            beforeSend: function () { $('#divActionMorosos').html("<img src=\""+$('#baseURL').val()+"style/images/loading.gif\" width='60' height='60'>Generando Aviso..."); },
            success   : function (r){ $('#divActionMorosos').html('<br><br><br><br><a  href=\''+$('#baseURL').val()+'portal/downloadTbjoManto/'+r+'\' title=\'Aviso Morosidad \'> <img src="'+$('#baseURL').val()+'style/images/logoPDF.png" width="25" height="25"> Aviso Morosidad</a>'); }, 
            error     : function (xhr, textStatus, error)
                                 { jAlert("Ha ocurrido un error al ingresar al sistema: " + xhr.statusText + " " + textStatus+" "+error,$('#tituloAlert').val()); }
           });    
} //printDMAX


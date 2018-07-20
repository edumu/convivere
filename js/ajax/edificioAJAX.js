
$("document").ready(function ()
{ 
    habilitaJS_Webpart("HM");
    $("#f_webpart_t1").click(function(){  habilitaJS_Webpart("HM");  });
    $("#f_webpart_t2").click(function(){  habilitaJS_Webpart("DP");  });
    $("#f_webpart_t3").click(function(){  habilitaJS_Webpart("AM");  });
    $("#f_webpart_t4").click(function(){  habilitaJS_Webpart("AB");  });
    $("#f_webpart_t5").click(function(){  habilitaJS_Webpart("RV");  });
    $("#f_webpart_t6").click(function(){  habilitaJS_Webpart("TM");  });
    $("#f_webpart_t7").click(function(){  habilitaJS_Webpart("VT");  });
    $("#f_webpart_t8").click(function(){  habilitaJS_Webpart("IA");  });
}); //$("document").ready


function habilitaJS_Webpart(tipo)
{
var today    = new Date();
var FirstDay = new Date(today.getFullYear(), today.getMonth()    , 1);
var LastDay  = new Date(today.getFullYear(), today.getMonth() + 1, 0);

switch(tipo){ 
case "HM": /*********     Formulario HOME INI       ***********/    
    if( Number($("#firstTimeHM").val()) === 0 )
    {
        $("#edificioForm").toggle();
        $("#nombre"      ).datepicker();
        $(".newEdificio" ).addClass("pointer");
        $(".newEdificio" ).click(function(){ limpiaForma(true); });
        $("#tiene_ame"   ).click(function(){ tieneAmenidades( $(this).prop('checked') ) }); 
        $("#coordenadas" ).toggle();
        $("#tgC"         ).click(function(){ $("#coordenadas").toggle("swing"); });
        $("#tgC"         ).addClass("pointer");
        var param = {"tipo"        :"Logo"
                    ,"allowedTypes":"jpg,png,gif"
                    ,"url"         :$('#baseURL').val()+"portal/agregaArchivoAX"             
                    ,"urlBorrar"   :$('#baseURL').val()+"portal/borrarArchivoAX"
                    ,"urlRename"   :$('#baseURL').val()+"portal/renombraArchivoAX"             
                    ,"campo"       :"logoEdificio"
                    ,"divFile"     :"divLogo"
                    }; 
        subirArchivoCNVR(param);
        $("#firstTimeHM").val(1); 
    }
    $("#edificio"         ).change(function(){ traeEdificioAX($(this).val()); });
    $("#num_torres"       ).change(function(){ numTorres($(this).val()         ,$("#num_viviendas").val(),$("#cuota_manto").val());});
    $("#num_viviendas"    ).change(function(){ totCuotas($("#num_torres").val(),$(this).val()            ,$("#cuota_manto").val());});
    $("#cuota_manto"      ).change(function(){ totCuotas($("#num_torres").val(),$("#num_viviendas").val(),$(this).val());});
    $("#tipo_penalizacion").change(function(){ cambioIconTipoPenal(); });

    $("#savButton").click(function(){ submitForm('edificioForm'); });
    $("#canButton").click(function(){ limpiaForma(false); });
    
 break;     /*********     Formulario HOME FIN       ***********/
 
 case "DP": /*********     Formulario Departamentos INI       ***********/     
    $("#edTorres").change(function(){ traeEdificioAX( $(this).val()); });
    $("#torres"  ).change(function(){ traeDeptosAX  ( $(this).val()); });    
    if( Number($("#firstTimeDP").val()) === 0 )
    {
        $("#buscarDeptoForm").toggle();
        $("#togSerchDep"    ).click(function(){ var isHidden = $("#buscarDeptoForm").is(":hidden");                                    
                                                if(isHidden) { $("#togSerchDep").removeClass("fa-search-plus" ).addClass("fa-search-minus" ); 
                                                               $("#detalleDepto").show();
                                                               $("#footerDetalleDepto").show();
                                                             }
                                                else         { $("#togSerchDep").removeClass("fa-search-minus").addClass("fa-search-plus"); 
                                                               $("#detalleDepto").hide(); 
                                                               $("#footerDetalleDepto").hide();
                                                             }
                                                $("#buscarDeptoForm").toggle("swing"); 
                                              });
        $("#togSerchDep"    ).addClass("pointer");
        
        habilitaMODAL("deptos");
        $("#firstTimeDP").val(1);
     }    
 break;     /*********     Formulario Departamentos FIN       ***********/
 
 case "AM": /*********     Formulario Amenidades INI       ***********/     
    

 break;    /*********     Formulario Amenidades FIN       ***********/
 
 case "AB":/*********     Formulario Asambleas INI       ***********/
    var initialLocaleCode = 'es';
    var today    = new Date();
    $('#errorAB' ).hide();
    $('#calendar').fullCalendar({
      header	   : { left  : 'prev,next today', center: 'title', right : 'month, agendaWeek, agendaDay, listMonth' }
      ,defaultDate : today
      ,locale	   : initialLocaleCode
      ,height      : 'auto'
      ,buttonIcons : true       
      ,navLinks    : true
      ,selectable  : true
      ,selectHelper: true
      ,editable    : true
      ,eventLimit  : true
      ,nowIndicator: true
      ,weekNumbers : false
      ,select      : function(start, end) 
      { var eventData;        
        jPrompt('Event Title:', 'Asamblea '+start, $('#tituloAlert').val(), function(title) 
        {   if (title) { eventData  = { title: title, start: start, end: end       };
                         $('#calendar').fullCalendar('renderEvent', eventData, true); 
                       }
        });        
        $('#calendar').fullCalendar('unselect');
      }
      ,events: {  url    : $('#baseURL').val()+'edificio/traeAsambleasAX/'+$("#id_edificio").val()
                 ,success: function(r) { $('#calendar').fullCalendar('renderEvent', r, true); }
                 ,error  : function( ) { $('#errorAB').show();  $("#calendar").hide(); }
               },
      loading: function(bool) { $('#loadingAB').toggle(bool); }
      /*
      ,events: [ { title: 'All Day Event', start: '2018-06-01' }
                ,{ title: 'Long Event'   , start: '2018-06-07', end: '2018-06-10'}
                ,{ id: 999, title: 'Repeating Event', start: '2018-06-09T16:00:00'}
                ,{ id: 999, title: 'Repeating Event', start: '2018-06-16T16:00:00' }
                ,{ title: 'Conference', start: '2018-06-11', end: '2018-06-13' }
                ,{ title: 'Meeting', start: '2018-06-12T10:30:00', end: '2018-06-12T12:30:00' }
                ,{ title: 'Lunch', start: '2018-06-12T12:00:00' }
                ,{ title: 'Meeting', start: '2018-06-12T14:30:00' }
                ,{ title: 'Happy Hour', start: '2018-06-12T17:30:00' }
                ,{ title: 'Dinner', start: '2018-06-12T20:00:00' }
                ,{ title: 'Birthday Party', start: '2018-03-13T07:00:00' }
                ,{ title: 'Click for Google', url: 'http://google.com/', start: '2018-06-28'}
             ]
      */          
    }); 
    if( Number($("#firstTimeAB").val()) === 0 )
    {
        $("#calendarAB"   ).toggle();
        $("#togCalendarAB").click(function(){ var isHidden = $("#calendarAB").is(":hidden");                                    
                                              if(isHidden) { $("#togCalendarAB").removeClass("fa-calendar-minus-o").addClass("fa-calendar-plus-o");  }
                                              else         { $("#togCalendarAB").removeClass("fa-calendar-plus-o ").addClass("fa-calendar-minus-o"); }                                            
                                              $("#calendarAB").toggle("swing"); 
                                            });
        $("#togCalendarAB").addClass("pointer");            
        $("#firstTimeAB"  ).val(1);
     }   
 break;     /*********     Formulario Asambleas FIN       ***********/
 
 case "RV": /*********     Formulario Reservaciones INI       ***********/ 
    
    
 break;     /*********     Formulario Reservaciones FIN       ***********/
 
 case "TM": /*********     Formulario Trabajos Manto  INI       ***********/
      cargaChartAX("TM");
         
 break;     /*********     Formulario Trabajos Manto  FIN       ***********/
 
 case "VT": /*********     Formulario Votaciones  INI       ***********/        
          
 break;     /*********     Formulario Votaciones  FIN      ***********/   
 case "IA": /*********     Formulario Inventario Activos  INI       ***********/
     
    
     
 break;     /*********     Formulario Inventario Activos  FIN       ***********/
}//switch
}//habilitaJS_Webpart




function submitForm(forma) 
{   $("#"+forma).validationEngine();	  
    if($("#"+forma).validationEngine('validate'))
      { submitEdificioAX($('#baseURL').val(),forma,$('#tituloAlert').val()); }
}


function submitEdificioAX(baseURL,forma,tituloAlert)
{
    $("#confirm"+forma).removeClass("msjOk").removeClass("msjErr").addClass("msjconfirm").html("").show(); 
    $.ajax({data      : $("#"+forma).serialize(),
            url       : $("#"+forma).attr("action"),
            type      : 'post',
            dataType  : 'json',
            beforeSend: function () { $("#confirm"+forma).removeClass("msjOk").addClass("msjconfirm");
                                      $("#confirm"+forma).html("<img src=\""+baseURL+"style/images/spin.png\"> Guardando la información, espere por favor...");
                                    },
            success   : function () { $("#confirm"+forma).removeClass("msjconfirm").addClass("msjOk");
                                      $("#confirm"+forma).html("<img src=\""+baseURL+"style/images/check.png\">Información del edificio guardada éxitosamente!");                                     
                                    }, 
            error     : function(xhr, textStatus, error)
                            { jAlert("Ha ocurrido un error al ingresar al sistema: " + xhr.statusText + " " + textStatus+" "+error,tituloAlert); 
                              $("#confirm"+forma).removeClass("msjconfirm").removeClass("msjOk").addClass("msjErr").html("<img src=\""+baseURL+"images/close.png\">Ocurrio un problema al guardar la seccion, intentelo mas tarde");
                            }
           });    
}

function limpiaForma(nuevoEdi)
{
    $("#edificioForm")[0].reset(); 
    $("#divTorres"   ).html("");
    $("#totalDeptos" ).html("");
    $("#totalCuotas" ).html("");
    $("#edificio"    ).val("0");
    $("#id_edificio" ).val(0);
    $("#logoEdificio").attr("src",$('#baseURL').val()+"logo_edificios/LogoConvivere.jpg");
    $("#penalizacion").prev().addClass("fa-gavel").removeClass("fa-percent").removeClass("fa-usd");
    $("#edTorres"    ).val(0);
    borraOptions("torres");
    if (nuevoEdi)
        { muestraForma("edificioForm"); 
          $('#deptosTable > tbody').html('');
        }
    else
        { $("#edificioForm").toggle(); }
}
 
 function muestraForma(forma)
 {
    var isHidden = $("#"+forma).is(":hidden");
    if(isHidden)
        { $("#"+forma).toggle(); }
 }
 
 function traeEdificioAX(id_edificio)
 {
    if(id_edificio === "0")
    { $("#edTorres"    ).val(0);
      borraOptions("torres");
      limpiaForma(false);
    }
    else
    {   var param = {"id_edificio" : id_edificio }; 
        $.ajax({data      : param,
                url       : $('#baseURL').val()+'edificio/traeEdificioAX/',
                type      : 'post',
                dataType  : 'json',
                beforeSend: function ()        { $("#confirmEdiAX").html("<img src=\""+$('#baseURL').val()+"style/images/spin.png\"> Consultando información, espere por favor...");  },
                success   : function (response){ $("#confirmEdiAX").html("");
                                       $("#logoEdImg").attr("src",$('#baseURL').val()+response['dir']+response['e'][0]['ID_EDIFICIO']+"/"+response['e'][0]['LOGOTIPO']);
                                       $("#logoEdificio"     ).val(response['e'][0]['LOGOTIPO']);
                                       $("#id_edificio"      ).val(response['e'][0]['ID_EDIFICIO']);
                                       $("#nombre"           ).val(response['e'][0]['NOMBRE']);
                                       $("#calle"            ).val(response['e'][0]['CALLE']);
                                       $("#numero"           ).val(response['e'][0]['NUMERO']);
                                       $("#colonia"          ).val(response['e'][0]['COLONIA']);
                                       $("#alcaldia"         ).val(response['e'][0]['ALCALDIA']);
                                       $("#estado"           ).val(response['e'][0]['ESTADO']);
                                       $("#cp"               ).val(response['e'][0]['CP']);
                                       $("#latitud"          ).val(response['e'][0]['LATITUD']);
                                       $("#longitud"         ).val(response['e'][0]['LONGITUD']);
                                       $("#cuota_manto"      ).val(response['e'][0]['CUOTA_MANTO']);
                                       $("#dia_corte"        ).val(response['e'][0]['DIA_CORTE']);
                                       $("#tipo_penalizacion").val(response['e'][0]['TIPO_PENALIZACION']);
                                       $("#penalizacion"     ).val(response['e'][0]['PENALIZACION']);
                                       $("#num_torres"       ).val(response['e'][0]['NUM_TORRES']);
                                       $("#num_viviendas"    ).val(response['e'][0]['NUM_VIVIENDAS']);
                                       var ame = (response['e'][0]['TIENE_AMENIDADES']== 0 ? false : true);
                                       $("#tiene_ame").attr('checked',ame);
                                       
                                       tieneAmenidades(ame);
                                       cambioIconTipoPenal();
                                       llenaDivTorres(response['t']);
                                       totCuotas($("#num_torres").val(), $("#num_viviendas").val(), $("#cuota_manto" ).val());                                       
                                       agregarTorres(response['e'][0]['ID_EDIFICIO'],response['torres']);
                                       $("#edificio").val(id_edificio);
                                       muestraForma("edificioForm");
                                     }, 
                error     : function(xhr, textStatus, error)
                                    { jAlert("Ha ocurrido un error al ingresar al sistema: " + xhr.statusText + " " + textStatus+" "+error,$('#tituloAlert').val()); }
               });    
    }
 } //traeEdificioAX

                            
function tieneAmenidades(ame)
{
    if(ame)        
    { $('#lblAme'      ).html('El edificio SI tiene amenidades');
      $('#f_webpart_t3').show();
      $('#tiene_ame'   ).val("1");
    }
    else
    { $('#lblAme'      ).html('El edificio NO tiene amenidades');
      $('#f_webpart_t3').hide();
      $('#tiene_ame'   ).val("0");
    }
}

function traeDeptosAX(torre)
 {
    if( torre === "0" || torre === "")
    {  $("#torresForm").html("<thead ><tr class='negritas'><th>Torre</th><th>Numeración</th><th>Dueño</th></tr></thead><tbody></tbody>");  }
    else
    {  paginarAX("deptos", "deptosTable", 1, 10);        }
 } //traeDeptosAX

function llenaDivTorres(torres)
{
    for(var i=0;i<torres.length;i++)
        {$("#divTorres").append(torres[i]); }
}

function cambioIconTipoPenal()
{
    $("#tipo_penalizacion").val()==="1"?$("#penalizacion").prev().addClass("fa-usd").removeClass("fa-gavel").removeClass("fa-percent"):$("#penalizacion").prev().addClass("fa-percent").removeClass("fa-gavel").removeClass("fa-usd");
}

function numTorres(torres,deptos,cuota)
{
    $("#divTorres").html("");
    $.ajax({data      : {"num_torres" : torres },
            url       : $('#baseURL').val()+'edificio/creaTorresAX/',
            type      : 'post',
            dataType  : 'json',
            beforeSend: function () {  $("#divTorres").html("<img src=\""+$('#baseURL').val()+"style/images/spin.png\"> Generando torres, espere por favor...");  },
            success   : function (response) {
                                $("#divTorres").html("");
                                llenaDivTorres(response);
                               }, 
            error     : function(xhr, textStatus, error)
                            { jAlert("Ha ocurrido un error al ingresar al sistema: " + xhr.statusText + " " + textStatus+" "+error,$('#tituloAlert').val()); }
           });  
    totCuotas(torres,deptos,cuota);
} //numTorres


function totDeptos(torres,deptos)
{   var tot = 0;
    if( isNaN(torres) === false & isNaN(deptos) === false)
     {
         var tot = Number(torres) * Number(deptos);         
         $("#totalDeptos").html(tot);         
     }
     else
     {   $("#totalDeptos").html(""); }
    return tot;
} //totDeptos


function totCuotas(torres,deptos,cuota)
{ 
    var totalDeptos = 0;
    var totalCuotas = 0;
    if( isNaN(cuota) === false )
     {
        totalDeptos = totDeptos(torres,deptos);
        totalCuotas =  Number(cuota) * totalDeptos;        
        $("#totalCuotas"  ).html("$"+$.number(totalCuotas,  0, '.', ',' ) );
     }
     else
     {  totDeptos(torres,deptos);
        $("#totalCuotas").html("-"); }
    return totalCuotas;
}


function submitFormUsrDepto(forma) 
{   $("#"+forma).validationEngine();	  
    if($("#"+forma).validationEngine('validate'))
      { submitUsrDeptoAX($('#baseURL').val(),forma,$('#tituloAlert').val()); }
}


function submitUsrDeptoAX(baseURL,forma,tituloAlert)
{
    $("#confirm"+forma).removeClass("msjOk").removeClass("msjErr").addClass("msjconfirm").html("").show(); 
    $.ajax({data      : $("#"+forma).serialize(),
            url       : $("#"+forma).attr("action"),
            type      : 'post',
            dataType  : 'json',
            beforeSend: function () { $("#confirm"+forma).removeClass("msjOk").addClass("msjconfirm");
                                      $("#confirm"+forma).html("<img src=\""+baseURL+"style/images/spin.png\"> Guardando la información, espere por favor...");
                                    },
            success   : function (response) 
                        { $("#confirm"+forma).removeClass("msjconfirm").addClass("msjOk");
                        $("#confirm"+forma).html("<img src=\""+baseURL+"style/images/check.png\">Información guardada éxitosamente!");

                        var select = $('#usuarios');
                        if(select.prop) { var options = select.prop('options');  }
                        else            { var options = select.attr('options');  }
                        options[options.length] = new Option(response['NOMBRE']+" "+response['APELLIDOS'],response['CUENTA']);
                        select.val(response['CUENTA']);
                        cancelarFormUsrDepto();
                        }, 
            error     : function(xhr, textStatus, error)
                        { jAlert("Ha ocurrido un error al ingresar al sistema: " + xhr.statusText + " " + textStatus+" "+error,tituloAlert); 
                          $("#confirm"+forma).removeClass("msjconfirm").removeClass("msjOk").addClass("msjErr").html("<img src=\""+baseURL+"images/close.png\">Ocurrio un problema al guardar la seccion, intentelo mas tarde");
                        }
           });    
}


function guardarDetalleDeptoAX()
{
$.ajax({data      : {"torre"       :  $('#hf_torre').val() 
                    ,"id_depto"    :  $('#hf_id_depto').val() 
                    ,"id_edificio" :  $('#hf_id_edificio').val()
                    ,"usuario"     :  $('#usuarios').val()
                    ,"tipoDueno"   :  $('#tipoDueno').val()                    
                    },
        url       : $('#baseURL').val()+'edificio/detalleDeptoAX/',
        type      : 'post',
        dataType  : 'json',
        beforeSend: function (        ) { },
        success   : function (response) { traeDeptosAX( $('#hf_torre').val() );
                                          $("#savButtonModalDU"   ).hide();
                                          $("#canButtonModalDU"   ).html("<i class='fa fa-close'> </i> Cerrar");
                                          $("#confirmDetalleDepto").addClass("msjOkII").html('<i class="fa fa-check msjOkII"> ¡Información guardada éxitosamente!</i>');
                                         //CERRAR AUTOMATICAMENTE MODAL$(".modalColorbox").colorbox.close();
                                        }, 
        error     : function(xhr, textStatus, error)
                    { jAlert("Ha ocurrido un error al ingresar al sistema: " + xhr.statusText + " " + textStatus+" "+error,$('#tituloAlert').val()); }
       });    
}
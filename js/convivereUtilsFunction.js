/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function isEmpty(e) {
                    switch(e) {
                        case "":
                        case "null":
                        case "0":
                        case 0:
                        case null:
                        case false:
                        case undefined:
                        case "undefined":
                        case typeof this === "undefined":
                        case typeof e === "undefined":
                            return true;
                        default : return false;
                    }
                }

function empty(e) {
            switch(e) {
                case "":                 
                case null:
                case false:
                case typeof this === "undefined":
                    return "";
                        default : return e;
            }
        }
        
function validaSesionAX(response)
{
    if ('session' in response) 
        {
            jAlert(response['msj'],$('#tituloAlert').val(), function (ans) { window.location.href = $('#baseURL').val(); });
            return false;
        }
}

function subirArchivoCNVR(param)
{
var settings = {url	     : param['url'],
                dragDrop     : true,
                fileName     : "myfile",
                allowedTypes : param['allowedTypes'],
                returnType   : "json",
                showDelete   : true,                
                onSuccess    : function(files,data,xhr)
                { $(".ajax-file-upload-green").html("Guardar " +param['tipo']);
                  $(".ajax-file-upload-red"  ).html("Cancelar "+param['tipo']);

                  $(".ajax-file-upload-green").attr( "id", "btnGuardarImagen"+param['tipo']);	  
                  $("#btnGuardarImagen"+param['tipo']).click(function(){ $("#status"+param['tipo']).html("<div><img src=\""+$('#baseURL').val()+"style/images/loading.gif\" width='60' height='60'> Cargando archivo...</div>");                                                                 
                                                                 renombrarArchivoCNVRAX(param, data); 
                                                               });
                },               
                deleteCallback: function(data,pd)
                {  for(var i=0;i<data.length;i++)
                    {   $.post(param['urlBorrar'],{op:"delete",name:data[i]},
                        function(resp, textStatus, jqXHR)
                                { $("#status"+param['tipo']).html("<div>Archivo cancelado</div>"); });
                    }      
                    pd.statusbar.hide(); //You choice to hide/not.
                }
               };
	
$("#subirArchivoCNVR"+param['tipo']).uploadFile(settings);
$("#subirArchivoCNVR"+param['tipo']).addClass('pointer');
}

function renombrarArchivoCNVRAX(param,nombreArchivo)		
{
    var nombreArchivoStr = String(nombreArchivo);
    var extensionStr	 = String(nombreArchivo);
    var len 		 = nombreArchivoStr.length;
    var len_ext 	 = len-3;     
    
    var paramRN = null;
    switch (param['tipo'])
    {
        case "tbjoMantoA":
        case "tbjoMantoD":
        case "Logo":
        case "Doc" : paramRN = {"nombreArchivo" : nombreArchivoStr.substring(0, len_ext-1),
                                "extension"	: extensionStr.substring(len_ext,len),
                                "tipo"          : param['tipo'],
                                "id_edificio"   : $('#id_edificio').val()
                               };
        break;
        case "Gasto": paramRN = {"nombreArchivo" : nombreArchivoStr.substring(0, len_ext-1),
                                  "extension"	 : extensionStr.substring(len_ext,len),
                                  "tipo"         : param['tipo'],
                                  "id_edificio"  : $('#id_edificio').val(),
                                  "tiene_iva"    : $('#tiene_iva'  ).attr('checked'),
                                  "id_gasto"     : $('#id_gasto'   ).val()
                                 };
        break;    
    }
    $.ajax({data    : paramRN,               
            url     : param['urlRename'],
            type    : 'post',
            dataType: 'json',
            beforeSend: function () {  }, 
            success : function (response) 
                    {   validaSesionAX(response);
                    
                        $("#status"+param['tipo']).html("");                                                                                               
                        var	iconFile       = '';
                        var	leyendaArchivo = '';
                        switch (param['tipo'])
                        {
                            case "Logo":
                                    iconFile="<img class=\"img-circle centerDiv\" id=\"logoEdImg\" width=\"75\" heigth=\"55\" src=\""+$('#baseURL').val()+response['pathFile']+"\"><br><br>"
                                     +"<img class=\"fileUp centerDiv\" title=\"Borrar Logotipo\" name='"+response['extension']+"'" 
                                     +" id=\""+response['file']+"\" src=\""+$('#baseURL').val()+"style/images/close.png\"><br>";
                                    leyendaArchivo = 'Logotipo';
                            break;
                            case "Gasto":
                                    iconFile="<img class=\"img-circle centerDiv\" id=\"gastoCom\" width=\"100\" heigth=\"100\" src=\""+$('#baseURL').val()+response['pathFile']+"\"><br>"
                                     +"<img class=\"fileUp centerDiv\" title=\"Borrar evidencia gasto\" name='"+response['extension']+"'" 
                                     +" id=\""+response['file']+"\" src=\""+$('#baseURL').val()+"style/images/close.png\">";
                                    leyendaArchivo = 'Gasto';
                                    $('#id_gasto').val(response['idGasto']);
                            break;
                            case "tbjoMantoA":
                                    iconFile="<img class=\"img-circle centerDiv\" id=\"tbjoMantoACom\" width=\"100\" heigth=\"100\" src=\""+$('#baseURL').val()+response['pathFile']+"\"><br>"
                                     +"<img class=\"fileUp centerDiv\" title=\"Borrar evidencia del trabajo\" name='"+response['extension']+"'" 
                                     +" id=\""+response['file']+"\" src=\""+$('#baseURL').val()+"style/images/close.png\">";
                                    leyendaArchivo = 'Evidencia Antes';                                    
                            break;
                            case "tbjoMantoD":
                                    iconFile="<img class=\"img-circle centerDiv\" id=\"tbjoMantoDCom\" width=\"100\" heigth=\"100\" src=\""+$('#baseURL').val()+response['pathFile']+"\"><br>"
                                     +"<img class=\"fileUp centerDiv\" title=\"Borrar evidencia del trabajo\" name='"+response['extension']+"'" 
                                     +" id=\""+response['file']+"\" src=\""+$('#baseURL').val()+"style/images/close.png\">";
                                    leyendaArchivo = 'Evidencia Después';                                    
                            break;
                            case "Doc":
                            break;
                        }

                        $('#'+param['divFile']).html(iconFile);
                        $('#'+param['campo']  ).val(response['file'] +"."+ response['extension']);

                        $('.fileUp').addClass('pointer');
                        $('.fileUp').click(function() { var img = $(this);
                                                      jConfirm("¿Borrar "+leyendaArchivo+"?",$('#tituloAlert').val(), function(r) {
                                                                       if(r) { borrarArchivoCNVRAX(param,img);  }
                                                            });
                                                     });		
                    }, 
            error: function(err){ jAlert("Ha ocurrido un error al renombrarArchivoCNVRAX: " + err.status + " " + err.statusText,$('#tituloAlert').val()); }
    });			
}


function borrarArchivoCNVRAX(param,objectImagen)
{    	        	        
var paramDL = null;
switch (param['tipo'])
{
    case "Logo":
    case "Doc" : paramDL = {"nombreArchivo" : $(objectImagen).attr('id'),
                            "extension"     : $(objectImagen).attr('name'),
                            "tipo"          : param['tipo'],
                            "id_edificio"   : $('#id_edificio').val()
                           };
    break;
    case "Gasto":  paramDL = {"nombreArchivo" : $(objectImagen).attr('id'),
                              "extension"     : $(objectImagen).attr('name'),
                              "tipo"          : param['tipo'],
                              "id_edificio"   : $('#id_edificio').val(),
                              "id_gasto"      : $('#id_gasto'   ).val()
                             };
    break;    
}
$.ajax({data	: paramDL,               
        url     : param['urlBorrar'],
        type	: 'post',
        dataType: 'json',
        success : function (response)  
                    {   validaSesionAX(response);

                        $('#'+param['divFile']).html('');
                        var	iconFile = '';

                        switch (param['tipo'])
                        {
                            case "Logo":
                                iconFile = "<img class=\"img-circle centerDiv\" id=\"logoEdImg\"  width=\"75\" heigth=\"55\" src=\""+$('#baseURL').val()+response['dir']+"/"+response['fileDefault']+" \">";
                            break;
                            case "Gasto":
                                iconFile = "";                                
                            break;
                            case "Doc":
                            break;
                        }

                        $('#'+param['divFile']).html(iconFile);
                        $('#'+param['campo']  ).val(response['fileDefault']);

                    }, 
        error   : function(err)
                        { jAlert("Ha ocurrido un error borrarArchivoCNVRAX: " + err.status + " " + err.statusText,$('#tituloAlert').val()); }
});			
}

function generarPDFAX(baseURL,typePDF)		
{
    //var paramInput = {"id_coti" : id_coti,"id_pedido" : $("#id_pedido").val() };
    //var paramInput = $('#coti').serialize();
    
    $.ajax({
    url       : baseURL+'convivere/generarPDFAX/',
    type      : 'post',
    data      : typePDF,
    dataType  : 'json',
    beforeSend: function () 
              { $("#generaPDF").html("<img src=\""+baseURL+"style/images/spin.png\"> Generando Archivo, espere por favor...");},
    success:  function (response) 
                    {
                    var	iconF="<a href=\""+baseURL+"cotizador/download/"+response['filename']+ "\" target=\"_blank\">"
                                      +"<img title=\"Ver Cotización generada con nombre "+response['filename']+"\" "
                                      +"  src=\""+baseURL+"style/images/logoPDF.png\" width='40px' height='40px'></a><br><br>"
                                      +"&nbsp;&nbsp;&nbsp;&nbsp;<img class=\"boton_confirm\" title=\"Borrar Archivo\""
                                      +" id=\""+response['cotizacion']+"\" src=\""+baseURL+"style/images/erase.png\">";

                    $("#generaPDF").html(iconF);                    
    }, 
                    error: function(err)
                    { alert("Ha ocurrido un error al genera Cotizacion PDF: " + err.status + " " + err.statusText); }
    });	
}

function borraOptions(idJquery)
{
    var select = $('#'+idJquery);    
    $('option', select).remove();
}

function paramPaginarAX(tipo, currentPage)
{ 
var param  = null;
var numCol = 0;

 switch(tipo){
  case "deptosCuotas":
    param = {"pagina"     : currentPage,
             "f1"         : $("#f1Depto").val(),
             "f2"         : null,
             "f3"         : null,
             "tipo"       : tipo,
             "torre"      : $("#torres").val(),
             "id_edificio": $("#edTorres").val()
            };
    numCol = 5;
  break;
  case "deptos":
    param = {"pagina" : currentPage,
             "f1"     : $("#f1Depto").val(),
             "f2"     : null,
             "f3"     : null,
             "tipo"   : tipo,
             "torre"  : $("#torres").val(),
             "id_edificio": $("#edTorres").val()
            };
    numCol = 3;
  break;
  case "cuotas":                 
    param = {"pagina"  : currentPage,
             "f1"      : null,
             "f2"      : null,
             "f3"      : null,
             "tipo"    : tipo,
             "edificio": $("#edificioGridCuotas").val(),
             "torre"   : $("#torreGridCuotas"   ).val(),
             "depto"   : $("#deptoGridCuotas"   ).val()
            };
    numCol = 7;       
  break;
  case "gastos":                 
    param = {"pagina" : currentPage,
             "f1"     : $("#f1").val(),
             "f2"     : $("#f2").val(),
             "f3"     : null,
             "tipo"   : tipo                 
            };   
     numCol = 7;          
  break;
  case "tbjoMto":                 
    param = {"pagina" : currentPage,
             "f1"     : $("#f1TM").val(),
             "f2"     : $("#f2TM").val(),
             "f3"     : null,
             "tipo"   : tipo                 
            };   
    numCol = 8;          
  break;
 }
 
 return {"param":param,"numCol":numCol};
 
}

function renglonesPaginarAX(tipo, grid, response)
{ var columna   = '';  
  var registros = response['registros'];
  var id        = response['offset'];  

    switch(tipo) {
    case "deptosCuotas":
        var pagoEnLinea = "";
        var cuotasPag   = "";        
        for (var x = 0; x < registros.length ; x++)
        {   id = id +1;
            columna = '<tr class="'+registros[x]['STATUS']['classTR']+'">';
            columna = columna + '<td>'+id+'</td>';
            columna = columna + '<td><i class="fa fa-home"> '+empty(registros[x]['NUMERACION'])+'</i></td>';
            columna = columna + '<td><div id="statusRating'+registros[x]['ID_DEPTO']+'" style="height:30px; width:30px;"> <i class="fa fa-gavel" style="font-size:20px;color:red;"></i> </div></td>';
            columna = columna + '<td><span class="'+registros[x]['STATUS']['class']+'">'+registros[x]['STATUS']['msj']+'</span></td>';
            
            cuotasPag   = '<i class="mcb_cuota pointer fa fa-folder" title="Cuotas pagadas del Depto '+empty(registros[x]['TORRE'])+' '+empty(registros[x]['NUMERACION'])+'" href="#modalCB_gridCuotas" torre="'+registros[x]['TORRE']+'" edificio="'+registros[x]['ID_EDIFICIO']+'" depto="'+registros[x]['ID_DEPTO']+'"> Cuotas Pagadas</i>';            
            pagoEnLinea = registros[x]['STATUS']['class']==="msjConfirmation"?"":'<span title="Pago en línea de la Cuota del Mantenimiento" href="#modalCB_pagoEnLinea" class="mcb_pl button pointer" adminpl="YES" torre="'+registros[x]['TORRE']+'" edificio="'+registros[x]['ID_EDIFICIO']+'" depto="'+registros[x]['ID_DEPTO']+'"><i class="fa fa-usd"></i> Pago en Línea</span>';
            columna = columna + '<td>'+cuotasPag+'<br><br>'+pagoEnLinea+'</td>';

            columna = columna + '</tr>';
            $('#'+grid+' > tbody:last-child').append(columna);
            $('#statusRating'+registros[x]['ID_DEPTO']).jRate({ rating: id });
            $('#statusRating'+registros[x]['ID_DEPTO']).css("cursor", "");
            columna = '';
        }        
        habilitaMODAL("pagos");
        habilitaMODAL("cuotas");
    break;    
    case "deptos":
        for (var x = 0; x < registros.length ; x++)
        {   id = id +1;
            columna = '<tr>';
            columna = columna + '<td>'+id+'</td>';                            
            columna = columna + '<td>'+empty(registros[x]['TORRE'])+'</td>';
            columna = columna + '<td id="numDep'+registros[x]['ID_DEPTO']+'"><i class="fa fa-pencil editarND pointer" torre="'+registros[x]['TORRE']+'" edificio="'+registros[x]['ID_EDIFICIO']+'" depto="'+registros[x]['ID_DEPTO']+'" num="'+registros[x]['NUMERACION']+'"> '+empty(registros[x]['NUMERACION'])+'</i></td>';
            columna = columna + '<td id="cuenta'+registros[x]['ID_DEPTO']+'"><i title="Formulario para Asignar el dueño a un Depto" href="#modalCB_depto" class="modalColorbox fa fa-pencil editar pointer" torre="'+registros[x]['TORRE']+'" edificio="'+registros[x]['ID_EDIFICIO']+'" depto="'+registros[x]['ID_DEPTO']+'">'+registros[x]['CONTACTOS']+'</i></td>';
            columna = columna + '<td id="borrar'+registros[x]['ID_DEPTO']+'"><i class="fa fa-trash  borrar pointer"></i></td>';
            columna = columna + '</tr>';
            $('#'+grid+' > tbody:last-child').append(columna);

            columna = '';
        }
        $(".editarND").click(function(){ habilitarCampoTable("deptos",$(this) ); });
        habilitaMODAL("deptos");     
    break;
    case "cuotas":                                                    
        for (var x = 0; x < registros.length ; x++)
           {   id = id +1;
               columna = '<tr class="'+statusCuotaTR(registros[x]['STATUS'])+'">';
               columna = columna + '<td>'+id+'</td>';
               columna = columna + '<td>'+registros[x]['REFERENCIA']+'</td>';
               columna = columna + '<td>'+registros[x]['CUOTA_DEL_MES']+'</td>';
               columna = columna + '<td>$'+$.number(registros[x]['IMPORTE'],  0, '.', ',' )+'</td>';
               columna = columna + '<td>'+statusCuota(registros[x]['STATUS'])+'</td>';
               columna = columna + '<td>'+tipoPagoCuota(registros[x]['TIPO_PAGO'])+'</td>';
               columna = columna + '<td>'+PDFCuota(registros[x])+'</td>';                                   
               columna = columna + '</tr>';
               $('#'+grid+' > tbody:last-child').append(columna);

               columna = '';
           }
    break;
    case "gastos":
        $("#totGastosTxt").val (response['totales']['totGas']   );
        $("#totGastos"   ).html(response['totales']['totalGasStr']);
        $("#totTMTxt"    ).val (response['totales']['totTM']   );
        $("#totTM"       ).html(response['totales']['totalTMStr']);
        $("#totPTOTxt"   ).val (response['totales']['totPto']   );
        $("#totPto"      ).html(response['totales']['totalPtoStr']);
        $("#totCuotasTxt").val (response['totales']['totCuota']   );
        $("#totCuotas"   ).html(response['totales']['totalCuotaStr']);
        for (var x = 0; x < registros.length ; x++)
           {   var statusCol = statusRegistroPaginar(registros[x], tipo);

               id = id +1;
               columna = '<tr id="col'+tipo+registros[x]['ID_EDIFICIO']+registros[x]['ID_GASTO']+'" class="centroTd '+statusCol+'">';
               columna = columna + '<td>'+id+'</td>';
               columna = columna + '<td>'+registros[x]['CONCEPTO']+'</td>';
               columna = columna + '<td>$'+$.number(registros[x]['MONTO'], 2, '.', ',' )+'</td>';
               columna = columna + '<td>'+registros[x]['IVA']+'</td>';
               columna = columna + '<td>$'+$.number(registros[x]['TOTAL'], 2, '.', ',' )+'</td>';

               columna = columna + '<td>'+adjuntoGasto(registros[x],statusCol)+'</td>';
               columna = columna + '<td class="accionesGas"><i id="editar'+registros[x]['ID_GASTO']+'" class="modalColorbox fa fa-pencil pointer" href="#modalColorbox_contentGas" title="Formulario para capturar Gastos del Edificio" edificio="'+registros[x]['ID_EDIFICIO']+'" gasto="'+registros[x]['ID_GASTO']+'"></i>&nbsp;&nbsp;';
               columna = columna + '    <i class="fa fa-trash borrarReg pointer" edificio="'+registros[x]['ID_EDIFICIO']+'" idRegistro="'+registros[x]['ID_GASTO']+'"></i></td>';

               columna = columna + '</tr>';
               $('#'+grid+' > tbody:last-child').append(columna);

               columna = '';
           }   

        if ( Number($("#nivelacceso").val()) < 2 ) { $(".accionesGas").hide(); }
        $(".borrarReg").click(function(){  var img = $(this);
                                           jConfirm("¿Está seguro de querer borrar el gasto registrado?",$('#tituloAlert').val(), function(r) {
                                           if(r) { borraRegistroAX(img, tipo);  }
                                           });
                                        });
        habilitaMODAL("gastos");
    break; 
    case "tbjoMto":                            
        for (var x = 0; x < registros.length ; x++)
           {   var statusCol = statusRegistroPaginar(registros[x], tipo);
               id = id +1;
               columna = '<tr id="col'+tipo+registros[x]['ID_EDIFICIO']+registros[x]['ID_TRABAJOS']+'" class="centroTd '+statusCol+'">';
               columna = columna + '<td>'+id+'</td>';
               columna = columna + '<td>'+registros[x]['TRABAJO']+'</td>';
               columna = columna + '<td>'+registros[x]['PROVEEDOR']+'</td>';
               columna = columna + '<td>$'+$.number(registros[x]['COSTO'], 2, '.', ',' )+'</td>';
               columna = columna + '<td>'+registros[x]['FECHA_COMPROMISO']+'</td>';
               columna = columna + '<td><a href=\''+$('#baseURL').val()+'portal/downloadTbjoManto/'+registros[x]['ORDEN_TRABAJO']+'\' title=\'Orden de Trabajo '+registros[x]['TRABAJO']+'\'> <i class="fa fa-file-pdf-o"></i></a> </td>';
               columna = columna + '<td>'+ tbjoManAntesDespues(x, registros[x]['EVIDENCIA_ANTES'], registros[x]['EVIDENCIA_DESPUES']) +'</td>';
               columna = columna + '<td class="accionesTM"><i class="modalColorbox fa fa-pencil pointer editarTM" href="#modalColorbox_contentTM" title="Formulario para registrar un Trabajo de mantenimiento en el edificio" edificio="'+registros[x]['ID_EDIFICIO']+'" trabajo="'+registros[x]['ID_TRABAJOS']+'"></i>&nbsp;&nbsp;';
               columna = columna + '                    <i class="fa fa-trash borrarReg pointer" edificio="'+registros[x]['ID_EDIFICIO']+'" idRegistro="'+registros[x]['ID_TRABAJOS']+'"></i></td>';

               columna = columna + '</tr>';
               $('#'+grid+' > tbody:last-child').append(columna);
               $(".group"+x).colorbox({rel:'group'+x});

               columna = '';
           }

        if ( Number($("#nivelacceso").val()) < 2 ) { $(".accionesTM").hide(); }
        $(".borrarReg").click(function(){  var img = $(this);
                                           jConfirm("¿Está seguro de cancelar el trabajo de mantenimiento registrado?",$('#tituloAlert').val(), function(r) {
                                           if(r) { borraRegistroAX(img, tipo);  }
                                           });
                                        });  
        habilitaMODAL("tbjoMto");
    break; 
 }
}


function paginarAX(tipo, grid, currentPage, registrosPagina)
{   
var p = paramPaginarAX(tipo, currentPage);    
$.ajax({ url       : $('#baseURL').val()+'portal/paginarAX/',
         type      : 'post',
         data      : p["param"],
         dataType  : 'json',
         beforeSend: function () 
         { $("#spinPaginar"+tipo).html("<img src=\""+$('#baseURL').val()+"style/images/loading.gif\" width='60' height='60'> Espere por favor...");
           $("#"+grid+" tbody"  ).html("");
         },
         success:  function (response) 
         { $("#spinPaginar"+tipo).html("");              
           if (response === false)
           {   var columna = '<tr><td colspan="'+p["numCol"]+'" align="center"><br><strong>No hay registros</strong></td></tr>';
               $('#'+grid+' > tbody:last-child').append(columna);
           }
           else { validaSesionAX(response); 
                  $("#linksPaginar" + (tipo==="deptosCuotas"?"deptos":tipo)).pagination(
                  {     items       : response['conteo'],
                        itemsOnPage : registrosPagina,
                        cssStyle    : 'light-theme',
                        currentPage : currentPage,
                        onPageClick : function(pageNumber){ paginarAX(tipo, grid, pageNumber, registrosPagina); }
                  });

                renglonesPaginarAX(tipo, grid, response);
                
                }            
         }, 
         error: function(err) { jAlert("Ha ocurrido un error al paginar los "+tipo+": " + err.status + " " + err.statusText,$('#tituloAlert').val()); }
        });
}


function borraRegistroAX(object, tipo)
{    	        	        
var param = { "id_registro" : $(object).attr('idregistro'),
              "id_edificio" : $(object).attr('edificio'),
              "tipo"        : tipo
            };
    
$.ajax({data	: param,               
        url     : $('#baseURL').val()+"finanzas/borraRegistroAX/",
        type	: 'post',
        dataType: 'json',
        success : function (response)  
                    { validaSesionAX(response);                        
                      
                      $('#col'+response['tipo']+response['id_edificio']+response['id_registro']).attr("class","");
                      $('#col'+response['tipo']+response['id_edificio']+response['id_registro']).addClass("centroTd").addClass("desactive");
                    }, 
        error   : function(err)
                        { jAlert("Ha ocurrido un error borraRegistroAX: " + err.status + " " + err.statusText,$('#tituloAlert').val()); }
});			
}

function tbjoManAntesDespues(x, antes, desp) 
{
  var celdaA = isEmpty(antes)?'':'<a href=\''+$('#baseURL').val()+'portal/downloadTbjoManto/'+antes+'\' title=\'Comprobante de Trabajo de Mantenimiento antes\'> <i class="fa fa-download"></i></a> <a class="group'+x+' cboxElement" href=\''+$('#baseURL').val()+antes+'\' title="Mantenimiento Antes"> <i class="fa fa-image"> </i></a>';
  var celdaD = isEmpty(desp) ?'':'&nbsp;/&nbsp;<a href=\''+$('#baseURL').val()+'portal/downloadTbjoManto/'+desp+'\' title=\'Comprobante de Trabajo de Mantenimiento después\'> <i class="fa fa-download"></i></a> <a class="group'+x+' cboxElement" href=\''+$('#baseURL').val()+desp+'\' title="Mantenimiento Después"> <i class="fa fa-image"> </i></a>';
  
  if (isEmpty(antes) & isEmpty(desp) )
  { return "<i class='fa fa-warning'> ¡Sin registro de evidencia!</i>"; }
  else
  { return celdaA+''+celdaD;                                            }
}


function agregarTorres(idEdi,torres)
{
    $("#edTorres").val(idEdi);
    borraOptions('torres');
    var select = $('#torres');
    if(select.prop) { var options = select.prop('options');  }
    else            { var options = select.attr('options');  }     
    
    options[options.length] = new Option("::Seleccione::","0");
     for(var x = 0; x < torres.length; ++x) 
        {  options[options.length] = new Option(torres[x]["text"],torres[x]["val"]);   }
     select.val(0);
}

function statusCuota(e) {
            switch(e) {
                case "":
                case null:
                case false:
                case typeof this === "undefined":
                    return "";
                break;
                case "PENDIENTE":
                case "pendiente":
                    return "<i class='fa fa-clock-o'></i> "+e;
                break;
                case "RECHAZADA":
                case "rechazada":
                    return "<i class='fa fa-close' style='color:red;'></i> "+e;
                break;
                case "PAGADA":
                    return "<i class='fa fa-check' style='color:green;'> "+e+"</i>";
                break;
            }
        }

function statusCuotaTR(e) {
            switch(e) {
                case "":
                case null:
                case false:
                case typeof this === "undefined":
                    return "";
                break;
                case "PENDIENTE":
                case "pendiente":
                    return "warning";
                break;
                case "RECHAZADA":
                case "rechazada":
                    return "danger";
                break;
                case "PAGADA":
                    return "success";
                break;
            }
        }
        
function statusRegistroPaginar(registro, tipo) 
{
    if(tipo === "tbjoMto")
    { switch(true){ case registro['STATUS'] == 11:
                       return "desactive";
                    break;
                    case "PENDIENTE":                 
                    return "warning";
                    break;                    
                    case isEmpty(registro['EVIDENCIA_ANTES']) && isEmpty(registro['EVIDENCIA_DESPUES']):
                       return "danger";
                   break;                   
                   default : return "";
                  }  
    }
    else
    { switch(true) {case registro['STATUS'] == 0:                       
                        return "desactive";
                    break;
                    case isEmpty(registro['COMPROBANTE']) && isEmpty(registro['FACTURA']):
                        return "danger";
                    break;                    
                    default : return "";
                   }
    }    
}        
        
function tipoPagoCuota(e) {
            switch(e) {                
                case "6":
                    return "<i class='fa fa-credit-card-alt'> Tarjeta Bancaria</i>";
                break;
                case "7":
                    return "<i class='fa fa-bank'> Banco</i>";
                break;
                case "8":
                    return "<i class='fa fa-map-pin'> Tienda</i>";
                break;
            }
        }        

function PDFCuota(registro) {
            switch(registro['TIPO_PAGO']) {                
                case "6":
                    return "<a href='"+$('#baseURL').val()+"portal/download/"+registro['RUTA_RECIBO']+"' title='Descargar Recibo'> <i class='fa fa-download'></i> <i class='fa fa-file-pdf-o'></i></a>";
                break;
                case "7":                    
                case "8":
                    return "<a href='"+$('#baseURL').val()+"portal/download/"+registro['RUTA_FORMATO_PAGO']+"' title='Descargar Formato de Pago'> <i class='fa fa-file-pdf-o'></i></a>";
                break;
            }
        }

function adjuntoGasto(registro, statusCol) 
{    
    switch(true) {        
        case statusCol === "danger":
            return "<i class='fa fa-warning'> ¡Sin registro de factura o comprobante!</i>";
        break;
        case statusCol === "desactive":
            return "-";
        break;
        case registro['IVA'] === "0":
            return "<a href='"+$('#baseURL').val()+"portal/downloadGasto/"+registro['ID_EDIFICIO']+"/"+registro['COMPROBANTE']+"' title='Descargar Comprobante'> <i class='fa fa-download'></i></a> <a class='group1 cboxElement' href='"+$('#baseURL').val()+"gastos_edificios/"+registro['ID_EDIFICIO']+"/"+registro['COMPROBANTE']+"' title='Comprobante de Gasto'> <i class='fa fa-image'> </i></a>";
        break;                
        case registro['IVA'] === "1":
            return "<a href='"+$('#baseURL').val()+"portal/downloadGasto/"+registro['ID_EDIFICIO']+"/"+registro['FACTURA']+"' title='Descargar Factura'> <i class='fa fa-download'></i> <i class='fa fa-file-pdf-o'></i></a>";
        break;
    }
} 


function habilitarCampoTable(tipo,object)
{
 var edificio = $(object).attr("edificio");
 
 switch(tipo) {  
  case "deptos":
      var tag      = $(object).parent().attr("id");
      var torre    = $(object).attr("torre"); 
      var depto    = $(object).attr("depto");
      var num      = $(object).attr("num");
      $("#"+tag).html("");
      $("#"+tag).html('<input type="text" id="N_'+tag+'" name="N_'+tag+'" value="'+num+'" class="campoTable" placeholder="Depto Ejemplo: 101" maxlength="6">'+
                      '&nbsp;<i class="fa fa-save  svCT  pointer" torre="'+torre+'" edificio="'+edificio+'" depto="'+depto+'" tag="'+tag+'"></i>'+
                      '<br>  <i class="fa fa-close delCT pointer" torre="'+torre+'" edificio="'+edificio+'" depto="'+depto+'" tag="'+tag+'" num="'+num+'"></i>');
      $(".delCT").click(function(){ deshabilitarCampoTable("deptos",$(this) ); });
      $(".svCT" ).click(function(){ editarCampoTable("deptos",$(this) );       });              
  break;
  case "gastos":
     
  break;
 }
}

function deshabilitarCampoTable(tipo,object)
{
 var torre    = $(object).attr("torre");
 var edificio = $(object).attr("edificio");
 var depto    = $(object).attr("depto");
 var num      = $(object).attr("num");
 var tag      = $(object).attr("tag");
  switch(tipo) {  
  case "deptos": 
      $("#"+tag).html("");
      $("#"+tag).html('<i class="fa fa-pencil editarND pointer" torre="'+torre+'" edificio="'+edificio+'" depto="'+depto+'" num="'+num+'"> '+num+'</i>');
      $(".editarND").click(function(){ habilitarCampoTable("deptos",$(this) ); });
  break;
 }    
}

function editarCampoTable(tipo,object)
{
 var param  = null;
 switch(tipo) 
 {
  case "deptos": var tag = $(object).attr("tag");
                 param   = {"tipo"        : tipo,
                            "id_depto"    : $(object).attr("depto"),
                            "id_edificio" : $(object).attr("edificio"),
                            "torre"       : $(object).attr("torre"),
                            "num"         : $("#N_"+tag).val()
                           };
  break;
  case "gastos": param  = {"tipo"        : tipo,
                           "id_gasto"    : $(object).attr("gasto"),
                           "id_edificio" : $('#id_edificio').val()                                                     
                          };
  break; 
  case "tbjoMto": param  = {"tipo"        : tipo,
                            "id_edificio" : $(object).attr("edificio"),                                                    
                            "id_trabajo"  : $(object).attr("trabajo")
                          };
  break;    
 }
$.ajax({ url       : $('#baseURL').val()+'portal/editarcampotableAX/',
         type      : 'post',
         data      : param,
         dataType  : 'json',
         beforeSend: function (        ) { },
         success   : function (response) 
         {  validaSesionAX(response); 
           
            switch(tipo) {
            case "deptos":                
                $("#"+tag).html("");
                $("#"+tag).html('<i class="fa fa-pencil editarND pointer" torre="'+response['torre']+'" edificio="'+response['edificio']+'" depto="'+response['depto']+'" num="'+response['num']+'"> '+response['num']+'</i>');           
                $(".editarND").click(function(){ habilitarCampoTable("deptos",$(this) ); });
            break;
            case "gastos":            
                var fileName       = "";
                var file           = "";
                var ext            = "";
                var lblComprobante = "";                

                if(response['gasto']['IVA'] == 1)
                {   $("input[name=tiene_iva]").prop( "checked", true );
                    
                    var tmp        = generaFilenameExt(response['gasto']['FACTURA']);
                    fileName       = tmp[0];
                    file           = tmp[1];
                    ext            = tmp[2];
                    lblComprobante = " Factura:";                    
                }
                else
                {   $("input[name=tiene_iva]" ).removeAttr('checked');
                    var tmp        = generaFilenameExt(response['gasto']['COMPROBANTE']);
                    fileName       = tmp[0];
                    file           = tmp[1];
                    ext            = tmp[2];
                    lblComprobante = " Comprobante:";
                }
                
                if(response['gasto']['GASTO_FIJO'] == 1)
                { $("input[name=gasto_fijo]").attr('checked','checked');                   
                  $(".gj").toggle();  
                }
                else
                { $("input[name=gasto_fijo]").removeAttr('checked');    }
                
                $("#total"              ).val(response['gasto']['TOTAL']);
                $("#monto"              ).val(response['gasto']['MONTO']);
                $("#concepto"           ).val(response['gasto']['CONCEPTO']);
                $("#fecha_gasto"        ).val(response['gasto']['FECHA_GASTO']);
                $("#gasto_cada_dia"     ).val(response['gasto']['GASTO_CADA_DIAS']);
                $("#gasto_durante_meses").val(response['gasto']['GASTO_DURANTE_MESES']);
                $('#id_gasto'           ).val(response['gasto']['ID_GASTO']);
                $('#id_edificio'        ).val(response['gasto']['ID_EDIFICIO']);
                $('#gastoAdjunto'       ).val(fileName);                
                $("#lblComprobante"     ).html("<i class='fa fa-image'> </i>"+lblComprobante);
                $("#lblTotal"           ).html("$ "+$.number(response['gasto']['TOTAL'],2, '.', ',' ) );
                $("#lblCuotasFijas"     ).html(response['cuotasFijas']);
                var iconFile = (fileName===""?"<img src='"+$('#baseURL').val()+"logo_edificios/LogoConvivere.jpg' class='img-circle centerDiv' width='100' heigth='250' alt=''><br><br>"
                                             :"  <img class=\"img-circle centerDiv\" id=\"gastoCom\" width=\"100\" heigth=\"100\" src=\""+$('#baseURL').val()+response['dir']+response['gasto']['ID_EDIFICIO']+"/"+fileName+"\"><br>"
                                              + "<img class=\"fileUp centerDiv\" title=\"Borrar evidencia gasto\" name='"+ext+"' id=\""+file+"\" src=\""+$('#baseURL').val()+"style/images/close.png\">");
                $("#divGasto").html(iconFile);                    
            break;
            case "tbjoMto":                
                $("#type_ant"      ).val(response['TIPO_ANT']);
                $("#statusTM"      ).val(response['STATUS']);
                $("#id_tbjoManto"  ).val(response['ID_TRABAJOS']);                
                $("#trabajo"       ).val(response['TRABAJO']);
                $("#proveedorTM"   ).val(response['PROVEEDOR']);
                $("#tbjo_desc"     ).val(response['DESCRIPCION']);
                $("#obsTM"         ).val(response['OBSERVACIONES']);
                $("#anticipo"      ).val(response['ANTICIPO']);
                $("#costo"         ).val(response['COSTO']);
                $("#duracion"      ).val(response['DURACION']);
                $("#fecha_inicioTM").val(response['FECHA_INICIO']);                
                $("#fecha_finTM"   ).val(response['FECHA_COMPROMISO']);
                $("#nuevoTM"       ).val(response['NUEVO']);

                var tmp   = generaArchivoExtension(response['EVIDENCIA_ANTES'], response['EVIDENCIA_DESPUES']);

                $("#divtbjoMantoA"       ).html(isEmpty(response['EVIDENCIA_ANTES'])?"<img src='"+$('#baseURL').val()+"logo_edificios/LogoConvivere.jpg' class='img-circle centerDiv' width='100' heigth='250' alt=''>":"<img src='"+$('#baseURL').val()+response['EVIDENCIA_ANTES'] + "' class='img-circle centerDiv' width='100' heigth='250' alt=''>"+tmp[0]);
                $("#statustbjoMantoA"    ).html("");                
                $("#divtbjoMantoD"       ).html(isEmpty(response['EVIDENCIA_DESPUES'])?"<img src='"+$('#baseURL').val()+"logo_edificios/LogoConvivere.jpg' class='img-circle centerDiv' width='100' heigth='250' alt=''>":"<img src='"+$('#baseURL').val()+response['EVIDENCIA_DESPUES']+"' class='img-circle centerDiv' width='100' heigth='250' alt=''>"+tmp[1]);
                $("#statustbjoMantoD"    ).html("");                                                                     
                $("#confirmtbjoMantoForm").html("");                
                cambioIconTipoAnticipo();
            break;
             }
         }, 
         error: function(err) { jAlert("Ha ocurrido un error al editarCampoTable los "+tipo+": " + err.status + " " + err.statusText,$('#tituloAlert').val()); }
        });
}

function generaFilenameExt(fileName)
{   var file           = "";
    var ext            = "";
    
    if(isEmpty(fileName))
    { fileName     = ""; }
    else
    {
        var len        = fileName.length;
        var len_ext    = len-3;                            
        file           = fileName.substring(0, len_ext-1);
        ext            = fileName.substring(len_ext,len);
    }
    
  return  Array(fileName, file, ext);  
  
}

function generaArchivoExtension(ea, ed)
{   var delEA = '';
    var delED = '';
    
    if(!isEmpty(ea))
    {
    var res = ea.split("/");
    var nombreArchivo = res[res.length];
    var nombreArchivoStr = String(nombreArchivo);
    var extensionStr	 = String(nombreArchivo);
    var len 		 = nombreArchivoStr.length;
    var len_ext 	 = len-3;
    delEA = "<br><img class=\"fileUp centerDiv\" title=\"Borrar evidencia del trabajo\" name='"+nombreArchivoStr.substring(0, len_ext-1)+"' id=\""+extensionStr.substring(len_ext,len)+"\" src=\""+$('#baseURL').val()+"style/images/close.png\">";
    }
    if(!isEmpty(ed))
    {
    var res = ed.split("/");
    var nombreArchivo = res[res.length];
    var nombreArchivoStr = String(nombreArchivo);
    var extensionStr	 = String(nombreArchivo);
    var len 		 = nombreArchivoStr.length;
    var len_ext 	 = len-3;
    delED = "<br><img class=\"fileUp centerDiv\" title=\"Borrar evidencia del trabajo\" name='"+nombreArchivoStr.substring(0, len_ext-1)+"' id=\""+extensionStr.substring(len_ext,len)+"\" src=\""+$('#baseURL').val()+"style/images/close.png\">";
    }
    
   return  Array(delEA, delED);
}

function habilitarFormTable(tipo,object)
{    
 var param  = null;
 switch(tipo)
 {   case "pagos" :
     case "deptos": param  = {"tipo"        : tipo,
                              "id_depto"    : $(object).attr("depto"),
                              "id_edificio" : $(object).attr("edificio"),
                              "torre"       : $(object).attr("torre")                           
                             };
    break;
 }
$.ajax({ url       : $('#baseURL').val()+'portal/traeformAX/',
         type      : 'post',
         data      : param,
         dataType  : 'json',
         beforeSend: function (        ) { },
         success   : function (response) 
         {  validaSesionAX(response); 
           
            switch(tipo) 
            { case "deptos":                
                $('#numDeptoLbl'   ).html(response['depto'][0]['TORRE']+" "+response['depto'][0]['NUMERACION']);
                $('#cumpDeptoLbl'  ).html('<div id="statusRating'+response['depto'][0]['ID_DEPTO']+'" style="height:30px; width:30px;"> <i class="fa fa-gavel" style="font-size:20px;color:red;"></i> </div>');
                $('#statusRating'+response['depto'][0]['ID_DEPTO']).jRate({ rating: response['depto'][0]['CUMPLIMIENTO'] });
                $('#statusRating'+response['depto'][0]['ID_DEPTO']).css("cursor", "");
                
                $('#hf_id_edificio').val(response['depto'][0]['ID_EDIFICIO']);
                $('#hf_id_depto'   ).val(response['depto'][0]['ID_DEPTO']   );
                $('#hf_torre'      ).val(response['depto'][0]['TORRE']      );
                var tmp = '';
                for (var x = 0; x < response['detalle'].length ; x++)
                    { tmp += '<i class="fa fa-user">'+response['detalle'][x]['CONTACTO_NOMBRE']+' - <i>'+response['detalle'][x]['TIPO']+'</i></i><br>'; }
                $('#contactosDeptoLbl').html(tmp);                
                if(!$("#nuevousuario").is(":hidden")) { $("#togNewUser").addClass("fa-minus").removeClass("fa-plus" ); 
                                                        $("#nuevousuario").toggle(); }
               $("#saveUsr").click(function(){ submitFormUsrDepto("sky-formDepto");  });
               $("#canUsr" ).click(function(){ cancelarFormUsrDepto();               });   
               $("#savButtonModalDU").click(function(){ guardarDetalleDeptoAX();     });   
               
              break;
              case "pagos":                                   
                $('#tiposPagoDiv' ).html(response['detalle']['tiposPagoRadioButton']);
                mostrarImporteReferenca(response['detalle']);
                habilitaCamposPago(param);
                var select = $('#cuotas');
                if(select.prop) { var options = select.prop('options');  }
                else            { var options = select.attr('options');  }                                
                for(var y = 0; y < response['detalle']['cuotas'].length; ++y) 
                   {    options[options.length] = new Option(response['detalle']['cuotas'][y]['id'],response['detalle']['cuotas'][y]['id']);   }
                
                select.val(response['detalle']['cuotas'][0]['id']);
              break;
            }
            
         }, 
         error: function(err) { jAlert("Ha ocurrido un error al editarCampoTable los "+tipo+": " + err.status + " " + err.statusText,$('#tituloAlert').val()); }
        });
}

function cancelarFormUsrDepto()
{
    $("#sky-formDepto").validationEngine('hideAll');
    $("#sky-formDepto")[0].reset(); 
    toggleClick_CVR("nuevousuario","togNewUser");
    $("#confirmsky-formDepto").html("");
    $("#confirmDetalleDepto" ).html("");
    $(".usr").val('');         
    $("#tipoDueno").val("0");
    $("#usuarios" ).val("0");
    
    $("#detalleDepto").show();
    $("#footerDetalleDepto").show();
}

function habilitaMODAL(tipo)
{
    switch(tipo) 
            { case "deptos": 
              $(".modalColorbox").colorbox({ inline     :true, width : "90%", height : "90%"
                                            ,onOpen     :function(){ habilitarFormTable(tipo,$(this)); 
                                                                     $("#savButtonModalDU").show();
                                                                     $("#canButtonModalDU").html("<i class='fa fa-close'>&nbsp;</i>Cancelar</span>");
                                                                   }
                                            ,onComplete :function(){ $("#nuevousuario").toggle();
                                                                     $("#togNewUser"  ).click(function(){ var isHidden = $("#nuevousuario").is(":hidden");                                    
                                                                                                        if(isHidden) { $("#togNewUser"  ).removeClass("fa-plus" ).addClass("fa-minus" ); 
                                                                                                                       $("#detalleDepto").hide(); 
                                                                                                                       $("#footerDetalleDepto").hide();
                                                                                                                     }
                                                                                                        else         { $("#togNewUser"  ).removeClass("fa-minus").addClass("fa-plus");
                                                                                                                       $("#detalleDepto").show();
                                                                                                                       $("#footerDetalleDepto").show();
                                                                                                                     }
                                                                                                        $("#nuevousuario").toggle("swing"); 
                                                                                                      });                                                                     
                                                                     $("#togNewUser"  ).addClass("pointer");
                                                                   }
                                           ,onClosed    :function(){ cancelarFormUsrDepto(); }
                                       });                             
              break;
              case "cuotas": 
              $(".mcb_cuota").colorbox({ inline     :true, width : "100%", height : "90%"
                                            ,onOpen     :function(){ $("#edificioGridCuotas").val($(this).attr('edificio'));
                                                                     $("#torreGridCuotas"   ).val($(this).attr('torre'));
                                                                     $("#deptoGridCuotas"   ).val($(this).attr('depto'));
                                                                     paginarAX("cuotas", "cuotasTable", 1, 10);
                                                                   }
                                            ,onComplete :function(){ $("#misCuotas").removeClass("pointer").html("");
                                                                   }
                                           ,onClosed    :function(){  }
                                       });                             
              break;
              case "pagos" :
              $(".mcb_pl").colorbox({ inline       :true, width :"85%"
                                            ,onOpen     :function(){ $("#savButtonModalTDC").show();
                                                                     $("#cancelarButtonTDC").html("<i class='fa fa-close'>&nbsp;</i>Cancelar</span>");
                                                                     if( !isEmpty($(this).attr('adminpl')) )
                                                                       { habilitarFormTable(tipo,$(this)); }
                                                                   }
                                            ,onComplete :function(){ OpenPay.setId($('#openPayId').val());
                                                                     OpenPay.setApiKey($('#openPayApiKey').val());
                                                                     OpenPay.setSandboxMode(true);
                                                                     OpenPay.deviceData.setup("payment-form", "deviceIdHiddenFieldName");    

                                                                     $('#savButtonModalTDC').on('click', function(event) { $( ".msjErr" ).remove();
                                                                                                                          event.preventDefault();
                                                                                                                          $("#savButtonModalTDC").prop( "disabled", true);
                                                                                                                          OpenPay.token.extractFormAndCreate('payment-form', success_callbak, error_callbak);
                                                                                                                         });                                                                     
                                                                   }
                                            //,onClosed   :function(){ alert('onClosed: colorbox has completely closed'); }
                                          });
              break;
              case "gastos" :
              $(".modalColorbox").colorbox({ inline     :true, width :"85%"
                                            ,onOpen     :function(){ editarCampoTable("gastos", $(this)); 
                                                                     muestraOcultaGF( $("input[name=gasto_fijo]") );
                                                                   }
                                            ,onComplete :function(){ $("#gasto_fijo").click (function(){ muestraOcultaGF( $(this) ); });
                                                                     $("#monto"     ).change(function(){ calculaIva($(this).val(),$("#tiene_iva").prop('checked')); });
                                                                     $("#tiene_iva" ).click (function(){ calculaIva($("#monto").val(),$(this).prop('checked')); 
                                                                                                         var txtComp  = ($(this).prop('checked') === true)?"<i class='fa fa-file-pdf-o'></i> Factura:":"<i class='fa fa-image'> </i> Comprobante:";
                                                                                                         $("#lblComprobante").html( txtComp );
                                                                                                       });
                                                                    $("divGasto"          ).html("");                                                                                                       
                                                                    $("#savButtGas"       ).show();                                                                    
                                                                    $("#cancelarButtonGas").html("<i class='fa fa-close'>&nbsp;</i>Cancelar</span>");                                                                    
                                                                   }
                                            ,onClosed   :function(){ $("#gasto-form"           )[0].reset();
                                                                     $("#lblTotal"             ).html("");
                                                                     $("#total"                ).val("");
                                                                     $("input[name=tiene_iva]" ).removeAttr('checked'); 
                                                                     $("input[name=gasto_fijo]").removeAttr('checked');                                                                      
                                                                     $("#lblComprobante"       ).html("<i class='fa fa-image'> </i> Comprobante:");
                                                                     $("#concepto"             ).val("");
                                                                     $("#fecha_gasto"          ).val("");                                                                     
                                                                     $("#gasto_cada_dia"       ).val("");
                                                                     $("#gasto_durante_meses"  ).val("");
                                                                     $("#subirArchivoCNVRGasto").next().html("");
                                                                     $("#divGasto"             ).html("<img src='"+$('#baseURL').val()+"logo_edificios/LogoConvivere.jpg' class='img-circle centerDiv' width='100' heigth='250' alt=''><br><br>");
                                                                     $("#statusGasto"          ).html("");
                                                                     $("#confirmgasto-form"    ).html("");
                                                                     $("#lblCuotasFijas"       ).html("");
                                                                   }
                                          });
              break;
              case "tbjoMto" :
              $(".modalColorbox").colorbox({ inline       :true , width : "85%"
                                            ,onOpen     :function(){ editarCampoTable("tbjoMto", $(this));  }            
                                            ,onComplete :function(){ $("#savButtTM"       ).show();                                                                    
                                                                     $("#cancelarButtonTM").html("<i class='fa fa-close'>&nbsp;</i>Cancelar</span>");
                                                                   }
                                            ,onClosed   :function(){ $("#tbjoMantoForm" )[0].reset();     
                                                                     $("#type_ant"      ).val(1);
                                                                     $("#statusTM"      ).val(9);
                                                                     $("#trabajo"       ).val("");
                                                                     $("#proveedorTM"   ).val("");
                                                                     $("#tbjo_desc"     ).val("");
                                                                     $("#obsTM"         ).val("");
                                                                     $("#anticipo"      ).val("");
                                                                     $("#costo"         ).val("");
                                                                     $("#duracion"      ).val("");
                                                                     $("#fecha_inicioTM").val("");
                                                                     $("#id_tbjoManto"  ).val("");
                                                                     $("#fecha_finTM"   ).val("");
                                                                     
                                                                     $("#subirArchivoCNVRtbjoMantoA").next().html("");
                                                                     $("#divtbjoMantoA"        ).html("<img src='"+$('#baseURL').val()+"logo_edificios/LogoConvivere.jpg' class='img-circle centerDiv' width='100' heigth='250' alt=''><br><br>");
                                                                     $("#statustbjoMantoA"     ).html("");
                                                                     $("#subirArchivoCNVRtbjoMantoD").next().html("");
                                                                     $("#divtbjoMantoD"        ).html("<img src='"+$('#baseURL').val()+"logo_edificios/LogoConvivere.jpg' class='img-circle centerDiv' width='100' heigth='250' alt=''><br><br>");
                                                                     $("#statustbjoMantoD"     ).html("");                                                                     
                                                                     $("#confirmtbjoMantoForm" ).html("");
                                                                     $("#lblPagoProve"         ).html("");
                                                                     $("#lblPagoAnticipo"      ).html("");
                                                                     $("#lblFecha_fin"         ).html("");
                                                                   }
                                          });
              break;
            }
}

function muestraOcultaGF(objGF)
{
if (objGF.prop('checked') === true)
    { $("#gasto_cada_dia"     ).addClass('validate[required,custom[number]]'); 
      $("#gasto_durante_meses").addClass('validate[required,custom[number]]');
      $(".gj").show(1000,"swing");
    }
else{ $("#gasto_cada_dia"     ).removeClass('validate[required,custom[number]]'); 
      $("#gasto_durante_meses").removeClass('validate[required,custom[number]]');
      $(".gj").hide(1000,"swing");
    }    
}


function toggleClick_CVR(div,icon)
{
    $("#"+div).toggle();                                     
    var isHidden = $("#"+div).is(":hidden");
    if(isHidden) { $("#"+icon).addClass("fa-plus" ).removeClass("fa-minus"); }
    else         { $("#"+icon).addClass("fa-minus").removeClass("fa-plus" ); }
}

var loadingCVRInterval;

function LoadingCVR (id, index, interval) {
  var gifLoading ="&nbsp;<img src=\""+$('#baseURL').val()+"style/images/loading.gif\" width='60' height='60'>";
  $('#loadingCVR-msg-'      + index).animate({ 'opacity': '0' });
  $('#loadingCVR-progress-' + index).animate({ 'opacity': '1' });
  
  var p = 0;
  $('#' + id).loadgo('resetprogress');
  $('#loadingCVR-progress-' + index).html('0%' + gifLoading);
  
  window.setTimeout(function () {
    interval = window.setInterval(function (){
      if ($('#' + id).loadgo('getprogress') === 100) {
        window.clearInterval(interval);
        $('#loadingCVR-msg-'      + index).animate({ 'opacity': '1' });
        $('#loadingCVR-progress-' + index).animate({ 'opacity': '0' });
        return;
      }

      var prog = p * 10;
      $('#' + id).loadgo('setprogress', prog);
      $('#loadingCVR-progress-' + index).html(prog + '%' + gifLoading);
      p++;
    }, 150);
  }, 300);
}


function toogleCVR(div, icon)
{
$("#"+div ).toggle("swing");
$("#"+icon).click(function(){ var isHidden = $("#"+div).is(":hidden");                                    
                              if(isHidden) { $("#"+icon).removeClass("fa-search-minus").addClass("fa-search-plus" ); }
                              else         { $("#"+icon).removeClass("fa-search-plus" ).addClass("fa-search-minus"); }
                              $("#"+div).toggle("swing");
                            });
}

function generaDivPto(monthIni, yearIni, monthFin, yearFin)
{
var iniPto = $("#pto_init").datepicker("getDate");
var finPto = $("#pto_fin" ).datepicker("getDate"); 

if( iniPto !== null &&  finPto !== null )
 { var start_date = new Date(yearIni, monthIni  ,"01");
   var end_date   = new Date(yearFin, (monthFin+1), 0);
   var totMonths  = (end_date.getFullYear() - start_date.getFullYear())*12 + (end_date.getMonth() - start_date.getMonth());                                               
   var txtMonth   = '';
   var pto    = '';
   
   $("#divPto").html("");
   $("#canButtonPto").show();
   $("#savButtonPto").show();   
   $("#divPto").append( mesPtoDragHTML() ); 
   
   for (var i = 0; i <= totMonths; i++) 
   { var tmp = new Date(yearIni, (monthIni + i), "01");      
     txtMonth = tmp.toLocaleDateString("es-ES", { year: 'numeric', month: 'short' });          
     pto = creaMesPtoHTML(txtMonth, tmp.getMonth(), tmp.getFullYear());
     
     $("#divPto").append(pto);    
   }
   $(".agregarDivArrast" ).click(function () { agregaPtoDivArrast(); });
 }
 else { jAlert("Favor de seleccionar la fecha <strong>De:</strong> y <strong>A:</strong> para generar presupuesto",$('#tituloAlert').val()); }
}//generaDivPto

function cargaPtoAX(id_pto, hideButton)
 {
    if(id_pto === "0")
    { $("#divPto"      ).html("");
      $("#id_pto"      ).val('');
      $("#fecha_ini"   ).val('');
      $("#fecha_fin"   ).val('');
      $("#statusPto"   ).val(14);
      $("#ptos"        ).val(0);
      $("#ptoForm"     )[0].reset();
      if(hideButton)
           { $("#genPtoButton").hide(); }
      else { $("#genPtoButton").show(); }        
      $("#canButtonPto").hide();
      $("#savButtonPto").hide();
      $("#confirmptoForm").removeClass("msjconfirmII").addClass("msjOkII" ).html('');
    }
    else
    {   var param = {"id_pto" : id_pto }; 
        $("#genPtoButton").hide();
        $("#canButtonPto").show();
        $("#savButtonPto").show();
        $.ajax({data      : param,
                url       : $('#baseURL').val()+'finanzas/cargaPtoAX/',
                type      : 'post',
                dataType  : 'json',
                beforeSend: function ()        { $("#confirmptoForm").html("<img src=\""+$('#baseURL').val()+"style/images/loading.gif\" width='40' height='40'>  Consultando información, espere por favor...");  },
                success   : function (response){ $("#confirmptoForm").html("");
                                                 
                                                 var iniDate  = new Date(response['pto']['INICIO_PTO']);
                                                 var finDate  = new Date(response['pto']['FIN_PTO']);
                                                 var testDate = new Date(finDate.getFullYear(), (finDate.getMonth()+1), 0);
                                                 
                                                 $("#nombre_pto").val(response['pto']['NOMBRE_PTO']);
                                                 $('#pto_init'  ).datepicker().datepicker('setDate', iniDate);
                                                 $('#pto_fin'   ).datepicker().datepicker('setDate', finDate);
                                                 $("#id_pto"    ).val(response['pto']['PRESUPUESTO_ID']);
                                                 $("#fecha_ini" ).val("01/"+getMonthCalendarDatePicker(iniDate.getMonth())+"/"+iniDate.getFullYear() );
                                                 $("#fecha_fin" ).val(testDate.getDate()+"/"+getMonthCalendarDatePicker(finDate.getMonth())+"/"+finDate.getFullYear() );
                                                 $("#statusPto" ).val(response['pto']['STATUS']);
                                                 
                                                 generaDivPto( iniDate.getMonth(), iniDate.getFullYear(), finDate.getMonth(), finDate.getFullYear());
                                                 generaConceptosPto(response['ptoDet']);
                                                 
                                                 if(hideButton)
                                                   { $("#pto-conceptos").hide(); $("#canButtonPto").hide(); $("#savButtonPto").hide(); $("#genPtoButton").hide(); $(".borrarDivArrast").hide(); }
                                               }, 
                error     : function(xhr, textStatus, error)
                                    { jAlert("Ha ocurrido un error al ingresar al sistema: " + xhr.statusText + " " + textStatus+" "+error,$('#tituloAlert').val()); }
               });    
    }
 } //cargaPtoAX

function generaConceptosPto(conceptos)
{  var ptoDivArrast = '' ;
   var detallePto   = null; 
   
   var totCon = -1;
   var totPto =  0;   
   var mesPto = '';
   
   for (var y = 0; y < conceptos.length; y++)
   { 
     detallePto = conceptos[y]['detalle'];
     mesPto     = (Number(conceptos[y]['CON_PTO_MN'])-1)+''+conceptos[y]['CON_PTO_YR'];
     
     for (var x = 0; x < detallePto.length; x++)
     { totCon++;       
       totPto = totPto + Number(detallePto[x]['IMPORTE']);
       
       ptoDivArrast = '<div class="concepto arrastrablePto pointer" mespto="'+mesPto+'" con="'+detallePto[x]['CONCEPTO']+'" imp="'+detallePto[x]['IMPORTE']+'">'+detallePto[x]['CONCEPTO']+' $'+$.number(detallePto[x]['IMPORTE'],2, '.', ',' )+' <i class="fa fa-trash borrarDivArrast pointer"></i>'+
                         ' <input type="hidden" name="conceptoPto'+mesPto+x+'" id="conceptoPto'+mesPto+x+'" value="'+detallePto[x]['CONCEPTO']+'" >'+
                         ' <input type="hidden" name="importePto' +mesPto+x+'" id="importePto' +mesPto+x+'" value="'+detallePto[x]['IMPORTE']+'" >';
                       '</div>';
       $("#lblPtoMes"+mesPto).append(ptoDivArrast);
     }
     
     $("#totalMesPto"+mesPto ).html("Total $ "+$.number(totPto,2, '.', ',' ));        
     $("#totPto"+mesPto      ).val(totPto);
     $("#totConceptos"+mesPto).val(totCon);
        
     totCon = 0;
     totPto = 0;             
   } 
   
    creaPtoDrag(true, true, false);
   
}//generaConceptosPto

function agregaPtoDivArrast()
{
  var ptoDivArrast = '' ;
  if( isNaN($("#importePto").val()) ){ jAlert("El valor ingresado: "+$("#importePto").val()+" no es valido, solo se permiten números",$('#tituloAlert').val());
                                       $("#importePto").val(''); 
                                     }
  else {var imp = Number($("#importePto").val());
        var con = $("#conceptoPto").val();
        
        ptoDivArrast = '<div class="concepto arrastrablePto" con="'+con+'" imp="'+imp+'">'+con+' $'+$.number(imp,2, '.', ',' )+' <i class="fa fa-trash borrarDivArrast pointer" style="float:right"></i></div>';
        $("#cotenidoPtoArrastrable").append(ptoDivArrast);                
        
        $("#importePto" ).val('');
        $("#conceptoPto").val('');
       }
       
  creaPtoDrag(false, true, false);
  
}

function mesPtoDragHTML()
{ return '<section class="col col-3"> '+
         '   <div id="pto-conceptos">'+
         '      <h4>Paso 1)</h4>'+
         '       Concepto:&nbsp;'+
         '       <input type="text" name="conceptoPto" id="conceptoPto" value="" class="text-input" size="8" maxlength="50" >'+
         '       Importe:&nbsp;&nbsp;'+
         '       $<input type="text" name="importePto" id="importePto"  value="" class="text-input" size="8" maxlength="16" >'+
         '       <label class="label"><i class="fa fa-plus pointer agregarDivArrast" style="float:right">Agregar</i></label>'+
         '      <div id="cotenidoPtoArrastrable"> </div>'+
         '      <p><label>Paso 2)Arraste el rectangulo azul hacia el mes</label></p>'+
         '   </div>'+
         '   </section>';
}

function creaMesPtoHTML(titMes, mes, ano)
{
    return  '<section class="col col-3">'+
            ' <div id="sueltaMesPto'+mes+ano+'" class="sueltaPto" mesPto="'+mes+ano+'" >'+
	    '  <input type="hidden" name="totPto'+mes+ano+'" id="totPto'+mes+ano+'" value="0" >'+
            '  <input type="hidden" name="totConceptos'+mes+ano+'" id="totConceptos'+mes+ano+'" value="-1" >'+
            '  <h4>'+titMes+'</h4> '+            
            '  <label class="label" id="lblPtoMes'+mes+ano+'"> '+           
            '  </label> '+
            '  <hr> '+
            '  <label class="label" id="totalMesPto'+mes+ano+'">$0 </label> '+
	    ' </div>'+
            ' </section>  ';    
}

function creaPtoDrag(drag, drop, out)
{
$(".arrastrablePto").draggable();
$(".arrastrablePto").data("soltado", drag );
 
$(".sueltaPto").droppable({ drop: function( event, ui ) {
                                  if (!ui.draggable.data("soltado"))
                                  { ui.draggable.data("soltado", drop);
                                    var elem      = $(this);
                                    var conPto    = $(ui.draggable);                                    
                                    var mespto    = elem.attr("mespto");                                    
                                    var tot       = Number($("#totPto"+mespto      ).val()) + Number(conPto.attr("imp"));
                                    var totConcep = Number($("#totConceptos"+mespto).val()) + 1;
                                    var campPto   = ' <input type="hidden" name="conceptoPto'+mespto+totConcep+'" id="conceptoPto'+mespto+totConcep+'" value="'+conPto.attr("con")+'" >'+
                                                    ' <input type="hidden" name="importePto'+mespto+totConcep+'"  id="importePto'+mespto+totConcep+'"  value="'+conPto.attr("imp")+'" >';
                                    
                                    conPto.attr("mespto",mespto);
                                    conPto.append(campPto);
                                    
                                    $("#totalMesPto"+mespto ).html("Total $ "+$.number(tot,2, '.', ',' ));                                    
                                    $("#totPto"+mespto      ).val(tot);
                                    $("#totConceptos"+mespto).val(totConcep);
                                  }
                            },
                            out: function( event, ui ) {
                                 if (ui.draggable.data("soltado"))
                                 {  ui.draggable.data("soltado", out);
                                    var elem      = $(this);
                                    var conPto    = $(ui.draggable);                                    
                                    var mespto    = elem.attr("mespto");
                                    var tot       = Number($("#totPto"+mespto).val()) - Number(conPto.attr("imp"));
                                    var totConcep = Number($("#totConceptos"+mespto).val()) - 1;
                                    
                                    conPto.removeAttr("mespto",mespto);
                                    conPto.html(conPto.attr("con") + ' $'+$.number( Number(conPto.attr("imp")),2, '.', ',' ) + ' <i class="fa fa-trash borrarDivArrast pointer"></i>');
                                    
                                    $("#totalMesPto"+mespto ).html("Total $ " + $.number(tot,2, '.', ',' ));                                    
                                    $("#totPto"+mespto      ).val(tot);
                                    $("#totConceptos"+mespto).val(totConcep);
                                 }
                            }
                          });
$(".sueltaPto"      ).droppable("option", "accept", ".concepto");
$(".borrarDivArrast").click(function () { borrarPtoDivArrast( $(this) ); });
}

function borrarPtoDivArrast(objeto)
{   var divConcepto = objeto.parent();    
    var importe   = divConcepto.attr("imp");
    var mespto    = divConcepto.attr("mespto");
    var tot       = Number($("#totPto"+mespto).val()) - Number(importe);
    var totConcep = Number($("#totConceptos"+mespto).val()) - 1;    

    $("#totalMesPto"+mespto ).html("Total $ "+$.number(tot,2, '.', ',' ));
    $("#totPto"+mespto      ).val(tot);
    $("#totConceptos"+mespto).val(totConcep);
    
    divConcepto.remove();
}

function generaEdoCtaAX()
{
    if( $('#edo_mesEC').val() === "" )
    { jAlert("Favor de seleccionar una fecha para el Estado de Cuenta ",$('#tituloAlert').val());  }
    else
    {           
    $.ajax({ data      : {"mesEdoCta":$("#mesEdoCta").val(), "anoEdoCta" : $("#anoEdoCta").val(), "mes_edoCta": $("#edo_mesEC").val(), "id_edificio": $("#id_edificio").val() },
             url       : $('#baseURL').val()+'finanzas/generaEdoCtaAX/',
             type      : 'post',
             dataType  : 'json',
             beforeSend: function ()         { $("#divEdoCta").html("<img src=\""+$('#baseURL').val()+"style/images/loading.gif\" width='40' height='40'><br>Generando estado de cuenta,<br> espere por favor..."); },
             success   : function (response) { $("#sendEC"   ).show(); 
                                               $("#divEdoCta").html('<br><br><br><br><br><a href=\''+$('#baseURL').val()+'portal/downloadTbjoManto/'+response['path']+'\' title=\'Estado de Cuenta \'><i class="fa fa-download"> </i><img src="'+$('#baseURL').val()+'style/images/logoPDF.png" width="25" height="25"> '+response['filename']+'</a>');
                                               Highcharts.chart('containerChartCVR_EC', 
                                               {chart      : { type: 'column'             }
                                               ,title      : { text: response['title']    }
                                               ,subtitle   : { text: response['subtitle'] }
                                               ,xAxis      : { type: 'category'     }
                                               ,yAxis      : { title : { text  : '$'              }
                                                              ,labels: { format: '$ {value:,.1f}' }
                                                             }                                               
                                               ,legend     : { enabled: false       }
                                               ,plotOptions: { series : { borderWidth: 0, dataLabels: { enabled: false } } }
                                               ,tooltip    : { headerFormat: '<span style="font-size:11px"     >{series.name}</span><br>',
                                                               pointFormat : '<span style="color:{point.color}">{point.name} </span>: <b>${point.y:,.1f}</b> <br/>'
                                                             }
                                               ,credits    : { enabled: false }
                                               ,exporting  : { enabled: false }
                                               ,series     : response['series']
                                               ,drilldown  : response['drilldown']
                                               });
                                             },
             error     : function(xhr, textStatus, error)
                         { jAlert("Ha ocurrido un error al generaEdoCtaAX: " + xhr.statusText + " " + textStatus+" "+error,$('#tituloAlert').val()); }
            });    
    }
}

function habilitaCamposPago(param)
{
    $(".radioTipoPago").click(function(){ habilitaTipoPago($('input[name=tiposPago]:checked').val(), param); });
    $(".onlyNumber"   ).keydown(function (e) 
    {        
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 ||             // Allow: backspace, delete, tab, escape, enter and .
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || // Allow: Ctrl+A, Command+A        
            (e.keyCode >= 35 && e.keyCode <= 40))                               // Allow: home, end, left, right, down, up   
                { return null; }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) 
           { e.preventDefault(); }
    });     
    $("#cuotas").change(function(){ traeReferenciaAX($(this).val(), param); });
}

function habilitaTipoPago(tipoPago, param)
{  $.ajax({ data      : {"tipoPago" : tipoPago,"cuotas":$("#cuotas").val(),"referencia" : $("#referencia").val(),"importe": $("#importe").val(), "id_depto":param['id_depto'], "id_edificio":param['id_edificio'], "torre":param['torre']},
            url       : $('#baseURL').val()+'finanzas/tipoPagoAX/',
            type      : 'post',
            dataType  : 'json',
            beforeSend: function () { $("#confirmPaid"       ).html("");
                                      $("#divBusquedaTiendas").html("");
                                      $("#tipoPagoContenedor").html("<img src=\""+$('#baseURL').val()+"style/images/loading.gif\" width='100' height='100'> Preparando método de pago, espere por favor...");
                                    },
            success   : function (response) {   $("#c"+$("#cuotas").val()).html('<i class="fa fa-calendar-times-o" style="font-size:15px;color:red; text-decoration-line: line-through;"> '+$("#cuotas").val()+' </i> Pendiente deposito ').css('text-decoration-line', 'line-through');
                                                $("#tipoPagoContenedor"  ).html(response['formTipoPago']);                                                

                                                switch(tipoPago) {         
                                                    case "6"://CARD
                                                        $("#savButtonModalTDC").show();
                                                        $("#cancelarButtonTDC").html("<i class='fa fa-close'>&nbsp;</i>Cancelar</span>");
                                                    break;                
                                                    case "7"://BANK
                                                        $("#confirmPaid"       ).html(response['divFooter']);
                                                        $("#divBusquedaTiendas").html(response['busquedaTiendas']);
                                                        $("#colapsarBanco"     ).before("<div id='iconColapBanco'><i class='fa fa-table'>Ver más</i> </div>");
                                                        $("#colapsarBanco"     ).toggle();
                                                        $("#iconColapBanco"    ).click(function(){ $("#colapsarBanco").toggle("swing"); });
                                                        $("#iconColapBanco"    ).addClass("pointer");
                                                        
                                                        $("#savButtonModalTDC" ).hide();
                                                        $("#cancelarButtonTDC" ).html("<i class='fa fa-close'> </i> Cerrar");
                                                    break;
                                                    case "8"://STORE
                                                        $("#confirmPaid"         ).html(response['divFooter']);
                                                        $("#divBusquedaTiendas"  ).html(response['busquedaTiendas']);                                                
                                                        $("#frameBusquedaTiendas").toggle();
                                                        $("#togSearchTiendas"    ).click(function(){ $("#frameBusquedaTiendas").toggle("swing"); });
                                                        $("#togSearchTiendas"    ).addClass("pointer");
                                                        
                                                        $("#savButtonModalTDC"   ).hide();
                                                        $("#cancelarButtonTDC"   ).html("<i class='fa fa-close'> </i> Cerrar");
                                                    break;
                                                }
                                                
                                                mostrarImporteReferenca(response);
                                                
                                            }, 
            error     : function(xhr, textStatus, error)
                        { jAlert("Ha ocurrido un error al habilitaTipoPago: " + xhr.statusText + " " + textStatus+" "+error,$('#tituloAlert').val()); }
           });
}

function traeReferenciaAX(cuota, param)
 {
    if(cuota !== "0" || cuota !== "P")
    {
        $.ajax({data      : {"cuota" : cuota, "id_depto":param['id_depto'], "id_edificio":param['id_edificio'], "torre":param['torre'] },
                url       : $('#baseURL').val()+'finanzas/traeReferenciaAX/',
                type      : 'post',
                dataType  : 'json',
                beforeSend: function ()        { },
                success   : function (response){ mostrarImporteReferenca(response); }, 
                error     : function(xhr, textStatus, error)
                                    { jAlert("Ha ocurrido un error al ingresar al sistema: " + xhr.statusText + " " + textStatus+" "+error,$('#tituloAlert').val()); }
               });    
    }
 } //traeReferenciaAX
 
function mostrarImporteReferenca(response)
{
    $("#lblReferencia").html(response['referencia']);
    $("#lblImporte"   ).html(response['imp']['importeStr']);
    $("#lblpena"      ).html( (response['imp']['penalizacion']<0?'<label class="label" id="lblpena">(<i class="fa fa-gavel" style="font-size:11px;font-style: italic;"> monto penalizado '+response['imp']['penaStr']+'</i>)</label>':""));

    $("#referencia").val(response['referencia']);
    $("#importe"   ).val(response['imp']['importe']);
}


function getMonthCalendarDatePicker(mesParam)
{
    var mes = Number(mesParam) + 1;
    return (mes<10?"0"+mes:mes);
}

function getDay2DDatePicker(diaParam)
{    
    return (diaParam<10?"0"+diaParam:diaParam);
}


function cargaChartAX(typeChart)
{   var paramChart    = null;
    $.ajax({data      :  {"type" : typeChart, "paramDe":$("#paramDe"+typeChart).val(),"paramHasta":$("#paramHasta"+typeChart).val(),"typeParam":$("input[name=typeParam"+typeChart+"]:checked").val() },
            url       :  $('#baseURL').val()+'portal/dataForChartAX/',
            type      : 'post',
            dataType  : 'json',
            beforeSend: function () { $("#containerChartCVR_"+typeChart).html("<img src=\""+$('#baseURL').val()+"style/images/loading.gif\" width='100' height='100'> Generando información, espere por favor...");  },
            success   : function (data) 
                        { if ('session' in data) 
                            {  jAlert(data['msj'],$('#tituloAlert').val(), function () { window.location.href = $('#baseURL').val(); });
                               return false;
                            }
                          /*** INI DIBUJA LA GRAFICA CON LOS PARAMETROS DEFINIDOS Y CON LOS DATOS EXTRAIDOS DE AJAX  **/  
                          switch(typeChart) 
                          {case "AN":var text = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean bibendum erat ac justo sollicitudin, quis lacinia ligula fringilla. Pellentesque hendrerit, nisi vitae posuere condimentum, lectus urna accumsan libero, rutrum commodo mi lacus pretium erat. Phasellus pretium ultrices mi sed semper. Praesent ut tristique magna. Donec nisl tellus, sagittis ut tempus sit amet, consectetur eget erat. Sed ornare gravida lacinia. Curabitur iaculis metus purus, eget pretium est laoreet ut. Quisque tristique augue ac eros malesuada, vitae facilisis mauris sollicitudin. Mauris ac molestie nulla, vitae facilisis quam. Curabitur placerat ornare sem, in mattis purus posuere eget. Praesent non condimentum odio. Nunc aliquet, odio nec auctor congue, sapien justo dictum massa, nec fermentum massa sapien non tellus. Praesent luctus eros et nunc pretium hendrerit. In consequat et eros nec interdum. Ut neque dui, maximus id elit ac, consequat pretium tellus. Nullam vel accumsan lorem.';
                                     var lines = text.split(/[,\. ]+/g),
                                     data = Highcharts.reduce(lines, function (arr, word) 
                                     {
                                      var obj = Highcharts.find(arr, function (obj) { return obj.name === word; });
                                            if (obj) { obj.weight += 1;             } 
                                            else     { obj = { name: word, weight: 1};
                                                       arr.push(obj);
                                                     }
                                            return arr;
                                     }, []);
                                     paramChart = { series   : [{ type : 'wordcloud',
                                                                  data : data,
                                                                  name : 'Número de veces comentado: '
                                                                }]
                                                    ,title    : { text   : 'Lo más comentado' }
                                                    ,credits  : { enabled: false              }
                                                    ,exporting: { enabled: false              }
                                                  };
                                    Highcharts.setOptions({ lang: { decimalPoint: '.', thousandsSep: ',' } });
                                    Highcharts.chart('containerChartCVR_'+typeChart, paramChart);              
                             break;
                             case "TM":paramChart = { chart    : { type : 'xrange'            }
                                                      ,title   : { text : data['title']       }
                                                      ,subtitle: { text : data['subtitulo']   }
                                                      ,xAxis   : { type : 'datetime'          }
                                                      ,yAxis   : { title: { text: ''          }
                                                                  ,categories: data['data']['categories']
                                                                  ,reversed: true
                                                                 }
                                                      ,series: [{ name       : data['data']['serieName']
                                                                 ,borderColor: 'gray'
                                                                 ,pointWidth : 20
                                                                 ,data       : data['data']['seriesData']
                                                                ,dataLabels: { enabled: true   }
                                                            }]
                                                      ,credits:  { enabled: false }
                                                    };                                        
                                        Highcharts.setOptions({ lang: { decimalPoint: '.', thousandsSep: ',' } });
                                        Highcharts.chart('containerChartCVR_'+typeChart,paramChart);            
                             break;
                             case "MOR":Highcharts.setOptions({ chart       : { type   : 'bullet', inverted: true }
                                                                ,title      : { text   : null                     }
                                                                ,legend     : { enabled: false                    }
                                                                ,yAxis      : { gridLineWidth: 0                  }
                                                                ,plotOptions: { series: { pointPadding: 0.25, borderWidth: 0, color: '#000' } }
                                                                ,credits    : { enabled: false }
                                                                ,exporting  : { enabled: false }
                                                              }); 
                                        Highcharts.chart('containerChartCVR_'+typeChart, {chart: { marginTop: 20 }
                                                                                         ,title: { text: ''      }
                                                                                         ,xAxis: { categories: ['Tasa Morosidad'] }
                                                                                         ,yAxis: { plotBands : [{from: 0 , to: 33,  color: '#66CC00' }
                                                                                                               ,{from: 34, to: 67,  color: '#FFFF00' }
                                                                                                               ,{from: 68, to: 100, color: '#FF0000' }
                                                                                                               ]
                                                                                                  ,labels: { format: '{value}%' }
                                                                                                  ,title : null
                                                                                                 }
                                                                                         ,series : [{ data: [{ y:  Number($('#tasaMoroField').val()), target: 0 }] }]
                                                                                         ,tooltip: { pointFormat: '<b>{point.y:,.1f}%</b> (sin adeudos {point.target:,.1f}%)'  }
                                                                                        });
                             break;                             
                             case "GAS":
                             case "GAS2":paramChart = { chart  : { type        : 'solidgauge'        }
                                                      ,title   : { text        : data['title']       }
                                                      ,subtitle: { text        : null  }
                                                      ,pane    : { center      : ['50%', '85%']
                                                                   ,size       : '140%'
                                                                   ,startAngle : -90
                                                                   ,endAngle   :  90
                                                                   ,background : { backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || '#EEE', innerRadius: '60%', outerRadius: '100%', shape: 'arc' } }
                                                      ,tooltip: { enabled: false }
                                                      ,yAxis  : {minorTickInterval: null
                                                                ,stops     : [ [0.1, '#4396ff'] ]
                                                                ,lineWidth : 0                                                                
                                                                ,tickAmount: 2
                                                                ,title     : { y: 0  }
                                                                ,labels    : { y: 16 }
                                                                ,min       : 0
                                                                ,max       : data['data']['max']                                                                
                                                              }
                                                      ,plotOptions: { solidgauge: { dataLabels: { y: 5, borderWidth: 0, useHTML: true } } }
                                                      ,series: [{ name: 'Cuotas'
                                                                 ,data: [data['data']['current']]
                                                                 ,dataLabels: { format: '<div style="text-align:center"><span style="font-size:20px;color:'   +
                                                                                        ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">${y:,.1f}</span><br/>' +
                                                                                        '<span style="font-size:12px;color:silver">$</span></div>'
                                                                              }
                                                            }]
                                                      ,credits  : { enabled: false }
                                                      ,exporting: { enabled: false }
                                                    };
                                        Highcharts.setOptions({ lang: { decimalPoint: '.', thousandsSep: ',' } });
                                        Highcharts.chart('containerChartCVR_'+typeChart, paramChart);
                             break;                                     
                             /******* HOME PORTAL ****************/
                             case "RE":paramChart = {  chart      : { type     : 'column'
                                                                     ,options3d: { enabled : true, alpha : 10, beta : 15,depth : 70 }
                                                                     , zoomType: 'xy'
                                                                    }
                                                      ,title      : { text  : data['title']       }
                                                      ,subtitle   : { text  : data['subtitulo']   }
                                                      ,plotOptions: { column: { depth: 25         } }
                                                      ,xAxis      : { categories: data['data']['categories']
                                                                     ,labels    : { skew3d: true, style : { fontSize: '16px' } }
                                                                     ,crosshair : true
                                                                    }
                                                      ,yAxis     : [{ labels: { format: '$ {value:,.1f}', style: { color: Highcharts.getOptions().colors[0] } },
                                                                      title : { text  : '$ Cuotas'      , style: { color: Highcharts.getOptions().colors[0] } }
                                                                    }
                                                                    ,{ labels  : { format: '$ {value:,.1f}', style: { color: Highcharts.getOptions().colors[1] } },
                                                                       title   : { text  : '$ Gastos'      , style: { color: Highcharts.getOptions().colors[1] } }                                                                       
                                                                      ,opposite: true
                                                                    },{ labels : { format: null       , style: { color: Highcharts.getOptions().colors[2] } },
                                                                        title  : { text  : '$ Balance', style: { color: Highcharts.getOptions().colors[2] } }
                                                                      ,opposite: true
                                                                    }
                                                                   ]
                                                      ,tooltip    : { shared: true, borderWidth : 1, borderRadius: 10 }
                                                      ,series     : data['data']['series']/*[{ name : 'Cuotas'
                                                                      ,type : 'column'
                                                                      ,yAxis: 0
                                                                      ,data : [1, 4, 3,4,7,8,9,null,0,10]                                                                      
                                                                     }
                                                                    ,{ name : 'Gastos'
                                                                      ,type : 'column'
                                                                      ,yAxis: 1
                                                                      ,data : [6, 4, 2,null,1,2,5,5,5,6]                                                                      
                                                                     }
                                                                    ,{ name: 'Balance'
                                                                      ,type: 'spline'
                                                                      ,data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3]                                                                      
                                                                     }
                                                                    ]*/
                                                      ,credits    :  { enabled: false }
                                                      ,responsive :  {rules: [{ condition   : { maxWidth: 500 }/**REVISAR TO DO's**/
                                                                               ,chartOptions: { legend : { align : 'center', verticalAlign: 'bottom', layout : 'horizontal'}
                                                                                              ,yAxis   : { labels: { align: 'left', x: 0, y: -5 }
                                                                                                          ,title : { text: null }
                                                                                                        }
                                                                                              ,subtitle: { text   : null  }
                                                                                              ,credits : { enabled: false }
                                                                                         }
                                                                             }]
                                                                    }
                                                    };                                                    
                                    Highcharts.setOptions({ lang: { decimalPoint: '.', thousandsSep: ',' } });
                                    Highcharts.chart('containerChartCVR_'+typeChart,paramChart);
                             break;
                             /******* HOME PORTAL  *******************/
                          };
                          
                          /*** FIN DIBUJA LA GRAFICA CON LOS PARAMETROS DEFINIDOS Y CON LOS DATOS EXTRAIDOS DE AJAX  **/  
                        }, 
            error     : function(err) { jAlert("Ha ocurrido un error cargaSeccionInAX en " + err.status + " " + err.statusText,$('#tituloAlert').val()); }
          }); 
}
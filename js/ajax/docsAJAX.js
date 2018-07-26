

function submitFormLogin(forma) 
{   $("#"+forma).validationEngine();	  
    if($("#"+forma).validationEngine('validate'))
      { submitLoginAX($('#baseURL').val(),forma,$('#tituloAlert').val()); }
}


$("document").ready(function (){
    
$("#login-button").click(function(){ submitFormLogin("login"); });

});
 

function submitLoginAX(baseURL,forma,tituloAlert)
{
    $("#confirm"+forma).removeClass("msjErrCentro").removeClass("check-box").removeClass("msjOk2").removeClass("msjOk").removeClass("msjErr").addClass("msjconfirm").html("").show(); 
    $.ajax({data      : $("#"+forma).serialize(),
            url       : $("#"+forma).attr("action"),
            type      : 'post',
            dataType  : 'json',
            beforeSend: function () { $("#confirm"+forma).removeClass("msjOk").addClass("msjconfirm");
                                      $("#confirm"+forma).html("<img src=\""+baseURL+"style/images/spin.png\"> Validando acceso, espere por favor...");},
            success   : function (response) {                                
                                      if(response['acceso'] === true)
                                      {
                                        $("#confirm"+forma).removeClass("msjconfirm").addClass("check-box").addClass("msjOk2");
                                        $("#confirm"+forma).html("<br><img src=\""+baseURL+"style/images/check.png\">&nbsp;BIENVENIDO<br>...Ingresando al Portal");                                        
                                        window.location.href = baseURL+"portal/";
                                      }
                                      else
                                      {
                                        $("#confirm"+forma).removeClass("msjconfirm").addClass("msjErrCentro");
                                        $("#confirm"+forma).html("<img src=\""+baseURL+"style/images/important.gif\"><br>"+(isEmpty(response['mensaje']['usuario'])?"":response['mensaje']['usuario'])+(isEmpty(response['mensaje']['pwd'])?"":response['mensaje']['pwd']));
                                      }
                                 }, 
            error     : function(xhr, textStatus, error)
                            { jAlert("Ha ocurrido un error al ingresar al sistema: " + xhr.statusText + " " + textStatus+" "+error,tituloAlert); 
                             // $("#confirm"+forma).removeClass("msjconfirm").removeClass("msjOk").addClass("msjErr").html("<img src=\""+baseURL+"images/close.png\">Ocurrio un problema al guardar la seccion, intentelo mas tarde");
                            }
           });    
}


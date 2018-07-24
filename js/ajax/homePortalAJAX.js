
$("document").ready(function (){ habilitaJS_Webpart("RE");                                
                                 $("#f_webpart_t1").click(function(){ habilitaJS_Webpart("RE"); });
                                 $("#f_webpart_t2").click(function(){ habilitaJS_Webpart("AN"); });
                                 $("#f_webpart_t3").click(function(){ habilitaJS_Webpart("PE" ); });
                                 $("#f_webpart_t4").click(function(){ habilitaJS_Webpart("CH"); });                                 
                               }); //$("document").ready


function habilitaJS_Webpart(tipo)
{
var today    = new Date();
var FirstDay = new Date(today.getFullYear(), today.getMonth()    , 1);
var LastDay  = new Date(today.getFullYear(), today.getMonth() + 1, 0);

switch(tipo){ 
case "RE":   /*********     RESUMEN EJECUTIVO  INI       ***********/    
    cargaChartAX("RE");
 break;      /*********     RESUMEN EJECUTIVO   FIN           ***********/
 case "AN": /*********      ANUNCIOS INI        ***********/         
    cargaChartAX("AN");
 break;     /*********      ANUNCIOS  FIN       ***********/
 
 case "PE": /*********      PERFIL  INI   ***********/     

 break;      /*********     PERFIL  FIN       ***********/
 
 case "CH": /*********      COMO LE HAGO  INI       ***********/        
    
 break;     /*********      COMO LE HAGO    FIN       ***********/   
}//switch
}//habilitaJS_Webpart

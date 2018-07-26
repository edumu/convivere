<?php
           echo "<html>"
. "           <head>";
$meta = array( array('name' => 'author'      , 'content' => 'DATARE'),
               array('name' => 'Content-type', 'content' => 'text/html; charset=UTF-8', 'type' => 'equiv')
             );
echo meta($meta);
echo '<link rel="STYLESHEET" href="style/css/ems/cvr_formatos_pdf.css" type="text/css">';

echo '</head>'; 
      echo   '<body marginwidth="0" marginheight="0" class="pdfFondo">';
      echo   '<div class="footer">
              <div style="text-align: center;"></div>
              <div style="text-align: center;"> <div class="page-number"></div> <img src="style/images/logo/logoTransparenteCNVR.jpg" width="300px" height="50px"></div>
             </div>';
      
      include("webpart_header_pdf.php");
      
      echo   br(3);
      echo   '<div><table align="center" class="edoCta" >
              <tbody>
                <tr> <td width="80%"></td><td width="20%" class="even_row">Folio'.br().'<strong>'.$trabajo['ID_TRABAJOS'].'</strong> </td> </tr>
              </tbody>
              </table></div>'; 
      echo   br(5);
      echo   '<div><table align="center" class="edoCta" >
              <tbody>
                <tr> <td width="30%">Lugar y Fecha de expedición</td><td width="70%" class="even_row">'.$dirEdificio.br().$fa.' </td> </tr>
              </tbody>
              </table></div>';
      echo   br(5);
      echo   '<div><table align="center" class="edoCta" >
              <tbody>
                <tr> <td width="30%">Cliente  </td><td width="70%" class="even_row">'.$nombreEdificio.' </td> </tr>
                <tr> <td width="30%">Proveedor</td><td width="70%" class="even_row">'.$trabajo['PROVEEDOR'].' </td> </tr>
              </tbody>
              </table></div>'; 
      echo   br(5);
      echo   '<div><table align="center" class="edoCta" >
              <tbody>
                <tr> <td width="100%" class="fondoGrisCentro"><strong>'.$trabajo['TRABAJO'].'</strong> </td> </tr>
                <tr> <td width="100%"><strong>Descripción: </strong>'.br().$trabajo['DESCRIPCION'].'   </td> </tr>
                <tr> <td width="100%"><strong>Observaciones</strong>'.br().$trabajo['OBSERVACIONES'].' </td> </tr>
              </tbody>
              </table></div>'; 
      echo   br(8);
      echo   '<div><table align="center" class="edoCta" >
              <tbody>
                <tr> <td width="33.3%"></td><td width="33.3%"><strong>Fecha de Inicio</strong></td><td width="33.3%"><strong>Fecha Compromiso</strong></td> </tr>
                <tr> <td width="33.3%" class="even_row"></td><td width="33.3%" class="even_row">'.$fi.'        </td><td width="33.3%" class="even_row"> '.$fc.'</td> </tr>
              </tbody>
              </table></div>'; 
      echo   br(6);
      echo   '<div><table align="center" class="edoCta" >
              <tbody>
                <tr> <td width="33.3%"><strong>Total a pagar:</strong></td> <td width="33.3%"><strong>Anticipo:</strong> </td> <td width="33.3%"><strong>Finiquito:</strong></td> </tr>
                <tr> <td width="33.3%" class="even_row">$ '.number_format($trabajo['COSTO'], 2, '.', ',').' MXN</td> <td width="33.3%" class="even_row">$ '.number_format($anticipo, 2, '.', ',').' MXN</td> <td width="33.3%" class="even_row">$ '.number_format($finiquito, 2, '.', ',').' MXN</td> </tr>
                <tr> <td width="33.3%" style="font-size: 7pt; text-align: center;">'.$costoLetras.'</td> <td width="33.3%"  class="center"  style="font-size: 7pt; text-align: center;">'.$anticipoLetras.'</td> <td width="33.3%"  class="center"  style="font-size: 7pt; text-align: center;">'.$finiquitoLetras.'</td> </tr>
              </tbody>
              </table></div>'; 
      
      echo   ' </body>';      
      echo   '</html>'; 


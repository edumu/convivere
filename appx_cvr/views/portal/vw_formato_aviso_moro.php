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
      
      echo   br(2);
      echo   '<div><table align="center" class="edoCta" >
              <tbody>
                <tr> <td width="70%"></td><td width="30%" class="even_row">'.br().'<strong>'.$hoy.'</strong> </td> </tr>
              </tbody>
              </table></div>';
      echo   '<div>
                <p><strong>Estimado Condomino,</strong></p>                
                <p style="text-align: justify;">Le comunicamos que hasta el momento no hemos recibido la confirmación de pago de una o más cuotas de mantenimiento, 
                   por lo que, le rogamos efectúe el abono de las mismas, lo antes posible, a fin de evitar afectaciones en los servicios contratdos, gastos fijos y trabajos de mantenimientos propios del edificio.
                </p>
                <br>
              </div>';
     echo   '<p><table align="center" class="edoCta" >
                <thead>
                    <tr> <th width="50%" class="fondoGrisCentro"><strong>Departamentos</strong></th><th width="50%" class="fondoGrisCentro"><strong>Cuotas Pendientes</strong> </th> </tr>
                </thead>
              <tbody>';
                $x = -1;
                foreach ($morosos as $m)
                       {  $x++;
                          $classFondo = ($x % 2)?"":"fondoBackGris";
                          echo '<tr class="'.$classFondo.'"> <td width="50%" valign="middle" class="center">'.$m['depto']['TORRE'].' '.$m['depto']['DEPTO'].'</td>
                                     <td width="50%" valign="top" class="center" style="font-size: 9pt;">';
                                     $y =0;  
                                     foreach ($m['cuotas'] as $c)
                                        { $y++; echo $y.") ".$c['CUOTA_PENDIENTE'].br(); }
                          echo '     </td>
                              </tr>';
                       }
     echo   '<tr> <td width="100%" colspan="2"> <p style="text-align: justify;">Si tiene cualquier duda al respecto puede ponerse en contacto al '.CALL_CENTER.' o en la dirección de correo electrónico '.CORREO_OFICIAL.'.</p> </td> </tr>';
     echo   '<tr> <td width="100%" colspan="2"> <p>'.nbs().'</p> </td> </tr>';
     echo   '<tr> <td width="100%" colspan="2"> <p>Sin otro particular, reciba un cordial saludo.</p> </td> </tr>';
     echo   '<tr> <td width="100%" colspan="2"> <p>'.nbs().'</p> </td> </tr>';
     echo   '<tr> <td width="100%" colspan="2" class="fondoGrisCentro"> <strong>Administración CONVIVERE</strong> </td> </tr>';
     echo   '</tbody>
            </table></p>';

      echo   ' </body>';      
      echo   '</html>'; 


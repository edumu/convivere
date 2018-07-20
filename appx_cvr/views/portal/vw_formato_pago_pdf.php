<?php
      echo "<html>"
. "           <head>";
$meta = array( array('name' => 'author'      , 'content' => 'DATARE'),
               array('name' => 'Content-type', 'content' => 'text/html; charset=UTF-8', 'type' => 'equiv')
             );
echo meta($meta);
echo '<link rel="STYLESHEET" href="'.($viewPDF===TRUE?"":base_url()).'style/css/ems/cvr_formatos_pdf.css" type="text/css">';

echo '</head>'; 
      echo   '<body marginwidth="0" marginheight="0">';
      
      include("webpart_header_pdf.php"  );
      include("webpart_formato_pago.php");
      
      echo   '<div id="colapsarBanco">';
      echo   '<table align="center" style="width: 90%;" >
              <tbody>
               <tr>
               <td width="2%" class="fondoColor"></td>
               <td width="48%" class="negritas"><strong>'.$section3_1.'</strong></td>
               <td width="2%"></td>
               <td width="48%" class="negritas"><strong>'.$section3_2.'</strong></td>
               </tr>
               <tr>
               <td width="2%"></td>
               <td width="48%" class="detalle" style="font-size: 9pt;">'.$section4_1.'</td>
               <td width="2%"></td>
               <td width="48%" class="detalle" style="font-size: 9pt;">'.$section4_2.'</td>
               </tr>
               </tbody>
              </table>';
      echo   ' </div>';
      
      echo   ' <table align="center" style="width: 90%;" >
              <tbody>
               <tr><td width="2%"></td><td width="100%" colspan="3" class="center"><p>'.$section5_1.'</p></td></tr>
              </tbody>
              </table>              
              ';       
      echo   ' </body>';
      echo   '</html>'; 


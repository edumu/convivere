<?php        
      echo   '<table align="center" style="width: 90%;" >
              <tbody>
               <tr>
               <td width="2%"></td>
               <td width="48%">'.$section1_1.'</td>
               <td width="2%"></td>
               <td width="48%" class="negritasCenter12"><strong>'.$section1_2.'</strong></td>
               </tr>
               <tr>
               <td width="2%"></td>
               <td width="48%" style="font-size: 8pt; text-align: center; ">'.$section2_1.'</td>
               <td width="2%"></td>
               <td width="48%" class="fondoColorTotal">'.br().$section2_2.br(2).'</td>
               </tr>
               </tbody>
              </table>
              <table align="center" style="width: 90%;" >
              <tbody>
               <tr><td width="2%"></td><td width="100%" colspan="3" class="center">'.br().'</td></tr>
              </tbody>
              </table>
              <table cellspacing="0" align="center" cellpadding="0" style="width: 90%;" >
              <tbody>
               <tr>
               <td width="2%" class="fondoColor"></td>
               <td width="48%" class="negritas"><strong>Detalles del Formato de pago</strong></td>
               <td width="2%"></td>
               <td width="48%"></td>
               </tr>
               <tr>
               <td width="2%"></td>
               <td width="48%" class="even_row">Cuota de Mantenimiento</td>
               <td width="2%"></td>
               <td width="48%" class="even_row">'.$detalle.'</td>
               </tr>
                <tr>
               <td width="2%"></td>
               <td width="48%" class="odd_row">Fecha y Hora del Formato de pago</td>
               <td width="2%"></td>
               <td width="48%" class="odd_row">'.$fechaHora.'</td>
               </tr>  
               <tr>
               <td width="2%"></td>
               <td width="48%" class="even_row">Vigencia al </td>
               <td width="2%"></td>
               <td width="48%" class="even_row">'.$vigencia.'</td>
               </tr>  
               </tbody>
              </table>
              <table align="center" style="width: 90%;" >
              <tbody>
               <tr><td width="2%"></td><td width="100%" colspan="3" class="center">'.br().'</td></tr>
              </tbody>
              </table>
              ';
      if( $viewPDF !== TRUE){
      echo   ' <table align="center" style="width: 90%;" >
              <tbody>
               <tr><td width="2%"></td><td width="100%" colspan="3" class="center"><p>'.$section5_1.'</p></td></tr>
              </tbody>
              </table>              
             ';       }


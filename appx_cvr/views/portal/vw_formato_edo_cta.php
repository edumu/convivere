<?php
      echo "<html>"
. "           <head>";
$meta = array( array('name' => 'author', 'content' => 'DATARE'),
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
      echo   '<table align="center" style="width: 100%;" >
              <tbody>               
               <tr>
               <td width="2%" ></td>
               <td width="38%">'.$chartMesEdoCta.'</td>
               <td width="2%" ></td>
               <td width="58%">'.$chartAcumEdoCta.'</td>
               </tr>
               </tbody>
              </table>
              '.br();
       echo   '<table align="center" class="edoCta">
               <tbody> 
               <tr>                
                <td width="'.$widthColumTot.'" valign="top" class="fondoGrisLeft"> <strong>Cuotas pagadas en '.$mes_edoCta.':'.br().'- '.$tot['numCuotas'].' de '.$totCuotasEdi.br().'- $ '.number_format($tot['cuotas'], 2, '.', ',').' de  $ '.number_format($totImporteEdi, 2, '.', ',').br().'- '.number_format($porcentajeCuota, 2, '.', ',').' % (tasa de pago)'.br().'- $ '.number_format($tot['penaCuotas'], 2, '.', ',').' de multas </strong> </td>
                <td width="'.$widthColumTot.'" valign="top" class="fondoGrisLeft"> <strong>Gastos de '.$mes_edoCta.':'.br().'- $ '.number_format( ($tot['gastos'] + $tot['tm']), 2, '.', ',').br().'- '.$tot['numGastos'].' gastos registrados.'.br().'- '.$tot['numTM'].' trabajos de manto. registrados.</strong> </td>';
      echo ( ($isPto)?'<td width="'.$widthColumTot.'" valign="top" class="fondoGrisLeft"> <strong>Presupuestado para '.$mes_edoCta.':'.br().'-  $ '.number_format($tot['pto']  , 2, '.', ',').'</strong> </td>':'');
      echo  ' </tr>
              <tr><td width="100%" colspan="'. ( ($isPto)?3:2 ).'" class="fondoGrisCentro"> BALANCE: $ '.number_format( $tot['cuotas']-($tot['gastos'] + $tot['tm']), 2, '.', ',').'  -  '.number_format( (($tot['gastos'] + $tot['tm'])/$tot['cuotas'])*100, 2, '.', ',').'% (tasa Cuotas Vs Gastos) </td> </tr>
              </tbody>
              </table> 
              '.br(8).'
              <table align="center" class="edoCta" >
              <tbody>
                <tr> <td class="fondoAzulCentro">Movimientos del Mes</td> </tr>
              </tbody>
              </table>
              '.br(2).'
              <table align="center" class="edoCta" >
              <thead>
              <tr>
                <th width="20%" class="fondoGrisCentro">Fecha</th>
                <th width="'.$widthColum.'" class="fondoGrisCentro">Cuotas</th>
                <th width="'.$widthColum.'" class="fondoGrisCentro">Gastos</th>';
         echo ( ($isPto)?'<th width="'.$widthColum.'" class="fondoGrisCentro">Presupuesto</th>':'');
         echo '</tr>'
           . '</thead>'         
           . '<tbody>';
      
      $tableContentIni = '<table align="center" style="width: 100%;"><tbody>';
      $tableContentFin = '</tbody></table>';            
      $x = -1;
      foreach ($edoCta as $e) 
      { $x++;
        $classFondo = ($x % 2)?"":"fondoBackGris";
        echo '<tr class="'.$classFondo.'">';
        echo '  <td class="edoCta">'.$e['fecha'].'</td>';
        /** CUOTAS PRINT INI **/
        echo '  <td class="edoCta">';
        echo $tableContentIni;
        foreach ($e['cuotas'] as $c)
            { echo '<tr> <td width="50%" class="center"  style="font-size: 8pt;">'.$c['CONCEPTO'].'</td>
                         <td width="50%" class="center"  style="font-size: 9pt;"> $ '.number_format($c['IMPORTE'], 2, '.', ',').'</td>
                   </tr>';            
            }
        echo $tableContentFin;
        echo '  </td>';          
        /** CUOTAS PRINT FIN **/
        
        /** CUOTAS GASTOS  PRINT INI **/
        echo '  <td class="edoCta">';
        echo $tableContentIni;
        foreach ($e['gastos'] as $g)
            {  echo '<tr> <td width="50%" class="center"  style="font-size: 8pt;">'.$g['CONCEPTO'].'</td>
                          <td width="50%" class="center"  style="font-size: 9pt;"> $ '.number_format($g['IMPORTE'], 2, '.', ',').'</td>
                   </tr>';
            }            
        foreach ($e['trabajosA'] as $ta)
            {  echo '<tr> <td width="50%" class="center"  style="font-size: 8pt;">'.$ta['CONCEPTO'].'</td>
                          <td width="50%" class="center"  style="font-size: 9pt;"> $ '.number_format($ta['IMPORTE'], 2, '.', ',').'</td>
                   </tr>';
            }
        foreach ($e['trabajosD'] as $td)
            {  echo '<tr> <td width="50%" class="center"  style="font-size: 8pt;">'.$td['CONCEPTO'].'</td>
                          <td width="50%" class="center"  style="font-size: 9pt;"> $ '.number_format($td['IMPORTE'], 2, '.', ',').'</td>
                   </tr>';
            }            
        echo $tableContentFin;
        echo '  </td>';
        /** CUOTAS GASTOS  PRINT FIN **/
        
        /** CUOTAS PRESUPUESSTOS  PRINT INI **/
        echo '  <td class="edoCta">';
        if(sizeof($e['ptos']) !== 0 ) 
        {
        echo $tableContentIni;
        foreach ($e['ptos'] as $p)
            {  echo '<tr> <td width="50%" class="center"  style="font-size: 8pt;">'.$p['CONCEPTO'].'</td>
                          <td width="50%" class="center"  style="font-size: 9pt;"> $ '.number_format($p['IMPORTE'], 2, '.', ',').'</td>
                    </tr>';
            }
        echo $tableContentFin;
        }
        echo '  </td>';
        /** CUOTAS PRESUPUESSTOS  PRINT FIN **/        
        echo '</tr>';
      }
      echo  ' <tr>
                <td width="20%" class="fondoGrisCentro"> <strong>Total</strong> </td>
                <td width="'.$widthColum.'" class="fondoGrisCentro"> <strong> $ '.number_format($tot['cuotas'], 2, '.', ',').'</strong> </td>
                <td width="'.$widthColum.'" class="fondoGrisCentro"> <strong> $ '.number_format( ($tot['gastos'] + $tot['tm']), 2, '.', ',').'</strong> </td>';
      echo ( ($isPto)?'<td width="'.$widthColum.'" class="fondoGrisCentro"> <strong> $ '.number_format($tot['pto']  , 2, '.', ',').'</strong> </td>':'');
      echo  ' </tr>';
      echo   '</tbody>
              </table> '; 
      echo   '</body>  ';      
      echo   '</html>  '; 


<?php
 if( $dirEdificio === NULL )
 { $col1 = "33.3%";
   $col2 = $col1;
   $col3 = $col1;
   $col4 = $col1;
 }
 else
 { $col1 = "20%";
   $col2 = "30%";
   $col3 = "22%";
   $col4 = "28%";
 }
  echo ' <div class="recuadroGris" style="width: 100%;">
         <table align="center" style="width: 100%;">
          <tbody>
            <tr> <td width="'.$col1.'" class="center" >'.$logoConvivere.'</td>
                 <td width="'.$col2.'" class="center"  style="font-size: 12pt;"><strong>'.$titulo.'</strong></td>
                 <td width="'.$col3.'" class="center"  style="font-size: 9pt;">'.$edificio.'</td>';
  echo  ( $dirEdificio === NULL?'':'<td width="28%" class="center"  style="font-size: 7pt;">'.$dirEdificio.'</td>');
  echo '    </tr>
          </tbody>
         </table>
         </div>
       ';


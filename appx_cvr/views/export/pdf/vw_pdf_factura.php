<?php
      echo "<html><head>";
      $meta = array(
                    array('name' => 'author', 'content' => 'DATARE'),
                    array('name' => 'Content-type', 'content' => 'text/html; charset=UTF-8', 'type' => 'equiv')
                    );
      echo meta($meta);
      echo   '<style type="text/css">
               @page { margin: 0; }
                body {  margin-top: 3.5cm;
                        margin-bottom: 2.5cm;
                        margin-left: 1.5cm;
                        margin-right: 1.5cm;	  
                        text-align: justify;
                        font-size:12pt;
                        font-weight:normal;
                        font:sans-serif;
                        background-image:url(style/images/important.gif);
                        background-repeat: no-repeat;
                        background-attachment: fixed;
                        background-position: center; 
                      }
                div.header,div.footer {
                  position: fixed;	 
                  width: 100%;
                  border: 0px solid #888;
                  overflow: hidden;
                  padding: 0.1cm;
                }		
                div.footer {
                  bottom: -0.2cm;
                  left: 0cm;
                  background-image:url(style/images/info.gif);
                  height: 2.0cm;
                  padding: 0cm 0cm .4cm 0cm;
                }
                div.header {
                  top: 0cm;
                  left: 0cm;
                  background-image:url(style/images/help.gif);	  
                  height: 2.0cm;
                }
                div.footer table {width: 100%;
                  text-align: center;
                }
                hr { page-break-after: always;
                     border: 0;
                   }  
                .page-number:before { content: "Página " counter(page); }
                </style>';
      echo   "</head>"; 

      echo   '<body marginwidth="0" marginheight="0">
          HELLO WORLD!!!!
                ';
      /*      
      echo  $this->table->set_template(array('table_open' => '<table cellspacing="0" align="center" cellpadding="0" width="100%">') );	   
            $this->table->add_row('<p style="font-weight:bold;text-align: right;">'.$fechaCoti.'</p>');
            $this->table->add_row('<span style="font-weight:bold;">Atte.'.nbs(1).$prospecto["prosp_nombre"].'</span>');
            $this->table->add_row('<span style="font-weight:bold;">'.$prospecto["prosp_empresa"].'</span>');
            $this->table->add_row('<span style="font-weight:bold;">ASUNTO:'.nbs(1).$prospecto["asunto"].'</span>');
            $this->table->add_row('<p style="font-size:9x;">'.$templateCotizacion[0]['parrafo_inicial'].'</p>');

      echo $this->table->generate();

      echo $servicios;
     
      echo '<p>&nbsp;</p>';
      echo '<p><img src="images/leyenda.png" width="100%" /> </p>';	
      echo '<p>&nbsp;</p>';
	
	$this->table->clear();
	
	$this->table->set_template(array('table_open' => '<table cellspacing="0" align="center" cellpadding="0" width="100%">' ));
	$this->table->add_row('<p style="font-size:8x; text-align: justify;">'.$templateCotizacion[0]['leyenda_riesgo'].'</p>');
	
	$celda = array('data' => '<p <span style="font-weight:bold;">'.$templateCotizacion[0]['leyenda_coti_seg'].'</p>','class'=>"CotiTextCenterBold");	
	$this->table->add_row($celda);
	
	for ($s = 0; $s <= $sl["slAtte"]; $s++)
		$slStr = $slStr.'<p>&nbsp;</p>';
	
	$celda = array('data' => $slStr.'<p>'.$templateCotizacion[0]['parrafo_final'].'</p>'  ,'class'=>"CotiTextJus");	
	$this->table->add_row($celda);	
	
	$celda = array('data' => '<p style="font-weight:bold;">Atentamente.</p>','class'=>"CotiIzquierdaBold");	
	$this->table->add_row($celda);
	$celda = array('data' => '<img border=0 width="120px" height="80px" src="images/firmas/'.$atentamente["firmaAdmin"].'"/>','class'=>"CotiIzquierdaBold");	
	$this->table->add_row($celda);
	$celda = array('data' => '<span style="font-weight:bold;">'.$atentamente["nombreAdmin"]."</span>",'class'=>"CotiIzquierdaBold");	
	$this->table->add_row($celda);
	$celda = array('data' => '<span style="font-weight:bold;">SENNI LOGISTICS S.A. DE C.V.'."</span>",'class'=>"CotiIzquierdaBold");	
	$this->table->add_row($celda);
	$celda = array('data' => '<span style="font-weight:bold;">Tel.'.nbs(1).'<img border=0 src="images/tel.png"/>'.nbs(1).$atentamente["telAdmin"]."</span>",
				   'class'=>"CotiIzquierdaBold");	
	$this->table->add_row($celda);
	$celda = array('data' => '<span style="font-weight:bold;">Cel.'.nbs(1).'<img border=0 src="images/cel.png"/> '.nbs(1).$atentamente["celAdmin"]."</span>",
				   'class'=>"CotiIzquierdaBold");	
	$this->table->add_row($celda);
	$celda = array('data' => '<span style="font-weight:bold;">EM.<a href="mailTo:'.$atentamente["correoAdmin"].'">
							 '.nbs(1).'<img border=0 src="images/at.png" /> '.nbs(1).$atentamente["correoAdmin"]."</span>",
				   'class'=>"CotiIzquierdaBold");	
	$this->table->add_row($celda);
	$celda = array('data' => '<span style="font-weight:bold;"><a href="'.base_url().'">'.nbs(1).'<img border=0 src="images/inicio.png"/>'.nbs(1).
				   'www.senni.com.mx</a>'."</span>",
				   'class'=>"CotiIzquierdaBold");	
	$this->table->add_row($celda);
	
      echo $this->table->generate();
       * 
       */
      echo   ' </body>';
      echo   '</html>'; 
?>

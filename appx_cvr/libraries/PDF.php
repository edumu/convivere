<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Pdf
 *
 * @author edumu
 */
class PDF {        
    var $nombrePDF;
    var $contenidoParaPDF;
    var $pdfCreado;
     
   
   function PDF($nombre, $contenido)
   {              
       $this->nombrePDF        = $nombre;
       $this->contenidoParaPDF = $contenido;
   }
    
   public function setnombrePDF($nombre)
    { $this->nombrePDF = $nombre; }
    
   public function getnombrePDF()
    { return $this->nombrePDF; }
    
    public function setpdfCreado($param)
    { $this->pdfCreado = $param; }
    
   public function getpdfCreado()
    { return $this->pdfCreado; }

 public function crearPDF()
 {
    $pdf = new DOMPDF();
    
    $pdf->load_html($this->contenidoParaPDF);    
    $pdf->render();         
    $pdfOut = $pdf->output();        
    $this->setpdfCreado(write_file($this->getnombrePDF(), $pdfOut));    
 }
    
    
}

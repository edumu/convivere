<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cartero
 *
 * @author edumu
 */
class Cartero {
    
    var $fromMail;
    var $fromName;
    var $message;
    var $cc;
    var $bcc;
    var $subject;
    var $adjunto;
    var $emailCI;
   
    
function Cartero($objectEmail)
{
    $config['protocol']  = "smtp";
    $config['smtp_host'] = "mail.senni.com.mx";
    $config['smtp_port'] = "26";
    $config['smtp_user'] = "ventas@senni.com.mx"; 
    $config['smtp_pass'] = "ventas$2016";
    $config['charset']   = "UTF8";
    $config['mailtype']  = "html";		
    $config['wordwrap']  = TRUE;
    $config['priority']  = 2;

    $this->emailCI = $objectEmail;
    $this->emailCI->clear();
    $this->emailCI->initialize($config);
}
    
public function setfromMail($param)
{ $this->fromMail = $param; }

public function getfromMail()
{ return $this->fromMail; }

public function setfromName($param)
{ $this->fromName = $param; }

public function getfromName()
{ return $this->fromName; }

public function getmessage()
{ return $this->message; }

public function setmessage($param)
{ $this->message = $param; }

public function setto($param)
{ $this->to = $param; }

public function getto()
{ return $this->to; }

public function setcc($param)
{ $this->cc = $param; }

public function getcc()
{ return $this->cc; }

public function setbcc($param)
{ $this->bcc = $param; }

public function getbcc()
{ return $this->bcc; }

public function setsubject($param)
{ $this->subject = $param; }

public function getsubject()
{ return $this->subject; }

public function setadjunto($param)
{ $this->adjunto = $param; }

public function getadjunto()
{ return $this->adjunto; }
    		
public function mandaCorreo()
{		
   $this->emailCI->from($this->getfromMail(), $this->getfromName());
   $this->emailCI->to($this->getto() );

   if( $this->getcc() != NULL)
     { $this->emailCI->cc($this->getcc()); }

   if( $this->getbcc() != NULL)		
     { $this->emailCI->bcc($this->getbcc()); }

   $this->emailCI->subject($this->getsubject());		
   $this->emailCI->message($this->getmessage() );

   if( $this->getadjunto() != NULL)
       { $this->emailCI->attach($this->getadjunto()); }

   $r = $this->emailCI->send();
   return $r;
}

}

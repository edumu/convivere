<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Menu
 *
 * @author edumu
 */
class GeneradorMenu {
    var $tipo;
    var $menu;
    var $path;
    var $login;
    var $edificio;
    var $depto;
    var $data;
    var $currentSection;
    var $liga;
   
    
function GeneradorMenu($sesion,$path)
{
    $this->tipo     = $sesion['nivelacceso'];
    $this->login    = $sesion['nombre'].' '.$sesion['apellidos'];
    $this->edificio = $sesion['edificio'];
    $this->depto    = $sesion['depto'];
    $this->path     = $path;
    
    $this->menuLiga(); 
    $this->menuTipo();           
}


public function getmenu()
{      
     $this->data['menu']        = $this->menu;
     $this->data['path']        = $this->path;
     $this->data['nivelacceso'] = $this->tipo;
     
    return $this->data;     
}

private function menuTipo(){
switch ( $this->tipo) {
    case SUPERADMIN:$this->menu = $this->menuSuperAdmin();
    break;
    case ADMIN:     $this->menu = $this->menuAdmin();
    break;
    case USER:      $this->menu = $this->menuUser();
    break;
    default:        $this->menu = $this->menuPublico();
    break;
    }
}

private function menuLiga(){   
switch ( $this->path ) {
    case "Inicio":       $this->currentSection = array("ini"=>"current");
    break;
    case "Edificio":     $this->currentSection = array("edi"=>"current");
    break;
    case "Finanzas":     $this->currentSection = array("fin"=>"current");
    break;    
    case "Contrataciones":$this->currentSection = array("con"=>"current");
    break;
    case "Mi Edificio":   $this->currentSection = array("mie"=>"current");
    break;    
    case "Docs":          $this->currentSection = array("doc"=>"current");
    break;    
    default:             $this->currentSection = array("ini"=>"current");
    break;
    }    
}

private function menuSuperAdmin()
{  $this->data['login'] = '<i class="fa fa-user"></i> '.$this->login;
   $menu = '<!-- Start Navbar --><div class="Navbar-Header navbar basic" data-sticky="true">
             <div class="container">
                <div class="row">
                    <div class="basic-wrapper"> <a class="navbar-logo" href="index.html"></a> </div>
                    <div class="right-wrapper"> <div class="sidebar-menu"> <a class="logout-logo" href="'.base_url().'portal/salir/">'.nbs(1).'Salir </a> </div> </div>
                    <div class="collapse pull-right navbar-collapse">
                        <div id="cssmenu" class="Menu-Header top-menu">
                            <ul> <li class="'.$this->currentSection["ini"].'"><a href="'.base_url()."portal/".'"        ><i class="fa fa-home"  ></i>Inicio</a></li>
                                 <li class="'.$this->currentSection["fin"].'"><a href="'.base_url()."finanzas/".'"      ><i class="fa fa-usd"></i>Finanzas</a></li>
                                 <li class="'.$this->currentSection["edi"].'"><a href="'.base_url()."edificio/".'"      ><i class="fa fa-building"></i>Edificio</a></li>                                 
                                 <li class="'.$this->currentSection["doc"].'"><a href="'.base_url()."docs/".'"          ><i class="fa fa-folder-open"></i>Docs</a></li>
                                 <li class="'.$this->currentSection["con"].'"><a href="'.base_url()."contrataciones/".'"><i class="fa fa-credit-card"></i>Servicios</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
	</div><!-- End Navbar -->'; 
   return $menu;
}


private function menuAdmin()
{ return '';}


private function menuUser()
{$this->data['login'] = '<i class="fa fa-user"></i> '.$this->login;
return '<!-- Start Navbar --><div class="Navbar-Header navbar basic" data-sticky="true">
             <div class="container">
                <div class="row">
                    <div class="basic-wrapper"> <a class="navbar-logo" href="index.html"></a> </div>
                    <div class="right-wrapper"> <div class="sidebar-menu"> <a class="logout-logo" href="'.base_url().'portal/salir/">'.nbs(1).'Salir </a> </div> </div>
                    <div class="collapse pull-right navbar-collapse">
                        <div id="cssmenu" class="Menu-Header top-menu">
                            <ul> <li class="'.$this->currentSection["ini"].'"><a href="'.base_url()."portal/".'"        ><i class="fa fa-home"  ></i>Inicio</a></li>
                                 <li class="'.$this->currentSection["fin"].'"><a href="'.base_url()."finanzas/".'"      ><i class="fa fa-usd"></i>Finanzas</a></li>
                                 <li class="'.$this->currentSection["mie"].'"><a href="'.base_url()."miedificio/".'"    ><i class="fa fa-building"></i>Mi edificio</a></li>                                 
                                 <li class="'.$this->currentSection["doc"].'"><a href="'.base_url()."docs/".'"          ><i class="fa fa-folder-open"></i>Docs</a></li>
                                 <li class="'.$this->currentSection["con"].'"><a href="'.base_url()."contrataciones/".'"><i class="fa fa-credit-card"></i>Servicios</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
	</div>
        <!-- End Navbar -->
        '; }


private function menuPublico()
{ $this->data['login'] = '';
return '<!-- Start Navbar -->
	<div class="Navbar-Header navbar basic" data-sticky="true">
            <div class="container">
                <div class="row">
                    <div class="basic-wrapper"><a class="navbar-logo" href="index.html"></a> </div>
                    <div class="right-wrapper"><div class="sidebar-menu"> <button class="menu-button sidebar-menu column" id="open-button" >'.nbs(1).'<i class="fa fa-sign-in"></i></button> </div> </div>
                    <div class="collapse pull-right navbar-collapse">
                        <div id="cssmenu" class="Menu-Header top-menu">
                            <ul> <li class="current"><a href="index.html"><i class="fa fa-home"></i>Inicio</a></li>
                                 <li                ><a href="#"><i class="fa fa-cog"></i>Ventajas</a></li>
                                 <li                ><a href="#"><i class="fa fa-cog"></i>Precios</a></li>
                                 <li                ><a href="#"><i class="fa fa-file-o"></i>Clientes</a></li>                                    
                                 <li                ><a href="#"><i class="fa fa-image"></i>Contacto</a></li>                                 
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
	</div> <!-- End Navbar -->    
          '; }



}// end class


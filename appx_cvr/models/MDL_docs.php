<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Modelo para interactuar en la BD
 * 
 * SELECT CUENTA, NOMBRE, APELLIDOS, CONTRASENA, NIVEL_ACCESO, TELEFONO_FIJO, CELULAR, CORREO_VERIFICADO, CELULAR_VERIFICADO, ACTIVO
FROM USUARIOS WHERE 1
 */
 
class MDL_usuario extends CI_Model {
	
	
    public function test()
    {        
        $query = $this->db->get('TEST');

        if($query->num_rows() > 0 )      
            return $query->result();
	else 
            return array();  
    }
    
    
public function validaUsuario($usuario,$pwd)
{
    $this->db->select('U.NOMBRE, U.APELLIDOS, U.NIVEL_ACCESO');
    $this->db->from('USUARIOS U');        
    $this->db->where('U.CUENTA',$usuario);
    $this->db->where('U.CONTRASENA',$pwd);
    $this->db->where('U.ACTIVO',1);
    $query = $this->db->get();        

    return ( $query->num_rows() > 0 )? $query->result_array(): NULL;  
}

public function traeEdificiosAdmin($cuenta)
{
    $this->db->select('E.ID_EDIFICIO');
    $this->db->from('EDIFICIOS E');    
    $this->db->where('E.CUENTA_ADMIN',$cuenta);        
    $query = $this->db->get();        

    return ( $query->num_rows() > 0 )? $query->result_array(): array();  
}

public function traeDeptosUser($cuenta,$campo)
{
    $this->db->select('DE.'.$campo);
    $this->db->from('DETALLE_DEPTO DE');    
    $this->db->where('DE.CUENTA',$cuenta);        
    $query = $this->db->get();        

return ( $query->num_rows() > 0 )? $query->result_array()[0][$campo]: array($campo=>NULL);  
}

public function traeUsuario($cuenta)
{
    $this->db->select('U.NOMBRE,U.APELLIDOS, C.DESCRIPCION AS TIPO');
    $this->db->from('USUARIOS U');
    $this->db->join('DETALLE_DEPTO DE', 'U.CUENTA = DE.CUENTA','inner outer');
    $this->db->join('CATALOGOS C', 'DE.CONTACTO = C.ID_CATALOGOS  ','inner outer');
    $this->db->where('U.CUENTA',$cuenta);        
    $query = $this->db->get();        

    return ( $query->num_rows() > 0 )? $query->result_array(): array();  
}


 public function poblarSelectUsuario()
    {    					
        $this -> db -> select('U.CUENTA');
        $this -> db -> select("CONCAT_WS(' ',`U`.`NOMBRE`,`U`.`APELLIDOS`) as NOMBRE_USR  ", FALSE);
        $this -> db -> order_by("U.NOMBRE, U.APELLIDOS","ASC");
        $this->db->where('U.NIVEL_ACCESO',  USER);
        $query = $this -> db -> get('USUARIOS U');	
	
        $options[] = array("id" => 0, "value" =>'::Seleccione::');
		
        if($query -> num_rows() > 0 ){
            foreach ($query->result() as $row)
               { $options[] = array("id" => $row->CUENTA, "value" => $row->NOMBRE_USR);}}
		
	return $options;          
    }
    
    
    public function insert_user($data)
    {		
        return $this->db->insert('USUARIOS',$data);
    }

}//MDL_USUARIO

<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

 /**
  * @version 1.0
  * @author CBM-RN
  * @link http://www.cbm.rn.gov.br/
  */
class Empresa_model extends CI_Model {

  function __construct() {
    parent::__construct();
    $this->load->database();
  }
  
  public function cadastroRetorno($data2){	  
	   if (is_array($data2)) {
      $query = $this->db->insert('enderecos', $data2);
			return mysql_insert_id();
     }else{
			return FALSE;
		}	
  }
	
	public function cadastroEmpresa($data){	
	$query=$this->db->query("Select login from empresas where login="."'".$data['login']."'");
	$query2=$this->db->query("Select cnpj from empresas where cnpj="."'".$data['cnpj']."'");
	
	if($query->num_rows() > 0 || $query2->num_rows() > 0){
		foreach($query->result() as $resultadOQuery):
		    if ($data['login'] == $resultadOQuery->login ) {
			   		$resultado="Login";
		          	return $resultado;
		        }
	    endforeach;
	    foreach($query2->result() as $resultadOQuery2):
	        if ($data['cnpj'] == $resultadOQuery2->cnpj) {
	        	$resultado="CNPJ";
	          	return $resultado;
	        }
	    endforeach;
	    }else{
			$query = $this->db->insert('empresas', $data);
			return mysql_insert_id();
		}	
    }
	public function cadastroRetornoTelefone($data3){	  
	   if (is_array($data3)) {
           $query = $this->db->insert('telefones', $data3);
			return mysql_insert_id();
        }else{
			return FALSE;
		}	
    }
	public function cadastroContato($data){	  
	   if (is_array($data)) {
           $query = $this->db->insert('contatos', $data);
			return mysql_insert_id();
        }else{
			return FALSE;
		}	
    }
	public function cadastroContatosEmpresa($data){			
	   if (is_array($data)) {
           $query = $this->db->insert('contatos_das_empresas', $data);
			return TRUE;
        }else{
			return FALSE;
		}  
	}
}
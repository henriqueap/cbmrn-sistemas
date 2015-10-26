<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
 /**
  * @version 1.0
  * @author CBM-RN
  * @link http://www.cbm.rn.gov.br/
  */
class Odometro_model extends CI_Model {

  function __construct() {
    parent::__construct();
    $this->load->database();

  }
  
   public function cadastro($data){
   	date_default_timezone_set('America/Sao_Paulo');
	   if (is_array($data)) {
	   		if($data['data']==date('Y-m-d')){
	   			 $this->db->insert('odometros', $data);
			return TRUE;
	   		}else{
	   			return FALSE;
	   		}           
        }else{
			return FALSE;
		}	
	}
    
  public function listarViaturas($id=NULL) {
	  if($id == NULL) {
		   $query = $this->db->query("select viaturas.id, viaturas.tipo_viaturas_id,viaturas.placa, modelo_veiculos.modelo, marca_veiculos.nome from viaturas,modelo_veiculos,marca_veiculos where viaturas.modelo_veiculos_id=modelo_veiculos.id and modelo_veiculos.marca_veiculos_id=marca_veiculos.id");
		 
		   return $query;

		} else {
			$query = $this->db->query("SELECT id, modelo FROM modelo_veiculos;");
	  		return $query;
		}
  }
  #Apenas por enquanto que o SESSION nao esta funcionando
  public function getByIdMilitar() {
		$query = $this->db->get('militares');
		//$query->result_array();
		foreach ($query->result_array() as $row)
		{
		   return $row['id'];
		}
  }
  public function getLast($data){	  
		$query = $this->db->query("select max(odometro) as 'maior' from odometros where viaturas_id=".$data['viaturas_id']); 
		foreach ($query->result() as $row)
		{
		   echo $row->maior;
		}
		if($data['odometro']>=$row->maior){			
		 return TRUE;
		}else
		return FALSE;
	}
}
<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

 /**
  * @version 1.0
  * @author CBM-RN
  * @link http://www.cbm.rn.gov.br/
  */
class Viaturas_model extends CI_Model {

  function __construct() {
    parent::__construct();
    $this->load->database();
  }

	public function cadastrar($data) {
    # Salvar viaturas
    if (is_array($data)) {
    	//var_dump($data);
      $this->db->insert("viaturas", $data);
      return TRUE;
    }
    else {
    	return FALSE;
    	}
 	}

  	# Retorna os modelos cadastrados.
	public function getByIdModelo($id=NULL) {
		if ($id==NULL) {
	      return $query = $this->db->get('modelo_veiculos');
	    } else {
	      $this->db->where('id', $id);
	      return $this->db->get('modelo_veiculos')->row(); 
	    }
	}

  	# Retorna as lotações existentes.
	public function getByIdSetor($id=NULL) {
		if ($id==NULL) {
	      return $query = $this->db->get('lotacoes');
	    } else {
	      $this->db->where('id', $id);
	      return $this->db->get('lotacoes')->row(); 
	    }
	}

	#Retorna os tipos de viaturas existentes.
	public function getByIdTipoViaturas($id=NULL) {
		if ($id==NULL) {
			return $query =$this->db->get('tipo_viaturas');
		} else {
			$this->db->where('id', $id);
			return $this->db->get('tipo_viaturas')->row();
		}
	}

  	# Retorna os tipos de combustiveis existentes.
	public function getByIdCombustiveis($id=NULL) {
		if ($id==NULL) {
	      return $query = $this->db->get('combustiveis');
	    } else {
	      $this->db->where('id', $id);
	      return $this->db->get('combustiveis')->row(); 
	    }
	}

	# Retorna as marcas existentes.
	public function getByIdMarcas($id=NULL) {
		if ($id==NULL) {
	      return $query = $this->db->get('marca_veiculos');
	    } else {
	      $this->db->where('id', $id);
	      return $this->db->get('marca_veiculos')->row();
	    }
	}

	public function getModeloVeiculos($id) {
		$query = $this->db->query("SELECT * FROM modelo_veiculos WHERE marca_veiculos_id = $id;");
		return $query->result();
	}
}
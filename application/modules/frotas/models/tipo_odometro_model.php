<?php

if (!defined('BASEPATH'))
		exit('No direct script access allowed');

 /**
	* @version 1.0
	* @author CBM-RN
	* @link http://www.cbm.rn.gov.br/
	*/
class Tipo_odometro_model extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function cadastrar($data) {
		if (is_array($data)) {
			$this->db->insert("tipos_odometros", $data);
			return ($this->db->affected_rows() > 0)? TRUE: FALSE;
		}
		else return FALSE;
	}

	public function listar() {
		$this->db->order_by("tipos_odometros_id", "asc");
		$_lista = $this->db->get("tipos_odometros");
		//var_dump($_lista);
		return ($_lista->num_rows() > 0)? $_lista: FALSE;
	}

	public function atualizar($data) {
		$this->db->where('tipos_odometros_id', $data['tipos_odometros_id']);
		return $this->db->update('tipos_odometros', $data);
	}

	public function excluir($id) {
		if (! is_null($id)) {
			$query = $this->getById($id);
			if ($query !== FALSE) {
				if ($query->ativo == 1) {
					$data = array('ativo' => 0);
					$query = $this->db->update('tipos_odometros', $data, array('tipos_odometros_id'=>$id));
					} else {
						$data  = array('ativo' => 1);
						$query = $this->db->update('tipos_odometros', $data, array('tipos_odometros_id'=>$id));
				}
				return ($this->db->affected_rows() > 0)? TRUE: FALSE;
			}
			else return FALSE;
		} 
		else return FALSE;
	}

	public function getById($id) {
		$this->db->where('tipos_odometros_id', $id);
		$_tipo = $this->db->get('tipos_odometros');
		return ($_tipo->num_rows() > 0)? $_tipo->row(): FALSE;
	}

	public function testaExiste($id) {
		$this->db->where("tipo", $id);
		$_existe = $this->db->get("odometros");
		return ($_existe->num_rows() > 0)? FALSE: TRUE;
	}

}
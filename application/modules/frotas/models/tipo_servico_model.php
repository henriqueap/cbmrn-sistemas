<?php

if (!defined('BASEPATH'))
		exit('No direct script access allowed');

 /**
	* @version 1.0
	* @author CBM-RN
	* @link http://www.cbm.rn.gov.br/
	*/
class Tipo_servico_model extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function salvar($data) {
		if(is_array($data)) {
			$this->db->insert("tipo_servicos", $data);
			return ($this->db->affected_rows() > 0)? TRUE: FALSE;
		}
		else return FALSE;
	}

	public function listar() {
		$this->db->order_by('id', 'asc');
		$_lista = $this->db->get('tipo_servicos');
		return ($_lista->num_rows() > 0)? $_lista: FALSE;
	}

	public function atualizar($data) {
		$this->db->where('id', $data['id']);
		return $this->db->update('tipo_servicos', $data);
	}

	public function excluir($id)  {
		if (! is_null($id)) {
			$query = $this->getById($id);
			if ($query !== FALSE) {
				if ($query->ativo == 1) {
					$data = array('ativo' => 0);
					$query = $this->db->update('tipo_servicos', $data, array('id'=>$id));
					} else {
						$data  = array('ativo' => 1);
						$query = $this->db->update('tipo_servicos', $data, array('id'=>$id));
				}
				return ($this->db->affected_rows() > 0)? TRUE: FALSE;
			}
			else return FALSE;
		} 
		else return FALSE;
	}

	public function getById($id) {
		$this->db->where('id', $id);
		$_tipo_servico = $this->db->get('tipo_servicos');
		return ($_tipo_servico->num_rows() > 0)? $_tipo_servico->row(): FALSE;
	}

	public function testaExiste($id) {
		$this->db->where("tipo_servicos_id", $id);
		$_existe = $this->db->get("servicos");
		return ($_existe->num_rows() > 0)? FALSE: TRUE;
	}

}
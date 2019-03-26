<?php

if (!defined('BASEPATH'))
		exit('No direct script access allowed');

 /**
	* @version 1.0
	* @author CBM-RN
	* @link http://www.cbm.rn.gov.br/
	*/
class Frotas_model extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function formataData($data) {
		if (substr_count($data, "-") == 2) {
			$data = implode('/', array_reverse(explode('-', $data)));
		} else {
			$data = implode('-', array_reverse(explode('/', $data)));
		}
		return $data;
	}

	public function getLotacoes(){
		$_lotacoes = $this->db->get("lotacoes");
		return ($_lotacoes->num_rows() > 0)? $_lotacoes: FALSE;
	}

	public function getByIdSetor($id) {
		if (! $id) {
			return FALSE;
		} else {
			$this->db->where('id', $id);
			return $this->db->get('lotacoes')->row();
		}
	}

}

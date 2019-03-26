<?php

if (!defined('BASEPATH'))
		exit('No direct script access allowed');

 /**
	* @version 1.0
	* @author CBM-RN
	* @link http://www.cbm.rn.gov.br/
	*/
class Suporte_model extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function validaOdometro($viatura_id) {
		$this->db->where('viaturas_id', $viatura_id);
		$this->db->select_max('odometro', 'max_odometro');
		$_query= $this->db->get('odometros');
		var_dump($_query->row()->max_odometro);
		return (!$_query)? $_query : $this->db->get('odometros')->row()->max_odometro;
	}

	public listarLotacoes($id=NULL) {
		if ($id == NULL) {
			return $query = $this->db->get('lotacoes');
		} else {
			$this->db->where('id', $id);
			return $this->db->get('lotacoes')->row(); 
		}
	}
}
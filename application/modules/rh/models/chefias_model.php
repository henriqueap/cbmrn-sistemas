<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

 /**
  * @version 1.0
  * @author CBM-RN
  * @link http://www.cbm.rn.gov.br/
  */
class Chefias_model extends CI_Model {
	
	private $table_name = "chefias";

	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function salvar($data) {
		$this->db->insert($this->table_name, $data);
		return $this->db->insert_id();
	}

	public function atualizar($data) {
		$this->db->where('id', $data['id']);
  	return $this->db->update($this->table_name, $data);
	}

	public function excluir($id) {
		$this->db->where('id', $id);
    return $this->db->delete($this->table_name);
	}
	
	public function getById($id=NULL) {
		if ($id==NULL) {
      return $query = $this->db->get($this->table_name);
    } else {
      $this->db->where('id', $id);
      return $this->db->get($this->table_name)->row(); 
    } 
	}

	public function consulta_chefias($filter) {
		# SELECT FROM 
		$this->db->select("
			chefias.id as idchefias,
    	chefias.lotacoes_id,
    	chefias.militares_id,
    	militares.nome as militar_nome,
    	lotacoes.nome as lotacoes_nome"
    );

		$this->db->from("chefias");
		$this->db->join('militares', 'militares.id = chefias.militares_id');
		$this->db->join('lotacoes', 'lotacoes.id = chefias.lotacoes_id');

		if (isset($filter['chefe_militares_id_hidden'])) {
			$this->db->where('militares.id', $filter['chefe_militares_id_hidden']);
		}

		# RETURN 
		$query = $this->db->get();
		return $query;
	}
}
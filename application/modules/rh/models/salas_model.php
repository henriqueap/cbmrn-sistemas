<?php

if (!defined('BASEPATH'))
		exit('No direct script access allowed');

 /**
	* @version 1.0
	* @author CBM-RN
	* @link http://www.cbm.rn.gov.br/
	*/
class Salas_model extends CI_Model {

		private $table_name = "lotacoes";

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
				$this->db->delete($this->table_name);
		}

		public function getById($id=NULL, $table_name=NULL) {
				# Adiciona o valor padrão para o nome da tabela.
				if (!$table_name==NULL) {
						$this->table_name = $table_name;
				}

				# Condicional id Nulo.
				if ($id==NULL) {
					$this->db->where('sala', 1);
					return $query = $this->db->get($this->table_name);
				} else {
					$this->db->where('id', $id);
					return $this->db->get($this->table_name)->row(); 
				}
		}

		public function getSalas($filter = array()) {
				$this->db->where('sala', 1);
				$this->db->from($this->table_name);
				$this->db->select("$this->table_name.*");

				if (isset($filter['nome'])) {
					$this->db->like($this->table_name . '.nome', $filter['nome']);
				}

				$this->db->order_by("$this->table_name.nome", 'asc');
				return $this->db->get();
		}
}

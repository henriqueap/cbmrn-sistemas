<?php

if (!defined('BASEPATH'))
		exit('No direct script access allowed');

 /**
	* @version 1.0
	* @author CBM-RN
	* @link http://www.cbm.rn.gov.br/
	*/
class Militares_model extends CI_Model {

	private $table_name = "militares";

	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	/**
	 * Anotações: Criar exceções para quando os dados que vinherem pela variável $data não for um array.
	 */
	public function salvar($data) {
		# Salvar militares.
		if (is_array($data)) {
			$this->db->insert($this->table_name, $data);
		}
	}

	public function atualizar($data) {
		# Atualizar os dados!
		$this->db->where('id', $data['id']);
		return $this->db->update($this->table_name, $data);
	}

	public function excluir($data) {
			# Excluir o militar! 
			# Obs: Não irá excluir apenas, desativar do sistema!
			$this->db->where('id', $data['id']);
			return $this->db->update($this->table_name, array('ativo'=>0));
	}

	public function getById($id=NULL) {
		# Fazer busca do militar no banco de dados.
		if ($id==NULL) {
			return $query = $this->db->get($this->table_name);
		} else {
			$this->db->where('id', $id);
			# $this->db->where('ativo', '1');
			return $this->db->get($this->table_name)->row(); 
		}
	}

	public function getByMatricula($matricula, $boolean=FALSE) {
		# Cosultar militar pela mattricula.
		$this->db->where('matricula', $matricula);

		if ($boolean) {
			$query = $this->db->query("SELECT id FROM militares WHERE matricula = '$matricula';")->result();
			
			foreach ($query as $row) {
				return $row->id;
			}
		} else return $this->db->get($this->table_name)->row();
	}

	public function getMilitares($filter=NULL) {
		# Retornar os dados dos militares.
		if (is_null($filter)) {
			$sql = "SELECT 
								militares.id AS idmilitar, 
								CONCAT(patentes.sigla, ' ', militares.nome_guerra) AS militar 
								FROM 
									militares 
									INNER JOIN patentes ON militares.patente_patentes_id = patentes.id";
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0) return $query; 
			else return FALSE;
		}
		else {
			$this->db->select('*');
			$this->db->from($this->table_name);

			if (isset($filter['nome'])) {
				$this->db->like($this->table_name . '.nome', $filter['nome']);
			}

			if (isset($filter['matricula'])) {
				$this->db->like($this->table_name . '.matricula', $filter['matricula']);
			}

			$this->db->order_by("$this->table_name.nome", 'asc');
			return $this->db->get();
		}
	}
}

<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

 /**
	* @version 1.0
	* @author CBM-RN
	* @link http://www.cbm.rn.gov.br/
	*/
class Ferias_model extends CI_Model {
	
	# Tabela padrão.	
	private $table_name = "turma_ferias";

	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	/**
	 * @param $data
	 * Salvar militares nas suas turmas de férias.
	 */
	public function salvar_ferias($data) {
		if (is_array($data)) {
			# $this->db->insert('militares_ferias', $data);
			$this->db->insert('afastamentos', $data);

		}
	}

	/**
	 * @param $data $table
	 * Salva as turmas de férias.
	 */
	public function salvar($data, $table=NULL) {
		if (!is_null($table)) {
			$this->table_name = $table;
		}

		if (is_array($data)) {
			$this->db->insert($this->table_name, $data);
			return $this->db->insert_id(); 
		}
	}

	/**
	 * @param $data $table
	 */
	public function atualizar($data, $table=NULL) {
		if (!is_null($table)) {
			$this->table_name = $table;
		}

		$this->db->where('id', $data['id']);
		return $this->db->update($this->table_name, $data);
	}

	/**
	 * @param $id 
	 * Excluír os dados desejados.
	 */
	public function excluir($id, $table=NULL) {
		if (!is_null($table)) {
			$this->table_name = $table;
		}

		if (isset($id)) {
			$this->db->where('id', $id);
			$this->db->delete($this->table_name);
		}
	}

	/**
	 * @param $id $table
	 * Pegar turmas de férias pelo exercicio.
	 */
	public function getById($id=NULL, $table=NULL) {
		if (!is_null($table)) {
			$this->table_name = $table;
		}

		if ($id==NULL) {
			return $query = $this->db->query('SELECT DISTINCT exercicio FROM turma_ferias ORDER BY exercicio desc');
		} else {
			$this->db->where('id', $id);
			return $this->db->get($this->table_name)->row(); 
		}
	}

	/**
	 * @param $data $tabela
	 * Fazer consulta no banco de dados através do ID.
	 * Method alterado: 06.02.2014
	 */
	public function getTurmaFeriasById($param) {
		(is_array($param))? $this->db->where($param) : $this->db->where('id', $param);
		$query = $this->db->get($this->table_name);
		return $query;
	}
	
	/**
	 * @param $data 
	 * Pegar turmas de férias pelo exercicio e numero.
	 */
	public function getTurmaFeriasByIdCadastroFerias($data) {
		$this->db->where('exercicio', $data['exercicio_id']);
		$this->db->where('numero', $data['numero_id']);
		$query = $this->db->get($this->table_name)->result();

		foreach ($query as $row) {
			return $row->id;
		}
	}

	/**
	 * @param $filter array and $boolean true or false
	 * Filtra as turmas de férias.
	 */
	public function getTurmaFerias($filter, $boolean = TRUE) {
		$this->db->select("$this->table_name.*");
		$this->db->from($this->table_name);

		if (isset($filter['numero'])) {
			$this->db->like($this->table_name . '.numero', $filter['numero']);
		}

		if (isset($filter['exercicio'])) {
			$this->db->like($this->table_name . '.exercicio', $filter['exercicio']);
		}

		$this->db->order_by("$this->table_name.id", 'asc');

		echo $this->db->last_query();
		if ($boolean === FALSE) {
			$query = $this->db->get();
			return $query->result_array();
		}
		return $this->db->get();
	}

	/**
	 * @param $matricula 
	 * Passando a matrícula retorna se o militar está em férias regulamentares, se não, retorna todos os militares em férias regulamentares.
	 */
	public function getMilitaresEmFerias($matricula = NULL) {
		$sql = "SELECT 
							afastamentos.id,
							afastamentos.tipo_afastamentos_id,
							militares.matricula,
							CONCAT(patentes.sigla, ' ', militares.nome_guerra) AS militar,
							militares.id AS militar_id,
							turma_ferias.exercicio,
							turma_ferias.numero,
							turma_ferias.data_inicio,
							DATE_ADD(turma_ferias.data_inicio, INTERVAL 29 DAY) AS data_fim,
							afastamentos.turma_ferias_id
							FROM
								afastamentos
								INNER JOIN turma_ferias ON afastamentos.turma_ferias_id = turma_ferias.id
								INNER JOIN militares ON afastamentos.militares_id = militares.id
								INNER JOIN patentes ON militares.patente_patentes_id = patentes.id
							WHERE
								afastamentos.ativo = 1
								AND CURDATE() BETWEEN turma_ferias.data_inicio AND data_fim";
		if (is_null($matricula)) {
			$sql .= " AND militares.matricula = '$matricula'";
			$query = $this->db->query();
			return ($query->num_rows() < 1)? FALSE : TRUE;
		}
		else {
			$query = $this->db->query();
			return ($query->num_rows() < 1)? FALSE : $query->result();
		}
	}

	/**
	 * @param $params 
	 * Passando a matrícula retorna se o militar está afastado em férias, se não, retorna todos os militares nesta situação.
	 */
	public function getFeriasMilitares($param = NULL) {
		$sql = "SELECT 
							afastamentos.id,
							militares.matricula,
							CONCAT(patentes.sigla, ' ', militares.nome_guerra) AS militar,
							afastamentos.militares_id,
							afastamentos.tipo_afastamentos_id AS tipo,
							tipo_afastamentos.nome,
							afastamentos.justificativas,
							DATE_FORMAT(afastamentos.data_inicio,  '%d/%m/%Y') AS data_inicio,
							DATE_FORMAT(afastamentos.data_fim, '%d/%m/%Y') AS data_fim,
							DATEDIFF(afastamentos.data_fim, afastamentos.data_inicio) + 1 AS dias,
							IF((CURDATE() BETWEEN afastamentos.data_inicio AND afastamentos.data_fim), 
								'EM CURSO', 
								IF(DATEDIFF(CURDATE(), afastamentos.data_fim) > 0,
								 'CONCLUÍDO',
								 'LANÇADO'
								)
							) AS afastamento,
							afastamentos.turma_ferias_id,
							turma_ferias.numero,
							turma_ferias.exercicio
							FROM
								afastamentos
								INNER JOIN turma_ferias ON afastamentos.turma_ferias_id = turma_ferias.id
								INNER JOIN militares ON afastamentos.militares_id = militares.id
								INNER JOIN patentes ON militares.patente_patentes_id = patentes.id
								INNER JOIN tipo_afastamentos ON afastamentos.tipo_afastamentos_id = tipo_afastamentos.id
							WHERE afastamentos.ativo = 1";
		if (is_null($param)) {
			$exercicio = date("Y") - 1;
			$sql .= " AND exercicio = '$exercicio'";
			$query = $this->db->query($sql);
			return ($query->num_rows() < 1)? FALSE : TRUE;
		}
		else {
			if (is_array($param)) {
				foreach ($param as $fld => $val) {
					$sql .= " AND $fld = '$val'";
				}
			}
			else {
				$sql .= " AND afastamentos.tipo_afastamentos_id = 1";
				$sql .= " AND militares.matricula = '$param'";
			}
			$query = $this->db->query($sql);
			return ($query->num_rows() < 1)? FALSE : $query;
		}
	}

	/**
	 * @param $params 
	 * Passando a matrícula retorna se o militar está em férias regulamentares, se não, retorna todos os militares em férias regulamentares.
	 */
	public function getAfastamentoMilitares($param = NULL) {
		$sql = "SELECT
							afastamentos.id,
							militares.matricula,
							CONCAT(patentes.sigla, ' ', militares.nome_guerra) AS militar,
							afastamentos.militares_id,
							afastamentos.tipo_afastamentos_id AS tipo,
							tipo_afastamentos.nome,
							afastamentos.justificativas,
							DATE_FORMAT(afastamentos.data_inicio,  '%d/%m/%Y') AS data_inicio,
							DATE_FORMAT(afastamentos.data_fim, '%d/%m/%Y') AS data_fim,
							DATEDIFF(afastamentos.data_fim, afastamentos.data_inicio) + 1 AS dias,
							IF(
								(CURDATE() BETWEEN afastamentos.data_inicio AND afastamentos.data_fim), 
								IF(afastamentos.sustado = 1, 'SUSTADO', 'EM CURSO'), 
								IF(DATEDIFF(CURDATE(),afastamentos.data_fim) > 0, 'CONCLUÍDO', 'LANÇADO')) AS afastamento,
							afastamentos.turma_ferias_id,
							turma_ferias.numero,
							turma_ferias.exercicio,
							afastamentos.sustado
							FROM
								afastamentos
								INNER JOIN turma_ferias ON afastamentos.turma_ferias_id = turma_ferias.id
								INNER JOIN militares ON afastamentos.militares_id = militares.id
								INNER JOIN patentes ON militares.patente_patentes_id = patentes.id
								INNER JOIN tipo_afastamentos ON afastamentos.tipo_afastamentos_id = tipo_afastamentos.id
							WHERE
								turma_ferias.exercicio = YEAR(CURDATE()) - 1";
		if (is_null($param)) {
			$query = $this->db->query();
			return ($query->num_rows() < 1)? FALSE : TRUE;
		}
		else {
			if (is_array($param)) {
				foreach ($param as $fld => $val) {
					$sql .= " AND $fld = '$val'";
				}
			}
			else {
				$sql .= " AND afastamentos.tipo_afastamentos_id = 1";
				$sql .= " AND militares.matricula = '$param'";
			}
			echo "<pre>".var_dump($sql)."</pre>";
			$query = $this->db->query($sql);
			return ($query->num_rows() < 1)? FALSE : $query->result();
		}
	}

	/**
	 * @param $id $data $table
	 * Retornar todas as turmas do militar pesquisado.
	 */
	public function consultar_ferias_militares($data, $table=NULL) {
		if (!is_null($table)) {
			$this->table_name = $table;
		}

		$this->db->where('militares_id', $data['militar']);
		return $this->db->get($this->table_name);
	}

	/**
	 * @param 
	 * @version 0.1 Version Deprecated.
	 */
	public function getInfoMilitares($id) {
		# Pegar informações do militar pelo id.
		$query = $this->db->query("SELECT militares.nome, militares.matricula, patentes.nome, militares_ferias.militares_id FROM militares, patentes, militares_ferias WHERE  militares.id = {$id} AND militares_ferias.militares_id = {$id} AND militares.patente_patentes_id = patentes.id;");
		return $query;
	}

	/**
	 * @version 0.1
	 * Pegar informações de militares.
	 */
	public function get_info_militares($filter) {
		if (is_array($filter)) {
			# Query Complexa, por favor, não alterar nada.
			$sql = "SELECT
								turma_ferias.id AS turma_ferias_id,
								turma_ferias.numero,
								afastamentos.data_inicio,
								DATE_ADD(afastamentos.data_inicio, INTERVAL 29 DAY) AS data_fim,
								turma_ferias.exercicio,
								afastamentos.id AS militares_ferias_id,
								afastamentos.militares_id,
								militares.matricula,
								militares.nome,
								CONCAT(patentes.sigla, ' ', militares.nome_guerra) AS militar,
								afastamentos.tipo_afastamentos_id,
								afastamentos.sustado
								FROM
									afastamentos
									INNER JOIN militares ON afastamentos.militares_id = militares.id
									INNER JOIN turma_ferias ON afastamentos.turma_ferias_id = turma_ferias.id
									INNER JOIN patentes ON militares.patente_patentes_id = patentes.id
								WHERE
									afastamentos.militares_id = ".$filter['militar']." 
									AND turma_ferias.exercicio =".$filter['exercicio'];
			$query = $this->db->query($sql);
			return $query;
		} else return FALSE;
	} # Fim get_info_militares

	public function salvar_reaprazamento($data, $tabela='afastamentos') {
		return $this->db->insert($tabela, $data);
	}

	/**
	 * @param empty
	 * Salvar os dados do formulário sustar férias
	 */
	public function salvar_sustar($data) {
		if (is_array($data)) {
			$data_termino = date('d/m/Y', strtotime($data['data_fim']));
			# Retira o id do afastamento
			$id = array_pop($data);
			# Prepara o array do insert
			$ins_data = $data;
			$ins_data['tipo_afastamentos_id'] = 3;
			$ins_data['justificativas'] = "As férias regulamentares deste militar para este exercício foram sustadas";
			# Prepara o array para o update
			array_shift($data);
			$upd_data = $data;
			$upd_data['ativo'] = 0;
			$ins_data['justificativas'] = "Férias regulamentares sustadas em $data_termino";
			$upd_data['sustado'] = 1;
			# Atualiza
			$this->db->where('id', $id); 
			$this->db->update('afastamentos', $upd_data);
			# Insere
			$this->db->insert('afastamentos', $ins_data);
			 
			return $this->db->insert_id();
		} else return FALSE;
	}

	/**
	 * @param empty
	 * Consultar militares em férias.
	 */
	public function consulta_militares_ferias($filter) {
		# Consultar período de férias dos militares.

	}
}
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
      $this->db->insert('militares_ferias', $data);
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
      return $query = $this->db->query('SELECT DISTINCT exercicio FROM turma_ferias ORDER BY exercicio asc');
    } else {
      $this->db->where('id', $id);
      return $this->db->get($this->table_name)->row(); 
    }
	}

  /**
   * @param $data $tabela
   * Fazer consulta no banco de dados com o parametro enviado pelo controller.
   * Method alterado: Risco de erros: 12.02.2014
   */
  public function getTurmaFeriasById($data, $tabela=NULL) {
    if (!is_null($tabela)) {
      $this->table_name = $tabela;
    }

    $this->db->where('exercicio', $data['exercicio']);
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

    $this->db->order_by("$this->table_name.id", 'desc');
    if ($boolean == FALSE) {
    	$query = $this->db->get();
    	return $query->result_array();
    }
    return $this->db->get();
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
      $query = $this->db->query(
        "SELECT turma_ferias.id as turma_ferias_id, turma_ferias.numero, turma_ferias.data_inicio, turma_ferias.exercicio, militares_ferias.id as militares_ferias_id, militares_ferias.militares_id, militares.matricula, militares.nome FROM militares, militares_ferias, turma_ferias WHERE 
        militares_ferias.militares_id = militares.id 
        AND militares_ferias.turma_ferias_id = turma_ferias.id 
        AND militares_ferias.militares_id = ".$filter['militar']." 
        AND turma_ferias.exercicio =".$filter['exercicio'].";"
      );
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
      $this->db->insert('sustar_ferias', $data); 
      return $this->db->insert_id();
    } else return FALSE;
  }

  /**
   * @param empty
   * Consultar militares em férias.
   */
  public function consulta_militares_ferias($filter) {
    # Consultar périodo de férias dos militares.
  }
}


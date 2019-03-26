<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

  /**
  * @version 1.0
  * @author CBM-RN
  * @link http://www.cbm.rn.gov.br/
  */
class Afastamentos_model extends CI_Model {
	
	private $table_name = "afastamentos";

	function __construct() {
		parent::__construct();
		$this->load->database();
    $this->load->helper('date');
	}

	public function salvar($data) {
    if (is_array($data)) {
      $tbl = (isset($data['tabela']))? array_shift($data) : $this->table_name;
      $this->db->insert($tbl, $data);
    }
		return $this->db->insert_id();
	}

	public function atualizar($data) {
    $tbl = (isset($data['tabela']))? array_shift($data) : $this->table_name;
		$this->db->where('id', $data['id']);
  	return $this->db->update($tbl, $data);
	}

	public function excluir($data) {
    if (is_array($data)) {
      $tbl = $data['tabela'];
      $id = $data['id'];
    }
    else {
      $tbl = $this->table_name;
      $id = $data;
    }
		$this->db->where('id', $id);
    $this->db->delete($tbl);
	}
		
	# Retorna os afastamentos cadastados no sistema.
	public function getById($id=NULL, $tabela=NULL) {
    $tbl = (is_null($tabela))? $this->table_name : $tabela;
		if ($id==NULL) {
      return $query = $this->db->get($tbl);
    } else {
      $this->db->where('id', $id);
      return $this->db->get($tbl)->row(); 
    }
	}

	# Retorna os tipos de afastamentos existentes.
	public function getByIdAfastamentos($id=NULL) {
		if ($id==NULL) {
      return $query = $this->db->get('tipo_afastamentos');
    } else {
      $this->db->where('id', $id);
      return $this->db->get('tipo_afastamentos')->row(); 
    }
	}

	# Retornar busca na tabela pelo nome do tipo de afastamento.
	public function getTipoAfastamentosByTipo($tipo=NULL, $tabela='tipo_afastamentos') {
		$this->db->where('nome', $tipo);
		$query = $this->db->get($tabela);
		return $query->row();
	}

	/**
	 * @param $filter  array
	 */
	public function getAfastamentosFilter($filter) {
		# SELECT 
		$this->db->select("
			afastamentos.id as idafastamentos,
      afastamentos.data_inicio,
      afastamentos.data_fim,
      afastamentos.numero_processo,
      afastamentos.ativo,
      afastamentos.justificativas,
      afastamentos.tipo_afastamentos_id,
      tipo_afastamentos.nome as tipo_afastamentos,
      militares.id as idmilitares,
      militares.nome as militares_nome,
      militares.matricula, 
      turma_ferias.id as idturma_ferias
    ");

		# FROM
    $this->db->from('afastamentos');

    # INNER JOIN
    $this->db->join('militares', 'militares.id = afastamentos.militares_id');
    $this->db->join('turma_ferias', 'afastamentos.turma_ferias_id = turma_ferias.id');
    $this->db->join('tipo_afastamentos', 'afastamentos.tipo_afastamentos_id = tipo_afastamentos.id');

    if (isset($filter['chefe_militares_id_hidden'])) {
      $this->db->like('afastamentos.militares_id', $filter['chefe_militares_id_hidden']);
    }

    # WHERE LIKES
    if (isset($filter['numero_processo'])) {
      $this->db->like('afastamentos.numero_processo', $filter['numero_processo']);
    }

    if (isset($filter['tipo_afastamentos_id'])) {
      $this->db->like('afastamentos.tipo_afastamentos_id', $filter['tipo_afastamentos_id']);
    }

    # BETWEEN 
    if (isset($filter['data_inicio'])) {
      if (isset($filter['data_fim'])) {
        $this->db->where("afastamentos.data_inicio BETWEEN '".$filter['data_inicio']."' AND '".$filter['data_fim']."'");
        $this->db->where("afastamentos.data_fim BETWEEN '".$filter['data_inicio']."' AND '".$filter['data_fim']."'");
      } else {
        $this->db->where("afastamentos.data_inicio BETWEEN '".$filter['data_inicio']."' AND '". date("Y-m-d")."'");
        $this->db->where("afastamentos.data_fim BETWEEN '".$filter['data_inicio']."' AND '". date("Y-m-d")."'");
      }
    }

    if (isset($filter['tipo_afastamentos_id'])) {
      $this->db->like('tipo_afastamentos.id', $filter['tipo_afastamentos_id']);
    }
    
    $query = $this->db->get();
    return $query;
	}

  /**
   * @param $id
   */
  public function cancelar_afastamentos($id) {
    $this->db->where('id', $id);
    return $this->db->update('afastamentos', array('ativo'=>'0'));
  }
}

<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

 /**
  * @version 1.0
  * @author CBM-RN
  * @link http://www.cbm.rn.gov.br/
  */
class Lotacao_model extends CI_Model {

  private $table_name = "lotacoes";

  function __construct() {
    parent::__construct();
    $this->load->database();
  }

  /** 
   * Consultar lotações e retornar todos os valores que estão na hierarquia. 
   * @param $id de onde comerçar a procurar no banco.
   * Anotações: Criar exceções para tratar $id não encontrado.
   */
  public function consulta_lotacoes($id) {
    do {
      $busca_lotacoes = $this->db->get_where($this->table_name, array('id'=>$id));
      if ($busca_lotacoes->num_rows() > 0) {
        $linha = $busca_lotacoes->row();
        $arvore[$linha->sigla]= $linha->id;
        $id = $linha->superior_id;
      } else {
        //erro
      }
    } while (!is_null($id));
    return $arvore;
  }

  /**
   * Função criada para salvar registros no banco de dados;
   * @param $data um array com os dados passados pelo controller.
   */
  public function salvar($data) {
    $this->db->insert($this->table_name, $data);
    return $this->db->insert_id();
  }

  /**
   * Função criada para atualizar e salvar registros no banco de dados;
   * @param $data um array com os dados passados pelo controller.
   */
  public function atualizar($data) {
    $this->db->where('id', $data['id']);
    return $this->db->update($this->table_name, $data);
  }

  /**
   * Função criada para apagar registros no banco de dados;
   * @param $id um inteiro com o id passados pelo controller.
   */
  public function excluir($id) {
    $this->db->where('id', $id);
    $this->db->delete($this->table_name);
  }

  public function getById($id=NULL) {
    if ($id==NULL) {
      return $query = $this->db->get($this->table_name);
    } else {
      $this->db->where('id', $id);
      return $this->db->get($this->table_name)->row(); 
    }
  }

  /**
   * Função criada para fazer filtragem de dados na tabela lotacaoes
   * @param null 
   */
  public function getLotacao() {
    $this->db->select("$this->table_name.*");
    $this->db->from($this->table_name);

    if (isset($filter['nome'])) {
      $this->db->like($this->table_name . '.nome', $filter['nome']);
    }

    $this->db->order_by("$this->table_name.nome", 'asc');
    return $this->db->get();
  }
}

<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

 /**
  * @version 1.0
  * @author CBM-RN
  * @link http://www.cbm.rn.gov.br/
  */
class Clog_model extends CI_Model {

  function __construct() 
  {
    parent::__construct();
    $this->load->database();
  }

  public  function salvar($tabela=NULL, $objeto=NULL) 
  {
  	if (!is_null($tabela) OR !is_null($objeto)) {
  		if (is_array($objeto)) {
  			$query = $this->db->insert($tabela, $objeto);
  			return  $query;
  		}
  	}	return 0;
  }

  public function atualizar($tabela=NULL, $objeto=NULL) 
  {
  	if (!is_null($tabela) OR is_null($objeto)) {
  		if (is_array($objeto)) {
  			$this->db->where('id', $objeto['id']);
  			$query = $this->db->update($tabela, $objeto);
  			return  $query;
  		}
  	}	return 0;
  }

  public function excluir($tabela=NULL, $id=NULL) 
  {
    if (is_string($tabela)) { 
      if (!is_null($tabela) OR !is_null($id)) {
        $this->db->where('id', $id);
        $this->db->delete($tabela);
      }
    } return 0;
  }

  public function listar($tabela, $id=NULL, $order = 'desc', $limit=NULL, $offset=NULL)
  {
    if (!is_null($id))
      $this->db->where('id', $id);

    $this->db->order_by('id', $order);
    $query = $this->db->get($tabela, $limit, $offset);
    return $query;
  }
}

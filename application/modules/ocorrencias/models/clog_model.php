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

  public function salvar($tabela=NULL, $objeto=NULL) 
  {
  	if (!is_null($tabela) OR !is_null($objeto)) {
  		if (is_array($objeto)) {
  			$query = $this->db->insert($tabela, $objeto);
        //var_dump($query);
  			return $query;
  		}
  	}	return 0;
  }

  public function atualizar($tabela=NULL, $objeto=NULL) 
  {
    if (!is_null($tabela) OR is_null($objeto)) {
      if (is_array($objeto)) {
        $this->db->where('id', $objeto['id']);
        $query = $this->db->update($tabela, $objeto);
        if ($this->db->affected_rows() > 0) return TRUE;
        else return FALSE;
      }
    }
    else return 0;
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

  public function excluirPorra($tabela=NULL, $id=NULL) 
  {
    if (is_string($tabela)) { 
      if (!is_null($tabela) OR !is_null($id)) {
        $this->db->where('cautelas_id', $id);
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

  #by Pereira
  public function getAll($tbl){
    $query = $this->db->get($tbl);
    if ($query->num_rows() > 0) {
      return $query;
    } 
    else {
      return FALSE;
    }
  }

  public function getByID($tbl, $id){
    $data = array('id'=>$id);
    $query = $this->db->get_where($tbl, $data);
    if ($query->num_rows() > 0) {
      return $query;
    } 
    else {
      return FALSE;
    }
  }

  public function getByIDporra($tbl, $id){
    $data = array('cautelas_id'=>$id);
    $query = $this->db->get_where($tbl, $data);
    if ($query->num_rows() > 0) {
      return $query;
    } 
    else {
      return FALSE;
    }
  }

  public function inserir($data, $tbl)
  {
    #$tbl = "os";
    $query = $this->db->insert($tbl, $data);
    if ($this->db->affected_rows() > 0) return TRUE;
    else return FALSE;
  }

  public function getGrupos($id=NULL){
    $sql = "SELECT
      grupos_permissoes.id,
      grupos_permissoes.nome,
      modulos.nome AS modulo,
      modulos.sigla AS sigla_modulo
      FROM
      grupos_permissoes
      Inner Join modulos ON grupos_permissoes.modulos_id = modulos.id";
    if (! is_null($id)) {
      $sql .= " WHERE grupos_permissoes.id = $id";
    }
    $grupos = $this->db->query($sql);
    if ($grupos->num_rows() > 0) {
      return $grupos;
    } 
    else {
      return FALSE;
    }
  }

  /*public function inserir($data, $tbl, $retornaID=FALSE)
  {
    #$tbl = "os";
    $query = $this->db->insert($tbl, $data);
    if ($this->db->affected_rows() > 0) {
      if ($retornaID === FALSE) return TRUE;
      else return $this->db->insert_id();
    }
    else return FALSE;
  }*/

  public function audita($data, $acao)
  {
    $tbl="auditoria";
    $query=$this->db->get_where('tipo_auditoria',array('tipo'=>$acao))->row();
    $sql="INSERT INTO auditoria (data, auditoria, idtipo, idmilitar, idmodulo) VALUES (now(), '".$data['auditoria']."', ".$query->id.",".$data['idmilitar'].",".$data['idmodulo']." )";
    //var_dump($sql);
    $this->db->query($sql);
    if ($this->db->affected_rows() > 0) return TRUE;
    else return FALSE;
  }
}

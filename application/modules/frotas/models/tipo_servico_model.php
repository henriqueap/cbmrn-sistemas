<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

 /**
  * @version 1.0
  * @author CBM-RN
  * @link http://www.cbm.rn.gov.br/
  */
class Tipo_servico_model extends CI_Model {

  function __construct() {
    parent::__construct();
    $this->load->database();
  }

	public function listarServicos(){
		#Listar serviços em ordem
		$this->db->order_by('id', 'asc');
		$query = $this->db->get('tipo_servicos');
		return $query;
	}

  public function atualizar($data) {
    $this->db->where('id', $data['id']);
    return $this->db->update('tipo_servicos', $data);
  }

  public function testaExiste($id) {
    $query = $this->db->query("SELECT tipo_servicos_id from servicos where tipo_servicos_id=$id");
    if ($query->num_rows() < 1) {
      return TRUE;
    } else {
      return FALSE;
    }
  }

  public function excluir($id)  {
    if (!is_null($id)) {
      $query = $this->db->query("SELECT ativo from tipo_servicos where id=$id")->row();
      if ($query->ativo ==1) {
        $data = array('ativo'=>0);
        $query = $this->db->update('tipo_servicos', $data, array('id'=>$id));
      } else {
        $data=array('ativo'=>1);
        $query = $this->db->update('tipo_servicos', $data, array('id'=>$id));
      }
      return TRUE;
    } else {
      return FALSE;
    }
  }

	public function getById($id) {
		#Pegar id de cada serviço para editar
		$this->db->where('id', $id);
		return $this->db->get('tipo_servicos')->row();
	}

	public function salvar($data) {
  #Inserir registros no banco
  	if(is_array($data)) {
		  $this->db->insert("tipo_servicos", $data);
		  return TRUE;
  	} else return FALSE;
  }
}
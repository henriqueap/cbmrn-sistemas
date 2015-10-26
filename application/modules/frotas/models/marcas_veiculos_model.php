<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

 /**
  * @version 1.0
  * @author CBM-RN
  * @link http://www.cbm.rn.gov.br/
  */
class Marcas_veiculos_model extends CI_Model {

  function __construct() {
    parent::__construct();
    $this->load->database();
  }

  public function cadastrar($data) {
    # Salvar marcas
    if (is_array($data)) {
      $this->db->insert("marca_veiculos", $data);
      return TRUE;
    }
    else return FALSE;
  }

  public function testaExiste($id) {
    $query = $this->db->query("SELECT marca_veiculos_id from modelo_veiculos where marca_veiculos_id=$id");
    if ($query->num_rows() < 1) {
      return TRUE;
    } else {
      return FALSE;
    }
  }

  public function excluir($id) {
    if (!is_null($id)) {
      $query = $this->db->query("SELECT ativo from marca_veiculos where id=$id")->row();
      if ($query->ativo == 1) {
        $data = array('ativo'=>0);
        $query = $this->db->update('marca_veiculos', $data, array('id'=>$id));
      } else {
        $data = array('ativo'=>1);
        $query = $this->db->update('marca_veiculos', $data, array('id'=>$id));
      }
      return TRUE;
    } else {
      return FALSE;
    }
  }

  public function atualizar($data) {
    #atualizar dados
      $this->db->where('id', $data['id']);
      return $this->db->update('marca_veiculos', $data);
    }

  public function getById($id) {
	#Pegar id de cada Marca
	$this->db->where('id', $id);
	return $this->db->get('marca_veiculos')->row();
  }
  
  public function listaMarcas() {
    #Listar as marcas cadastradas
    $this->db->order_by('id', 'asc');
    $query = $this->db->get('marca_veiculos');
    return $query;
  }
}

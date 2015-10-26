<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

 /**
  * @version 1.0
  * @author CBM-RN
  * @link http://www.cbm.rn.gov.br/
  */
class Tipo_viatura_model extends CI_Model {

  function __construct() {
    parent::__construct();
    $this->load->database();
  }

  public function cadastrar($data) {
	  	if (is_array($data)){
	  		$this->db->insert("tipo_viaturas", $data);
	  		return TRUE;
	  	}
	  	else return FALSE;
    }

    public function atualizar($data) {
    	$this->db->where('id', $data['id']);
    	return $this->db->update('tipo_viaturas', $data);
    } 

    public function getById($id) {
    	$this->db->where('id', $id);
    	return $this->db->get('tipo_viaturas')->row();
    }

    public function testaExiste($id) {
      $query = $this->db->query("SELECT tipo_viaturas_id from viaturas where tipo_viaturas_id=$id");
      if ($query->num_rows() < 1) {
        return TRUE; 
      } else {
        return FALSE;
      }
    }

    public function excluir($id) {
    	if (!is_null($id)) {
        $selAtivo = $this->db->query("SELECT ativo from tipo_viaturas where id=".$id)->row();
        //Altera estado
        if($selAtivo->ativo == 1){
          $data = array('ativo'=>0);
          $query = $this->db->update('tipo_viaturas', $data, array('id'=>$id));
        } else {
          $data=array('ativo'=>1);
          $query = $this->db->update('tipo_viaturas', $data, array('id'=>$id));
        }
        if($this->db->affected_rows() > 0) return TRUE;
        else return FALSE;
      } else return FALSE; 
    }

    public function listaTipo() {
    	$this->db->order_by('id', 'asc');
    	$query = $this->db->get('tipo_viaturas');
    	return $query;
    }
}
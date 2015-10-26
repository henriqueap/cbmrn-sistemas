<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

 /**
  * @version 1.0
  * @author CBM-RN
  * @link http://www.cbm.rn.gov.br/
  */
class Servico_model extends CI_Model {

  function __construct() {
    parent::__construct();
    $this->load->database();
	
  }
   public function listarEmpresas($id=NULL) {
	  if($id == NULL) {
		  return $query = $this->db->get('empresas');
		} else {
			 $this->db->where('id', $id);
	      return $this->db->get('empresas')->row();
		}
  }
   public function listarTipoServicos($id=NULL) {
	  if($id == NULL) {
		  return $query = $this->db->get('tipo_servicos');
		} else {
			 $this->db->where('id', $id);
	      return $this->db->get('tipo_servicos')->row();
		}
  }
  public function cadastro($data) {
    # Salvar viaturas
   // var_dump($data);
    if (is_array($data) && $data['data_abertura'] == date("Y-m-d")) {
      $this->db->insert("servicos", $data);
      return TRUE;
    }
    else 
      return FALSE;
  }

    public function cadastroRetroativo($data) {
    # Salvar viaturas
   // var_dump($data);
    if (is_array($data) ) {
      $this->db->insert("servicos", $data);
      return TRUE;
    }
    else 
      return FALSE;
  }
}
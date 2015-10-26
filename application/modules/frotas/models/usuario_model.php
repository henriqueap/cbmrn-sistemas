<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

 /**
  * @version 1.0
  * @author CBM-RN
  * @link http://www.cbm.rn.gov.br/
  */
class Usuario_model extends CI_Model {
  function __construct() {
    parent::__construct();
    $this->load->database();
  }

  public function salvar($data) {
    if(is_array($data)) {
      $this->db->insert("cbfrotas_usuario", $data);
      return TRUE;
    } else {
      return FALSE;
    }
  }

	public function listarMilitares($id=NULL) { //metodo que retorna um objeto
  	if ($id == NULL) {
  		$query = $this->db->query("SELECT militares.id, matricula, nome_guerra, patentes.sigla FROM militares, patentes WHERE patentes.id=militares.patente_patentes_id");
  	} else {
  		$query = $this->db->query("SELECT id, nome_guerra FROM militares");
  	}
  	return $query->result();
  }

  public function listarTiposUsuarios(){
    $query=$this->db->query("SELECT * from cbfrotas_tipo_usuario");
    return $query->result();
  }
}
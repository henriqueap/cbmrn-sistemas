<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

 /**
  * @version 1.0
  * @author CBM-RN
  * @link http://www.cbm.rn.gov.br/
  */
class Abastecimento_model extends CI_Model {

  function __construct() {
    parent::__construct();
    $this->load->database();
  }

   public function cadastrar($data){
   date_default_timezone_set('America/Sao_Paulo');
     if (is_array($data)) {
        if($data['data']==date('Y-m-d')){
            $this->db->insert("abastecimento", $data);
            return TRUE;
        }else{
          return FALSE;
        }
    }
    else return FALSE;
  }

  public function cadastrarOdometro($data2){
    if (is_array($data2)) {
      $query = $this->db->insert('odometros', $data2);
      return mysql_insert_id();
    }  else {
      return FALSE;
    }
  }

  public function getByIdSetor($id=NULL) {
  	if ($id==NULL) {
  		return $query = $this->db->get('lotacoes');
  	} else {
  		$this->db->where('id', $id);
  		return $this->db->get('lotacoes')->row();
  	}
  }

  public function getListarViaturas($id=NULL) {
    if($id == NULL) {
      $query = $this->db->query("SELECT viaturas.id,viaturas.placa, modelo_veiculos.modelo, marca_veiculos.nome FROM viaturas,modelo_veiculos,marca_veiculos WHERE viaturas.modelo_veiculos_id=modelo_veiculos.id AND modelo_veiculos.marca_veiculos_id=marca_veiculos.id");
      return $query;
    } else {
      $query = $this->db->query("SELECT id, modelo FROM modelo_veiculos");
      return $query;
    }
  }
}
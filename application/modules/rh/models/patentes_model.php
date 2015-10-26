<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

 /**
  * @version 1.0
  * @author CBM-RN
  * @link http://www.cbm.rn.gov.br/
  */
class Patentes_model extends CI_Model {

    private $table_name = "patentes";

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function atualizar($data) {
        $this->db->where('id', $data['id']);
        return $this->db->update($this->table_name, $data);
    }

    public function salvar($data) {
        $this->db->insert($this->table_name, $data);
        return $this->db->insert_id();
    }

    public function excluir($id) {
        $this->db->where('id', $id);
        $this->db->delete($this->table_name);
    }

    public function getById($id) {
        $this->db->where('id', $id);
        return $this->db->get($this->table_name)->row();
    }

    /* LISTAR TODOS OS REGISTROS */
    public function listPatentes($filter = array()) {
        $this->db->order_by('nome', 'asc');
        return $this->db->get_where($this->table_name, $filter);
    }
}

